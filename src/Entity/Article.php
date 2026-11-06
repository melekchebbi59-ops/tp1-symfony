<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Le titre doit contenir au moins 5 caractères.',
        maxMessage: 'Le titre ne peut pas dépasser 255 caractères.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Assert\NotBlank(message: 'Le contenu est obligatoire.')]
    #[Assert\Length(
        min: 20,
        minMessage: 'Le contenu doit contenir au moins 20 caractères.'
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[Assert\NotBlank(message: 'Le nom de l’auteur est obligatoire.')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le nom doit contenir au moins 2 caractères.',
        maxMessage: 'Le nom ne peut pas dépasser 100 caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s\-]+$/',
        message: 'Le nom ne doit contenir que des lettres, des espaces ou des tirets.'
    )]
    #[ORM\Column(length: 100)]
    private ?string $auteur = null;

    #[Assert\NotNull(message: 'La date de création est obligatoire.')]
    #[ORM\Column]
    private ?\DateTime $dateCreation = null;

    #[ORM\Column]
    private ?bool $publie = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Categorie $categorie = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTime $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isPublie(): ?bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): static
    {
        $this->publie = $publie;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
