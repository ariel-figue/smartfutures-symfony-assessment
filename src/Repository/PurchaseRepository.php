<?php

namespace App\Repository;

use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for querying Purchase entities.
 *
 * @extends ServiceEntityRepository<Purchase>
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    /**
     * Retrieve all purchases with their associated customers and books.
     * Uses JOIN FETCH to optimize query performance.
     *
     * @return Purchase[] Returns an array of Purchase objects with related entities.
     */
    public function findAllWithCustomerAndBook(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.customer', 'c')
            ->addSelect('c')
            ->leftJoin('p.book', 'b')
            ->addSelect('b')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve a single purchase by ID along with customer and book details.
     *
     * @param int $id The ID of the purchase.
     * @return Purchase|null The purchase entity with related customer and book or null if not found.
     */
    public function findOneWithCustomerAndBook(int $id): ?Purchase
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.customer', 'c')
            ->addSelect('c')
            ->leftJoin('p.book', 'b')
            ->addSelect('b')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retrieve purchases made by a specific customer.
     *
     * @param int $customerId The ID of the customer.
     * @return Purchase[] Returns an array of Purchase objects for the given customer.
     */
    public function findPurchasesByCustomer(int $customerId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.customer = :customerId')
            ->setParameter('customerId', $customerId)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve purchases for a specific book.
     *
     * @param int $bookId The ID of the book.
     * @return Purchase[] Returns an array of Purchase objects for the given book.
     */
    public function findPurchasesByBook(int $bookId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.book = :bookId')
            ->setParameter('bookId', $bookId)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
