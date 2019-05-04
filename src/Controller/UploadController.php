<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Symfony\Component\Security\Core\User\UserInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/flatmate/doUpload", name="upload")
     */
    public function index(Request $request, string $uploadDir, FileUploader $uploader, UserInterface $user)
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token)) {
            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST, ['content-type' => 'text/plain']);
        }

        $file = $request->files->get('profile_picture');

        if (empty($file)) {
            return new Response("No file specified",
                Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $userId = $user->getId()->toString();
        $filename = $file->getClientOriginalName();
        $uploader->upload($uploadDir.'profile_pictures/'.$userId, $file, $filename);

        return $this->redirect('/flatmate/'.$userId);
    }
}