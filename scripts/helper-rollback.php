<?php
// scripts/helper-rollback.php
// Script temporal para revertir la migración en producción.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
ignore_user_abort(true);
set_time_limit(600);

$secret_token = "mitsa_rollback_secure_token_2026";
if (!isset($_GET['token']) || $_GET['token'] !== $secret_token) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$sql_file = __DIR__ . '/mitsa_db_backup.sql';
$backup_folder = __DIR__ . '/old_site_backup_tmp';

if (!is_dir($backup_folder)) {
    echo json_encode(["status" => "error", "message" => "old_site_backup_tmp directory not found"]);
    exit;
}
if (!file_exists($sql_file)) {
    echo json_encode(["status" => "error", "message" => "mitsa_db_backup.sql not found"]);
    exit;
}

// 1. Mover los archivos del despliegue fallido a un directorio temporal
$failed_folder = __DIR__ . '/failed_deploy_tmp';
if (!is_dir($failed_folder)) {
    mkdir($failed_folder, 0755, true);
}

$dir_items = scandir(__DIR__);
foreach ($dir_items as $item) {
    if ($item === '.' || $item === '..' || $item === 'old_site_backup_tmp' || 
        $item === 'failed_deploy_tmp' || $item === 'mitsa_db_backup.sql' || $item === 'helper-rollback.php') {
        continue;
    }
    rename(__DIR__ . '/' . $item, $failed_folder . '/' . $item);
}

// 2. Restaurar los archivos viejos desde old_site_backup_tmp
$backup_items = scandir($backup_folder);
foreach ($backup_items as $item) {
    if ($item === '.' || $item === '..') {
        continue;
    }
    rename($backup_folder . '/' . $item, __DIR__ . '/' . $item);
}
rmdir($backup_folder); // borrar carpeta temporal de respaldo ya que está vacía

// 3. Importar la Base de Datos vieja
$wp_config_path = __DIR__ . '/wp-config.php';
if (!file_exists($wp_config_path)) {
    echo json_encode(["status" => "error", "message" => "Restored wp-config.php not found"]);
    exit;
}

$config_content = file_get_contents($wp_config_path);
preg_match("/define\(\s*['\"]DB_NAME['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_db);
preg_match("/define\(\s*['\"]DB_USER['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_user);
preg_match("/define\(\s*['\"]DB_PASSWORD['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_pass);
preg_match("/define\(\s*['\"]DB_HOST['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_host);

$db_name = isset($matches_db[1]) ? $matches_db[1] : '';
$db_user = isset($matches_user[1]) ? $matches_user[1] : '';
$db_pass = isset($matches_pass[1]) ? $matches_pass[1] : '';
$db_host = isset($matches_host[1]) ? $matches_host[1] : 'localhost';

$db_status = "failed";
try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    // Leer e importar el SQL original de producción
    $sql = file_get_contents($sql_file);
    
    // Separar y ejecutar
    $queries = explode(";\n", $sql);
    foreach ($queries as $query) {
        $query = trim($query);
        if ($query !== "") {
            $pdo->exec($query);
        }
    }
    $db_status = "success";
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database restore failed: " . $e->getMessage()]);
    exit;
}

echo json_encode([
    "status" => "success",
    "restore_files" => "success",
    "restore_db" => $db_status
]);
