<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../conexion/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $password_confirmar = $_POST['password_confirmar'];
    $id_usuario = $_SESSION['usuario_id'];

    if ($password_nueva !== $password_confirmar) {
        $mensaje = "Las contraseñas nuevas no coinciden.";
    } else {
        $sql = "SELECT pass FROM usuarios WHERE id_usuario = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hash_bd);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (password_verify($password_actual, $hash_bd)) {
            
            $nuevo_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
            
            $sql_update = "UPDATE usuarios SET pass = ? WHERE id_usuario = ?";
            $stmt_update = mysqli_prepare($conexion, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $nuevo_hash, $id_usuario);
            
            if (mysqli_stmt_execute($stmt_update)) {
                $mensaje = "¡Contraseña actualizada exitosamente!";
            } else {
                $mensaje = "Error al actualizar la contraseña: " . mysqli_error($conexion);
            }
            mysqli_stmt_close($stmt_update);
            
        } else {
            $mensaje = "La contraseña actual es incorrecta.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="stylesheet" href="../estilos/usuario.css">
</head>
<body>
     <header>
        <?php
            include_once '../componentes/nav.php';
        ?>
    </header>

    <main class="cuerpo">
        <div class="tarjeta-perfil">
            <h2>Cambiar Contraseña</h2>
            
            <?php 
            if ($mensaje != "") {
                echo '<p class="mensaje-alerta">' . $mensaje . '</p>';
            }
            ?>
            <form action="cambiarContraseña.php" method="POST">
                
                <div class="campo-formulario">
                    <label for="password_actual">Contraseña actual:</label>
                    <input type="password" id="password_actual" name="password_actual" required>
                </div>
                
                <div class="campo-formulario">
                    <label for="password_nueva">Nueva contraseña:</label>
                    <input type="password" id="password_nueva" name="password_nueva" required>
                </div>
                
                <div class="campo-formulario">
                    <label for="password_confirmar">Confirmar nueva contraseña:</label>
                    <input type="password" id="password_confirmar" name="password_confirmar" required>
                </div>
                
                <div class="acciones-perfil">
                    <button type="submit" class="boton-principal">Actualizar Contraseña</button>
                    <a href="./usuario.php" class="boton-secundario">Volver al Perfil</a>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <?php
            include_once '../componentes/footer.php';
        ?>
    </footer>

</body>
</html>