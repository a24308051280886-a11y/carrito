<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$action = $_REQUEST['action'] ?? '';
$origen = $_REQUEST['origen'] ?? 'index.html';

// 1. AGREGAR AL CARRITO
if ($action === 'agregar_carrito' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = intval($_POST['producto_id'] ?? 0);
    $cantidad    = intval($_POST['cantidad'] ?? 1);

    if ($producto_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$producto_id]);
        $prod = $stmt->fetch();

        if ($prod) {
            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
            } else {
                $_SESSION['carrito'][$producto_id] = [
                    'id'        => $prod['id'],
                    'nombre'    => $prod['nombre'],
                    'marca'     => $prod['marca'],
                    'precio'    => $prod['precio'],
                    'categoria' => $prod['categoria'],
                    'cantidad'  => $cantidad
                ];
            }
            header("Location: " . $origen . "?msg=" . urlencode("¡Producto añadido al carrito!") . "&type=exito");
            exit;
        }
    }
}

// 2. ACTUALIZAR CANTIDADES
if ($action === 'actualizar_cantidad' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = intval($_POST['producto_id'] ?? 0);
    $nueva_cant  = intval($_POST['cantidad'] ?? 1);

    if ($producto_id > 0 && isset($_SESSION['carrito'][$producto_id])) {
        if ($nueva_cant > 0) {
            $_SESSION['carrito'][$producto_id]['cantidad'] = $nueva_cant;
        } else {
            unset($_SESSION['carrito'][$producto_id]);
        }
    }
    header("Location: carrito.php?msg=" . urlencode("Carrito actualizado.") . "&type=exito");
    exit;
}

// 3. ELIMINAR ITEM
if ($action === 'eliminar' && isset($_GET['id'])) {
    $producto_id = intval($_GET['id']);
    unset($_SESSION['carrito'][$producto_id]);
    header("Location: carrito.php?msg=" . urlencode("Producto quitado del carrito.") . "&type=exito");
    exit;
}

// 4. VACIAR CARRITO
if ($action === 'vaciar') {
    $_SESSION['carrito'] = [];
    header("Location: carrito.php?msg=" . urlencode("Carrito vaciado correctamente.") . "&type=exito");
    exit;
}

// 5. PROCESAR COMPRA Y REGISTRAR PEDIDO EN MYSQL
if ($action === 'finalizar_compra' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.html?msg=" . urlencode("Inicia sesión para procesar tu pedido.") . "&type=error");
        exit;
    }

    if (empty($_SESSION['carrito'])) {
        header("Location: carrito.php?msg=" . urlencode("Tu carrito está vacío.") . "&type=error");
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];
    $subtotal   = 0;

    foreach ($_SESSION['carrito'] as $item) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }

    $iva   = $subtotal * 0.16;
    $total = $subtotal + $iva;

    try {
        $pdo->beginTransaction();

        $stmtPed = $pdo->prepare("INSERT INTO pedidos (usuario_id, subtotal, iva, total) VALUES (?, ?, ?, ?)");
        $stmtPed->execute([$usuario_id, $subtotal, $iva, $total]);
        $pedido_id = $pdo->lastInsertId();

        $stmtDet = $pdo->prepare("INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['carrito'] as $item) {
            $stmtDet->execute([$pedido_id, $item['id'], $item['cantidad'], $item['precio']]);
        }

        $pdo->commit();
        $_SESSION['carrito'] = []; // Vaciar el carrito al completar la compra

        header("Location: carrito.php?msg=" . urlencode("¡Compra procesada con éxito! Tu Pedido es el #" . $pedido_id) . "&type=exito");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        header("Location: carrito.php?msg=" . urlencode("Error al procesar: " . $e->getMessage()) . "&type=error");
        exit;
    }
}
?>