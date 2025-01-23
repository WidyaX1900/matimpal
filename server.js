import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";

const app = express();
const server = createServer(app);
const io = new Server(server);
const port = 3000;
let disconnectTimeout;

app.get("/", (req, res) => {
    res.send("<p>NodeJS running...</p>")
});

io.on("connection", (socket) => {
    clearTimeout(disconnectTimeout);
    console.log("User connected");
    socket.on("get-info", (data) => {
        console.log(data);        
    });
    socket.on("disconnect", () => {});
});

server.listen(port, () => console.log("Server running at port: 3000"));
