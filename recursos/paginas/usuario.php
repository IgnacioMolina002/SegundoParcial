<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../conexion/conexion.php';

$id_usuario = $_SESSION['usuario_id'];
$nombre = "";
$email = "";
$telefono = "";

$sql = "SELECT nombre, email, telefono FROM usuarios WHERE id_usuario = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario); 
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nombre, $email, $telefono);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'modificar') {
    
    $nuevo_nombre = trim($_POST['nombre']);
    $nuevo_telefono = trim($_POST['telefono']);
    
    $sql_update = "UPDATE usuarios SET nombre = ?, telefono = ? WHERE id_usuario = ?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    
    mysqli_stmt_bind_param($stmt_update, "ssi", $nuevo_nombre, $nuevo_telefono, $id_usuario);
    
    if (mysqli_stmt_execute($stmt_update)) {
        $mensaje = "Datos actualizados correctamente.";
        
        $nombre = $nuevo_nombre;
        $telefono = $nuevo_telefono;
        
        $_SESSION['usuario_nombre'] = $nuevo_nombre;
    } else {
        $mensaje = "Error al actualizar los datos: " . mysqli_error($conexion);
    }
    mysqli_stmt_close($stmt_update);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Usuario</title>
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
            <h2>Mi Usuario</h2>
            <?php 
                if ($mensaje != "") {
                    echo '<p class="mensaje-alerta">' . $mensaje . '</p>';
                }
            ?>
            <form action="usuario.php" method="POST">

                <div class="campo-formulario">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>
                
                <div class="campo-formulario">
                    <label for="nombre">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div>
                
                <div class="campo-formulario">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
                </div>
                
                <div class="acciones-perfil">
                    <button type="submit" name="accion" value="modificar" class="boton-principal">Modificar Datos</button>
                    <a href="cambiarContraseña.php" class="boton-secundario">Cambiar Contraseña</a>
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