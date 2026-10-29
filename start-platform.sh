#!/usr/bin/env bash
set -e

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$DIR"

PORT=${PORT:-8090}
echo "Starting Photobooth Platform (Laravel) on http://localhost:$PORT ..."
php artisan serve --host=0.0.0.0 --port=$PORT
