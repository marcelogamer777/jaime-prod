<?php
// Conexión a la base de datos
$host = 'localhost';
$db = 'biblioteca';
$user = 'postgres'; // Cambia por tu usuario de MySQL
$password = ''; // Cambia por tu contraseña de MySQL

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Capturar los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Consulta para verificar las credenciales
$sql = "SELECT * FROM usuarios WHERE username = ? AND password = MD5(?) AND role = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Usuario válido: iniciar sesión y redirigir
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

    // Redirigir según el rol
    switch ($role) {
        case 'administrador':
            header('Location: administrador.html');
            break;
        case 'alumno':
            header('Location: alumno.html');
            break;
        case 'departamento':
            header('Location: departamento.html');
            break;
    }
    exit();
} else {
    // Usuario no válido
    echo "<script>
        alert('Usuario o contraseña incorrectos');
        window.location.href = 'index.html'; // Vuelve a la página de login
    </script>";
}

$conn->close();
?>
