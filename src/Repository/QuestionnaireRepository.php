<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Questionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questionnaire[]    findAll()
 * @method Questionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Questionnaire::class);
    }
}
