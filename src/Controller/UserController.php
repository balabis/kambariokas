<?php


namespace App\Controller;

use App\Form\UserType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

class UserController extends AbstractController
{

    /**
     * @Route("/flatmate/{uuid}", name="profile.view", methods={"GET"})
     * @param UserService $userService
     * @param $uuid
     * @return Response
     */
    public function showUserProfile(UserService $userService, $uuid): Response
    {
        $user = $userService->getUserByUUID($uuid);

        return isset($user)
            ? $this->render('profile/profileView.html.twig')
            : $this->render('profile/profileNotFound.html.twig');
    }

    /**
     * @Route("/dashboard/profile", name="profile.edit",)
     * @param UserService $userService
     * @return Response
     */
    public function editUserProfile(Request $request, UserService $userService, FileUploader $fileUploader): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $userService->getUserByUUID($this->getUser()->getId());

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('profile_picture');
            $userId = $user->getId()->toString();
            $fileName = $fileUploader->uploadProfilePicture($file, $userId);

            $user->setProfilePicture($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        }

        return $this->render('profile/profileEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}