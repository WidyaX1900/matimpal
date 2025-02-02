import { Peer } from "https://esm.sh/peerjs@1.5.4?bundle-deps";
// localStream.getVideoTracks()[0];

if (document.getElementById("vicall-room")) {
    const localVideo = document.querySelector(".vicall-room .local-user video");
    const socket = io.connect("http://127.0.0.1:3000/");
    const room = $("#vicall-room").data("room");
    const user = $(".vicall-room .local-user").data("local");
    const peer = new Peer({
        host: "127.0.0.1",
        port: 3001,
        path: "/",
    });
    let localStream;

    peer.on("open", async (peerId) => {
        updatePeer(peerId, room);
        socket.emit("join-videocall", { username: user, userId: peerId, room });
        localStream = await getStream("user");
        openCamera(localVideo, localStream);

        if(localVideo.dataset.audio === "true") {
            localStream.getAudioTracks()[0].enabled = true;
        } else if(localVideo.dataset.audio === "false") {
            localStream.getAudioTracks()[0].enabled = false;
        }

        if (localVideo.dataset.camera === "true") {
            localStream.getVideoTracks()[0].enabled = true;
        } else if (localVideo.dataset.camera === "false") {
            localStream.getVideoTracks()[0].enabled = false;
        }
    });

    peer.on("call", (call) => {
        call.answer(localStream);
        call.on("stream", (remoteStream) => {
            const remoteVideo = document.querySelector(
                ".vicall-room .remote-user video"
            );
            openCamera(remoteVideo, remoteStream);
        });
    });

    $(".vicall-room").on(
        "click",
        ".vicall-navigator .close-vicall-btn",
        function () {
            endCall(room);
        }
    );
    
    $(".vicall-room").on("click", ".vicall-navigator .audio-btn",
        function () {
            const $icon = $(
                ".vicall-room .vicall-navigator .audio-btn i"
            );            
            
            if (localVideo.dataset.audio === "true") {
                localVideo.dataset.audio = "false";
                localStream.getAudioTracks()[0].enabled = false;
                $icon
                    .removeClass("fa-microphone text-light")
                    .addClass("fa-microphone-slash text-danger");
                updateMedia("audio", "false");
            } else if (localVideo.dataset.audio === "false") {
                localVideo.dataset.audio = "true";
                localStream.getAudioTracks()[0].enabled = true;
                $icon
                    .removeClass("fa-microphone-slash text-danger")
                    .addClass("fa-microphone text-light");
                updateMedia("audio", "true");
            }                                    
        }
    );
    
    $(".vicall-room").on("click", ".vicall-navigator .camera-btn",
        function () {
            const $icon = $(
                ".vicall-room .vicall-navigator .camera-btn i"
            );            
            
            if (localVideo.dataset.camera === "true") {
                localVideo.dataset.camera = "false";
                localStream.getVideoTracks()[0].enabled = false;
                $icon
                    .removeClass("text-light")
                    .addClass("text-danger");
                $("#vicall-room .local-user").append(`
                    <div class="off-cam">
                        <i class="fa-solid fa-camera text-danger"></i>
                    </div>
                `);
                socket.emit("toggle-media", { room, toggle: "false", friend: user });
                updateMedia("camera", "false");
            } else if (localVideo.dataset.camera === "false") {
                localVideo.dataset.camera = "true";
                localStream.getVideoTracks()[0].enabled = true;
                $icon
                    .removeClass("text-danger")
                    .addClass("text-light");
                $("#vicall-room .local-user .off-cam").remove();
                socket.emit("toggle-media", { room, toggle: "true", friend: user });
                updateMedia("camera", "true");
            }                                    
        }
    );

    // Functions
    async function getStream(mode) {
        let camStream = await navigator.mediaDevices.getUserMedia({
            video: mode,
            audio: true,
        });
        return camStream;
    }

    function openCamera(video, stream) {
        video.srcObject = stream;
        video.onloadedmetadata = () => video.play();
    }

    function updatePeer(peerId, room) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/videocall/updatepeer",
            method: "post",
            dataType: "json",
            data: { peer_id: peerId, room }
        });
    }
    
    function endCall(room) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/videocall/endcall",
            method: "post",
            dataType: "json",
            data: { room }
        });
    }

    function updateMedia(media, toggle) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/videocall/togglemedia",
            method: "post",
            dataType: "json",
            data: { room, media, toggle }
        });
    }
    // End Functions

    // Sockets
    socket.on("new-videocall", (data) => {
        setTimeout(() => {
            const call = peer.call(data.userId, localStream);
            call.on("stream", (remoteStream) => {
                const remoteVideo = document.querySelector(
                    ".vicall-room .remote-user video"
                );
                openCamera(remoteVideo, remoteStream);
            });
        }, 1500);        
    });
    socket.on("end-videocall", (data) => {
        setTimeout(() => {
            window.location.href = "/";            
        }, 1000);
    });
    socket.on("toggle-camera", (data) => {
        const friend = $(".vicall-room .remote-user").data("remote");
        if(friend === data.friend) {
            if(data.toggle === "false") {
                $("#vicall-room .remote-user").append(`
                    <div class="off-cam">
                        <i class="fa-solid fa-camera text-danger"></i>
                    </div>
                `);
            } else {
                $("#vicall-room .remote-user .off-cam").remove();
            }
        }                        
    });
    // End Sockets
}
