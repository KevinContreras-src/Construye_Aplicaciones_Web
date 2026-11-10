<?php require_once "sesion.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Inicio - Luis Victor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>LUIS VICTOR</h1>
  <?php include "menu.php"; ?>

  <h2>Bienvenido a Luis Victor</h2>

  <div class="ancho">
    <p>Luis Victor es una tienda de lujo ficticia, creada como parodia de la famosa casa de moda francesa. Aquí encontrarás bolsos, ropa, calzado, cosméticos y accesorios para celular, todos con nuestro inconfundible monograma dorado.</p>
    <p>Nuestro lema: elegancia de otro nivel, con mucho estilo y un poquito de humor.</p>
    <p class="centro">
      <?php if (isset($_SESSION["usuario_id"])) { ?>
        <a class="cta" href="carrito.php">Ver mi carrito</a>
        <a class="cta" href="bolsos.php">Explorar colección</a>
      <?php } else { ?>
        <a class="cta" href="registro.php">Cuenta</a>
        <a class="cta" href="bolsos.php">Ver colección</a>
      <?php } ?>
    </p>
  </div>

  <h2>Nuestras categorías</h2>
  <div class="ancho">
    <p><a href="bolsos.php">Bolsos y Accesorios</a><br>Bolsos, carteras, maletas y accesorios con el monograma dorado que nos hace famosos.</p>
    <p><a href="ropa.php">Ropa</a><br>Prendas elegantes para lucir como millonario aunque el banco diga lo contrario.</p>
    <p><a href="calzado.php">Calzado</a><br>Tenis, zapatos y botas para pisar fuerte y con estilo.</p>
    <p><a href="cosmeticos.php">Cosméticos</a><br>Perfumes y maquillaje de lujo para que todo mundo voltee a verte.</p>
    <p><a href="celulares.php">Celulares</a><br>Fundas, audífonos y gadgets con monograma para tu tecnología.</p>
  </div>

  <h2>¿Cómo comprar?</h2>
  <div class="ancho">
    <p>1. Entra a una categoría y elige la cantidad que quieres.<br>
    2. Da clic en Agregar al carrito. Si todavía no tienes cuenta, te llevamos al registro y tu producto se agrega solo.<br>
    3. Revisa tu carrito: puedes cambiar cantidades o quitar productos.<br>
    4. Escribe tu dirección y realiza tu pedido.<br>
    5. Consulta tus compras en Mis pedidos.</p>
    <p class="centro"><a class="cta" href="ropa.php">Empezar a comprar</a></p>
  </div>
  <?php include "pie.php"; ?>
</body>
</html>
