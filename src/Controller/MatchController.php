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
        if ($this->getUser()->getQuestionnaireScore()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $service->filter($entityManager, $this->getUser(), $compareService);

            $matches = $service->getPossibleMatch($this->getUser(), $entityManager);
            $usersName = $userService->getAllUsersNamesByUUID($matches);

            return $this->render('match/index.html.twig', [
                'contentName' => 'Match',
                'matchesInfo' => $matches,
                'usersName' => $usersName,
                'userCount'=> count($matches) - 1
            ]);
        }

        return $this->render('match/noMatch.html.twig', [
            'contentName' => 'Match'
        ]);



    }
}
