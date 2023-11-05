<?php
class pezzo{
    private static PDO $pdo;
    private int $id;
    private string $codice;
    private string $titolo;


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
        $id = self::getPdo()->lastInsertId();
        $query = self::getPdo()->prepare(
            "INSERT INTO autori_pezzi(autori_id, pezzi_id) VALUES (:autori_id, :pezzi_id)"
        )->execute([
            "autori_id" => $dati["autori_id"],
            "pezzi_id" => $id,      
        ]);
        $query = self::getPdo()->prepare(
            "SELECT * FROM ((
             INNER JOIN autori, pezzi ON autori_pezzi.pezzi_id = pezzi.id)
             INNER JOIN autori, pezzi ON autori_pezzi.autori_id = autori.id)
             WHERE id=:id"
        );
        $query->execute(["id" => self::getPdo()->lastInsertId()]);
        $query->fetch(PDO::FETCH_BOTH);
        return $query;
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
