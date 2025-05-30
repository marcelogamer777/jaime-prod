<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos
    require_once 'inc/conexion.php';

    // Recibir los datos del formulario
    $id_libro = $_POST['id_libro'];
    $id_usuario = $_POST['id_usuarios'];
    $fecha_prestamo = $_POST['fech_pres'];
    $fecha_devolucion = $_POST['fec_dev'];

    try {
        // Inicia una transacción para asegurar que ambas consultas se ejecuten correctamente
        $pdo->beginTransaction();

        // Registrar la solicitud de préstamo en la base de datos
        $sql = 'INSERT INTO prestamos (id_libro, id_usuarios, fech_pres, fec_dev) 
                VALUES (:id_libro, :id_usuarios, :fech_pres, :fec_dev)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_libro' => $id_libro,
            'id_usuarios' => $id_usuario,
            'fech_pres' => $fecha_prestamo,
            'fec_dev' => $fecha_devolucion
        ]);

        // Actualizar la cantidad disponible del libro seleccionado
        $sqlUpdate = 'UPDATE libros SET cant_disp = cant_disp - 1 WHERE id_libro = :id_libro AND cant_disp > 0';
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute(['id_libro' => $id_libro]);
        
        // Verificar si se actualizó alguna fila
        if ($stmtUpdate->rowCount() === 0) {
            throw new Exception("No hay suficientes libros disponibles para realizar el préstamo.");
        }

        // Confirmar la transacción
        $pdo->commit();

        // Redirigir al usuario a una página de confirmación o a la página de préstamos
        header("Location: biblioteca.php");
        exit;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        echo "Error al registrar el préstamo: " . $e->getMessage();
    }
}
?>
