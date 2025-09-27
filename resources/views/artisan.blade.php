<!DOCTYPE html>
<html>
<head>
    <title>Artisan Console</title>
    <style>
        body { background: #111; color: #eee; font-family: monospace; }
        #output { background: #000; padding: 10px; height: 400px; overflow-y: auto; white-space: pre-wrap; }
        input, button { width: 100%; margin: 5px 0; padding: 8px; }

        .container{ max-width: 1024px; margin: 0 auto; }
        .buttons{ display: flex; margin: 10px 0; gap: 10px; }
        .buttons button{ max-width: 100px }
    </style>
</head>
<body>
    <div class="container">
        <h1>Artisan Web Console</h1>

        <div class="buttons">
            <input id="command" type="text" placeholder="ex: migrate --seed">
            <button onclick="runCommand()">Executar</button>
        </div>

        <div id="output"></div>
    </div>

    <script>
        function runCommand() {
            const cmd = document.getElementById("command").value;
            const output = document.getElementById("output");
            output.innerHTML = "";

            const eventSource = new EventSource("/artisan/run/" + encodeURIComponent(cmd));

            eventSource.onmessage = function(e) {
                output.innerHTML += e.data + "\n";
                output.scrollTop = output.scrollHeight;
            };

            eventSource.onerror = function() {
                output.innerHTML += "\n[Concluído ou erro]\n";
                eventSource.close();
            };
        }
    </script>
</body>
</html>
