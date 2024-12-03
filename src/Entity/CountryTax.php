<?php

namespace App\Entity;

use App\Repository\CountryTaxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryTaxRepository::class)]
class CountryTax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 2, unique: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $tax = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): static
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return Collection<int, ProductCountryTax>
     */
    public function getProductCountryTaxes(): Collection
    {
        return $this->productCountryTaxes;
    }

    public function addProductCountryTax(ProductCountryTax $productCountryTax): static
    {
        if (!$this->productCountryTaxes->contains($productCountryTax)) {
            $this->productCountryTaxes->add($productCountryTax);
            $productCountryTax->setCountryTaxId($this);
        }

        return $this;
    }

    public function removeProductCountryTax(ProductCountryTax $productCountryTax): static
    {
        if ($this->productCountryTaxes->removeElement($productCountryTax)) {
            // set the owning side to null (unless already changed)
            if ($productCountryTax->getCountryTaxId() === $this) {
                $productCountryTax->setCountryTaxId(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
