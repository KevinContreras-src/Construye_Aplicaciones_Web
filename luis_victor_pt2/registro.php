<?php
require "conexion.php";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($nombre == "" || $email == "" || strlen($password) < 6) {
        $mensaje = "Completa todo. La contraseña debe tener mínimo 6 caracteres.";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensaje = "Ese correo ya está registrado.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $hash);
            $stmt->execute();
            $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
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
      <input type="text" name="nombre" required><br><br>

      <label>Correo:</label><br>
      <input type="email" name="email" required><br><br>

      <label>Contraseña:</label><br>
      <input type="password" name="password" minlength="6" required><br><br>

      <button type="submit">Registrarme</button>
    </form>
    <hr>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
  </div>
</body>
</html>
