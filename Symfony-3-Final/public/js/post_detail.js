$(document).on('click', '.post-link', function(e){

    e.preventDefault();
    const url = $(this).attr('href');
    
    $.get(url, function(postHtml){

        $('#postDetail-container').html(postHtml).show();
        return;
        
        // $('#ajax-results').html(response.success).show();
        
    });

});