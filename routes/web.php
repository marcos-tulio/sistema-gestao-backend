<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

Route::get('/artisan/run/{cmd}', function ($cmd) {
    return response()->stream(function () use ($cmd) {
        // força saída imediata
        @ini_set('output_buffering', 'off');
        @ini_set('zlib.output_compression', false);
        while (ob_get_level() > 0) ob_end_flush();
        ob_implicit_flush(true);

        // caminho absoluto do artisan
        $artisanPath = base_path('artisan');

        // separa o comando e argumentos
        $parts = explode(' ', $cmd);
        $process = new Process(array_merge(['php', $artisanPath], $parts));
        $process->setTimeout(null);
        $process->start();

        // envia saída linha por linha
        foreach ($process as $type => $data) {
            if (!empty(trim($data))) {
                echo "data: " . str_replace("\n", "\ndata: ", trim($data)) . "\n\n";
                flush();
            }
        }

        echo "data: [FIM]\n\n";
        flush();
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
    ]);
});

Route::match(['get', 'post'], '/artisan', function (Request $request) {
    $output = null;

    if ($request->isMethod('post')) {
        $command = $request->input('command');

        try {
            Artisan::call($command, ['--force' => true]);
            $output = Artisan::output();
        } catch (\Throwable $e) {
            $output = $e->getMessage();
        }
    }

    return view('artisan', compact('output'));
}); // 🔒 restrinja o acesso!

Route::get('/{any}', function () {
    return view('index');
})->where('any', '^(?!frontend|api).*$');
