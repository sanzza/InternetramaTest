<?php

namespace App\Entity;

use App\Repository\SocieteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocieteRepository::class)
 */
class Societe
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
    private $nom;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siret;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nic;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreationEtablissement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeEffectifEtablissement;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNom()
    {
        return $this -> nom;
    }

    public function setNom($nom): void
    {
        $this -> nom = $nom;
    }

    public function getSiren(): ?int
    {
        return $this->siren;
    }

    public function setSiren(?int $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNic(): ?int
    {
        return $this->nic;
    }

    public function setNic(?int $nic): self
    {
        $this->nic = $nic;

        return $this;
    }

    public function getDateCreationEtablissement(): ?\DateTimeInterface
    {
        return $this->dateCreationEtablissement;
    }

    public function setDateCreationEtablissement(?\DateTimeInterface $dateCreationEtablissement): self
    {
        $this->dateCreationEtablissement = $dateCreationEtablissement;

        return $this;
    }

    public function getAnneeEffectifEtablissement(): ?int
    {
        return $this->anneeEffectifEtablissement;
    }

    public function setAnneeEffectifEtablissement(?int $anneeEffectifEtablissement): self
    {
        $this->anneeEffectifEtablissement = $anneeEffectifEtablissement;

        return $this;
    }
}
