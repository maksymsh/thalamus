/*category*/
$("body").delegate('.edit-cat-block', "click", function (event) {
    event.preventDefault();
    if($(this).hasClass('active-edit')){
        $('#'+$(this).attr('data-cat-block')).find('.actions-panel, .btn-add-new-categoty').css('display','none');
        $(this).text('Edit');
        $(this).removeClass('active-edit');
    }else{
        $('#'+$(this).attr('data-cat-block')).find('.actions-panel, .btn-add-new-categoty').css('display','block');
        $(this).text('Done editing');
        $(this).addClass('active-edit');
    }
    
});

$("body").delegate('.select-category', "change", function (event) {
    if($(this).val() == 'add!'){
        var nameCategory = prompt('Enter the new category name')
        if(nameCategory){
            var newCategory = addNewCategory(nameCategory, $(this).attr('data-type'),  $('#category-list').attr('data-url'));
            if(newCategory){
                $('.select-category').find('option:last').before('<option value='+newCategory.id+'>'+newCategory.name+'</option>');
                $(this).find('option:last').prev().prop('selected', true);
            }
        }else{
            $(this).find('option:first').prop('selected', true);
        }
    }
});

$("body").delegate('.btn-add-new-categoty', "click", function (event) {
    event.preventDefault();
    var nameCategory = prompt('Enter the new category name')
    if(nameCategory.trim()){
        var newCategory = addNewCategory(nameCategory, $('#category-list').attr('data-type'), $('#category-list').attr('data-url') );
        if(newCategory){
            var newCategory ='<li><a data-cat-id="'+newCategory.id+'"  href="?cat='+newCategory.id+'">'+newCategory.name+'</a>'
                  +'<span class="actions-panel" style="display: block">'
                     +'<a class="btn-rename-category" data-name="'+newCategory.name+'"  data-id="'+newCategory.id+'">Rename</a> ' 
                     +'<a class="btn-delete-category" data-id="'+newCategory.id+'"><img src="/bundles/wwscthalamus/images/remove_icon.png"></a>'
                +'</span></li>'
            $(this).parents('ul').find('li:last').before(newCategory);
        } 
    }
});

$("body").delegate('.btn-rename-category', "click", function (event) {
    event.preventDefault();
    var nameCategory = prompt('Enter the new category name', $(this).attr('data-name'));
    if(nameCategory.trim()){
        var renameCategory = editCategory(nameCategory, $(this).attr('data-id'), $('#category-list').attr('data-url'));
        if(renameCategory){
            $('a[data-id="'+renameCategory.id+'"]').attr('data-name',renameCategory.name);
            $('a[data-cat-id="'+renameCategory.id+'"]').text(renameCategory.name);
        } 
    }
});

$("body").delegate('.btn-delete-category', "click", function (event) {
    event.preventDefault();
    var deletedCategory = deleteCategory($(this).attr('data-id'));
    if(deletedCategory){
       $(this).parents('li').remove();
    } 
});


function editCategory(name, id, url){
    var updateCategory = false;
    $.ajax({
        type: "POST",
        data: {name: name, id: id},
        url: url,
        async: false, 
        success: function (data) {
            data = $.parseJSON(data);
            if (data.status == 'error') {
                alert(data.msg);
            }
            if(data.status == 'success'){
                 updateCategory = data;
            }
        }    
    });
    return updateCategory;
}

function deleteCategory(id){
    var deletedCategory = false;
    $.ajax({
        type: "POST",
        url: '/category/delete/'+id,
        async: false, 
        success: function (data) {
            if(data == 1){
                 deletedCategory = true;
            }
        }    
    });
    return deletedCategory;
}

function addNewCategory(name, type, url){
    var newCategory = false;
    $.ajax({
        type: "POST",
        data: {name: name, type: type},
        url: url,
        async: false, 
        success: function (data) {
            data = $.parseJSON(data);
            if (data.status == 'error') {
                alert(data.msg);
            }
            if(data.status == 'success'){
                 newCategory = data;
            }
        }    
    });
    return newCategory;
}