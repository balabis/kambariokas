<?php

namespace App\Repository;

use App\Entity\QuestionnaireScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionnaireScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionnaireScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionnaireScore[]    findAll()
 * @method QuestionnaireScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionnaireScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionnaireScore::class);
    }
}
