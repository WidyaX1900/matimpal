if(document.getElementById("chatPage")) {
    const friend = $(".show-chat-content").length > 0
        ? $(".show-chat-content").data("friend").trim()
        : undefined;
    
    const socket = io.connect("http://127.0.0.1:3000/");
    const user = $("nav").data("user");
    

    $("#chatInput").on("click", "button", function () {
        const $textarea = $(this).prev();
        const message = $textarea.val().trim();
        if (message === "") return;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/chat/store",
            method: "post",
            dataType: "json",
            data: { receiver: friend, message },
            success: function (response) {
                const send_from = response.send_from;
                const send_to = response.send_to;
                socket.emit("send-message", { send_from, send_to });
                $textarea.val("");
                getAllChat();
            },

            error: function (error) {
                console.log(error);
            },
        });
    });
    getAllChat();

    // Functions
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
    // Functions

    // Sockets
    socket.on("receive-message", (data) => {        
        if(data.send_from !== friend) return; 
        getAllChat();                
    });
    socket.on("receive-message-list", (data) => {        
        if($(".show-chat-content").length <= 0 && data.send_to === user) {
            $(".chat-content").load(location.href + " .chat-content > * ");
        }                         
    });
    // Sockets
}
