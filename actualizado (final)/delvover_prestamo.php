<?php
session_start();

if (!isset($_GET['id_libro'])) {
    echo "Error: No se ha recibido el ID del libro.";
    exit;
}

$id_libro = $_GET['id_libro'];

// Conexión a la base de datos para obtener los detalles del libro y préstamo
require_once 'inc/conexion.php';
$sql = 'SELECT prestamos.id_prest, prestamos.id_libro, libros.nom_libro, prestamos.fech_pres, prestamos.fec_dev
        FROM prestamos
        JOIN libros ON prestamos.id_libro = libros.id_libro
        WHERE prestamos.id_libro = :id_libro AND prestamos.id_usuarios = :id_usuario';
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_libro' => $id_libro, 'id_usuario' => $_SESSION['id_usuario']]);

$libro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$libro) {
    echo "No se encontró el préstamo del libro.";
    exit;
}

// Fecha de entrega automática (hoy)
$fecha_entrega = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="inc/Imagenes/logo.png" />
    <title>Devolución de Libro</title>
    <style>
        /* Estilo global */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Enlace de regreso */
        .link {
            display: inline-block;
            padding: 10px;
            background-color: #6c4ab6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px;
        }

        .link:hover {
            background-color: #563a9e;
        }

        /* Contenedor del formulario */
        .form-container {
            width: 25%;
            margin: 10px auto;
            padding: 60px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Estilo del formulario */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #444;
            margin-top: 5px;
        }

        .form-group input[readonly] {
            background-color: #f1f1f1;
        }

        .form-group button {
            width: 100%;
            padding: 14px;
            background-color: #6c4ab6;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .form-group button:hover {
            background-color: #563a9e;
        }

        /* Ajustes de responsive */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Enlace de regresar -->
    <a href="index.php" class="link">⬅️ Regresar</a>

    <div class="form-container">
        <h2>Devolución del Libro: <br> <?= htmlspecialchars($libro['nom_libro']); ?></h2>

        <form action="procesar_devolucion.php" method="POST">
            <div class="form-group">
                <label for="id_prest">ID del Préstamo:</label>
                <input type="text" id="id_prest" name="id_prest" value="<?= $libro['id_prest']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="id_libro">ID del Libro:</label>
                <input type="text" id="id_libro" name="id_libro" value="<?= $libro['id_libro']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nom_libro">Nombre del Libro:</label>
                <input type="text" id="nom_libro" name="nom_libro" value="<?= htmlspecialchars($libro['nom_libro']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="fech_pres">Fecha de Préstamo:</label>
                <input type="text" id="fech_pres" name="fech_pres" value="<?= $libro['fech_pres']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="fec_dev">Fecha de Devolución:</label>
                <input type="text" id="fec_dev" name="fec_dev" value="<?= $libro['fec_dev']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="fecha_entrega">Fecha de Entrega:</label>
                <input type="text" id="fecha_entrega" name="fecha_entrega" value="<?= $fecha_entrega; ?>" readonly>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Registrar Devolución</button>
            </div>
        </form>
    </div>

</body>
</html>
