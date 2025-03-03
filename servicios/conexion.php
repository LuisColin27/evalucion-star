<?php
    try{
        $db = new SQLite3('../hospital.db');
    } catch (PDOException $e){
        echo json_encode(["error" => "Ocurrió un error al momento de realizar la conexión a la base de datos" ]);
    }
?>