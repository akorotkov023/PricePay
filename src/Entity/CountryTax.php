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

    #[ORM\Column]
    private ?int $tax = null;

    #[ORM\OneToMany(targetEntity: "App\Entity\Country", mappedBy: "taxId")]
    private Collection $collect;

    public function __construct() {
        $this->collect = new ArrayCollection();
    }

    public function getCollect(): Collection
    {
        return $this->collect;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;
        return $this;
    }
}
