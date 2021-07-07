<?php

namespace App\Containers\Books\Classes;

use App\Models\Book;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class BinderImagesBooks
{

    public function saveImage(?string $uri)
    {
        if (!$uri) {
            return null;
        }

        $this->saveImageOnLocalDisk($uri);
    }

    public function getNameForDatabase(?string $uri): ?string
    {
        return $this->getImageName($uri);
    }

    public function getLocalImageUrl(string $imageName): string
    {
        return Storage::disk('books')->url($imageName);
    }


    private function getImageName(?string $uri): ?string
    {
        if (!$uri) {
            return null;
        }

        $hashName = hash('md5', $uri);
        $extension = pathinfo($uri, PATHINFO_EXTENSION);

        return $hashName . '.' . $extension;
    }

    private function saveImageOnLocalDisk(?string $uri): bool
    {
        $fileName = $this->getImageName($uri);

        if (!Storage::disk('books')->exists($fileName)) {
            $file = file_get_contents($uri);

            Storage::disk('books')->put($fileName, $file);
        }

        return true;
    }

    public function getBookImage(Book $book)
    {
        $filename = $book->thumbnailUrl ?? '';

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        try {
            $file = Storage::disk('books')->get($filename);
        } catch (FileNotFoundException $e) {
            $file = '';
        }

        $base64 = $file ?? null;

        if (!$base64) {
            return null;
        }

        return  sprintf(
            "data:image/{$extension};base64, %s",
            base64_encode($file ?? '')
        );
    }
}
