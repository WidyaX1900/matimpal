import { Peer } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

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

    // Functions
    async function getStream(mode) {
        let camStream = navigator.mediaDevices.getUserMedia({
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
        }, 1000);
    });
    // End Sockets
}
