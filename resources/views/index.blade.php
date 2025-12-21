<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="/favicon-dark.svg" media="(prefers-color-scheme: light)"/>
    <link rel="icon" type="image/svg+xml" href="/favicon-light.svg" media="(prefers-color-scheme: dark)"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ config('app.name') }}</title>

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
        @foreach ($cssFiles as $css)
            <link rel="stylesheet" href="/frontend/{{ $css }}">
        @endforeach
    @endif
</head>
<body>
    <div id="app"></div>

    @if ($manifest && $jsFile)
        <script type="module" src="/frontend/{{ $jsFile }}"></script>
    @endif
</body>
</html>
