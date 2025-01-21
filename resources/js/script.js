let video;
let localStream;
let ringtone = $("#callSfx")[0];

$(document).ready(function() {
    $(".friend-list li .vicall-icon").on("click", function(){
        const $receiver = $(this).data("receiver");
        ringtone.loop = true;
        ringtone.play();
        loadVideo($receiver);                                 
    });

    $(".videocall-container .vicall-navigator .close-vicall-btn").on("click", function() {
        closeCamera();        
        video.srcObject = null;
        video.remove();
        ringtone.pause();
        ringtone.currentTime = 0;
        $(".videocall-container").addClass("d-none");
    });
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
