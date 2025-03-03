<?php
include_once __DIR__ . "\conexion.php";

// Obtener el nombre del hospital desde la URL
$hospital = isset($_GET['hospital']) ? $_GET['hospital'] : '';

// Conectar a la base de datos SQLite
try {

    // Si se proporciona un nombre de hospital, obtenemos los servicios de ese hospital
    if ($hospital) {
        // Aquí puedes agregar una tabla de servicios asociados al hospital seleccionado
        $query = "SELECT nombre, descripcion, estandar, premiun, star FROM servicios WHERE idHospital = :hospital";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':hospital', $hospital);
        $result = $stmt->execute();

        // Recuperar los resultados
        $services = [];
        $hospitalInfo = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push($services, $row);
        }


        $query = "SELECT ubicacion, direccion, telefono FROM hospitales WHERE id = :hospital";
        $stmt2 = $db->prepare($query);
        $stmt2->bindParam(':hospital', $hospital);
        $result2 = $stmt2->execute();

        while ($row2 = $result2->fetchArray(SQLITE3_ASSOC)) {
            array_push($hospitalInfo, $row2);
        }

        $db->close();
    } else {
        $services = [];
    }
} catch (PDOException $e) {
    $services = ['error' => 'Error de base de datos: ' . $e->getMessage()];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios de Hospital - <?php echo htmlspecialchars($hospitalInfo[0]['ubicacion']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Encabezado -->
    <header>
        <div class="logo">
            <img src="img/logoStarMedica.png" alt="Logo de la Empresa" width="100">
        </div>
        <div class="social-media">
            <a href="https://www.facebook.com" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="https://www.instagram.com" target="_blank"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="https://www.youtube.com" target="_blank"><ion-icon name="logo-youtube"></ion-icon></a>
            <a href="https://twitter.com" target="_blank"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="https://www.linkedin.com" target="_blank"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
    </header>

    <!-- Banner -->
    <section class="banner">
        <img src="img/Baner2.png" alt="">
    </section>

    <!-- Tabla de Servicios -->
    <section class="hospital-services">
        <?php if (count($services) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th id="servicios">Paquetes</th>
                        <th>Estándar</th>
                        <th>Premium</th>
                        <th>Star</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($service['nombre']); ?>
                                <h6><?php echo htmlspecialchars($service['descripcion']); ?></h6>
                            </td>
                            <td><?php if ($service['estandar'] == 1): ?>
                                    <ion-icon name="checkmark"></ion-icon>
                                <?php endif; ?>
                            </td>
                            <td><?php if ($service['premiun'] == 1): ?>
                                    <ion-icon name="checkmark"></ion-icon>
                                <?php endif; ?>
                            </td>
                            <td><?php if ($service['star'] == 1): ?>
                                    <ion-icon name="checkmark"></ion-icon>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron paquetes disponibles para este hospital.</p>
        <?php endif; ?>
    </section>

    <!-- Formulario de contacto -->
    <section class="contact-form">
        <h2>¿Quieres personaliza tu experiencia de maternidad?</h2>
        <h3>Déjanos tus datos o contacto</h3>
        <form id="contactForm">
            <input type="text" id="name" name="name" placeholder="Nombres" required>
            <input type="text" id="lastName" name="lastName" placeholder="Apellidos" required>
            <input type="email" id="email" name="email" placeholder="Correo Electrónico" required>
            <input type="tel" id="phone" name="phone" placeholder="Teléfono" required>
            <button type="submit">Guardar Información</button>
        </form>
    </section>

    <!-- Footer -->
    <footer>
        <div class="contact-info">
            <p><strong style="color: #007BFF; font-size: 15px;">Star Médica <?php echo htmlspecialchars($hospitalInfo[0]['ubicacion']); ?></strong></p>
            <p><strong>Dirección: </strong><?php echo htmlspecialchars($hospitalInfo[0]['direccion']); ?> </p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($hospitalInfo[0]['telefono']); ?></p>
        </div>
        <div class="footer-links">
            <a href="https://www.facebook.com" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="https://www.instagram.com" target="_blank"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="https://www.youtube.com" target="_blank"><ion-icon name="logo-youtube"></ion-icon></a>
            <a href="https://twitter.com" target="_blank"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="https://www.linkedin.com" target="_blank"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
    </footer>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>

</html>