<?php


namespace App\Controller;

use App\Form\UserType;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/flatmate/{uuid}", name="profile.view", methods={"GET"})
     */
    public function showUserProfile(UserService $userService, $uuid): Response
    {
        $user = $userService->getUserByUUID($uuid);
        $userAge = $userService->getUserAge($user);

        return isset($user)
            ? $this->render('profile/profileView.html.twig', [
                'userAge' => $userAge,
            ])
            : $this->render('profile/profileNotFound.html.twig');
    }

    /**
     * @Route("/dashboard/profile", name="profile.edit",)
     */
    public function editUserProfile(
        Request $request,
        UserService $userService,
        FileUploader $fileUploader
    ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $userAge = $userService->getUserAge($user);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->getData()->getProfilePicture();

            if (isset($file)) {
                $userId = $user->getId()->toString();
                $fileName = $fileUploader->uploadProfilePicture($file, $userId);
                $user->setProfilePicture($fileName);
            } else {
                $gender = $form->getData()->getGender();
                $user->setProfilePicture('uploads/profile_pictures/default/' . $gender . '.png');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($user);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->refresh($user);
        }

        return $this->render('profile/profileEdit.html.twig', [
            'form' => $form->createView(),
            'userAge' => $userAge,
        ]);
    }
}
