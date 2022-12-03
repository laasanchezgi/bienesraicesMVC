<?php

    require 'funciones.php';
    // Conexion a la BD
    require 'config/database.php';
    require __DIR__ . '/../vendor/autoload.php';

    // Conectar a la BD
    $db = conectarDB();
    
    // Importar clase
    use Model\ActiveRecord;
    ActiveRecord::setDB($db);