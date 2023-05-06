<?php
// Verificar si la extensión GD está habilitada
if (extension_loaded('gd')) {
    // Obtener información sobre la versión de GD
    $gdInfo = gd_info();

    echo "La extensión GD está habilitada en tu entorno de PHP.<br>";
    echo "Versión de GD: " . $gdInfo['GD Version'];
} else {
    echo "La extensión GD no está habilitada en tu entorno de PHP.";
}