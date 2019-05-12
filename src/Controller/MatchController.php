<?php

namespace App\Controller;

use App\Services\MatchService;
use App\Services\UserCompareService;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    /**
     * @Route("/matched", name="matched")
     */
    public function index(
        EntityManagerInterface $entityManager,
        MatchService $service,
        UserService $userService,
        UserCompareService $compareService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $service->filter($this->getUser());

        $matches = $service->getPossibleMatch($this->getUser());
        $usersName = $userService->getAllUsersNamesByUUID($matches);

        return $this->render('match/index.html.twig', [
            'contentName' => 'Match',
            'matchesInfo' => $matches,
            'usersName' => $usersName,
            'userCount'=> (count($matches) - 1)
        ]);
    }
}
