<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'root', 'bienes_raices');
    $db -> set_charset('utf8');

    if(!$db) {
        echo 'error al conectar';
        exit;
    }
    
    return $db;

}

conectarDB();