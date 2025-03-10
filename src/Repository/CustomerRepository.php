<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for querying Customer entities.
 *
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * Retrieve all customers with their purchases.
     * Uses JOIN FETCH to optimize query performance.
     *
     * @return Customer[] Returns an array of Customer objects with their purchases.
     */
    public function findAllWithPurchases(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.purchases', 'p')
            ->addSelect('p')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve a single customer by ID along with their purchases.
     *
     * @param int $id The ID of the customer.
     * @return Customer|null The customer entity with purchases or null if not found.
     */
    public function findOneWithPurchases(int $id): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.purchases', 'p')
            ->addSelect('p')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retrieve customers who have made at least one purchase.
     *
     * @return Customer[] Returns an array of Customer objects who have made purchases.
     */
    public function findCustomersWithPurchases(): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.purchases', 'p') // Ensures only customers with purchases are retrieved
            ->addSelect('p')
            ->groupBy('c.id')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve customers who have purchased a specific book.
     *
     * @param int $bookId The ID of the book.
     * @return Customer[] Returns an array of Customer objects who have purchased the specified book.
     */
    public function findCustomersByBook(int $bookId): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.purchases', 'p')
            ->innerJoin('p.book', 'b')
            ->where('b.id = :bookId')
            ->setParameter('bookId', $bookId)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
