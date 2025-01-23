<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tes Socket</title>
</head>
<body>
    <h1 id="tesEl">Tes Receive Socket</h1>
    <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
    <script>
        const socket = io.connect("http://127.0.0.1:3000/");
        socket.on("get-info", (data) => {
            document.getElementById("tesEl").innerText = data.name;
        });
    </script>
</body>
</html>