if(document.getElementById("vicall-room")) {
    let localStream;
    const localVideo = document.querySelector(".vicall-room .local-user video");
    const socket = io.connect("http://127.0.0.1:3000/");
    const room = $("#vicall-room").data("room");
    const user = $(".vicall-room .local-user").data("local"); 
    
    socket.emit("join-videocall", { username: user, userId: 10, room });        
    openCamera(localVideo, "user");
    function openCamera(video, mode) {
        video.onloadedmetadata = () => video.play();
        navigator.mediaDevices
            .getUserMedia({ video: mode, audio: true })
            .then((stream) => {
                localStream = stream;
                video.srcObject = localStream;
            })
            .catch((error) => console.log(`Failed to open camera: ${error}`));
    }

    // Sockets
    socket.on("new-videocall", (data) => {
        console.log(`User ${data.username} has joined video call with id ${data.userId} in ${data.room} room.`);        
    });
    socket.on("onair-videocall", (data) => {
        console.log(data.videocall);        
    });
    // End Sockets
}
