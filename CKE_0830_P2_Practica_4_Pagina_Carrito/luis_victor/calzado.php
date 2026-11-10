<?php
require_once "sesion.php";
$categoria = "Calzado";
require "conexion.php";

$stmt = $conexion->prepare("SELECT id, nombre, descripcion, precio, imagen FROM productos WHERE categoria = ? ORDER BY precio DESC");
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
        <th>Imagen</th>
        <th>Producto</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Agregar</th>
      </tr>
      <?php while ($p = $productos->fetch_assoc()) { ?>
      <tr>
        <td><img class="prod" src="<?php echo htmlspecialchars($p["imagen"]); ?>" alt="<?php echo htmlspecialchars($p["nombre"]); ?>" loading="lazy" onerror="this.onerror=null;this.src='imagen_no.svg'"></td>
        <td><?php echo htmlspecialchars($p["nombre"]); ?></td>
        <td class="izq"><?php echo htmlspecialchars($p["descripcion"]); ?></td>
        <td>$<?php echo number_format($p["precio"], 2); ?></td>
        <td>
          <form method="post" action="carrito.php">
            <input type="number" name="cantidad" value="1" min="1" max="10">
            <br>
            <button type="submit" name="agregar" value="<?php echo $p["id"]; ?>">Agregar al carrito</button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </table>
    <p class="centro"><a class="cta" href="carrito.php">Ver mi carrito</a></p>
  </div>
  <?php include "pie.php"; ?>
</body>
</html>
