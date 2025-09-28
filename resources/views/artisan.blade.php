<!DOCTYPE html>
<html>
<head>
    <title>Artisan Console</title>
    <style>
        body { 
            color: #111; 
            font-family: monospace; 
            height: 100vh;
            margin: 0;
        }

        #output { 
            background: #000;
            color: #fff;
            padding: 10px; 
            overflow-y: auto; 
            white-space: pre-wrap;
            display: flex;
            height: 100%;
            margin: 10px 0;
        }

        input, button { 
            width: 100%; 
            margin: 5px 0;
            padding: 8px; 
        }

        .container{ 
            max-width: 1024px; 
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .buttons{ 
            display: flex; 
            gap: 10px; 
        }
        
        .buttons button{ 
            max-width: 100px 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Artisan Web Console</h1>

        <div class="buttons">
            <button onclick="runCommand('migrate:fresh')">Migrate Fresh</button>
            <button onclick="runCommand('db:seed')">db:seed</button>
        </div>
        <div class="buttons">
            <input id="command" type="text" placeholder="ex: migrate --seed">
            <button onclick="runCommand()">Executar</button>
        </div>

        <div id="output"></div>
    </div>

    <script>
        function runCommand(command = null) {
            const cmd = command ?? document.getElementById("command").value;
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
