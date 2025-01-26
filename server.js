import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";

const app = express();
const server = createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*",
    }
});
const port = 3000;
let disconnectTimeout;
let videocall = {};

app.get("/", (req, res) => {
    res.send("<p>NodeJS running...</p>")
});

io.on("connection", (socket) => {
    clearTimeout(disconnectTimeout);
    socket.on("get-info", (data) => {
        socket.broadcast.emit("get-info", data);        
    });
    socket.on("start-call", (data) => {
        socket.broadcast.emit("receive-call", data);                
    });
    socket.on("close-call", (data) => {
        socket.broadcast.emit("close-call", data);                
    });
    socket.on("reject-call", (data) => {
        socket.broadcast.emit("reject-call", data);                
    });
    socket.on("accept-vicall", (data) => {
        socket.broadcast.emit("accept-vicall", data);        
    });
    socket.on("join-videocall", (data) => {
        const username = data.username;
        const userId = data.userId;
        const room = data.room;
        socket.join(room);
        socket.to(room).emit("new-videocall", { username, userId, room });        
                
    });
    socket.on("disconnect", () => {
        clearTimeout(disconnectTimeout);
        disconnectTimeout = setTimeout(() => {}, 5000)
    });
});

server.listen(port, () => console.log("Server running at port: 3000"));
