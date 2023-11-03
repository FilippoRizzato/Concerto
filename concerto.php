<?php

class Concerto {
    private static PDO $pdo;

    private int $id;
    private string $codice;
    private string $titolo;
    private string $descrizione;
    private $data;


    function getId(){
        return $this->$id;
    }

    function getCodice(){
        return $this->$codice;
    }
    function setCodice($codice){
        $this->codice=$codice;
    }

    function getTitolo(){
        return $this->$titolo;
    }
    function setTitolo($titolo){
        $this->titolo=$titolo;
    }

    function getDescrizione(){
        return $this->$descrizione;
    }
    function setDescrizione($descrizione){
        $this->descrizione=$descrizione;
    }

    function getData(){
        return $this->$data;
    }
    public function setData($data){
        if (is_string($data)) {
            $data = new DateTime($data);
        }
        $this->data=$data;
    }
    function getSala_id(){
        return $this->$sala_id;
    }
    function getPezzo_id(){
        return $this->$pezzo_id;
    }

    public static function Create($dati) {
        $query = self::getPdo()->prepare(
            "INSERT INTO concerti(codice, titolo, descrizione, data, sala_id) VALUES (:codice, :titolo, :descrizione, :data :sala_id)"
        )->execute([
            "codice" => $dati["codice"],
            "titolo" => $dati["titolo"],
            "descrizione" => $dati["descrizione"],
            "data" => $dati["data"],
            "sala_id" => $dati["sala_id"]

        ]);

        $query = self::getPdo()->prepare(
            "SELECT * FROM concerti WHERE id=:id"
        );
        $query->execute(["id" => self::getPdo()->lastInsertId()]);

        $obj = $query->fetchObject(__CLASS__);
        $obj->data = new Datetime($obj->data);
        return $obj;
    }

    public static function Find($id) {
        $query = self::getPdo()->prepare(
            "SELECT * FROM concerti WHERE id=:id"
        );
        $query->execute(["id" => $id]);
        return $query->fetchObject(__CLASS__);
    }

    public static function FindAll() {
        $query = self::getPdo()->prepare(
            "SELECT * FROM concerti"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    public function Delete() {
        $stmt = self::getPdo()->prepare("DELETE FROM concerti WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function Update($params = []) {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        self::getPdo()->prepare(
            "UPDATE concerti SET codice = :codice, titolo = :titolo, descrizione = :descrizione, data = :data WHERE id = :id"
        )->execute([
            "id" => $this->id,
            "codice" => $this->codice,
            "titolo" => $this->titolo,
            "descrizione" => $this->descrizione,
            "data" => $this->data->format("Y-m-d H:i:s")
        ]);
    }
    public  function sala(){
        $stmt = self::getSala_id();
        $temp = new sala($stmt);
        return $temp;
    }
    public function pezzo(){
        $stmt = self::getPezzo_id();
        $temp = new pezzo($stmt);
        return $temp;
    }

    public static function getPdo() {
        return self::$pdo;
    }

    public static function setPdo($pdo) {
        self::$pdo = $pdo;
    }
}
