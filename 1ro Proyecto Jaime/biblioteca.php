<?php
// Aquí deberías tener la lógica para obtener los libros (como en tu código original)
session_start();
require_once 'inc/conexion.php';

$sql = 'SELECT id_libro, nom_libro, autor, editorial, año_publ, cant_disp, categoria FROM libros';
$stmt = $pdo->query($sql);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="inc/Imagenes/logo.png" />
    <title>Biblioteca Municipal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 0px;
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 100px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #6c4ab6;
            display: inline-block;
            margin: 0 auto;
        }

        .link {
            display: inline-block;
            padding: 10px;
            background-color: #6c4ab6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 0;
        }

        .link:hover {
            background-color: #5a3996;
        }

        .left-align {
            text-align: left;
            padding-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            background-color: #6c4ab6;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="left-align">
        <a href="alumno.php" class="link">⬅️ Regresar</a>
    </div>

    <h1>Libros de la Biblioteca</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Año Publicación</th>
                <th>Cantidad Disponible</th>
                <th>Categoria</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?= htmlspecialchars($libro['id_libro']); ?></td>
                <td><?= htmlspecialchars($libro['nom_libro']); ?></td>
                <td><?= htmlspecialchars($libro['autor']); ?></td>
                <td><?= htmlspecialchars($libro['editorial']); ?></td>
                <td><?= htmlspecialchars($libro['año_publ']); ?></td>
                <td><?= htmlspecialchars($libro['cant_disp']); ?></td>
                <td><?= htmlspecialchars($libro['categoria']); ?></td>
                <td>
                    <!-- Enviar formulario con el id_libro -->
                    <form action="solicitar_prestamo.php" method="GET">
                        <input type="hidden" name="id_libro" value="<?= $libro['id_libro']; ?>">
                        <button type="submit" class="btn">Solicitar</button>
                        
                    </form>
                  
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
