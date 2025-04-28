<?php
class Reclamation
{
    private ?int $id;
    private ?string $email;
    private ?string $sujet;
    private ?string $descrip;
    private ?string $daterec;
    private ?string $status;

    // Constructeur
    public function __construct($id = null, $email, $sujet, $descrip, $daterec, $status)
    {
        $this->id = $id;
        $this->email = $email;
        $this->sujet = $sujet;
        $this->descrip = $descrip;
        $this->daterec = $daterec;
        $this->status = $status;
    }

    // Getter et Setter pour id
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    // Getter et Setter pour email
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    // Getter et Setter pour sujet
    public function getSujet()
    {
        return $this->sujet;
    }

    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
        return $this;
    }

    // Getter et Setter pour description
    public function getDescription()
    {
        return $this->descrip;
    }

    public function setDescription($description)
    {
        $this->descrip = $description;
        return $this;
    }

    // Getter et Setter pour date_rec
    public function getDateRec()
    {
        return $this->daterec;
    }

    public function setDateRec($date_rec)
    {
        $this->daterec = $date_rec;
        return $this;
    }

    // Getter et Setter pour status
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
?>
