<?php
require_once "sesion.php";
require_once "conexion.php";

// Cantidad de productos en el carrito del usuario
$en_carrito = 0;
if (isset($_SESSION["usuario_id"])) {
    $q_menu = $conexion->prepare("SELECT COALESCE(SUM(cantidad), 0) FROM carrito WHERE usuario_id = ?");
    $q_menu->bind_param("i", $_SESSION["usuario_id"]);
    $q_menu->execute();
    $q_menu->bind_result($en_carrito);
    $q_menu->fetch();
    $q_menu->close();
}
?>
<div class="menu">
  <a href="index.php">Inicio</a> |
  <a href="bolsos.php">Bolsos y Accesorios</a> |
  <a href="ropa.php">Ropa</a> |
  <a href="calzado.php">Calzado</a> |
  <a href="cosmeticos.php">Cosméticos</a> |
  <a href="celulares.php">Celulares</a> |
  <a href="carrito.php">Carrito (<?php echo (int)$en_carrito; ?>)</a> |
  <?php if (isset($_SESSION["usuario_id"])) { ?>
    <a href="tienda.php">Mis pedidos</a> |
    <a href="logout.php">Cerrar sesión</a>
  <?php } else { ?>
    <a href="login.php">Iniciar sesión</a> |
    <a href="registro.php">Registro</a>
  <?php } ?>
</div>
