<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function findQuestionsByQuestionnaireWithAnswers($questionnaireId)
    {
        return $this->createQueryBuilder('q')
            // p.category refers to the "category" property on product
            ->innerJoin('q.answers', 'c')
            // selects all the category data to avoid the query
            ->addSelect('c')
            ->andWhere('q.questionnaireId = :questionnaireId')
            ->setParameter('questionnaireId', $questionnaireId)
            ->getQuery()
            ->getResult();
    }
}
