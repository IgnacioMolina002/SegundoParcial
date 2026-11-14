<?php
    session_start();
    
    require_once '../conexion/conexion.php';

    $mensaje = "";
    if (isset($_GET['msg']) && $_GET['msg'] == 'sesion_cerrada') {
            $mensaje = "Has cerrado sesión correctamente.";
    }

    $email_guardado = isset($_COOKIE['email_recordado']) ? $_COOKIE['email_recordado'] : "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $recordarme = isset($_POST['recordarme']) ? true : false;

        $sql = "SELECT id_usuario, nombre, pass, admin, activo FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $sql);
    
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            
            mysqli_stmt_bind_result($stmt, $id_bd, $nombre_bd, $password_bd, $admin_bd, $activo_bd);
            mysqli_stmt_fetch($stmt);

            if ($activo_bd == 0) {
                $mensaje = "Tu cuenta se encuentra inactiva o suspendida. Contacta a soporte.";
            } else {
                
                if (password_verify($password, $password_bd)) {
                    
                    $_SESSION['usuario_id'] = $id_bd;
                    $_SESSION['usuario_nombre'] = $nombre_bd;
                    $_SESSION['usuario_admin'] = $admin_bd;
                
                    if ($recordarme) {
                        setcookie("email_recordado", $email, time() + (86400 * 30), "/");
                        setcookie("password_recordado", $password, time() + (86400 * 30), "/");
                    } else {
                        setcookie("email_recordado", "", time() - 3600, "/");
                        setcookie("password_recordado", "", time() - 3600, "/");
                    }

                    header("Location: ./catalogo.php");
                    exit; 
                    
                } else {
                    $mensaje = "La contraseña es incorrecta.";
                }
            }
        } else {
            $mensaje = "No existe ninguna cuenta con ese correo electrónico.";
        }
        
        mysqli_stmt_close($stmt);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar</title>
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="stylesheet" href="../estilos/login.css">
</head>
<body>
   <header>
        <?php
            include_once '../componentes/nav.php';
        ?>
    </header>
    <main class="cuerpo">
        <div class="tarjeta-login">
            <h2>Iniciar Sesión</h2>
            <?php
                if ($mensaje != "") {
                    echo '<p class="mensaje-alerta">' .  htmlspecialchars($mensaje) . '</p>';
                }
            ?>
            <form action="login.php" method="POST">
                
                <div class="campo-formulario">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required
                    value="<?php echo isset($_COOKIE['email_recordado']) ? htmlspecialchars($_COOKIE['email_recordado']) : ''; ?>">
                </div>
                
                <div class="campo-formulario">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required
                    value="<?php echo isset($_COOKIE['password_recordado']) ? htmlspecialchars($_COOKIE['password_recordado']) : ''; ?>">
                </div>

                <div class="campo-checkbox">
                    <input type="checkbox" name="recordarme" id="recordarme" <?php echo isset($_COOKIE['email_recordado']) ? 'checked' : ''; ?>>
                    <label for="recordarme">Recordar mis datos</label>
                </div>
                <button type="submit" class="boton-principal">Ingresar</button>
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