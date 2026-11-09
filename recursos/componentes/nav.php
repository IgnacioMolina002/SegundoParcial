<nav class="menu-principal">
    <div class="logo">
        <?php 
        if (isset($_SESSION['usuario_id'])) {
            echo '<a href="/SegundoParcial/recursos/paginas/catalogo.php">tuAuto.com</a>';
        } else {
            echo '<a href="/SegundoParcial/">tuAuto.com</a>';
        }
        ?>
    </div>
    <div class="enlaces">
        <?php 
        if (isset($_SESSION['usuario_id'])) {
            if (isset($_SESSION['usuario_admin']) && $_SESSION['usuario_admin'] == 1) {
                echo '<a href="usuarios.php">Usuarios</a>';
            }
            echo '<a href="/SegundoParcial/recursos/paginas/catalogo.php">Catálogo</a>';
            echo '<a href="/SegundoParcial/recursos/paginas/usuario.php">Usuario (' . htmlspecialchars($_SESSION['usuario_nombre']) . ')</a>';
            echo '<a href="/SegundoParcial/recursos/conexion/logout.php" class="boton-salir">Cerrar Sesión</a>';
        } else {
            echo '<a href="/SegundoParcial/recursos/paginas/login.php" class="btn-ingresar">Ingresar</a>';
            echo '<a href="/SegundoParcial/recursos/paginas/registro.php" class="btn-registro">Registrarse</a>';
        }
        ?>
    </div>
    
</nav>