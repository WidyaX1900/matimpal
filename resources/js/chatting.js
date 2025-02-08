if(document.getElementById("chatPage")) {
    const friend = $("nav h4").text().trim();
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
            },

            error: function (error) {
                console.log(error);
            },
        });        
    });
}
