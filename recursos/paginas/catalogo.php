<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="stylesheet" href="../estilos/index.css">
</head>
<body>
    <header>
        <?php
            include_once '../componentes/nav.php';
        ?>
    </header>
    <main class="cuerpo">
        <div class="cuerpo-contenido">
            <h1>Catálogo en construcción 🚧</h1>
        </div>
    </main>
    <footer>
        <?php
            include_once '../componentes/footer.php';
        ?>
    </footer>
</body>
</html>