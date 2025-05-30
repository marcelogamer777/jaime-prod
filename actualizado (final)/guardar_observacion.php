<?php
// Incluir el archivo de conexión
include('inc/conexion.php');

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id_prest = $_POST['id_prest'];
    $observaciones = $_POST['observaciones'];

    // Validar que la observación no esté vacía
    if (!empty($observaciones)) {
        try {
            // Preparar la consulta para actualizar la observación
            $sql = "
                UPDATE prestamos
                SET observ = :observaciones
                WHERE id_prest = :id_prest
            ";

            // Ejecutar la consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['observaciones' => $observaciones, 'id_prest' => $id_prest]);

            // Verificar si la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                // Redirigir a la página de préstamos con un mensaje de éxito
                header('Location: prestamos.php?mensaje=Observación guardada exitosamente');
                exit();
            } else {
                // Si no se actualizó ningún registro
                echo "<p>No se pudo guardar la observación. Intente nuevamente.</p>";
            }
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    } else {
        echo "<p>La observación no puede estar vacía.</p>";
    }
}
?>
