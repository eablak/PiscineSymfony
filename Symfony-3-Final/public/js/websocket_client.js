let socket = null;

function initWebSocket(){

    socket = new WebSocket('ws://localhost:8080');
    
    socket.onopen = function() {
        console.log('You are Connected to WebSocket Server');
    };
    
    socket.onmessage = function(event) {
        console.log("Message from server: ", event.data);
    
        if (event.data === 'post added' || event.data === 'post deleted'){
    
            $.get('/ajax/postList', function(listHtml){
                $('#postList-container').html(listHtml);
            });
    
        }
    };
    
    socket.onclose = function(event) {
        console.log('Disconnected from WebSocket server');
        setTimeout(initWebSocket, 1000);
    };

}

$(document).ready(function(){
    initWebSocket();

});