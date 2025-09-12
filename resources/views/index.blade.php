<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão</title>

    @php
        // Caminho do manifest dentro da pasta .vite
        $manifestPath = public_path('frontend/.vite/manifest.json');
        $manifest = file_exists($manifestPath) 
            ? json_decode(file_get_contents($manifestPath), true) 
            : null;

        $jsFile = $manifest['index.html']['file'] ?? null;
        $cssFiles = $manifest['index.html']['css'] ?? [];
    @endphp

    @if ($manifest)
        {{-- Carrega os CSS gerados pelo Vite --}}
        @foreach ($cssFiles as $css)
            <link rel="stylesheet" href="{{ secure_asset('frontend/' . $css) }}">
        @endforeach
    @endif
</head>
<body>
    <div id="app"></div>

    @if ($manifest && $jsFile)
        {{-- Carrega o JS gerado pelo Vite --}}
        <script type="module" src="{{ secure_asset('frontend/' . $jsFile) }}"></script>
    @endif
</body>
</html>
