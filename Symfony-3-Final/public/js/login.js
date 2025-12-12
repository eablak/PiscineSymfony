$(document).on('click', '.ajax-login', function(e){

    e.preventDefault();

    $.post('/ajax/login', $('#login-form').serialize(), function(response){

        if (response.success){
            $('#loginForm-container').hide();
            $.get('/ajax/postForm', function(formHtml){
                $('#postForm-container').html(formHtml).show();
            });
            $.get('/ajax/postList', function(tableHtml){
                $('#postList-container').html(tableHtml).show();
            });
        }else{
            alert('Invalid Credentials!')
        }

    });


});