<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function editUserProfile(UserService $userService): Response
    {
        // if user is authenticated navigate to this url
        // if user is not authenticated (not logged in), redirect to login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        return $this->render('profile/profileEdit.html.twig');

    }

}