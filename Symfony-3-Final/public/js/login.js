$(document).on('click', '.ajax-login', function(e){

    e.preventDefault();

    $.post('/ajax/login', $('#login-form').serialize(), function(response){

        if (response.error){
            $('#ajax-results').html(response.error).show();
            return;
        }
        $('#ajax-results').html(response.success).show();
    });


});