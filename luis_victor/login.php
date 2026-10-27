<?php
session_start();
require "conexion.php";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $hash);

    if ($stmt->fetch() && password_verify($password, $hash)) {
        $_SESSION["usuario_id"] = $id;
        $_SESSION["nombre"] = $nombre;
        header("Location: tienda.php");
        exit;
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
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
</body>
</html>
