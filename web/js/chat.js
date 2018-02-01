$(document).ready(function () {

    chatModule.updateChat();
    setInterval(
        function () {
            chatModule.updateChat();
        }, 3000
    );
    $("#form-message").submit(function() {
        var datastring = $("#form-message").serialize();
        chatModule.sendMessage(datastring);
        $(this).each(function(){
            this.reset();
        });
        return false;
    })

});

var chatModule = (function () {

    var updateChat = function () {
        $.ajax(
            {
                type : "GET",
                dataType : "json",
                url : "/",
                success : function(data) {
                    $("#messages").empty();

                    $.each( data.messages, function( key,item ) {
                        $("#messages").append( item.senderId + ' - ' + item.createdAt + ' - ' +  item.message+'<br/>');
                    });
                }
            });
    };
    var sendMessage = function (datastring) {
        $.ajax(
            {
                type : "POST",
                dataType : "json",
                url : "/",
                data : datastring,
                success : function(data) {
                    if(data.success){
                        updateChat(data);
                    }else{
                        addMessageError(data);
                    }

                }
            });
    };
    var addMessageError=function (data) {
        $("#errors").remove();
        $("#form-message").append('<span id="errors">'+data.errors+'</span>');

    };

    return {
        sendMessage: sendMessage,
        updateChat: updateChat
    }
})();