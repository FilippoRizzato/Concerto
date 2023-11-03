<?php
class pezzo{
    private static PDO $pdo;
    private int $id;
    private string $codice;
    private string $titolo;
    private string $autore;

    public static function getPdo() {
        return self::$pdo;
    }
    
    public static function setPdo($pdo) {
        self::$pdo = $pdo;
    }
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
    

    public static function create($dati){
        $query = self::getPdo()->prepare(
            "INSERT INTO pezzi(codice, titolo) VALUES (:codice, :titolo)"
        )->execute([
            "codice" => $dati["codice"],
            "titolo" => $dati["titolo"],      
        ]);
        $query = self::getPdo()->prepare(
            "SELECT * FROM pezzi WHERE id=:id"
        );
        $query->execute(["id" => self::getPdo()->lastInsertId()]);
        $obj = $query->fetchObject(__CLASS__);
        return $obj;
    }
    public static function FindAll() {
        $query = self::getPdo()->prepare(
            "SELECT * FROM pezzi"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }
}
?>
