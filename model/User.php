<?php
class User {
    private $iduser, $nom, $prenom, $email, $password, $numtel, $sexe, $role;

    public function __construct($nom, $prenom, $email, $password, $numtel, $sexe, $role) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->numtel = $numtel;
        $this->sexe = $sexe;
        $this->role = $role;
    }


    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getNumtel() { return $this->numtel; }
    public function getSexe() { return $this->sexe; }
    public function getRole() { return $this->role; }
}
?>
