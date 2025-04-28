<?php
class Reservation {
    private $idreservation;
    private $client;
<<<<<<< HEAD
    private $idev;  
=======
    private $idev; 
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
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
