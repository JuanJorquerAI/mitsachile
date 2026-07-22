<?php
// scripts/helper-deploy.php
// Script temporal para implementar el sitio nuevo.

header('Content-Type: application/json');
ignore_user_abort(true);
set_time_limit(600);

$secret_token = "mitsa_deploy_secure_token_2026";
if (!isset($_GET['token']) || $_GET['token'] !== $secret_token) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$zip_file = __DIR__ . '/wpactual.zip';
$sql_file = __DIR__ . '/new_site_production.sql';

if (!file_exists($zip_file)) {
    echo json_encode(["status" => "error", "message" => "wpactual.zip not found"]);
    exit;
}
if (!file_exists($sql_file)) {
    echo json_encode(["status" => "error", "message" => "new_site_production.sql not found"]);
    exit;
}

// 1. Mover archivos viejos a una carpeta de respaldo local
$backup_folder = __DIR__ . '/old_site_backup_tmp';
if (!is_dir($backup_folder)) {
    mkdir($backup_folder, 0755, true);
}

$dir_items = scandir(__DIR__);
foreach ($dir_items as $item) {
    if ($item === '.' || $item === '..' || $item === 'old_site_backup_tmp' || 
        $item === 'wpactual.zip' || $item === 'new_site_production.sql' || $item === 'helper-deploy.php') {
        continue;
    }
    rename(__DIR__ . '/' . $item, $backup_folder . '/' . $item);
}

// 2. Extraer el sitio nuevo
$zip = new ZipArchive();
if ($zip->open($zip_file) === true) {
    $zip->extractTo(__DIR__);
    $zip->close();
    $unzip_status = "success";
} else {
    echo json_encode(["status" => "error", "message" => "Cannot extract wpactual.zip"]);
    exit;
}

// 3. Importar la nueva Base de Datos
$wp_config_path = __DIR__ . '/wp-config.php';
if (!file_exists($wp_config_path)) {
    echo json_encode(["status" => "error", "message" => "New wp-config.php not found after extract"]);
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
    
    // Leer e importar el SQL
    $sql = file_get_contents($sql_file);
    
    // Ejecutar en bloques o mediante un parser básico para evitar límites de memoria
    $queries = explode(";\n", $sql);
    foreach ($queries as $query) {
        $query = trim($query);
        if ($query !== "") {
            $pdo->exec($query);
        }
    }
    $db_status = "success";
    
    // 4. Búsqueda y reemplazo de URLs en la base de datos
    // Modificar las URLs de localhost al dominio de producción
    $old_url = 'http://localhost:8892';
    $new_url = 'https://mitsachile.com';
    
    // Actualizar wp_options
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = REPLACE(option_value, ?, ?) WHERE option_name IN ('siteurl', 'home')");
    $stmt->execute([$old_url, $new_url]);
    
    // Actualizar posts
    $stmt = $pdo->prepare("UPDATE wp_posts SET post_content = REPLACE(post_content, ?, ?), guid = REPLACE(guid, ?, ?)");
    $stmt->execute([$old_url, $new_url, $old_url, $new_url]);
    
    // Actualizar postmeta
    $stmt = $pdo->prepare("UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, ?, ?)");
    $stmt->execute([$old_url, $new_url]);
    
    $url_replace_status = "success";
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database import/replace failed: " . $e->getMessage()]);
    exit;
}

echo json_encode([
    "status" => "success",
    "unzip" => $unzip_status,
    "import" => $db_status,
    "replace" => $url_replace_status
]);
