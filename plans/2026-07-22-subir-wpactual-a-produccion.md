# Subida de wpactual a Producción con Respaldo Automático

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Subir el sitio web modernizado ubicado en el directorio `wpactual` al servidor de producción de `mitsachile.com` (BlueHosting), realizando previamente un respaldo completo (base de datos y archivos) seguro y automatizado.

**Architecture:** Dado que el hosting carece de acceso SSH, se utilizarán scripts en Python ejecutados localmente que automatizan la conexión por FTP/FTPS para subir scripts PHP de soporte (`helper-backup.php` y `helper-deploy.php`) al servidor de producción. El script de respaldo leerá dinámicamente las credenciales de la base de datos de producción desde el `wp-config.php` existente en el servidor, generará un volcado SQL y un archivo ZIP de los archivos actuales, y el script de subida preparará el nuevo sitio con los datos de producción, limpiará el servidor y descomprimirá el nuevo contenido.

**Tech Stack:** Python 3 (ftplib, requests), PHP (ZipArchive, PDO), MySQL/MariaDB, cPanel/MultiPHP.

---

### Task 1: Crear Scripts de Respaldo Automático

**Files:**
- Create: `scripts/helper-backup.php`
- Create: `scripts/backup-produccion.py`

**Step 1: Crear helper-backup.php**
Crear el archivo `scripts/helper-backup.php` que se ejecutará en el servidor y realizará:
1. Lectura del `wp-config.php` existente para obtener credenciales de la base de datos.
2. Exportación de la base de datos (con fallback a exportador puro PHP si `exec()` con `mysqldump` está bloqueado).
3. Compresión en formato ZIP de toda la carpeta del sitio (excluyendo el propio script y otros archivos grandes).
4. Retorno de estado en JSON.

```php
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
```

**Step 2: Crear scripts/backup-produccion.py**
Crear el script en Python que leerá `.env`, subirá el PHP por FTP, lo detonará vía HTTP, descargará las copias y limpiará.

```python
# scripts/backup-produccion.py
import os
import sys
import ftplib
import requests
from dotenv import load_dotenv

load_dotenv()

ftp_host = os.getenv("MITSA_FTP_HOST") or os.getenv("MITSA_CPANEL_URL")
if ftp_host and "://" in ftp_host:
    ftp_host = ftp_host.split("://")[1].split(":")[0]
ftp_user = os.getenv("MITSA_FTP_USER") or os.getenv("MITSA_CPANEL_USER")
ftp_pass = os.getenv("MITSA_FTP_PASS") or os.getenv("MITSA_CPANEL_PASS")
remote_root = os.getenv("MITSA_FTP_REMOTE_ROOT", "public_html")
wp_url = os.getenv("MITSA_WP_URL", "https://mitsachile.com")

if not all([ftp_host, ftp_user, ftp_pass]):
    print("Error: Credenciales incompletas en el archivo .env", file=sys.stderr)
    sys.exit(1)

print("==> 1. Conectando al servidor FTP...")
try:
    ftp = ftplib.FTP(ftp_host)
    ftp.login(ftp_user, ftp_pass)
    ftp.cwd(remote_root)
    print("    Conexión establecida con éxito.")
except Exception as e:
    print(f"Error FTP: {e}", file=sys.stderr)
    sys.exit(1)

print("==> 2. Subiendo el script helper-backup.php...")
local_php = os.path.join(os.path.dirname(__file__), "helper-backup.php")
with open(local_php, "rb") as f:
    ftp.storbinary("STOR helper-backup.php", f)
print("    Script subido correctamente.")

print("==> 3. Ejecutando el respaldo en el servidor de producción (esto puede tomar 1-3 minutos)...")
token = "mitsa_backup_secure_token_2026"
backup_url = f"{wp_url}/helper-backup.php?token={token}"
try:
    r = requests.get(backup_url, timeout=300)
    res = r.json()
    if res.get("status") == "success":
        print(f"    Respaldo de BD: {res.get('database')}")
        print(f"    Tamaño de BD: {res.get('sql_size')} bytes")
        print(f"    Tamaño de ZIP: {res.get('zip_size')} bytes")
    else:
        print(f"Error devuelto por el servidor: {res.get('message')}", file=sys.stderr)
        ftp.quit()
        sys.exit(1)
except Exception as e:
    print(f"Error ejecutando el backup HTTP: {e}", file=sys.stderr)
    ftp.quit()
    sys.exit(1)

print("==> 4. Descargando los archivos de respaldo a la carpeta local staging/...")
staging_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging")
os.makedirs(staging_dir, exist_ok=True)

local_zip = os.path.join(staging_dir, "mitsa_files_backup.zip")
local_sql = os.path.join(staging_dir, "mitsa_db_backup.sql")

with open(local_zip, "wb") as f:
    ftp.retrbinary("RETR mitsa_files_backup.zip", f.write)
print("    ZIP de archivos descargado a staging/mitsa_files_backup.zip")

with open(local_sql, "wb") as f:
    ftp.retrbinary("RETR mitsa_db_backup.sql", f.write)
print("    SQL de base de datos descargado a staging/mitsa_db_backup.sql")

print("==> 5. Eliminando archivos temporales de producción para no comprometer la seguridad...")
try:
    ftp.delete("helper-backup.php")
    ftp.delete("mitsa_files_backup.zip")
    ftp.delete("mitsa_db_backup.sql")
    print("    Archivos temporales borrados del servidor.")
except Exception as e:
    print(f"Advertencia al limpiar servidor: {e}", file=sys.stderr)

ftp.quit()
print("\n==> ¡PROCESO DE RESPALDO COMPLETADO CON ÉXITO! <==")
```

**Step 3: Ejecutar una prueba seca y commit**
Validar localmente la sintaxis de los scripts y commitear.
```bash
php -l scripts/helper-backup.php
git add scripts/helper-backup.php scripts/backup-produccion.py
git commit -m "feat: add production backup helper and runner scripts"
```

---

### Task 2: Crear Scripts de Despliegue Automático

**Files:**
- Create: `scripts/helper-deploy.php`
- Create: `scripts/deploy-wpactual.py`

**Step 1: Crear helper-deploy.php**
Crear el script en PHP que se encargará de:
1. Mover los archivos viejos existentes a un subdirectorio temporal en el servidor para evitar dejarlos mezclados con el sitio nuevo.
2. Extraer el contenido del ZIP del nuevo sitio (`wpactual.zip`) en la raíz del servidor.
3. Importar la nueva base de datos (`new_site_production.sql`) sobre las tablas de producción.
4. Aplicar el reemplazo de URLs en la base de datos de producción (`http://localhost:8892` a `https://mitsachile.com`).

```php
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

$db_name = $matches_db[1] ?? '';
$db_user = $matches_user[1] ?? '';
$db_pass = $matches_pass[1] ?? '';
$db_host = $matches_host[1] ?? 'localhost';

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
```

**Step 2: Crear scripts/deploy-wpactual.py**
Script Python que creará los ZIPs locales correspondientes, reemplazará temporalmente credenciales locales de base de datos por credenciales extraídas, subirá el paquete por FTP y detonará el deploy.

```python
# scripts/deploy-wpactual.py
import os
import sys
import zipfile
import ftplib
import requests
import shutil
from dotenv import load_dotenv

load_dotenv()

ftp_host = os.getenv("MITSA_FTP_HOST") or os.getenv("MITSA_CPANEL_URL")
if ftp_host and "://" in ftp_host:
    ftp_host = ftp_host.split("://")[1].split(":")[0]
ftp_user = os.getenv("MITSA_FTP_USER") or os.getenv("MITSA_CPANEL_USER")
ftp_pass = os.getenv("MITSA_FTP_PASS") or os.getenv("MITSA_CPANEL_PASS")
remote_root = os.getenv("MITSA_FTP_REMOTE_ROOT", "public_html")
wp_url = os.getenv("MITSA_WP_URL", "https://mitsachile.com")

if not all([ftp_host, ftp_user, ftp_pass]):
    print("Error: Credenciales incompletas en el archivo .env", file=sys.stderr)
    sys.exit(1)

staging_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "staging")
wpactual_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), "wpactual")

print("==> 1. Exportando base de datos local mitsa_actual...")
local_sql_file = os.path.join(staging_dir, "new_site_production.sql")
db_user_local = "mitsa_dev"
db_pass_local = "mitsa_dev_local_pw"
db_name_local = "mitsa_actual"

# Exportar base de datos local
cmd = f"mysqldump -u {db_user_local} -p{db_pass_local} {db_name_local} > {local_sql_file}"
ret = os.system(cmd)
if ret != 0:
    print("Error: No se pudo exportar la base de datos local", file=sys.stderr)
    sys.exit(1)
print("    Base de datos local exportada.")

print("==> 2. Generando paquete zip de wpactual...")
local_zip_file = os.path.join(staging_dir, "wpactual.zip")

# Crear el ZIP con los archivos del sitio nuevo
with zipfile.ZipFile(local_zip_file, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for root, dirs, files in os.walk(wpactual_dir):
        for file in files:
            file_path = os.path.join(root, file)
            rel_path = os.path.relpath(file_path, wpactual_dir)
            zipf.write(file_path, rel_path)
print("    Paquete wpactual.zip creado.")

print("==> 3. Conectando al FTP de producción para subir el paquete...")
try:
    ftp = ftplib.FTP(ftp_host)
    ftp.login(ftp_user, ftp_pass)
    ftp.cwd(remote_root)
except Exception as e:
    print(f"Error FTP: {e}", file=sys.stderr)
    sys.exit(1)

# Subir wpactual.zip
print("    Subiendo wpactual.zip...")
with open(local_zip_file, "rb") as f:
    ftp.storbinary("STOR wpactual.zip", f)

# Subir new_site_production.sql
print("    Subiendo new_site_production.sql...")
with open(local_sql_file, "rb") as f:
    ftp.storbinary("STOR new_site_production.sql", f)

# Subir helper-deploy.php
print("    Subiendo helper-deploy.php...")
local_helper = os.path.join(os.path.dirname(__file__), "helper-deploy.php")
with open(local_helper, "rb") as f:
    ftp.storbinary("STOR helper-deploy.php", f)

print("==> 4. Ejecutando la implementación en el servidor de producción (esto puede tomar 2-5 minutos)...")
token = "mitsa_deploy_secure_token_2026"
deploy_url = f"{wp_url}/helper-deploy.php?token={token}"
try:
    r = requests.get(deploy_url, timeout=300)
    res = r.json()
    if res.get("status") == "success":
        print(f"    Extracción: {res.get('unzip')}")
        print(f"    Importación BD: {res.get('import')}")
        print(f"    Reemplazo de URLs: {res.get('replace')}")
    else:
        print(f"Error en servidor: {res.get('message')}", file=sys.stderr)
        ftp.quit()
        sys.exit(1)
except Exception as e:
    print(f"Error ejecutando la URL de deploy: {e}", file=sys.stderr)
    ftp.quit()
    sys.exit(1)

print("==> 5. Eliminando archivos temporales del servidor...")
try:
    ftp.delete("helper-deploy.php")
    ftp.delete("wpactual.zip")
    ftp.delete("new_site_production.sql")
    print("    Archivos temporales borrados del servidor.")
except Exception as e:
    print(f"Advertencia al limpiar servidor: {e}", file=sys.stderr)

ftp.quit()
print("\n==> ¡PROCESO DE DESPLIEGUE COMPLETADO CON ÉXITO! <==")
```

**Step 3: Validar sintaxis y commit**
```bash
php -l scripts/helper-deploy.php
git add scripts/helper-deploy.php scripts/deploy-wpactual.py
git commit -m "feat: add deployment helper and runner scripts"
```

---

### Task 3: Ejecutar Respaldo de Producción (Backup)

**Files:**
- Modify: `staging/.gitignore` (asegurar que no se suban respaldos zip o sql)

**Step 1: Asegurar staging/ en .gitignore**
Asegurar que los archivos `.zip` y `.sql` en `staging/` estén ignorados:
```
staging/*.zip
staging/*.sql
```

**Step 2: Ejecutar script de respaldo**
Correr el script localmente:
```bash
python scripts/backup-produccion.py
```
**Expected Output:** Ver mensajes indicando conexión FTP exitosa, subida de helper, ejecución HTTP, descarga de archivos ZIP y SQL, y posterior borrado de temporales.

**Step 3: Verificar archivos de respaldo locales**
Comprobar existencia y tamaño de `staging/mitsa_files_backup.zip` y `staging/mitsa_db_backup.sql`.
Abrir las primeras líneas del SQL para verificar que sea correcto.

---

### Task 4: Configurar Base de Datos Nueva y Desplegar Sitio

**Files:**
- Modify: `wpactual/wp-config.php` (actualizar credenciales a las de producción reales)

**Step 1: Obtener credenciales de la BD de producción**
1. Extraer el archivo `wp-config.php` del ZIP de respaldo (`staging/mitsa_files_backup.zip`).
2. Anotar las definiciones de `DB_NAME`, `DB_USER`, `DB_PASSWORD`, y `DB_HOST`.

**Step 2: Modificar wpactual/wp-config.php**
Actualizar temporalmente el archivo `wpactual/wp-config.php` con las credenciales de producción recién obtenidas (para que viajen configuradas en el ZIP).

**Step 3: Ejecutar script de despliegue**
Correr el script localmente:
```bash
python scripts/deploy-wpactual.py
```
**Expected Output:** Ver mensajes indicando exportación local, compresión de archivos, conexión FTP, subida de archivos, ejecución HTTP del helper (unzip, import y replace con éxito), y posterior limpieza de temporales.

---

### Task 5: Cambios de Configuración de Servidor y QA

**Files:**
- Modify: `.env`

**Step 1: Ajustar PHP en cPanel**
1. Entrar a cPanel de `mitsachile.com` -> **MultiPHP Manager**.
2. Seleccionar el dominio `mitsachile.com` y actualizar la versión de PHP a **PHP 8.2** (o 8.1 si 8.2 no está disponible).

**Step 2: Limpieza de robots.txt**
Verificar que el nuevo `robots.txt` del sitio nuevo permita indexación (sin el bloqueo `Disallow: /`).

**Step 3: Verificación manual de QA**
1. Abrir `https://mitsachile.com` en el navegador y comprobar la carga correcta.
2. Probar el formulario de contacto para asegurar que los correos se envían correctamente.
3. Verificar que wp-admin sea accesible con las credenciales locales de wpactual.
