<?php
session_start();
require_once 'inc/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prest = $_POST['id_prest'];
    $cantidad = $_POST['cantidad'];
    $fech_pago = !empty($_POST['fech_pago']) ? $_POST['fech_pago'] : null;

    // Generar la fecha actual para `fech_gen`
    $fech_gen = date('Y-m-d'); // Obtiene la fecha actual en formato 'YYYY-MM-DD'

    try {
        $sql = "INSERT INTO multa (id_prest, fech_gen, cantidad, fech_pago)
                VALUES (:id_prest, :fech_gen, :cantidad, :fech_pago)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_prest', $id_prest, PDO::PARAM_INT);
        $stmt->bindParam(':fech_gen', $fech_gen, PDO::PARAM_STR);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        if ($fech_pago) {
            $stmt->bindParam(':fech_pago', $fech_pago, PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':fech_pago', null, PDO::PARAM_NULL);
        }

        $stmt->execute();

        // Redirigir a multas.php después del registro exitoso
        header("Location: multas.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Error al registrar la multa: " . $e->getMessage() . "</p>";
    }
}
?>
