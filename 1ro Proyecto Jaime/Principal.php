<?php
// Verificar si hay un mensaje en la URL
$message = '';
$message_type = '';

if (isset($_GET['success'])) {
    $message = 'Ingreso exitoso. Bienvenido.';
    $message_type = 'success';
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        $message = 'Error.';
        $message_type = 'error';
    } elseif ($_GET['error'] == 2) {
        $message = 'Error.';
        $message_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="inc/Imagenes/logo.png" />
    <title>Biblioteca Municipal</title>
    <link rel="stylesheet" href="assets/Css/estilos_biblioteca.css">
</head>
<body>  
    
<br>

<div class="container">

    <div>
        <a href="index.php" class="link">⬅️Regresar</a>
        <h1 class="titulo">Bienvenido a nuestra Biblioteca</h1>
    </div>

    <!-- Mostrar el mensaje si existe -->
    <?php if ($message): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Pestañas -->
    <div class="tabs">
        <div class="tab active" onclick="showForm('administrador')">Administrador</div>
        <div class="tab" onclick="showForm('alumno')">Alumno</div>
        <div class="tab" onclick="showForm('docente')">Docente</div>
    </div>

    <!-- Formulario Administrador -->
    <form id="administrador" class="login-form" method="POST" action="ver_roles.php">
        <input type="hidden" name="role" value="administrador">
        <div class="form-group">
            <label for="admin-username">Usuario</label>
            <input type="text" id="admin-username" name="username" placeholder="Ingrese su usuario" required>
        </div>
        <div class="form-group">
            <label for="admin-password">Contraseña</label>
            <input type="password" id="admin-password" name="password" placeholder="Ingrese su contraseña" required>
        </div>
        <button type="submit" class="btn">Iniciar sesión</button>
    </form>

    <!-- Formulario Alumno -->
    <form id="alumno" class="login-form" method="POST" action="ver_roles.php" style="display: none;">
        <input type="hidden" name="role" value="alumno">
        <div class="form-group">
            <label for="alumno-control">Número de Control</label>
            <input type="text" id="alumno-control" name="username" placeholder="Ingrese su número de control" required>
        </div>
        <div class="form-group">
            <label for="alumno-password">Contraseña</label>
            <input type="password" id="alumno-password" name="password" placeholder="Ingrese su contraseña" required>
        </div>
        <button type="submit" class="btn">Iniciar sesión</button>
    </form>

    <!-- Formulario Docente-->
    <form id="docente" class="login-form" method="POST" action="ver_roles.php" style="display: none;">
        <input type="hidden" name="role" value="docente">
        <div class="form-group">
            <label for="doc-username">Usuario</label>
            <input type="text" id="doc-username" name="username" placeholder="Ingrese su usuario" required>
        </div>
        <div class="form-group">
            <label for="doc-password">Contraseña</label>
            <input type="password" id="doc-password" name="password" placeholder="Ingrese su contraseña" required>
        </div>
        <button type="submit" class="btn">Iniciar sesión</button>
    </form>

</div>

<script>
    // Función para cambiar entre formularios
    function showForm(formId) {
        // Ocultar todos los formularios
        document.querySelectorAll('.login-form').forEach(form => form.style.display = 'none');

        // Mostrar el formulario correspondiente
        document.getElementById(formId).style.display = 'block';

        // Actualizar las pestañas activas
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelector(`.tab[onclick="showForm('${formId}')"]`).classList.add('active');
    }
</script>
</body>
</html>
