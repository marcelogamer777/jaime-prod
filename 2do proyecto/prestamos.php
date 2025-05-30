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
            color: black; /* Cambiar el color del texto en los encabezados a negro */
        }
        .btn {
            background-color: #45a049;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #6c4ab6;
        }
        td.action-column { /* Estilo para la columna de acción */
            text-align: center; /* Centra los botones */
            padding: 15px; /* Da más espacio alrededor de los botones */
        }
    </style>
</head>
<body>
    <div class="left-align">
        <a href="Docente.php" class="link">⬅️ Regresar</a>
    </div>

    <h1 align="center">Centro de Préstamos</h1>

    <?php
    // Incluir el archivo de conexión
    include('inc/conexion.php'); 

    try {
        // Consulta SQL con JOIN para obtener la información de los préstamos, libros y usuarios, solo aquellos con fecha de entrega (fe_entre) definida
        $sql = '
            SELECT p.id_prest, p.fech_pres, p.fec_dev, p.fe_entre, p.observ,
                   l.nom_libro, l.autor, l.isbn, l.categoria, 
                   u.nom_usuario, u.apell_usua, u.correo
            FROM prestamos p
            JOIN libros l ON p.id_libro = l.id_libro
            JOIN usuarios u ON p.id_usuarios = u.id_usuarios
            WHERE p.fe_entre IS NOT NULL
        ';

        $stmt = $pdo->query($sql);
        $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mostrar los resultados en una tabla
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>
            <thead>
                <tr style='background-color:blue; color: white;'>
                    <th>ID Préstamo</th>
                    <th>Libro</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Categoría</th>
                    <th>Usuario</th>
                    <th>Fecha de Préstamo</th>
                    <th>Fecha de Devolución</th>
                    <th>Fecha de Entrega</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>";

        // Mostrar los datos de cada préstamo en filas
        foreach ($prestamos as $prestamo) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($prestamo['id_prest']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['nom_libro']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['autor']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['isbn']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['categoria']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['nom_usuario']) . " " . htmlspecialchars($prestamo['apell_usua']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fech_pres']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fec_dev']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fe_entre']) . "</td>";
            // Columna de acción con espaciado
            echo "<td class='action-column'><a href='observaciones.php?id_prest=" . urlencode($prestamo['id_prest']) . "' class='btn'>Seleccionar</a></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    ?>
</body>
</html>
