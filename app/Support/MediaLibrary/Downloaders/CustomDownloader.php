<?php

namespace App\Support\MediaLibrary\Downloaders;

use Spatie\MediaLibrary\Downloaders\Downloader;

class CustomDownloader implements Downloader
{
    public function getTempFile(string $url): string
    {
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36",
            ],
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ]);

        $stream = file_get_contents($url, false, $context);

        $temporaryFile = tempnam(sys_get_temp_dir(), 'media-library');
        
        file_put_contents($temporaryFile, $stream);

        return $temporaryFile;
    }
}