<?php 
require_once 'conexion.php'; 
$stmt = $pdo->query("SELECT * FROM productos WHERE categoria = 'Skincare'"); 
$productos = $stmt->fetchAll(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Skincare - SEPHORA MX</title>
</head>
<body bgcolor="#FFF8F0" text="#333333">

    <table width="100%" border="0" cellpadding="10" bgcolor="#000000">
        <tr>
            <td><h1><font color="#FFFFFF" face="Arial">SEPHORA MX</font></h1></td>
            <td align="right">
                <font face="Arial" color="#FFFFFF">
                    <a href="index.html"><font color="#E8C5B0">Inicio</font></a> | 
                    <a href="skincare.php"><font color="#E8C5B0"><b>Skincare</b></font></a> | 
                    <a href="maquillaje.php"><font color="#E8C5B0">Maquillaje</font></a> | 
                    <a href="labiales.php"><font color="#E8C5B0">Labiales</font></a> | 
                    <a href="fragancias.php"><font color="#E8C5B0">Perfumes</font></a> | 
                    <a href="carrito.php"><font color="#E8C5B0">Mi Carrito</font></a> | 
                    <a href="login.html"><font color="#E8C5B0">Mi Cuenta</font></a>
                </font>
            </td>
        </tr>
    </table>

    <br>
    <h2 align="center"><font face="Arial">Categoría: Skincare</font></h2>
    
    <table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#E8C5B0">
        <tr bgcolor="#000000">
            <th><font color="#FFFFFF">Imagen</font></th>
            <th><font color="#FFFFFF">Producto</font></th>
            <th><font color="#FFFFFF">Marca</font></th>
            <th><font color="#FFFFFF">Precio ($ MXN)</font></th>
            <th><font color="#FFFFFF">Acción</font></th>
        </tr>
        <?php 
        $i = 1; 
        foreach ($productos as $p) { 
            $ext = ($i == 3 || $i == 4 || $i == 6 || $i == 8 || $i == 9 || $i == 10) ? 'png' : 'jpeg';
        ?>
        <tr bgcolor="#FFFFFF">
            <td align="center">
                <img src="img/skincare<?php echo $i; ?>.<?php echo $ext; ?>" width="80" height="80" alt="Producto <?php echo $i; ?>">
            </td>
            <td><b><font face="Arial"><?php echo $p['nombre']; ?></font></b><br><small><?php echo $p['descripcion']; ?></small></td>
            <td align="center"><b><?php echo $p['marca']; ?></b></td>
            <td align="center"><b><font color="#B85D75">$<?php echo number_format($p['precio'], 2); ?> MXN</font></b></td>
            <td align="center">
                <form action="api.php" method="POST">
                    <input type="hidden" name="action" value="agregar_carrito">
                    <input type="hidden" name="producto_id" value="<?php echo $p['id']; ?>">
                    <input type="hidden" name="origen" value="skincare.php">
                    <input type="submit" value="Agregar al Carrito">
                </form>
            </td>
        </tr>
        <?php $i++; } ?>
    </table>
</body>
</html>