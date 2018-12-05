/* delete computer-files files*/
$("body").delegate(".btn-delete-file", "click", function (event) {
    event.preventDefault();
    var fileItem = $(this).parents('.computer-files');
    if (!confirm("Are you sure you want to delete this file?")) {
        return false;
    }
    var url = $(this).attr('href');
    ajaxSpinnerShow($(this).parent());
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (data) {
                fileItem.remove();
            }
        }
    });
});

$("body").delegate('.remove-gd-file', "click", function (event) {
    $(this).parents('.gd-file').remove();
    $('input[name^="aFiles['+$(this).attr('data-id')+']"]').remove();
});

function attachmentFiles(form, type, idComment, redirect){
      $(form).find('.attachment-files').bind('fileuploaddone', function(e, data) {
          $(form).append('<input type="hidden" name=aFiles['+[data.jqXHR.responseJSON.files[0].name]+'][original_name] value="'+data.jqXHR.responseJSON.files[0].original_name+'">'
                     +'<input type="hidden" name=aFiles['+[data.jqXHR.responseJSON.files[0].name]+'][size] value='+data.jqXHR.responseJSON.files[0].size+'>' );
        });
        $(form).find('.attachment-files').bind('fileuploadsubmit', function (e, data) {
            data.formData=({'type':'attachment'});
        });
        $(form).find('.attachment-files button[type="submit"]').click();
        
        $(form).find('.attachment-files').bind('fileuploadstop', function (e) {
            if(type == 'comment'){
                saveComment($(form), idComment);
                $('input[name^="aFiles"]').remove();
            }else if(type == 'writeboard' && typeof redirect === 'undefined'){
                saveWriteboard($(form));
            }else{
                form.submit();
            }    
        });
}

/**
 * Google drive upload methods
 */
let scope = 'https://www.googleapis.com/auth/drive';
let pickerApiLoaded = false;
let oauthToken;
let authBtn = $(".fileinput-button-gd");

/**
 * Gapi onload method
 */
function handleGoogleClientLoad(){
    gapi.load('auth2', onAuthApiLoad);
    gapi.load('picker', onPickerApiLoad);
}

function onAuthApiLoad() {

    // Handle upload button
    $(authBtn).on('click', function(e) {
        e.preventDefault();

        // Get auth token
        $.ajax({
            type: "GET",
            url: "/user_oauth/get",
            success: function(response) {

                if(response.status == 'error') {

                    if(response.message == 'access_token_not_found') {

                        // Need to make user auth to get authorization code
                        gapi.auth2.authorize({
                            client_id       : google_client_id,
                            redirect_uri    : "https://thalamus.io/user_oauth/get_code",
                            scope           : scope,
                            access_type     : "offline",
                            response_type   : "code",
                            include_granted_scopes: true
                        }, function () {

                            // Callback to reopen Google Drive
                            authBtn.click();

                        });

                    } else if(response.message == 'access_token_invalid') {

                        // Requesting new access token
                        refreshToken(response.refresh);

                    } else if(response.message == 'refresh_token_not_found') {
                        
                        // Callback to get refresh token again
                        clearTokenData();

                    }

                } else if(response.status == 'success') {

                    // Set oauth token
                    oauthToken = response.access;

                    // Run Picker
                    createPicker();

                }

            }
        });

    });

}

/**
 * Clear all Google drive token data
 */
function clearTokenData() {
    
    $.ajax({
        type: "POST",
        url: "/user_oauth/clear_token_data",
        success: function(response) {

            // Data cleared, can auth again
            if(response.status == 'success') {

                // Remove permissions and reload window
                alert(response.desc);
                window.location.href = 'https://myaccount.google.com/permissions';
                
            } else if(response.status == 'error') {
                
                // Try again after window reload
                window.location.reload();
                
            }

        }
    });
    
}

/**
 * Get new access token with refresh token
 */
function refreshToken(refresh) {

    $.ajax({
        type: "POST",
        url: "https://www.googleapis.com/oauth2/v4/token",
        cache: false,
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        async: true,
        data: {
            refresh_token   : refresh,
            client_id       : google_client_id,
            client_secret   : google_client_secret,
            grant_type      : "refresh_token"
        },
        success: function (response) {

            // Saving new access token
            updateAccessToken(response['access_token'], response['expires_in']);

        },
        error: function (response) {

            // Got some errors
            console.log("error: " + response);

        }
    });

}

/**
 * Save new access token to user profile
 */
function updateAccessToken(access, expire) {

    $.ajax({
        type: "POST",
        url: "/user_oauth/update_access_token",
        data: {
            access_token        : access,
            access_token_expire : expire
        },
        success: function(response) {

            // Set updated oauth token
            oauthToken = response.access;

            // Run Picker
            createPicker();

        }
    });

}

/**
 * Onload Picker method
 */
function onPickerApiLoad() {

    pickerApiLoaded = true;
    createPicker();

}

/**
 * Run Picker
 */
function createPicker() {

    if(pickerApiLoaded && oauthToken) {
        let picker = new google.picker.PickerBuilder()
            .addView(google.picker.ViewId.DOCS)
            .setOAuthToken(oauthToken)
            .setDeveloperKey(google_api_key)
            .setCallback(pickerCallback)
            .build();
        picker.setVisible(true);
    }

}

/**
 * Work with Drive files
 */
function pickerCallback(data) {

    if (data.action == google.picker.Action.PICKED) {
        var form = $('.attachment-files').parents('form');
        $(data.docs).each(function() {
            form.append('<input type="hidden" name=aFiles['+this.id+'][url] value="'+this.url+'">'
                +'<input type="hidden" name=aFiles['+this.id+'][original_name] value="'+this.name+'">'
                +'<input type="hidden" name=aFiles['+this.id+'][format_file] value="GOOGLE_DRIVE">'
            );
            $('.attachment-preview').before('<div class="template-upload gd-file col-md-12"><img src="/bundles/wwscthalamus/images/gd-icon-min.png"><a target="_blank" href='+this.url+'>'+ this.name +'</a>\n\<img class="remove-gd-file cancel" data-id='+this.id+' src="/bundles/wwscthalamus/images/remove_icon.png"></div>');
        });
    }

}
