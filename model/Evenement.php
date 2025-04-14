<?php

class Evenement {
    private $id;
    private $titre;
    private $description;
    private $categorie;
    private $dateEvenement;
    private $lieu;
    private $idOrganisateur;
    private $image;

    
    public function __construct($titre, $description, $categorie, $dateEvenement, $lieu, $idOrganisateur, $image= null) {
        $this->titre = $titre;
        $this->description = $description;
        $this->categorie = $categorie;
        $this->dateEvenement = $dateEvenement;
        $this->lieu = $lieu;
        $this->idOrganisateur = $idOrganisateur;
        $this->image = $image;
    }

    
    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getDescription() { return $this->description; }
    public function getCategorie() { return $this->categorie; }
    public function getDateEvenement() { return $this->dateEvenement; }
    public function getLieu() { return $this->lieu; }
    public function getIdOrganisateur() { return $this->idOrganisateur; }
    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; }
    public function setTitre($titre) { $this->titre = $titre; }
    public function setDescription($description) { $this->description = $description; }
    public function setCategorie($categorie) { $this->categorie = $categorie; }
    public function setDateEvenement($dateEvenement) { $this->dateEvenement = $dateEvenement; }
    public function setLieu($lieu) { $this->lieu = $lieu; }
    public function setIdOrganisateur($idOrganisateur) { $this->idOrganisateur = $idOrganisateur; }
}
?>