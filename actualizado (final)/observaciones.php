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
            padding: 50px;
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

        .form-container {
            text-align: left;
            padding: 60px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #6c4ab6;
            width: 30%;
            margin: 0 auto;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .btn {
            background-color: #6c4ab6;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #563a9e;
        }
        .left-align {
            text-align: left;
            padding-left: 10px;
        }
    </style>
</head>
<body>

    <div class="left-align">
        <a href="prestamos.php" class="link">⬅️ Regresar</a>
    </div>

    <h1>Observaciones</h1>

    <?php
    // Incluir el archivo de conexión
    include('inc/conexion.php');

    // Obtener el id_prest de la URL
    if (isset($_GET['id_prest'])) {
        $id_prest = $_GET['id_prest'];

        try {
            // Consulta para obtener los datos del préstamo seleccionado
            $sql = "
                SELECT p.id_prest, p.fech_pres, p.fec_dev, p.fe_entre, p.observ,
                       l.nom_libro, l.autor, l.isbn, l.categoria, 
                       u.nom_usuario, u.apell_usua, u.correo
                FROM prestamos p
                JOIN libros l ON p.id_libro = l.id_libro
                JOIN usuarios u ON p.id_usuarios = u.id_usuarios
                WHERE p.id_prest = :id_prest
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_prest' => $id_prest]);
            $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($prestamo) {
                // Mostrar el formulario con los datos del préstamo
                echo "<div class='form-container'>";
                echo "<form action='guardar_observacion.php' method='post'>";
                echo "<input type='hidden' name='id_prest' value='" . htmlspecialchars($prestamo['id_prest']) . "' />";
                echo "<label for='nom_libro'>Libro</label>";
                echo "<input type='text' id='nom_libro' value='" . htmlspecialchars($prestamo['nom_libro']) . "' readonly />";
                echo "<label for='autor'>Autor</label>";
                echo "<input type='text' id='autor' value='" . htmlspecialchars($prestamo['autor']) . "' readonly />";
                echo "<label for='isbn'>ISBN</label>";
                echo "<input type='text' id='isbn' value='" . htmlspecialchars($prestamo['isbn']) . "' readonly />";
                echo "<label for='categoria'>Categoría</label>";
                echo "<input type='text' id='categoria' value='" . htmlspecialchars($prestamo['categoria']) . "' readonly />";
                echo "<label for='usuario'>Usuario</label>";
                echo "<input type='text' id='usuario' value='" . htmlspecialchars($prestamo['nom_usuario']) . " " . htmlspecialchars($prestamo['apell_usua']) . "' readonly />";
                echo "<label for='observaciones'>Observaciones</label>";
                echo "<textarea id='observaciones' name='observaciones' rows='4' placeholder='Ingrese las observaciones aquí...'></textarea>";
                echo "<button type='submit' class='btn'>Guardar Observaciones</button>";
                echo "</form>";
                echo "</div>";
            } else {
                echo "<p>No se encontraron datos para este préstamo.</p>";
            }

        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    } else {
        echo "<p>No se proporcionó un ID de préstamo.</p>";
    }
    ?>

</body>
</html>
