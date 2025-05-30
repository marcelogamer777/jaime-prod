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
            width: 20%;
            margin: auto;
            padding: 45px;
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
            width: 110%;
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


    </style>
</head>
<body>
<a href="multas.php" class="link">⬅️ Regresar</a>
    <div class="form-container">
    
        <h2>Generar Multa</h2>
        <form action="insertar_multa.php" method="POST">
            <div class="form-group">
                <label for="id_prest">ID Préstamo:</label>
                <input type="text" id="id_prest" name="id_prest" value="<?php echo htmlspecialchars($_POST['id_prest'] ?? ''); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad (en MXN):</label>
                <input type="text" id="cantidad" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="fech_pago">Fecha de Pago (opcional):</label>
                <input type="date" id="fech_pago" name="fech_pago">
            </div>
            <div class="form-group">
            <button type="submit">Registrar Multa</button>
            </div>
        </form>
    </div>
</body>
</html>
