<?php
$categoria = "Calzado";
require "conexion.php";

$stmt = $conexion->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE categoria = ? ORDER BY precio DESC");
$stmt->bind_param("s", $categoria);
$stmt->execute();
$productos = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Calzado - Luis Victor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>LUIS VICTOR</h1>
  <?php include "menu.php"; ?>

  <h2>Calzado</h2>
  <div class="ancho">
    <p>Tenis, zapatos y botas para pisar fuerte y con estilo.</p>
    <hr>
    <table>
      <tr>
        <th>Producto</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Pedir</th>
      </tr>
      <?php while ($p = $productos->fetch_assoc()) { ?>
      <tr>
        <td><?php echo htmlspecialchars($p["nombre"]); ?></td>
        <td class="izq"><?php echo htmlspecialchars($p["descripcion"]); ?></td>
        <td>$<?php echo number_format($p["precio"], 2); ?></td>
        <td><a href="tienda.php?producto=<?php echo $p["id"]; ?>">Comprar</a></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <?php include "pie.php"; ?>
</body>
</html>
