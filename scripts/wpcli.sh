#!/usr/bin/env bash
# Wrapper de wp-cli con memory_limit ampliado (WordPress 7.x agota los 128M
# por defecto del PHP CLI al extraer el tarball / correr ciertos comandos).
exec php -d memory_limit=512M "$(command -v wp)" "$@"
