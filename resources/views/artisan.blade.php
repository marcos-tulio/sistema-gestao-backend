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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <div class="container">
        <h1>Artisan Web Console</h1>

        <div class="buttons">
            <button onclick="runCommand('migrate:fresh')">Migrate Fresh</button>
            <button onclick="runCommand('db:seed')">db:seed</button>

            <!-- Configuração -->
            <div id="g_id_onload"
                data-client_id="{{ config('services.google.client_id') }}"
                data-callback="handleCredentialResponse">
            </div>

            <!-- Botão -->
            <div class="g_id_signin"
                data-type="standard"
                data-size="large"
                data-theme="outline"
                data-text="signin_with"
                data-shape="rectangular">
            </div>

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

        window.handleCredentialResponse = function (response) {
            const output = document.getElementById("output");
            output.textContent += "ID TOKEN:\n" + response.credential + "\n\n";
        };
    </script>
</body>
</html>
