<?php
require_once "sesion.php";
require_once "conexion.php";

// Si ya tiene sesión, no necesita registrarse
if (isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

$mensaje = "";
$nombre = "";
$email = isset($_GET["email"]) ? trim($_GET["email"]) : "";
$aviso = isset($_GET["aviso"]) ? (int)$_GET["aviso"] : 0;

if ($aviso == 1) {
    $mensaje = "Para agregar al carrito o comprar necesitas una cuenta. Regístrate aquí. Si ya tienes una, inicia sesión.";
} elseif ($aviso == 2) {
    $mensaje = "No encontramos una cuenta con ese correo. Crea tu cuenta aquí.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $mensaje = "";

    if ($nombre == "" || $email == "" || strlen($password) < 6) {
        $mensaje = "Completa todo. La contraseña debe tener mínimo 6 caracteres.";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensaje = "Ese correo ya está registrado. Inicia sesión.";
        } else {
            $stmt->close();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $hash);
            $stmt->execute();
            $nuevo_id = $conexion->insert_id;
            $stmt->close();

            // Cuenta creada: se inicia sesión sola y se sigue con lo que quería hacer
            iniciar_sesion_usuario($nuevo_id, $nombre);
            aplicar_pendiente($conexion);
            ir_a_destino("index.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Registro - Luis Victor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>LUIS VICTOR</h1>
  <?php include "menu.php"; ?>

  <h2>Crear cuenta</h2>

  <div>
    <p><?php echo htmlspecialchars($mensaje); ?></p>
    <form method="post" action="registro.php">
      <label>Nombre:</label><br>
      <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br><br>

      <label>Correo:</label><br>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

      <label>Contraseña:</label><br>
      <input type="password" name="password" minlength="6" required><br><br>

      <button type="submit">Registrarme</button>
    </form>
    <hr>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
  </div>
  <?php include "pie.php"; ?>
</body>
</html>
