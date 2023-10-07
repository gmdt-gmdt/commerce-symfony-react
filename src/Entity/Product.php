<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?float $discountPercentage = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\ManyToOne(inversedBy: 'products', targetEntity: Category::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;


    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $image;

    #[ORM\Column(length: 255)]
    private ?string $thumbnail = null;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }
  
    public function __toString()
    {
        return $this->getTitle() ?? 'Product (ID: ' . $this->getId() . ')';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountPercentage(): ?float
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(float $discountPercentage): static
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(ProductImage $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(ProductImage $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $imageUrls = [];
        foreach ($this->getImage() as $image) {
            $imageUrls[] = $image->getUrl();
        }

        return [
            "id" => $this->getId(),
            "price" => $this->getPrice(),
            "discountPercentage" => $this->getDiscountPercentage(),
            "rating" => $this->getRating(),
            "stock" => $this->getStock(),
            "category" => $this->getCategory() ? $this->getCategory()->getName() : '',
            "brand" => $this->getBrand(),
            "thumbnail" => $this->getThumbnail(),
            "images" => $imageUrls,
            "title" => $this->getTitle(),
            "description" => $this->getDescription()
        ];
    }
}
