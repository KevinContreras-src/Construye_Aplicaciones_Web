<?php
require_once "sesion.php";
exigir_cuenta("tienda.php");
require_once "conexion.php";

$mensaje = "";
$seleccionado = isset($_GET["producto"]) ? (int)$_GET["producto"] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = (int)$_POST["producto_id"];
    $cantidad    = (int)$_POST["cantidad"];
    $direccion   = trim($_POST["direccion"]);
    $comentarios = trim($_POST["comentarios"]);

    // Revisar que el producto exista en el catálogo
    $stmt = $conexion->prepare("SELECT id FROM productos WHERE id = ?");
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $mensaje = "Ese producto no existe en el catálogo.";
    } elseif ($cantidad < 1 || $cantidad > 10 || $direccion == "") {
        $mensaje = "La cantidad debe ser de 1 a 10 y la dirección no puede ir vacía.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO pedidos (usuario_id, producto_id, cantidad, direccion, comentarios) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $_SESSION["usuario_id"], $producto_id, $cantidad, $direccion, $comentarios);
        $stmt->execute();
        $mensaje = "¡Pedido guardado!";
    }
}

// Catálogo de productos para el select
$productos = $conexion->query("SELECT id, categoria, marca, nombre, precio FROM productos ORDER BY categoria, marca, nombre");

// Pedidos del usuario
$stmt = $conexion->prepare("SELECT pr.categoria, pr.marca, pr.nombre, pr.precio, pe.cantidad, pe.fecha FROM pedidos pe INNER JOIN productos pr ON pr.id = pe.producto_id WHERE pe.usuario_id = ? ORDER BY pe.id DESC");
$stmt->bind_param("i", $_SESSION["usuario_id"]);
$stmt->execute();
$pedidos = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tienda - Luis Victor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>LUIS VICTOR</h1>
  <?php include "menu.php"; ?>
  <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?></h2>

  <div>
    <p><?php echo htmlspecialchars($mensaje); ?></p>

    <form method="post" action="tienda.php">
      <label>Producto:</label><br>
      <select name="producto_id">
        <?php while ($p = $productos->fetch_assoc()) { ?>
          <option value="<?php echo $p["id"]; ?>"<?php if ($p["id"] == $seleccionado) { echo " selected"; } ?>>
            <?php echo htmlspecialchars($p["categoria"] . " - " . $p["nombre"] . " - $" . number_format($p["precio"], 2)); ?>
          </option>
        <?php } ?>
      </select><br><br>

      <label>Cantidad:</label><br>
      <input type="number" name="cantidad" value="1" min="1" max="10" required><br><br>

      <label>Dirección de envío:</label><br>
      <textarea name="direccion" required></textarea><br><br>

      <label>Comentarios:</label><br>
      <textarea name="comentarios"></textarea><br><br>

      <button type="submit">Comprar</button>
    </form>
  </div>

  <h2>Mis pedidos</h2>
  <div>
    <table>
      <tr>
        <th>Categoría</th>
        <th>Producto</th>
        <th>Cant.</th>
        <th>Total</th>
        <th>Fecha</th>
      </tr>
      <?php while ($p = $pedidos->fetch_assoc()) { ?>
      <tr>
        <td><?php echo htmlspecialchars($p["categoria"]); ?></td>
        <td><?php echo htmlspecialchars($p["nombre"]); ?></td>
        <td><?php echo $p["cantidad"]; ?></td>
        <td>$<?php echo number_format($p["precio"] * $p["cantidad"], 2); ?></td>
        <td><?php echo $p["fecha"]; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <?php include "pie.php"; ?>
</body>
</html>
