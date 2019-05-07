<?php


namespace App\Controller;

use App\Entity\UpdateUserRequest;
use App\Form\UserType;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UserService;

class UserController extends AbstractController
{

    /**
     * @Route("/flatmate/{uuid}", name="profile.view", methods={"GET"})
     * @return Response
     */
    public function showUserProfile(UserService $userService, $uuid): Response
    {
        $user = $userService->getUserByUUID($uuid);
        $userAge = $userService->getUserAge($user);
        $profileOfCurrentlyLoggedUser =  $this->getUser()->getId() === $user->getId();

        return isset($user)
            ? $this->render('profile/profileView.html.twig', [
                'userAge' => $userAge,
                'profileAuthor' => $profileOfCurrentlyLoggedUser,
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

        $user = $userService->getUserByUUID($this->getUser()->getId());
        $updateUserRequest = UpdateUserRequest::fromUser($user);
        $userAge = $userService->getUserAge($user);

        $form = $this->createForm(UserType::class, $updateUserRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->getData()->getProfilePicture();

            if (isset($file)) {
                $userId = $user->getId()->toString();
                $fileName = $fileUploader->uploadProfilePicture($file, $userId);
                $updateUserRequest->setProfilePicture($fileName);
            } else {
                $gender = $form->getData()->getGender();
                $updateUserRequest->setProfilePicture('uploads/profile_pictures/default/' . $gender . '.png');
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($updateUserRequest);
            $entityManager->flush();
//            $user->setProfilePicture(null);
            return $this->redirect($request->getUri());
        }
        return $this->render('profile/profileEdit.html.twig', [
            'form' => $form->createView(),
            'userAge' => $userAge,
        ]);
    }
}
