<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMatch[]    findAll()
 * @method UserMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMatchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserMatch::class);
    }

    /**
     * @param User $user
     */
    public function deleteUsersMatch(User $user) : void
    {
        $db = $this->createQueryBuilder('p')
            ->delete('UserMatch', 'p')
            ->where('p.firstUser = :val');
        $db->setParameters(['val', $user->getId()]);
        var_dump($db->getParameter('val'));
        var_dump($db->Query());
    }
}