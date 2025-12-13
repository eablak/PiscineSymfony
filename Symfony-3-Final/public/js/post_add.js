$(document).on('submit', '#post-form', function(e){

    e.preventDefault();
    var $form = $(this);
    
    $.post('/ajax/postAdd', $form.serialize(), function(response){
        if(response.error){
            alert("Title already exsist!");
            return;
        }
        
        $('#ajax-results').html(response.success).show();
        
    });

});