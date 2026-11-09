<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_admin'] != 1) {
    header("Location: ./index.php");
    exit;
}

require_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['estado'])) {
    
    $id_cambio = intval($_POST['id']);
    $nuevo_estado = intval($_POST['estado']);
    
    if ($id_cambio == $_SESSION['usuario_id']) {
        header("Location: ./usuarios.php?msg=error_auto_baja");
        exit;
    }

    $sql = "UPDATE usuarios SET activo = ? WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    
    mysqli_stmt_bind_param($stmt, "ii", $nuevo_estado, $id_cambio);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: ./usuarios.php");
exit;
?>