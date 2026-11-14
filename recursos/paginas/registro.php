<?php
    session_start();
    
    require_once '../conexion/conexion.php'; 

    $mensaje = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];
                
    if ($password !== $confirmar_password) {
        $mensaje = "Las contraseñas no coinciden. Inténtalo de nuevo.";
    } else {          
        $sql_check = "SELECT id_usuario FROM usuarios WHERE email = ?";
        $stmt_check = mysqli_prepare($conexion, $sql_check);
                        
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
                        
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $mensaje = "El correo electrónico ya está registrado.";
        } else {
            $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
                            
            $sql_insert = "INSERT INTO usuarios (nombre, email, telefono, pass) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conexion, $sql_insert);
                            
            mysqli_stmt_bind_param($stmt_insert, "ssss", $nombre, $email, $telefono, $password_hasheada);
                            
            if (mysqli_stmt_execute($stmt_insert)) {
                $mensaje = "¡Registro exitoso! Ya puedes ingresar.";
            }  else{
                $mensaje = "Error al intentar registrar: " . mysqli_error($conexion);
            }
                            
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);
        }
    }
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="stylesheet" href="../estilos/registro.css">
</head>
<body>
    <header>
        <?php
            include_once '../componentes/nav.php';
        ?>
    </header>
    <main class="cuerpo">
        <div class="tarjeta-registro">
            <h2>Crear Cuenta</h2>
            <?php
                if ($mensaje != "") {
                    echo '<p class="mensaje-alerta">' . htmlspecialchars($mensaje) . '</p>';
                }
            ?>
            <form action="registro.php" method="POST">
                <div class="grupo-input">
                    <label for="nombre">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="grupo-input">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="grupo-input">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required>
                </div>
                
                <div class="grupo-input">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="grupo-input">
                    <label for="confirmar_password">Repetir contraseña:</label>
                    <input type="password" id="confirmar_password" name="confirmar_password" required>
                </div>
                
                <button type="submit" class="btn-submit">Registrarme</button>
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