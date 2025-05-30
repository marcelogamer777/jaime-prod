<?php
session_start();
require_once 'inc/conexion.php';

// Verificar si la sesión y el id_usuario están definidos
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'Sesión no iniciada o id_usuario vacío.']);
    exit();
}

$id_usuario = $_SESSION['id_usuario']; // Ahora obtenemos el id_usuario de la sesión

try {
    // Realizar la consulta para obtener los datos del usuario
    $query = $pdo->prepare("
        SELECT id_usuarios, nom_usuario, apell_usua, tel, direccion, carrera, semestre, correo 
        FROM usuarios 
        WHERE id_usuarios = :id_usuario AND rol = 'alumno'
    ");
    $query->execute([':id_usuario' => $id_usuario]);

    if ($query->rowCount() > 0) {
        // Si se encuentran los datos, enviarlos como JSON
        $data = $query->fetch(PDO::FETCH_ASSOC);
        header('Content-Type: application/json'); // Asegúrate de que la respuesta sea en formato JSON

        echo json_encode($data); // Enviamos los datos completos del usuario como JSON
    } else {
        // Si no se encuentran datos, devolver un mensaje de error
        echo json_encode(['error' => 'No se encontraron datos para el usuario especificado.']);
    }
} catch (PDOException $e) {
    // Enviar un JSON válido con el error
    echo json_encode(['error' => 'Error al conectar con la base de datos: ' . $e->getMessage()]);
}

?>
