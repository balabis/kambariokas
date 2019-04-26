<?php

namespace App\Repository;

use App\Entity\QuestionAnswers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionAnswers|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionAnswers|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionAnswers[]    findAll()
 * @method QuestionAnswers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionAnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionAnswers::class);
    }
}
