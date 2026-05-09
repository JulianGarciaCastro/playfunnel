<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaFileController extends Controller
{
    public function show(string $path)
    {
        $path = rawurldecode($path);

        if (!Str::startsWith($path, 'media/') || Str::contains($path, ['../', '..\\'])) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($path), [
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }
}
