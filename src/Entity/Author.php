<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Represents an Author entity in the application, exposing it via API Platform.
 * This entity manages author details and their associated books.
 */
#[ORM\Entity]
#[ApiResource]
class Author
{
    /**
     * Unique identifier for the author, auto-generated by Doctrine.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The author's first name, limited to 255 characters.
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $firstName = null;

    /**
     * The author's last name, limited to 255 characters.
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $lastName = null;

    // Getters and setters

    /**
     * Retrieves the author's ID.
     *
     * @return int|null The author ID or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retrieves the author's first name.
     *
     * @return string|null The first name or null if not set.
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Sets the author's first name.
     *
     * @param string $firstName The first name to set.
     * @return self Returns the current instance for method chaining.
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Retrieves the author's last name.
     *
     * @return string|null The last name or null if not set.
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Sets the author's last name.
     *
     * @param string $lastName The last name to set.
     * @return self Returns the current instance for method chaining.
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Collection of books authored by this author, mapped by the 'author' property in the Book entity.
     * Uses OneToMany relationship with lazy loading by default.
     *
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class)]
    private Collection $books;

    /**
     * Constructor to initialize the books collection.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * Retrieves all books associated with this author.
     *
     * @return Collection The collection of books.
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * Adds a book to the author's collection, ensuring no duplicates and updating the book's author reference.
     *
     * @param Book $book The book to add.
     * @return self Returns the current instance for method chaining.
     */
    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthor($this); // Maintain bidirectional relationship
        }
        return $this;
    }

    /**
     * Removes a book from the author's collection, updating the book's author reference if necessary.
     *
     * @param Book $book The book to remove.
     * @return self Returns the current instance for method chaining.
     */
    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null); // Clean up bidirectional relationship
            }
        }
        return $this;
    }
}