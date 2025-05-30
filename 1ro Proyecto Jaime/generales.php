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
        .data-item {
            margin: 10px 0;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            padding: 10px;
            background-color: #f0f0f0;
            margin-bottom: 5px;
            border-radius: 4px;
            font-size: 16px;
        }
        .link {
            position: absolute;
            top: 10px; 
            left: 10px; 
            padding: 10px;
            background-color: #6c4ab6;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <a href="alumno.php" class="link">⬅️ Regresar</a>
    <div class="container">
        <h1>Datos Generales</h1>
        <div id="user-data">
        <ul>
            <li><strong>Matricula:</strong> <span id="id_usuario">Cargando...</span></li>
            <li><strong>Nombre:</strong> <span id="nombre">Cargando...</span></li>
            <li><strong>Apellidos:</strong> <span id="apellido">Cargando...</span></li>
            <li><strong>Teléfono:</strong> <span id="telefono">Cargando...</span></li>
            <li><strong>Dirección:</strong> <span id="direccion">Cargando...</span></li>
            <li><strong>Carrera:</strong> <span id="carrera">Cargando...</span></li>
            <li><strong>Semestre:</strong> <span id="semestre">Cargando...</span></li>
            <li><strong>Correo Electrónico:</strong> <span id="correo">Cargando...</span></li>
        </ul>

        </div>
    </div>
    <script>
    async function cargarDatos() {
            try {
                const response = await fetch('viewdatos.php');
                
                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error('No se pudo obtener los datos del servidor');
                }

                // Verificar si la respuesta es JSON
                const text = await response.text(); // Leer la respuesta como texto
                try {
                    const data = JSON.parse(text); // Intentar convertir el texto a JSON
                    console.log(data); // Mostrar los datos en la consola para depuración
                    if (data.error) {
                        alert(`Error: ${data.error}`); // Mostrar un mensaje de error si hay algún problema
                        return;
                    }

                    // Asignar los valores a los elementos <span> dentro de la lista
                    document.getElementById('id_usuario').textContent = data.id_usuarios || 'N/A';
                    document.getElementById('nombre').textContent = data.nom_usuario || 'N/A';
                    document.getElementById('apellido').textContent = data.apell_usua || 'N/A';
                    document.getElementById('telefono').textContent = data.tel || 'N/A';
                    document.getElementById('direccion').textContent = data.direccion || 'N/A';
                    document.getElementById('carrera').textContent = data.carrera || 'N/A';
                    document.getElementById('semestre').textContent = data.semestre || 'N/A';
                    document.getElementById('correo').textContent = data.correo || 'N/A';
                } catch (error) {
                    console.error('Error al parsear la respuesta JSON:', error);
                    alert("Hubo un problema al cargar los datos. Respuesta no válida.");
                }
            } catch (error) {
                console.error("Error al cargar los datos:", error);
                alert("Hubo un problema al cargar los datos. Por favor, inténtalo de nuevo más tarde.");
            }
        }


    // Llamar a la función para cargar los datos cuando la página esté completamente cargada
    document.addEventListener('DOMContentLoaded', cargarDatos);
</script>

</body>
</html>
