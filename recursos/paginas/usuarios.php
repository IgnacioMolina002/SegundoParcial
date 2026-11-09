<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_admin'] != 1) {
    header("Location: login.php");
    exit;
}

require_once '../conexion/conexion.php';

$sql = "SELECT id_usuario, nombre, email, fecha_registro, admin, activo FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="stylesheet" href="../estilos/usuarios.css"> 
</head>
<body>
   <header>
        <?php
            include_once '../componentes/nav.php';
        ?>
    </header>
    <main class="cuerpo">
        <div class="contenedor-tabla">
            <h2>Gestión de Usuarios</h2>
            
            <table class="tabla-datos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Alta</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($fila['id_usuario']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['nombre']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['fecha_registro']) . '</td>';
                        echo '<td>';
                        if ($fila['admin'] == 1) {
                            echo 'Administrador';
                        } else {
                            echo 'Usuario';
                        }
                        echo '</td>';
                        echo '<td>';
                        if ($fila['activo'] == 1) {
                            echo '<span class="etiqueta-activo">Activo</span>';
                        } else {
                            echo '<span class="etiqueta-inactivo">Inactivo</span>';
                        }
                        echo '</td>';
                        echo '<td>';
                        echo '<form action="cambiarEstado.php" method="POST" style="margin: 0;">';
                        echo '<input type="hidden" name="id" value="' . $fila['id_usuario'] . '">';
                        if ($fila['activo'] == 1) {
                            echo '<input type="hidden" name="estado" value="0">';
                            echo '<button type="submit" class="btn-accion btn-inactivar" style="cursor: pointer;">Inactivar</button>';
                        } else {
                            echo '<input type="hidden" name="estado" value="1">';
                            echo '<button type="submit" class="btn-accion btn-activar" style="cursor: pointer;">Activar</button>';
                        }
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <?php
            include_once '../componentes/footer.php';
        ?>
    </footer>
</body>
</html>