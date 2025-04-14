<?php
class Reservation {
    private $idreservation;
    private $client;
    private $idev; 
    private $date;

    public function __construct($client, $idev, $date) {
        $this->client = $client;
        $this->idev = $idev;
        $this->date = $date;
    }
    public function getId() { return $this->idreservation; }
    public function getClient() {
        return $this->client;
    }

    public function getIdev() {
        return $this->idev;
    }

    public function getDate() {
        return $this->date;
    }
}
?>
