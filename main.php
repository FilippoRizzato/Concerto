<?php
include 'concerto.php';
include 'db_manager.php';

$cfg = [];


$cfg_linee = file("config.txt");

foreach ($cfg_linee as $linea) {

    if (
        str_starts_with($linea, "//")
        || $linea === "\n"
    ) {
        continue;
    }

    
    $gruppi = explode(":", $linea, 2);

    if (count($gruppi) == 1) {
        echo 'Linea non valida (non contiene ":"): ' . $linea . PHP_EOL;
        exit(1);
    }

    // key = parte prima dei ":"
    // value = parte dopo
    $key = $gruppi[0];
    $value = substr($gruppi[1], 0, -1);

    // non si possono iterare le stringe con foreach, bisogna convertire la stringa ad un array, grazie php
    foreach (str_split($key) as $lettera) {
        if ($lettera < "A" || $lettera > "z") {
            echo "Key non valida (non è formata solo da lettere): " . $key . PHP_EOL;
            exit(1);
        }
    }

    // Come abbiamo stabilito circa 110 linee fa $cfg deve contenere la nostra configurazione
    $cfg[$key] = $value; 
};

// Il prossimo step è connettersi al database
$db = new DbManager($cfg["database"], $cfg["host"], $cfg["username"], $cfg["password"]);
// E inizializzare Concerto con la connessione al db
Concerto::setPdo($db);

while (true) {
    echo "premere 1 per creare un record" . PHP_EOL
        . "premere 2 per mostrare un record" . PHP_EOL
        . "premere 3 per modificare un record" . PHP_EOL
        . "premere 4 per eliminare un record" . PHP_EOL
        . "premere 5 per mostrare tutti i records presenti nella tabella" . PHP_EOL
        . "premere 6 per mostrare il record della sala" . PHP_EOL
        . "premere 7 per mostrare il record dei pezzi" . PHP_EOL
        . "premere 0 per terminare il programma" . PHP_EOL;
    $input = readline("> ");

    if ($input == "1\n") {
        $concerto = Concerto::Create([
            "codice" => readline("codice> "), 
            "titolo" => readline("titolo> "),
            "descrizione" => readline("descrizione> "),
            "data" => readline("data> "),
        ]);
        var_dump($concerto);

    } else if ($input == "2\n") {
        $id = readline("id> ");
        var_dump(Concerto::Find($id));

    } else if ($input == "3\n") {
        $id = readline("id> ");
        $obj = Concerto::Find($id);

        $codice = readline("codice> ");
        $obj->setCodice($codice === "\n" ? $obj->getCodice() : $codice);

        $titolo = readline("titolo> ");
        $obj->setTitolo($titolo === "\n" ? $obj->getTitolo() : $titolo);

        $descrizione = readline("descrizione> ");
        $obj->setDescrizione($descrizione === "\n" ? $obj->getDescrizione() : $descrizione);

        $data = readline("data> ");
        $obj->setData($data === "\n" ? $obj->getData() : $data);

        $obj->update();

        var_dump($obj);

    } else if ($input == "4\n") {
        $id = readline("> ");
        $obj = Concerto::Find($id);
        if ($obj !== false) {
            $obj->Delete();
        }

    } else if ($input == "5\n") {
        foreach (Concerto::FindAll() as $obj) {
            var_dump($obj);
            echo "=========" . PHP_EOL;
        }

    } 
    else if($input == "6\n")  {
        $obj->sala();
    }  
    else if($input == "7\n"){
        $obj-> pezzo();
    }
    else if ($input == "0\n") {
        exit(0);
    } 
}
