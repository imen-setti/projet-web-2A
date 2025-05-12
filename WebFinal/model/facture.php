<?php
class Facture {
    private $id;
    private $numero_facture;
    private $date_facture;
    private $montant_total;
    private $statut;
    private $client_nom;
    private $paiement_id;

    public function __construct($id = null, $numero_facture = null, $date_facture = null, $montant_total = null, $statut = null, $client_nom = null, $paiement_id = null) {
        $this->id = $id;
        $this->numero_facture = $numero_facture;
        $this->date_facture = $date_facture;
        $this->montant_total = $montant_total;
        $this->statut = $statut;
        $this->client_nom = $client_nom;
        $this->paiement_id = $paiement_id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNumeroFacture() { return $this->numero_facture; }
    public function getDateFacture() { return $this->date_facture; }
    public function getMontantTotal() { return $this->montant_total; }
    public function getStatut() { return $this->statut; }
    public function getClientNom() { return $this->client_nom; }
    public function getPaiementId() { return $this->paiement_id; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNumeroFacture($numero_facture) { $this->numero_facture = $numero_facture; }
    public function setDateFacture($date_facture) { $this->date_facture = $date_facture; }
    public function setMontantTotal($montant_total) { $this->montant_total = $montant_total; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setClientNom($client_nom) { $this->client_nom = $client_nom; }
    public function setPaiementId($paiement_id) { $this->paiement_id = $paiement_id; }
}