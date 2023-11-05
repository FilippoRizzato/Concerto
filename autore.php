<?php
class pezzo{
    private static PDO $pdo;
    private int $id;
    private string $codice;
    private string $nome;


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
    function getNome(){
        return $this->$nome;
    }
    function setNome($nome){
        $this->nome=$nome;
    }
    

    public static function create($dati){
        
        $query = self::getPdo()->prepare(
            "INSERT INTO autori(codice, nome) VALUES (:codice, :nome)"
        )->execute([
            "codice" => $dati["codice"],
            "nome" => $dati["nome"],      
        ]);
        $query = self::getPdo()->prepare(
            "SELECT * FROM autori WHERE id=:id"
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
