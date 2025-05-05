<?php
class Facture
{
    private ?int $id;
    private string $numero_facture;
    private string $date_facture;
    private float $montant_total;
    private string $statut;
    private ?string $client_nom;
    private int $paiement_id;

    public function __construct($id = null, string $numero_facture, string $date_facture, float $montant_total, string $statut, ?string $client_nom, int $paiement_id)
    {
        $this->id = $id;
        $this->numero_facture = $numero_facture;
        $this->date_facture = $date_facture;
        $this->montant_total = $montant_total;
        $this->statut = $statut;
        $this->client_nom = $client_nom;
        $this->paiement_id = $paiement_id;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): self { $this->id = $id; return $this; }

    public function getNumeroFacture(): string { return $this->numero_facture; }
    public function setNumeroFacture(string $numero_facture): self { $this->numero_facture = $numero_facture; return $this; }

    public function getDateFacture(): string { return $this->date_facture; }
    public function setDateFacture(string $date_facture): self { $this->date_facture = $date_facture; return $this; }

    public function getMontantTotal(): float { return $this->montant_total; }
    public function setMontantTotal(float $montant_total): self { $this->montant_total = $montant_total; return $this; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): self { $this->statut = $statut; return $this; }

    public function getClientNom(): ?string { return $this->client_nom; }
    public function setClientNom(?string $client_nom): self { $this->client_nom = $client_nom; return $this; }

    public function getPaiementId(): int { return $this->paiement_id; }
    public function setPaiementId(int $paiement_id): self { $this->paiement_id = $paiement_id; return $this; }
}
?>
