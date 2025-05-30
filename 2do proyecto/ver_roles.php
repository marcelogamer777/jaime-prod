<?php
session_start(); // Asegúrate de incluir esto al inicio del archivo

require_once 'inc/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    try {
        // Determinar la tabla según el rol
        $table = 'usuarios'; // Supongo que todos los roles están en la misma tabla

        // Consulta SQL con parámetros
        $query = $pdo->prepare("
            SELECT id_usuarios, password 
            FROM $table 
            WHERE id_usuarios = :username 
              AND rol = :role
        ");
        $query->execute([
            ':username' => $username,
            ':role' => $role
        ]);

        // Verificar si se encontró el usuario
        if ($query->rowCount() > 0) {
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // Verificar si la contraseña es correcta
            if (md5($password) === $user['password']) { // Asegúrate de usar el mismo método para la verificación
                // Guardar ID de usuario y contraseña en la sesión
                $_SESSION['id_usuario'] = $user['id_usuarios']; // Usar id_usuarios 
                $_SESSION['password'] = $user['password']; // No es lo ideal, pero si es necesario

                // Redirigir según el rol
                switch ($role) {
                    case 'administrador':
                        header('Location: administrador.php');
                        break;
                    case 'alumno':
                        header('Location: alumno.php');
                        break;
                    case 'docente': // Ajustado para "docente"
                        header('Location: docente.php');
                        break;
                }
                exit;
            } else {
                // Contraseña incorrecta
                header("Location: Principal.php?error=1");
                exit;
            }
        } else {
            // Usuario no encontrado
            header("Location: Principal.php?error=2");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
