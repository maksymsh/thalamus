/**
 * OAuth get tokens by code
 */

function saveTokens(access, expire, refresh) {
    
    $.ajax({
        type: "POST",
        url: "/user_oauth/save_tokens",
        data: {
            access_token        : access,
            access_token_expire : expire,
            refresh_token       : refresh
        },
        success: function(response) {

            console.log(response.status + ': ' + response.message);
            console.log('refresh is: ' + refresh);
            if(response.status == 'tokens_saved') {
                $("#oauth-save-token").html(response.message);
                setTimeout(function () {
                    window.close();
                }, 1700);
            }
        }
    });

}

$(document).ready(function () {

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    };

    let code = $.urlParam('code');

    // Check if we got the code
    if(code != '') {

        // Exchange code for tokens
        $.ajax({
            type: "POST",
            url: "https://www.googleapis.com/oauth2/v4/token",
            cache: false,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            async: true,
            data: {
                code            : code,
                client_id       : google_client_id,
                client_secret   : google_client_secret,
                redirect_uri    : "https://thalamus.io/user_oauth/get_code",
                grant_type      : "authorization_code"
            },
            success: function (html) {

                // Save tokens to user profile
                saveTokens(html['access_token'], html['expires_in'], html['refresh_token']);

            },
            error: function (html) {
                console.log("error: " + html);
            }
        });

    } else {

        $("#oauth-save-token").html('Problem with getting auth code. Please, try again or write about this error to system administrator!');
        setTimeout(function () {
            window.close();
        }, 1700);

    }

});