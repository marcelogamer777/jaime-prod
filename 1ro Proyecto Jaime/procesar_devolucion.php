<?php
session_start();

// Verifica si se han recibido los datos necesarios
if (!isset($_POST['id_prest']) || !isset($_POST['id_libro']) || !isset($_POST['fecha_entrega'])) {
    echo "Error: Datos incompletos para procesar la devolución.";
    exit;
}

// Captura los datos del formulario
$id_prest = $_POST['id_prest'];
$id_libro = $_POST['id_libro'];
$fecha_entrega = $_POST['fecha_entrega'];

// Conexión a la base de datos
require_once 'inc/conexion.php';

try {
    // Actualiza el registro de préstamo con la fecha de entrega
    $sql = 'UPDATE prestamos SET fe_entre = :fecha_entrega WHERE id_prest = :id_prest AND id_libro = :id_libro';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'fecha_entrega' => $fecha_entrega,
        'id_prest' => $id_prest,
        'id_libro' => $id_libro
    ]);

    // Redirige al usuario al login
    header("Location: devolver.php");
    exit;
} catch (PDOException $e) {
    echo "Error al procesar la devolución: " . $e->getMessage();
    exit;
}
