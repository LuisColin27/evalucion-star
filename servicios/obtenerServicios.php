<?php
    include_once __DIR__ . "\conexion.php";

    // Se obtiene el identificador del hospital desde la url

    $hospital = isset($_GET['hospital']) ? $_GET['hospital'] : '';
    try{
        if($hospital){
            $query = "SELECT nombre, descripcion, estandar, premiun, star FROM servicios WHERE idHospital = :hospital";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':hospital', $hospital);
            $result = $stmt->execute();

            $services = [];

            while ($row = $result->fetchArray(SQLITE3_ASSOC)){
                array_push($services, $row);
            }
            $db->close();
            echo json_encode($services);
        }else {
            echo json_encode(["error" => "Debe de especificar el identificador del hospital para continuar con la solicitud"]);
        }
        
    } catch(Exception $e) {
        echo json_encode(['error' => 'Ocurrio un error inesperado ' . $e->getMessage()]);
    }


?>