<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * Get all questions with their participants
     *
     * @return Question[]
     */
    public function findAllWithParticipants(): array
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.participants', 'p')
            ->leftJoin('q.alerts', 'a')
            ->addSelect('p', 'a')
            ->getQuery()
            ->getResult();
    }
}
