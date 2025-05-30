<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="inc/Imagenes/logo.png" />
    <title>Biblioteca Municipal</title>
    <style>
        .link {
            display: inline;
            margin: 10px 0;
            padding: 10px;
            background-color: #6c4ab6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .boton-derecha {
            position: absolute;  
            top: 10px;         
            right: 10px;        
            padding: 10px 20px;  
            background-color: #6c4ab6;
            color: white;       
            border: none;       
            border-radius: 5px;  
            cursor: pointer;     
        }
        .boton-derecha:hover {
            background-color: #6c4ab6;
        }
        .btn-multa {
            background-color:  #45a049;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-multa:hover {
            background-color: #6c4ab6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #6c4ab6;
            color: white;
        }
    </style>
</head>
<body>
    <a href="administrador.php" class="link">⬅️ Regresar</a>

    <button class="boton-derecha" onclick="window.location.href='Principal.php';">
        Cerrar Sesión
    </button>

    <h1 align="center">Gestión de Multas</h1>
    <?php
session_start();

// Incluir el archivo de conexión
require_once 'inc/conexion.php';

try {
    // Filtrar préstamos donde fe_entre no está vacío y no tienen multa asociada
    $sql = 'SELECT p.id_prest, p.id_libro, p.id_usuarios, p.fech_pres, p.fec_dev, p.fe_entre, p.observ
            FROM prestamos p
            LEFT JOIN multa m ON p.id_prest = m.id_prest
            WHERE p.fe_entre IS NOT NULL AND m.id_prest IS NULL';

    $stmt = $pdo->query($sql);
    $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($prestamos) > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>
        <thead>
            <tr>
                <th>ID Préstamo</th>
                <th>ID Libro</th>
                <th>ID Usuario</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
                <th>Fecha de Entrega</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>";

        foreach ($prestamos as $prestamo) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($prestamo['id_prest']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['id_libro']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['id_usuarios']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fech_pres']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fec_dev']) . "</td>";
            echo "<td>" . htmlspecialchars($prestamo['fe_entre']) . "</td>";
            echo "<td>
                <form action='genera_multas.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='id_prest' value='" . htmlspecialchars($prestamo['id_prest']) . "'>
                    <input type='hidden' name='id_libro' value='" . htmlspecialchars($prestamo['id_libro']) . "'>
                    <input type='hidden' name='id_usuarios' value='" . htmlspecialchars($prestamo['id_usuarios']) . "'>
                    <input type='hidden' name='fe_entre' value='" . htmlspecialchars($prestamo['fe_entre']) . "'>
                    <button type='submit' class='btn-multa'>Generar Multa</button>
                </form>
            </td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p align='center'>No hay registros con fechas de entrega completadas y sin multas.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error de conexión: " . $e->getMessage() . "</p>";
}
?>

</body>
</html>
