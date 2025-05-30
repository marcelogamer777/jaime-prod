<?php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="inc/Imagenes/logo.png" />
    <title>Biblioteca Municipal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 50%;
            margin: 0 auto;
        }
        .link {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #6c4ab6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .link:hover {
            background-color: #5a3996;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido Administrador</h1>
        <p>Selecciona una opción:</p>
        
        <a href="multas.php" class="link">Gestion de Multas</a>
        <a href="reporte_prestamos.php" class="link">Reportes de Prestamos</a>
        <a href="Principal.php" class="link">Salir</a>
    </div>
</body>
</html>
