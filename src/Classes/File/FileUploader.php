<?php

declare(strict_types=1);

namespace App\Classes\File;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private const PUBLIC_DIRECTORY = 'tmp/';

    /**
     * @var string
     */
    private $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $uuid = Uuid::uuid4();

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $uuid->toString().'.'.$file->guessExtension();

        try {
            $file->move($this->targetDirectory, $fileName);
        } catch (FileException $e) {
            dd('failed');
        }

        return self::PUBLIC_DIRECTORY.$fileName;
    }
}
