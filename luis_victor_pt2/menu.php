<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="menu">
  <a href="index.php">Inicio</a> |
  <a href="bolsos.php">Bolsos y Accesorios</a> |
  <a href="ropa.php">Ropa</a> |
  <a href="calzado.php">Calzado</a> |
  <a href="cosmeticos.php">Cosméticos</a> |
  <a href="celulares.php">Celulares</a> |
  <?php if (isset($_SESSION["usuario_id"])) { ?>
    <a href="tienda.php">Comprar</a> |
    <a href="logout.php">Cerrar sesión</a>
  <?php } else { ?>
    <a href="login.php">Iniciar sesión</a> |
    <a href="registro.php">Registro</a>
  <?php } ?>
</div>
