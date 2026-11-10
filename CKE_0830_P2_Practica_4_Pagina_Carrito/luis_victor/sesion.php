<?php
// Este archivo se llama AL PRINCIPIO de cada página (antes de cualquier HTML)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si no hay sesión, guarda a dónde quería ir y lo manda al REGISTRO
function exigir_cuenta($destino) {
    if (!isset($_SESSION["usuario_id"])) {
        $_SESSION["volver"] = $destino;
        header("Location: registro.php?aviso=1");
        exit;
    }
}

// Deja al usuario con la sesión iniciada (se usa en login y en registro)
function iniciar_sesion_usuario($id, $nombre) {
    session_regenerate_id(true);
    $_SESSION["usuario_id"] = $id;
    $_SESSION["nombre"] = $nombre;
}

// Lo manda a donde quería ir (o a la página por defecto)
function ir_a_destino($por_defecto) {
    $destino = isset($_SESSION["volver"]) ? $_SESSION["volver"] : $por_defecto;
    unset($_SESSION["volver"]);
    header("Location: " . $destino);
    exit;
}

// Agrega un producto al carrito (máximo 10 por producto)
function agregar_al_carrito($conexion, $usuario_id, $producto_id, $cantidad) {
    if ($cantidad < 1) { $cantidad = 1; }
    if ($cantidad > 10) { $cantidad = 10; }

    $q = $conexion->prepare("SELECT id FROM productos WHERE id = ?");
    $q->bind_param("i", $producto_id);
    $q->execute();
    $q->store_result();
    $existe = $q->num_rows > 0;
    $q->close();
    if (!$existe) {
        return false;
    }

    $q = $conexion->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE cantidad = LEAST(cantidad + ?, 10)");
    $q->bind_param("iiii", $usuario_id, $producto_id, $cantidad, $cantidad);
    $q->execute();
    $q->close();
    return true;
}

// Si el usuario quiso agregar algo ANTES de tener cuenta, se agrega ahora
function aplicar_pendiente($conexion) {
    if (isset($_SESSION["pendiente"])) {
        agregar_al_carrito($conexion, $_SESSION["usuario_id"], $_SESSION["pendiente"]["producto_id"], $_SESSION["pendiente"]["cantidad"]);
        unset($_SESSION["pendiente"]);
    }
}
