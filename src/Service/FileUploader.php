<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function uploadProfilePicture(UploadedFile $file, string $id)
    {
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $uploadDir = $this->getTargetDirectory() . 'profile_pictures/' . $id;

        try {
            $file->move($uploadDir, $filename);
        } catch (FileException $e) {
            throw new FileException('Failed to upload file');
        }

        return $filename;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}