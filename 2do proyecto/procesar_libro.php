<?php
session_start();
require_once 'inc/conexion.php'; // Incluye el archivo con la conexión PDO

// Verificar si el formulario fue enviado usando el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde el formulario
    $id_libro = $_POST["id_libro"];
    $nom_libro = $_POST["nom_libro"];
    $autor = $_POST["autor"];
    $editorial = $_POST["editorial"];
    $num_pag = $_POST["num_pag"];
    $isbn = $_POST["isbn"];
    $ano_publ = $_POST["año_publ"]; 
    $cant_disp = $_POST["cant_disp"];
    $categoria = $_POST["categoria"];

    // Comprobar si el libro ya existe
    $stmt = $pdo->prepare('SELECT * FROM libros WHERE id_libro = :id_libro');
    $stmt->execute(['id_libro' => $id_libro]);
    if ($stmt->fetch()) {
        header('Location: libros_recom.php?error=2'); // Error: El libro ya existe
        exit;
    }

    try {
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO libros (id_libro, nom_libro, autor, editorial, num_pag, isbn, año_publ, cant_disp, categoria)
                VALUES (:id_libro, :nom_libro, :autor, :editorial, :num_pag, :isbn, :ano_publ, :cant_disp, :categoria)";

        // Preparar la declaración con PDO
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta con los valores correspondientes
        $stmt->execute([
            ':id_libro' => $id_libro,
            ':nom_libro' => $nom_libro,
            ':autor' => $autor,
            ':editorial' => $editorial,
            ':num_pag' => $num_pag,
            ':isbn' => $isbn,
            ':ano_publ' => $ano_publ, 
            ':cant_disp' => $cant_disp,
            ':categoria' => $categoria
        ]);

        // Redirigir con mensaje de éxito
        header('Location: libros_recom.php?success=1');
        exit;
    } catch (PDOException $e) {
        // Redirigir con mensaje de error
        header('Location: libros_recom.php?error=1');
        exit;
    }
} else {
    echo "Método no permitido.";
}
?>
