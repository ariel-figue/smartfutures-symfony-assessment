<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Customer;
use App\Entity\Purchase;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $author->setFirstName('Jane');
        $author->setLastName('Doe');
        $manager->persist($author);

        // Uncomment and adjust the following if you want to include relationships
        
        $book = new Book();
        $book->setTitle('Sample Book');
        $book->setSummary('A great book summary.');
        $book->setPrice(19.99);
        $book->setAuthor($author);
        $manager->persist($book);

        $customer = new Customer();
        $customer->setFirstName('John');
        $customer->setLastName('Smith');
        $manager->persist($customer);

        $purchase = new Purchase();
        $purchase->setPurchaseDate(new \DateTime());
        $purchase->setBook($book);
        $purchase->setCustomer($customer);
        $manager->persist($purchase);
        

        $manager->flush();
    }
}
