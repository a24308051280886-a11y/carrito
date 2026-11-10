<?php
session_start();
$carrito = $_SESSION['carrito'] ?? [];
$subtotal = 0;
foreach ($carrito as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}
$iva   = $subtotal * 0.16;
$total = $subtotal + $iva;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras - SEPHORA MX</title>
</head>
<body bgcolor="#FFF8F0" text="#333333" link="#B85D75" vlink="#8B4255" alink="#FF0000">

    <!-- BARRA NAVEGACIÓN -->
    <table width="100%" border="0" cellpadding="10" bgcolor="#000000">
        <tr>
            <td align="left">
                <h1><font color="#FFFFFF" face="Arial">SEPHORA MX</font></h1>
                <small><font color="#E8C5B0" face="Arial">Cosméticos y Belleza de Lujo ($ MXN)</font></small>
            </td>
            <td align="right">
                <font face="Arial" color="#FFFFFF">
                    <a href="index.html"><font color="#E8C5B0">Inicio</font></a> | 
                    <a href="skincare.php"><font color="#E8C5B0">Skincare</font></a> | 
                    <a href="maquillaje.php"><font color="#E8C5B0">Maquillaje</font></a> | 
                    <a href="labiales.php"><font color="#E8C5B0">Labiales</font></a> | 
                    <a href="fragancias.php"><font color="#E8C5B0">Perfumes</font></a> | 
                    <a href="carrito.php"><font color="#E8C5B0"><b>Mi Carrito (<?php echo count($carrito); ?>)</b></font></a> | 
                    <a href="login.html"><font color="#E8C5B0">Mi Cuenta</font></a>
                </font>
            </td>
        </tr>
    </table>

    <br>

    <!-- ALERTAS DINÁMICAS -->
    <script>
        const params = new URLSearchParams(window.location.search);
        const msg = params.get('msg');
        const type = params.get('type');
        if (msg) {
            const colorFondo = (type === 'exito') ? '#D4EDDA' : '#F8D7DA';
            const colorTexto = (type === 'exito') ? '#155724' : '#721C24';
            document.write(`
                <table width="100%" border="1" cellpadding="15" bgcolor="${colorFondo}">
                    <tr><td align="center"><b><font face="Arial" color="${colorTexto}" size="4">${msg}</font></b></td></tr>
                </table><br>
            `);
        }
    </script>

    <h2 align="center"><font face="Arial" color="#000000">Tu Carrito de Compras</font></h2>

    <?php if (empty($carrito)): ?>
        <table width="100%" border="0" cellpadding="20" bgcolor="#FFFFFF">
            <tr>
                <td align="center">
                    <font face="Arial" size="4">Tu carrito de compras está vacío.</font><br><br>
                    <form action="index.html" method="GET">
                        <input type="submit" value="Ir a la Tienda">
                    </form>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#E8C5B0">
            <tr bgcolor="#000000">
                <th><font color="#FFFFFF">Producto</font></th>
                <th><font color="#FFFFFF">Marca</font></th>
                <th><font color="#FFFFFF">Precio Unitario</font></th>
                <th><font color="#FFFFFF">Cantidad</font></th>
                <th><font color="#FFFFFF">Subtotal</font></th>
                <th><font color="#FFFFFF">Acción</font></th>
            </tr>
            <?php foreach ($carrito as $p_id => $item): ?>
            <tr bgcolor="#FFFFFF">
                <td><b><font face="Arial"><?php echo $item['nombre']; ?></font></b></td>
                <td align="center"><?php echo $item['marca']; ?></td>
                <td align="center"><b><font color="#B85D75">$<?php echo number_format($item['precio'], 2); ?> MXN</font></b></td>
                <td align="center">
                    <form action="api.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="actualizar_cantidad">
                        <input type="hidden" name="producto_id" value="<?php echo $p_id; ?>">
                        <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" max="10" style="width:50px;">
                        <input type="submit" value="Actualizar">
                    </form>
                </td>
                <td align="center"><b><font color="#B85D75">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?> MXN</font></b></td>
                <td align="center">
                    <a href="api.php?action=eliminar&id=<?php echo $p_id; ?>"><font color="#FF0000"><b>[X] Quitar</b></font></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <br>

        <!-- RESUMEN DE TOTALES Y CONFIRMACIÓN DE PEDIDO -->
        <table width="100%" border="0" cellpadding="10">
            <tr>
                <td width="60%" valign="top">
                    <form action="api.php" method="GET">
                        <input type="hidden" name="action" value="vaciar">
                        <input type="submit" value="Vaciar Carrito Completo">
                    </form>
                </td>
                <td width="40%" bgcolor="#FFFFFF">
                    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#E8C5B0">
                        <tr bgcolor="#000000">
                            <th colspan="2"><font color="#FFFFFF">Resumen de Compra</font></th>
                        </tr>
                        <tr>
                            <td><b>Subtotal:</b></td>
                            <td align="right">$<?php echo number_format($subtotal, 2); ?> MXN</td>
                        </tr>
                        <tr>
                            <td><b>IVA (16%):</b></td>
                            <td align="right">$<?php echo number_format($iva, 2); ?> MXN</td>
                        </tr>
                        <tr bgcolor="#F4E3D7">
                            <td><b><font size="4">TOTAL:</font></b></td>
                            <td align="right"><b><font color="#B85D75" size="4">$<?php echo number_format($total, 2); ?> MXN</font></b></td>
                        </tr>
                    </table>
                    <br>
                    <form action="api.php" method="POST">
                        <input type="hidden" name="action" value="finalizar_compra">
                        <input type="submit" value="Proceder a Finalizar Compra" style="width:100%; height:40px; background-color:#000; color:#FFF; font-weight:bold; cursor:pointer;">
                    </form>
                </td>
            </tr>
        </table>
    <?php endif; ?>

    <br><br>
    <table width="100%" border="0" cellpadding="10" bgcolor="#000000">
        <tr><td align="center"><font color="#E8C5B0" face="Arial" size="2">&copy; SEPHORA MX - Tienda Oficial de Cosméticos</font></td></tr>
    </table>
</body>
</html>