<?php
class Paiement
{
    private ?int $id; // Primary key
    private string $montant;
    private string $devise;
    private string $methode;
    private string $carte;
    private ?string $description;

    // Constructor
    public function __construct($id = null, string $montant, string $devise, string $methode, string $carte, string $description = null)
    {
        $this->id = $id;
        $this->montant = $montant;
        $this->devise = $devise;
        $this->methode = $methode;
        $this->carte = $carte;
        $this->description = $description;
    }

    // Getter and Setter for id
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    // Getter and Setter for montant
    public function getMontant(): string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    // Getter and Setter for devise
    public function getDevise(): string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): self
    {
        $this->devise = $devise;
        return $this;
    }

    // Getter and Setter for methode
    public function getMethode(): string
    {
        return $this->methode;
    }

    public function setMethode(string $methode): self
    {
        $this->methode = $methode;
        return $this;
    }

    // Getter and Setter for carte
    public function getCarte(): string
    {
        return $this->carte;
    }

    public function setCarte(string $carte): self
    {
        $this->carte = $carte;
        return $this;
    }

    // Getter and Setter for description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
?>
