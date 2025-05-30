<?php
// Verificar si hay un mensaje en la URL
$message = '';
$message_type = '';

if (isset($_GET['success'])) {
    $message = 'El libro fue recomendado con éxito.';
    $message_type = 'success';
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        $message = 'Error al recomendar el libro.';
    } elseif ($_GET['error'] == 2) {
        $message = 'El libro ya existe.';
    }
    $message_type = 'error';
}
?>

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
        .form-container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #6c4ab6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #563a9e;
        }

        /* Estilo del mensaje */
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
            width: 80%;
            max-width: 500px;
            margin: 20px auto;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <a href="Docente.PHP" class="link">⬅️ Regresar</a>
    <h1 align="center">Libros</h1>

    <div class="form-container">
        <h2>Recomendar un Libro</h2>

        <!-- Mostrar el mensaje si está presente -->
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="procesar_libro.php" method="POST">
            <div class="form-group">
                <label for="id_libro">ID del Libro:</label>
                <input type="text" id="id_libro" name="id_libro" required>
            </div>
            <div class="form-group">
                <label for="nom_libro">Nombre del Libro:</label>
                <input type="text" id="nom_libro" name="nom_libro" required>
            </div>
            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" required>
            </div>
            <div class="form-group">
                <label for="editorial">Editorial:</label>
                <input type="text" id="editorial" name="editorial">
            </div>
            <div class="form-group">
                <label for="num_pag">Número de Páginas:</label>
                <input type="number" id="num_pag" name="num_pag" min="1" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn">
            </div>
            <div class="form-group">
                <label for="año_publ">Año de Publicación:</label>
                <input type="number" id="año_publ" name="año_publ" min="1000" max="9999" required>
            </div>
            <div class="form-group">
                <label for="cant_disp">Cantidad Disponible:</label>
                <input type="number" id="cant_disp" name="cant_disp" min="0">
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria">
            </div>
            <div class="form-group">
                <button type="submit">Recomendar Libro</button>
            </div>
        </form>
    </div>

</body>
</html>
