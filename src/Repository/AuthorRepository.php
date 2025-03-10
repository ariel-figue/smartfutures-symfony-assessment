<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for querying Author entities.
 *
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * Retrieve all authors with their books.
     * This uses a JOIN FETCH to optimize query performance.
     *
     * @return Author[] Returns an array of Author objects with their books
     */
    public function findAllWithBooks(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.books', 'b')
            ->addSelect('b')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve a single author by ID along with their books.
     * 
     * @param int $id The ID of the author.
     * @return Author|null The author entity with books or null if not found.
     */
    public function findOneWithBooks(int $id): ?Author
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.books', 'b')
            ->addSelect('b')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
