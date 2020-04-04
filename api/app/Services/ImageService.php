<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    const ORIGIN = 'storage/images/';
    const CACHE = 'storage/images/cache/';

    private array $mimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
    ];

    public static function i(): self
    {
        return new self();
    }

    public function fit($filename, $w = null, $h = null): ?string
    {
        if (!$filename || !Storage::disk('public')
            ->exists("images/$filename")) {
            return null;
        }

        $origin = $this->getOrigin($filename);

        if (!$this->validate($origin)) {
            throw new \Exception('Mime type');
        }

        $ext = $this->mimeTypes[mime_content_type($origin)];

        [$_w, $_h] = getimagesize($origin);

        if (!$w && !$h) {
            $w = $_w;
            $h = $_h;
            $postfix = 'origin';
        } elseif (!$w) {
            $w = round($_w / ($_h / $h));
            $postfix = 'h' . $h;
        } elseif (!$h) {
            $h = round($_h / ($_w / $w));
            $postfix = 'w' . $w;
        } else {
            $postfix = $w . 'x' . $h;
        }

        $cache = substr($filename, 0, strrpos($filename, '.'))
            . '-' . $postfix . '-fit.' . $ext;

        $result = self::CACHE . $cache;

        if (!Storage::disk('public')->exists('images/cache')) {
            Storage::disk('public')->makeDirectory('images/cache');
        }

        if (!Storage::disk('public')->exists('images/cache/' . $cache) || filectime($origin) > filectime($result)) {

            $shell = 'mogrify -write ' . $result . ' -resize "' . $w . 'x' . $h
                . '^" -gravity center -crop ' . $w . 'x' . $h . '+0+0 '
                . self::ORIGIN . $filename;

            shell_exec($shell);

            switch ($ext) {
                case 'png':
                    shell_exec('optipng -o2 -strip all ' . $result);
                    break;
                case 'jpg':
                    shell_exec('jpegoptim ' . $result . ' --all-progressive --strip-all --max=90 --force');
                    break;
            }
        }

        return asset($result);
    }

    private function getOrigin(string $filename): string
    {
        return Storage::disk('public')->path('images/' . $filename);
    }

    private function validate(string $origin): bool
    {
        return array_key_exists(mime_content_type($origin), $this->mimeTypes);
    }
}
