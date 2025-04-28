<?php
class Reponse
{
    private ?int $id;
    private ?int $reclamation_id;
    private ?string $contenu;
    private ?string $date_reponse;
    private ?int $staff_id;
    private ?string $staff_name;

    // Constructeur
    public function __construct($id = null, $reclamation_id, $contenu, $date_reponse, $staff_id = null, $staff_name = null)
    {
        $this->id = $id;
        $this->reclamation_id = $reclamation_id;
        $this->contenu = $contenu;
        $this->date_reponse = $date_reponse;
        $this->staff_id = $staff_id;
        $this->staff_name = $staff_name;
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

    // Getter et Setter pour reclamation_id
    public function getReclamationId()
    {
        return $this->reclamation_id;
    }

    public function setReclamationId($reclamation_id)
    {
        $this->reclamation_id = $reclamation_id;
        return $this;
    }

    // Getter et Setter pour contenu
    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }

    // Getter et Setter pour date_reponse
    public function getDateReponse()
    {
        return $this->date_reponse;
    }

    public function setDateReponse($date_reponse)
    {
        $this->date_reponse = $date_reponse;
        return $this;
    }

    // Getter et Setter pour staff_id
    public function getStaffId()
    {
        return $this->staff_id;
    }

    public function setStaffId($staff_id)
    {
        $this->staff_id = $staff_id;
        return $this;
    }

    // Getter et Setter pour staff_name
    public function getStaffName()
    {
        return $this->staff_name;
    }

    public function setStaffName($staff_name)
    {
        $this->staff_name = $staff_name;
        return $this;
    }
}
?>