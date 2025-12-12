$(document).on('submit', '#post-form', function(e){

    e.preventDefault();
    var $form = $(this);

    
    $.post('/ajax/postAdd', $form.serialize(), function(response){
        if(response.error){
            $('#ajax-results').html(response.error).show();
            return;
        }

        $.get('/ajax/postList', function(listHtml){
            $('#postList-container').html(listHtml);
        })
        
        $('#ajax-results').html(response.success).show();
        
    });

});