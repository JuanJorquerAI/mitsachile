<?php
/**
 * Router para el servidor embebido de PHP (`php -S`) sirviendo WordPress
 * sin Apache/.htaccess. Necesario porque WordPress resuelve permalinks
 * bonitos vía mod_rewrite en producción; en local usamos este router
 * estándar de la comunidad WP para lograr el mismo comportamiento.
 */
$root = $_SERVER['DOCUMENT_ROOT'];
$path = '/' . ltrim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');

if ($path !== '/' && file_exists($root . $path) && is_file($root . $path)) {
	return false;
}

chdir($root);
require_once $root . '/index.php';
