<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 2, unique: true)]
    private ?string $slug = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\CountryTax", fetch: "EAGER", inversedBy: "collect")]
    #[ORM\JoinColumn(name: "tax_id", referencedColumnName: "id")]
    private CountryTax $taxId;

    public function setTaxId(CountryTax $taxId): void
    {
        $this->taxId = $taxId;
    }

    public function getTaxId(): CountryTax
    {
        return $this->taxId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
}
