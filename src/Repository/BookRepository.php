<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for querying Book entities.
 *
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Retrieve all books with their associated authors.
     * Uses JOIN FETCH to optimize query performance.
     *
     * @return Book[] Returns an array of Book objects with their authors.
     */
    public function findAllWithAuthors(): array
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->addSelect('a')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve a single book by ID along with its author.
     *
     * @param int $id The ID of the book.
     * @return Book|null The book entity with its author or null if not found.
     */
    public function findOneWithAuthor(int $id): ?Book
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->addSelect('a')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retrieve books within a specified price range.
     *
     * @param float $minPrice Minimum price.
     * @param float $maxPrice Maximum price.
     * @return Book[] Returns an array of Book objects within the given price range.
     */
    public function findBooksByPriceRange(float $minPrice, float $maxPrice): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.price BETWEEN :minPrice AND :maxPrice')
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            ->orderBy('b.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve books by a specific author.
     *
     * @param int $authorId The ID of the author.
     * @return Book[] Returns an array of Book objects by the specified author.
     */
    public function findBooksByAuthor(int $authorId): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.author = :authorId')
            ->setParameter('authorId', $authorId)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
