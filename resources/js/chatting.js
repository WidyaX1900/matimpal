if(document.getElementById("chatPage")) {
    const friend = $(".show-chat-content").data("friend").trim();
    const socket = io.connect("http://127.0.0.1:3000/");
    
    $("#chatInput").on("click", "button", function() {
        const $textarea = $(this).prev();
        const message = $textarea.val().trim();
        if(message === "") return;
        
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/chat/store",
            method: "post",
            dataType: "json",
            data: { receiver: friend, message },
            success: function (response) {
                $textarea.val("");
                getAllChat();
            },

            error: function (error) {
                console.log(error);
            },
        });        
    });

    function getAllChat() {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/chat/get_all",
            method: "post",
            dataType: "html",
            data: { friend },
            success: function (response) {
                $(".show-chat-content ul").html(response);                
            },

            error: function (error) {
                console.log(error);
            },
        });
    }

    getAllChat();
}
