<?php

namespace App\Repository;

use App\Entity\UserMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMatch[]    findAll()
 * @method UserMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMatchRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, UserMatch::class);
        $this->entityManager = $entityManager;
    }

    public function query(string $query) : void
    {
        $statement = $this->entityManager->getConnection()->prepare($query);
        $statement->execute();
    }

    public function findMatches($userId): array
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
        SELECT um.*, user.*, invite.*
        FROM user_match um
        LEFT JOIN user ON um.second_user = user.id
        LEFT JOIN invite ON (invite.sender_id = :id 
        AND invite.receiver_id = user.id) OR (invite.sender_id = user.id AND invite.receiver_id = :id) 
        WHERE um.first_user = :id
        ORDER BY um.coeficient DESC
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$userId]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
