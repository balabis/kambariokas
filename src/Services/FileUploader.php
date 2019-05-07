<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    /**
     * @param UploadedFile $file
     * @param string $id
     * @return string
     */
    public function uploadProfilePicture(UploadedFile $file, string $id)
    {
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $uploadDir = 'uploads/profile_pictures/' . $id;

        try {
            $file->move($uploadDir, $filename);
        } catch (FileException $e) {
            throw new FileException('Failed to upload file');
        }

        return $uploadDir.'/'.$filename;
    }
}
