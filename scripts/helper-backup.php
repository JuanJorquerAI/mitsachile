<?php
// scripts/helper-backup.php
// Script temporal para respaldo en producción.

header('Content-Type: application/json');
ignore_user_abort(true);
set_time_limit(600);

$secret_token = "mitsa_backup_secure_token_2026";
if (!isset($_GET['token']) || $_GET['token'] !== $secret_token) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$wp_config_path = __DIR__ . '/wp-config.php';
if (!file_exists($wp_config_path)) {
    echo json_encode(["status" => "error", "message" => "wp-config.php not found"]);
    exit;
}

// Extraer credenciales usando regex para evitar ejecutar el archivo directamente
$config_content = file_get_contents($wp_config_path);
preg_match("/define\(\s*['\"]DB_NAME['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_db);
preg_match("/define\(\s*['\"]DB_USER['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_user);
preg_match("/define\(\s*['\"]DB_PASSWORD['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_pass);
preg_match("/define\(\s*['\"]DB_HOST['\"]\s*,\s*['\"](.*)['\"]\s*\)/", $config_content, $matches_host);

$db_name = $matches_db[1] ?? '';
$db_user = $matches_user[1] ?? '';
$db_pass = $matches_pass[1] ?? '';
$db_host = $matches_host[1] ?? 'localhost';

if (!$db_name || !$db_user) {
    echo json_encode(["status" => "error", "message" => "Could not extract database credentials"]);
    exit;
}

$backup_dir = __DIR__;
$sql_file = $backup_dir . '/mitsa_db_backup.sql';
$zip_file = $backup_dir . '/mitsa_files_backup.zip';

// 1. Respaldo de Base de Datos
$db_status = "failed";
if (function_exists('exec')) {
    // Intentar mysqldump
    $cmd = sprintf('mysqldump --no-tablespaces -h %s -u %s -p%s %s > %s 2>&1', escapeshellarg($db_host), escapeshellarg($db_user), escapeshellarg($db_pass), escapeshellarg($db_name), escapeshellarg($sql_file));
    exec($cmd, $output, $return_var);
    if ($return_var === 0) {
        $db_status = "mysqldump_success";
    }
}

if ($db_status !== "mysqldump_success") {
    // Fallback: Exportador puro PHP
    try {
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        $handle = fopen($sql_file, 'w');
        fwrite($handle, "/* Backup MITSA PHP Export */\n\n");
        
        $tables = [];
        $result = $pdo->query("SHOW TABLES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }
        
        foreach ($tables as $table) {
            $show_create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch();
            fwrite($handle, "DROP TABLE IF EXISTS `$table`;\n" . $show_create['Create Table'] . ";\n\n");
            
            $rows = $pdo->query("SELECT * FROM `$table`");
            while ($row = $rows->fetch()) {
                $columns = array_map(function($col) use ($pdo) {
                    return $col === null ? 'NULL' : $pdo->quote($col);
                }, $row);
                fwrite($handle, "INSERT INTO `$table` VALUES (" . implode(',', $columns) . ");\n");
            }
            fwrite($handle, "\n\n");
        }
        fclose($handle);
        $db_status = "php_success";
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "DB backup failed: " . $e->getMessage()]);
        exit;
    }
}

// 2. Respaldo de Archivos en ZIP
if (!class_exists('ZipArchive')) {
    echo json_encode(["status" => "error", "message" => "ZipArchive PHP class is not available"]);
    exit;
}

$zip = new ZipArchive();
if ($zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    echo json_encode(["status" => "error", "message" => "Cannot create ZIP file"]);
    exit;
}

$root_path = __DIR__;
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root_path, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($root_path) + 1);
        
        // Excluir el propio script de backup, el ZIP resultante y archivos sql
        if ($relativePath === 'helper-backup.php' || 
            $relativePath === 'mitsa_files_backup.zip' || 
            $relativePath === 'mitsa_db_backup.sql' ||
            strpos($relativePath, 'backup-') === 0) {
            continue;
        }
        
        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();

echo json_encode([
    "status" => "success",
    "database" => $db_status,
    "sql_size" => file_exists($sql_file) ? filesize($sql_file) : 0,
    "zip_size" => file_exists($zip_file) ? filesize($zip_file) : 0
]);
