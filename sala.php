<?php
class sala{
    private static PDO $pdo;
private int $id;
private int $codice;
private string $nome;
private int $capienza;


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

function getCapienza(){
    return $this->$capienza;
}
function setCapienza($capienza){
    $this->capienza=$capienza;
}

public static function create($dati){
    $query = self::getPdo()->prepare(
        "INSERT INTO sale(codice, nome, capienza) VALUES (:codice, :nome, :capienza)"
    )->execute([
        "codice" => $dati["codice"],
        "nome" => $dati["nome"],
        "capienza" => $dati["capienza"],       
    ]);
    $query = self::getPdo()->prepare(
        "SELECT * FROM sale WHERE id=:id"
    );
    $query->execute(["id" => self::getPdo()->lastInsertId()]);
    $obj = $query->fetchObject(__CLASS__);
    return $obj;
}
public static function find($id){
    $query = self::getPdo()->prepare(
        "SELECT * FROM sale WHERE id=:id"
    );
    $query->execute(["id" => $id]);
    return $query->fetchObject(__CLASS__);
}




}

?>