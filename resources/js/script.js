let video;
let localStream;
let ringtone = $("#callSfx")[0];
let receiveTone = $("#ringtone")[0];
let receiver;
const caller = $("nav").data("user");
const socket = io.connect("http://127.0.0.1:3000/");
let missedCallTimeout;

$(document).ready(function() {
    $(".friend-list li .vicall-icon").on("click", function(){
        $(".videocall-container .friend-info small").html("");
        $(".videocall-container .vicall-navigator")
            .removeClass("vicall-navigator--between")
            .addClass("vicall-navigator--center");
        
        receiver = $(this).data("receiver");
        $(".videocall-container .vicall-navigator").html(`
            <button type="button" class="btn btn-danger rounded-circle close-vicall-btn">
                <i class="fa-solid fa-video-slash"></i>
            </button>
        `);
        socket.emit("start-call", { caller, receiver: receiver});
        ringtone.loop = true;
        ringtone.play();
        loadVideo(receiver);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/videocall/startcall",
            method: "post",
            dataType: "json",
            data: { caller, receiver: receiver },
            error: function (error) {
                console.log(error);
            },
        });
        clearTimeout(missedCallTimeout);
        missedCallTimeout = setTimeout(() => {
            socket.emit("close-call", { caller, receiver: receiver });
            ringtone.pause();
            ringtone.currentTime = 0;
            $(".videocall-container .friend-info small").html(
                "missed call"
            );
            $(".videocall-container .vicall-navigator").html(`
                <button type="button" class="btn btn-success rounded-circle redial-vicall-btn" data-receiver="${receiver}">
                    <i class="fa-solid fa-video"></i>
                </button>
                <button type="button" class="btn btn-light rounded-circle cancel-vicall-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `);
            $(".videocall-container .vicall-navigator")
                .removeClass("vicall-navigator--center")
                .addClass("vicall-navigator--between");
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "/videocall/misscall",
                method: "post",
                dataType: "json",
                data: { secondary: caller, main: receiver }
            });
        }, 22000)                                 
    });

    $(".videocall-container").on("click",".vicall-navigator .close-vicall-btn", function(){
        clearTimeout(missedCallTimeout);
        socket.emit("close-call", { caller, receiver: receiver });
        closeCamera();
        video.srcObject = null;
        video.remove();
        ringtone.pause();
        ringtone.currentTime = 0;
        $(".videocall-container").addClass("d-none");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/videocall/misscall",
            method: "post",
            dataType: "json",
            data: { secondary: caller, main: receiver }
        });
    });
    
    $(".videocall-container").on("click",".vicall-navigator .accept-vicall-btn", function(){
        const caller = $(this).data("caller");
        $(".videocall-container .vicall-navigator").html(
            `<small class="redirect-text">Direct to videocall...</small>`
        );
        socket.emit("accept-vicall", { caller });
        const receiver = $("nav").data("user");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/videocall/acceptcall",
            method: "post",
            dataType: "json",
            data: { secondary: caller, main: receiver },
            success: function (response) {
                if(response == "success") {
                    window.location.href = "/videocall/oncall";
                }
            },
        });
    });

    $(".videocall-container").on("click",".vicall-navigator .reject-vicall-btn", function () {
            clearTimeout(missedCallTimeout);
            const caller = $(this).data("caller");
            socket.emit("reject-call", { caller });
            closeCamera();
            video.srcObject = null;
            video.remove();
            receiveTone.pause();
            receiveTone.currentTime = 0;
            $(".videocall-container").addClass("d-none");
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "/videocall/rejectcall",
                method: "post",
                dataType: "json",
                data: { secondary: caller, main: receiver }
            });
        }
    );

    $(".videocall-container").on("click",".vicall-navigator .cancel-vicall-btn",
    function () {
            clearTimeout(missedCallTimeout);
            closeCamera();
            video.srcObject = null;
            video.remove();
            ringtone.pause();
            ringtone.currentTime = 0;
            $(".videocall-container").addClass("d-none");
        }
    );
    
    $(".videocall-container").on("click",".vicall-navigator .redial-vicall-btn",
    function () {
            $(".videocall-container .friend-info small").html("");
            $(".videocall-container .vicall-navigator")
                .removeClass("vicall-navigator--between")
                .addClass("vicall-navigator--center");

            receiver = $(this).data("receiver");
            $(".videocall-container .vicall-navigator").html(`
            <button type="button" class="btn btn-danger rounded-circle close-vicall-btn">
                <i class="fa-solid fa-video-slash"></i>
            </button>
        `);
            socket.emit("start-call", { caller, receiver: receiver });
            ringtone.loop = true;
            ringtone.play();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "/videocall/redialcall",
                method: "post",
                dataType: "json",
                data: { receiver },
                success: function(response) {
                    console.log(response);                    
                },
                error: function(error) {
                    console.log(error);                    
                }
            });
            clearTimeout(missedCallTimeout);
            missedCallTimeout = setTimeout(() => {
                socket.emit("close-call", { caller, receiver: receiver });
                ringtone.pause();
                ringtone.currentTime = 0;
                $(".videocall-container .friend-info small").html(
                    "missed call"
                );
                $(".videocall-container .vicall-navigator").html(`
                <button type="button" class="btn btn-success rounded-circle redial-vicall-btn" data-receiver="${receiver}">
                    <i class="fa-solid fa-video"></i>
                </button>
                <button type="button" class="btn btn-light rounded-circle cancel-vicall-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `);
                $(".videocall-container .vicall-navigator")
                    .removeClass("vicall-navigator--center")
                    .addClass("vicall-navigator--between");
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: "/videocall/misscall",
                    method: "post",
                    dataType: "json",
                    data: { secondary: caller, main: receiver },
                });
            }, 22000);
        }
    );
});


function loadVideo(receiver) {
    video = document.createElement("video");
    video.muted = true;
    video.playsInline = true;
    video.onloadedmetadata = () => video.play();
    $(".videocall-container").removeClass("d-none");
    $(".videocall-container .friend-info h6").text(receiver);
    $(".videocall-container").append(video);
    openCamera(video, 'user');
}

function openCamera(video, mode) {
    navigator.mediaDevices
        .getUserMedia({ video: mode, audio: false })
        .then((stream) => {
            localStream = stream;
            video.srcObject = localStream;
        })
        .catch((error) => console.log(`Failed to open camera: ${error}`));
}

function closeCamera() {
    localStream.getTracks().forEach((track) => {
        if(track.readyState === "live") {
            track.stop();
        }
    });
}

socket.on("receive-call", (data) => {
    const user = $("nav").data("user");
    if (data.receiver === user) {
        $(".videocall-container .friend-info small").html("");
        $(".videocall-container .vicall-navigator").html(`
            <button type="button" class="btn btn-success rounded-circle accept-vicall-btn" data-caller="${data.caller}">
                <i class="fa-solid fa-video"></i>
            </button>
            <button type="button" class="btn btn-danger rounded-circle reject-vicall-btn" data-caller="${data.caller}">
                <i class="fa-solid fa-video-slash"></i>
            </button>
        `);
        
        $(".videocall-container .vicall-navigator")
        .removeClass("vicall-navigator--center")
        .addClass("vicall-navigator--between");
        receiveTone.loop = true;
        receiveTone.play();
        loadVideo(data.caller);
    }
});

socket.on("close-call", (data) => {
    clearTimeout(missedCallTimeout);
    const user = $("nav").data("user");
    if (data.receiver === user) {
        closeCamera();
        video.srcObject = null;
        video.remove();
        receiveTone.pause();
        receiveTone.currentTime = 0;
        $(".videocall-container").addClass("d-none");
    }
});

socket.on("reject-call", (data) => {
    clearTimeout(missedCallTimeout);    
    const user = $("nav").data("user");
    if (data.caller === user) {
        closeCamera();
        video.srcObject = null;
        video.remove();
        ringtone.pause();
        ringtone.currentTime = 0;
        $(".videocall-container").addClass("d-none");
    }
});

socket.on("accept-vicall", (data) => {        
    const user = $("nav").data("user");
    if (data.caller === user) {
        $(".videocall-container .friend-info small").html(
            "accept your video call"
        );

        $(".videocall-container .vicall-navigator").html(
            `<small class="redirect-text">Please Wait...</small>`
        );
        window.location.href = "/videocall/oncall";
    }
});
