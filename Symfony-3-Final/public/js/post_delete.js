$(document).on('click', '.post-delete', function(e){

    e.preventDefault();
    const url = $(this).attr('href');
    
    $.post(url, function(response){
        if(response.error){
            $('#ajax-results').html(response.error).show();
            return;
        }
        
        $('#ajax-results').html(response.success).show();
        
    });

});