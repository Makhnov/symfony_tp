<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide.")]
    #[Assert\Length(
        min: 5,
        max: 150,
        minMessage: "Le titre doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[\w\s\-]+$/",
        message: "Le titre ne peut contenir que des caractères alphanumériques, des espaces, des tirets et des underscores."
    )]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Le message ne peut pas être vide.")]
    #[Assert\Length(
        min: 10,
        max: 5000,
        minMessage: "Le message doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le message ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "La date ne peut pas être vide.")]
    #[Assert\Type(
        type: "\DateTimeInterface",
        message: "La valeur {{ value }} n'est pas une date valide."
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Assert\NotNull(message: "La catégorie ne peut pas être vide.")]
    private ?PostCategory $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Assert\NotNull(message: "L'auteur ne peut pas être vide.")]
    private ?Auteur $auteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCategorie(): ?PostCategory
    {
        return $this->categorie;
    }

    public function setCategorie(?PostCategory $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'message' => $this->getMessage(),
            'date' => $this->getDate(),
            'categorie' => $this->getCategorie(),
            'auteur' => $this->getAuteur(),
        ];
    }
    
    public function __toString()
    {
        return $this->getTitre();
    }
}
