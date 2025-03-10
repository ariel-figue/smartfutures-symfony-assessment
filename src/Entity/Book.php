<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\Common\Collections\Collection;   

/**
 * Represents a Book entity.
 * 
 * This entity is mapped using Doctrine ORM and exposed via API Platform.
 */
#[ORM\Entity]
#[ApiResource]
class Book
{
    /**
     * @var int|null $id The unique identifier of the book.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null $title The title of the book.
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    /**
     * @var string|null $summary A brief description of the book.
     */
    #[ORM\Column(type: 'text')]
    private ?string $summary = null;

    /**
     * @var float|null $price The price of the book.
     */
    #[ORM\Column(type: 'float')]
    private ?float $price = null;

    /**
     * @var Author|null $author The author who wrote the book.
     * 
     * This defines a Many-to-One relationship with the Author entity.
     */
    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    /**
     * Get the unique identifier of the book.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the book title.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the book title.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the summary of the book.
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * Set the summary of the book.
     */
    public function setSummary(string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Get the price of the book.
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Set the price of the book.
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get the author of the book.
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * Set the author of the book.
     */
    public function setAuthor(?Author $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @var Collection<int, Purchase> $purchases The purchases associated with this book.
     * 
     * Defines a One-to-Many relationship with the Purchase entity.
     */
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Purchase::class)]
    private Collection $purchases;

    /**
     * Book constructor initializes the purchases collection.
     */
    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    /**
     * Get the collection of purchases related to this book.
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    /**
     * Add a purchase record for this book.
     */
    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setBook($this);
        }
        return $this;
    }

    /**
     * Remove a purchase record associated with this book.
     */
    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // Set the book reference to null if it was associated with this book
            if ($purchase->getBook() === $this) {
                $purchase->setBook(null);
            }
        }
        return $this;
    }
}
