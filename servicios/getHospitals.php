<?php
include_once __DIR__ . "\conexion.php";
//header('Content-Type: application/json; charset=utf-8');
// Configurar la conexión a la base de datos SQLite
try {
    // Consultar los hospitales Star
    $query = "SELECT id, ubicacion FROM hospitales order by ubicacion";
    $result = $db->query($query);

    // Recuperar los resultados
    $hospitals = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)){
        array_push($hospitals, $row);
    }
    // Devolver los hospitales en formato JSON
    $db->close();
    echo json_encode($hospitals);
} catch (PDOException $e) {
    // Si hay un error en la consulta, devolver el mensaje de error en formato JSON
    $db->close();
    echo json_encode(["error" => "Error al conectar con la base de datos: " . $e->getMessage()]);
}
?>
