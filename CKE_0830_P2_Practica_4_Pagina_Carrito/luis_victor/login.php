<?php
require_once "sesion.php";
require_once "conexion.php";

// Si ya tiene sesión, no necesita entrar otra vez
if (isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nombre, $hash);

    if ($stmt->fetch()) {
        if (password_verify($password, $hash)) {
            $stmt->close();
            iniciar_sesion_usuario($id, $nombre);
            aplicar_pendiente($conexion);
            ir_a_destino("index.php");
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        // No existe una cuenta con ese correo: se manda al registro
        header("Location: registro.php?aviso=2&email=" . urlencode($email));
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión - Luis Victor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>LUIS VICTOR</h1>
  <?php include "menu.php"; ?>

  <h2>Iniciar sesión</h2>

  <div>
    <p><?php echo htmlspecialchars($mensaje); ?></p>
    <form method="post" action="login.php">
      <label>Correo:</label><br>
      <input type="email" name="email" required><br><br>

      <label>Contraseña:</label><br>
      <input type="password" name="password" required><br><br>

      <button type="submit">Entrar</button>
    </form>
    <hr>
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
  </div>
  <?php include "pie.php"; ?>
</body>
</html>
