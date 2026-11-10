<?php
session_start();
require_once 'conexion.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'registro') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $pass      = trim($_POST['password'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if (empty($nombre) || empty($email) || empty($pass)) {
        header("Location: login.html?msg=" . urlencode("Completa los campos obligatorios.") . "&type=error");
        exit;
    }

    $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmtCheck->execute([$email]);
    if ($stmtCheck->fetch()) {
        header("Location: login.html?msg=" . urlencode("El correo ya está registrado.") . "&type=error");
        exit;
    }

    $passwordHash = password_hash($pass, PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuarios (nombre, email, password, telefono, direccion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nombre, $email, $passwordHash, $telefono, $direccion])) {
        $mensaje = "¡Bienvenida a SEPHORA MX! Tu cuenta se ha creado con éxito.";
        header("Location: login.html?msg=" . urlencode($mensaje) . "&type=exito");
        exit;
    } else {
        header("Location: login.html?msg=" . urlencode("Error al registrar en SQL.") . "&type=error");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    $sql = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($pass, $usuario['password'])) {
        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];

        $mensaje = "¡Bienvenid@ de nuevo a SEPHORA MX, " . $usuario['nombre'] . "!";
        header("Location: index.html?msg=" . urlencode($mensaje) . "&type=exito");
        exit;
    } else {
        header("Location: login.html?msg=" . urlencode("Correo o contraseña incorrectos.") . "&type=error");
        exit;
    }
}
?>