<?php

namespace App\Repository;

use App\Entity\Invite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invite[]    findAll()
 * @method Invite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InviteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invite::class);
    }

    public function findSentInvites($userId): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT um.*, u.*, i.*
        FROM invite i
        LEFT JOIN user u ON i.receiver_id = u.id 
        LEFT JOIN user_match um ON um.second_user = i.receiver_id
        WHERE i.sender_id = :id AND um.first_user = :id
        ORDER BY i.created_at ASC
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$userId]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function findReceivedInvites($userId): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT um.*, u.*, i.*
        FROM invite i
        LEFT JOIN user u ON i.sender_id = u.id
        LEFT JOIN user_match um ON um.first_user = i.receiver_id AND um.second_user = i.sender_id
        WHERE i.receiver_id = :id AND um.first_user = :id
        ORDER BY i.created_at ASC
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$userId]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
