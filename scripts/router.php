<?php
/**
 * Router para el servidor embebido de PHP (`php -S`) sirviendo WordPress
 * sin Apache/.htaccess.
 */
$root = $_SERVER['DOCUMENT_ROOT'];
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = $root . $urlPath;

// Si es un archivo estático real (css, js, png, etc.), PHP lo sirve directamente
if (is_file($filePath)) {
    return false;
}

// Si es un directorio (como /wp-admin/)
if (is_dir($filePath)) {
    $dirPath = rtrim($filePath, '/');
    if (file_exists($dirPath . '/index.php')) {
        $scriptName = rtrim($urlPath, '/') . '/index.php';
        $_SERVER['SCRIPT_NAME'] = $scriptName;
        $_SERVER['PHP_SELF'] = $scriptName;
        $_SERVER['SCRIPT_FILENAME'] = $dirPath . '/index.php';
        chdir($dirPath);
        require_once $dirPath . '/index.php';
        return true;
    }
    if (file_exists($dirPath . '/index.html')) {
        return false;
    }
}

// Para permalinks y cualquier otra ruta, carga el index.php raíz de WP
chdir($root);
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/index.php';
require_once $root . '/index.php';
