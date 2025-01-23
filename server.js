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

app.get("/", (req, res) => {
    res.send("<p>NodeJS running...</p>")
});

io.on("connection", (socket) => {
    clearTimeout(disconnectTimeout);
    socket.on("get-info", (data) => {
        socket.broadcast.emit("get-info", data);        
    });
    socket.on("disconnect", () => {
        clearTimeout(disconnectTimeout);
        disconnectTimeout = setTimeout(() => {}, 5000)
    });
});

server.listen(port, () => console.log("Server running at port: 3000"));
