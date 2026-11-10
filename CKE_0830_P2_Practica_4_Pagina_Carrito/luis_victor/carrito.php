<?php
require_once "sesion.php";
require_once "conexion.php";

$uid = isset($_SESSION["usuario_id"]) ? $_SESSION["usuario_id"] : 0;
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // AGREGAR: si no tiene cuenta, se guarda el producto y se manda al registro
    if (isset($_POST["agregar"])) {
        $producto_id = (int)$_POST["agregar"];
        $cantidad = (int)$_POST["cantidad"];
        if (!$uid) {
            $_SESSION["pendiente"] = array("producto_id" => $producto_id, "cantidad" => $cantidad);
            exigir_cuenta("carrito.php");
        }
        agregar_al_carrito($conexion, $uid, $producto_id, $cantidad);
        header("Location: carrito.php?ok=1");
        exit;
    }

    // Todo lo demás necesita cuenta
    exigir_cuenta("carrito.php");

    // ACTUALIZAR cantidad
    if (isset($_POST["actualizar"])) {
        $producto_id = (int)$_POST["actualizar"];
        $cantidad = (int)$_POST["cantidad"];
        if ($cantidad < 1) { $cantidad = 1; }
        if ($cantidad > 10) { $cantidad = 10; }
        $stmt = $conexion->prepare("UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?");
        $stmt->bind_param("iii", $cantidad, $uid, $producto_id);
        $stmt->execute();
        $stmt->close();
        header("Location: carrito.php?ok=2");
        exit;
    }

    // QUITAR producto
    if (isset($_POST["quitar"])) {
        $producto_id = (int)$_POST["quitar"];
        $stmt = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?");
        $stmt->bind_param("ii", $uid, $producto_id);
        $stmt->execute();
        $stmt->close();
        header("Location: carrito.php?ok=3");
        exit;
    }

    // FINALIZAR compra: el carrito pasa a la tabla pedidos
    if (isset($_POST["comprar"])) {
        $direccion = trim($_POST["direccion"]);
        $comentarios = trim($_POST["comentarios"]);

        if ($direccion == "") {
            $mensaje = "Escribe tu dirección de envío.";
        } else {
            $conexion->begin_transaction();

            $stmt = $conexion->prepare("INSERT INTO pedidos (usuario_id, producto_id, cantidad, direccion, comentarios) SELECT usuario_id, producto_id, cantidad, ?, ? FROM carrito WHERE usuario_id = ?");
            $stmt->bind_param("ssi", $direccion, $comentarios, $uid);
            $stmt->execute();
            $filas = $stmt->affected_rows;
            $stmt->close();

            if ($filas < 1) {
                $conexion->rollback();
                $mensaje = "Tu carrito está vacío.";
            } else {
                $stmt = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ?");
                $stmt->bind_param("i", $uid);
                $stmt->execute();
                $stmt->close();
                $conexion->commit();
                header("Location: carrito.php?ok=4");
                exit;
            }
        }
    }
}

// Ver el carrito también necesita cuenta
exigir_cuenta("carrito.php");

$textos = array(
    1 => "Producto agregado al carrito.",
    2 => "Cantidad actualizada.",
    3 => "Producto quitado del carrito.",
    4 => "¡Pedido realizado! Puedes verlo en Mis pedidos."
);
$ok = isset($_GET["ok"]) ? (int)$_GET["ok"] : 0;
if ($mensaje == "" && isset($textos[$ok])) {
    $mensaje = $textos[$ok];
}

$stmt = $conexion->prepare("SELECT pr.id, pr.nombre, pr.precio, pr.imagen, ca.cantidad FROM carrito ca INNER JOIN productos pr ON pr.id = ca.producto_id WHERE ca.usuario_id = ? ORDER BY ca.id");
$stmt->bind_param("i", $uid);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$total = 0;
foreach ($items as $it) {
    $total = $total + ($it["precio"] * $it["cantidad"]);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Carrito - Luis Victor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>LUIS VICTOR</h1>
  <?php include "menu.php"; ?>

  <h2>Mi carrito</h2>

  <div class="ancho">
    <p><?php echo htmlspecialchars($mensaje); ?></p>

    <?php if (count($items) == 0) { ?>
      <p>Tu carrito está vacío.</p>
      <p class="centro"><a class="cta" href="bolsos.php">Ver colección</a></p>
    <?php } else { ?>
      <table>
        <tr>
          <th>Imagen</th>
          <th>Producto</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
        </tr>
        <?php foreach ($items as $it) { ?>
        <tr>
          <td><img class="prod" src="<?php echo htmlspecialchars($it["imagen"]); ?>" alt="<?php echo htmlspecialchars($it["nombre"]); ?>" loading="lazy" onerror="this.onerror=null;this.src='imagen_no.svg'"></td>
          <td><?php echo htmlspecialchars($it["nombre"]); ?></td>
          <td>$<?php echo number_format($it["precio"], 2); ?></td>
          <td>
            <form method="post" action="carrito.php">
              <input type="number" name="cantidad" value="<?php echo $it["cantidad"]; ?>" min="1" max="10">
              <br>
              <button type="submit" name="actualizar" value="<?php echo $it["id"]; ?>">Actualizar</button>
              <button type="submit" name="quitar" value="<?php echo $it["id"]; ?>">Quitar</button>
            </form>
          </td>
          <td>$<?php echo number_format($it["precio"] * $it["cantidad"], 2); ?></td>
        </tr>
        <?php } ?>
      </table>
      <h2>Total: $<?php echo number_format($total, 2); ?></h2>
    <?php } ?>
  </div>

  <?php if (count($items) > 0) { ?>
  <h2>Finalizar compra</h2>
  <div>
    <form method="post" action="carrito.php">
      <label>Dirección de envío:</label><br>
      <textarea name="direccion" required></textarea><br><br>

      <label>Comentarios:</label><br>
      <textarea name="comentarios"></textarea><br><br>

      <button type="submit" name="comprar" value="1">Realizar pedido</button>
    </form>
  </div>
  <?php } ?>

  <?php include "pie.php"; ?>
</body>
</html>
