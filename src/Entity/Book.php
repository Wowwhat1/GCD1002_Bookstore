<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Author;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     */
    private $Category;

    /**
     * @ORM\ManyToOne(targetEntity=Publisher::class, inversedBy="books")
     */
    private $Publisher;

    /**
     * @ORM\Column(type="float")
     */
    private $Cost;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgUrl;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="Book")
     */
    private $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->Author;
    }

    public function setAuthor(string $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->Publisher;
    }

    public function setPublisher(?Publisher $Publisher): self
    {
        $this->Publisher = $Publisher;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->Cost;
    }

    public function setCost(float $Cost): self
    {
        $this->Cost = $Cost;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setBook($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getBook() === $this) {
                $orderDetail->setBook(null);
            }
        }

        return $this;
    }
}
