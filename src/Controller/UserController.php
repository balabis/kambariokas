<?php


namespace App\Controller;


use App\Service\UserService;

class UserController
{

    /**
     * @Route("/flatmates/{id}", name="flatmates.search")
     */
    public function showUserProfile(UserService $userService)
    {

    }

    /**
     * @Route("/dashboard/profile", )
     */
    public function editUserProfile(UserService $userService)
    {

    }

}