let video;
let localStream;
let ringtone = $("#callSfx")[0];
let receiveTone = $("#ringtone")[0];
let receiver;
const caller = $("nav").data("user");
const socket = io.connect("http://127.0.0.1:3000/");

$(document).ready(function() {
    $(".friend-list li .vicall-icon").on("click", function(){
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
    });

    $(".videocall-container").on("click",".vicall-navigator .close-vicall-btn", function(){
        socket.emit("close-call", { caller, receiver: receiver });
        closeCamera();
        video.srcObject = null;
        video.remove();
        ringtone.pause();
        ringtone.currentTime = 0;
        $(".videocall-container").addClass("d-none");
    });
    
    $(".videocall-container").on("click",".vicall-navigator .accept-vicall-btn", function(){
        const caller = $(this).data("caller");
        $(".videocall-container .vicall-navigator").html(
            `<small class="redirect-text">Direct to videocall...</small>`
        );
        socket.emit("accept-vicall", { caller });
    });

    $(".videocall-container").on("click",".vicall-navigator .reject-vicall-btn", function () {
            const caller = $(this).data("caller");
            socket.emit("reject-call", { caller });
            closeCamera();
            video.srcObject = null;
            video.remove();
            receiveTone.pause();
            receiveTone.currentTime = 0;
            $(".videocall-container").addClass("d-none");
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
    }
});
