<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="inc/Imagenes/logo.png" />
    <title>Biblioteca Municipal - Préstamos</title>
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
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        
    </style>
</head>
<body>

    <div class="left-align">
        <a href="administrador.php" class="link">⬅️ Regresar</a>
    </div>

    <h1>Historial de Préstamos Completos</h1>
    <?php
// Iniciar la sesión
session_start();

// Incluir el archivo de conexión
include('inc/conexion.php');

try {
    // Consulta para obtener los préstamos completos (sin campos vacíos) y el id del usuario
    $sql = "
        SELECT p.id_prest, p.fech_pres, p.fec_dev, p.fe_entre, 
               l.nom_libro, l.autor, l.isbn, 
               p.id_usuarios, -- Agregar id_usuarios
               m.cantidad AS multa, m.fech_gen AS fecha_multa, m.fech_pago
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id_libro
        LEFT JOIN multa m ON p.id_prest = m.id_prest
        WHERE p.fech_pres IS NOT NULL
          AND p.fec_dev IS NOT NULL
          AND p.fe_entre IS NOT NULL
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay préstamos
    if (count($prestamos) > 0) {
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Id Usuario</th>
                    <th>Libro</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Fecha de Préstamo</th>
                    <th>Fecha de Devolución</th>
                    <th>Fecha de Entrega</th>
                    <th>Multa</th>
                    <th>Fecha de Generación de Multa</th>
                    <th>Fecha de Pago</th>
                </tr>
              </thead>";
        echo "<tbody>";

        // Mostrar los datos de los préstamos y la multa
        foreach ($prestamos as $prestamo) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($prestamo['id_usuarios']) . "</td>"; // Mostrar el ID del usuario
            echo "<td>" . htmlspecialchars($prestamo['nom_libro']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['autor']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['isbn']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fech_pres']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fec_dev']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fe_entre']) . "</td>";

            // Mostrar la multa si existe
            if ($prestamo['multa']) {
                echo "<td>" . htmlspecialchars($prestamo['multa']) . "</td>";
                echo "<td>" . htmlspecialchars($prestamo['fecha_multa']) . "</td>";
                echo "<td>" . htmlspecialchars($prestamo['fech_pago']) . "</td>";
            } else {
                echo "<td>No hay multa</td><td>No generada</td><td>No pagada</td>";
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No se encontraron préstamos completos.</p>";
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

</body>
</html>
