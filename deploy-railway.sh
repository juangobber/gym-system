#!/bin/bash

# ============================================================================
# Script de Deployment para Railway (ForzaGym)
# ============================================================================
# Railway ejecuta principalmente el Procfile, pero este script documenta los
# pasos manuales en caso de necesitar ejecutar el pipeline desde SSH.
# ============================================================================

set -e

echo "🚀 Iniciando deployment en Railway..."
echo "📅 $(date)"
echo ""

# ============================================================================
# 1. Migraciones
# ============================================================================
echo "📊 Ejecutando migraciones..."
php artisan migrate --force
echo "✅ Migraciones completadas"
echo ""

# ============================================================================
# 2. Seeders (roles y usuarios de ejemplo)
# ============================================================================
echo "🌱 Ejecutando seeders (roles + usuarios demo)..."

if php artisan db:seed --force; then
    echo "✅ Seeders completados"
else
    echo "⚠️  Warning: Error en seeders (posiblemente datos ya existentes)"
fi
echo ""

# ============================================================================
# 3. Optimización
# ============================================================================
echo "⚡ Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Cachés generadas"
echo ""

# ============================================================================
# 4. Storage link
# ============================================================================
echo "🔗 Creando storage link..."
php artisan storage:link 2>/dev/null || echo "   ℹ️  Storage link ya existe"
echo ""

echo "✅ Deployment completado!"
echo "📍 URL: ${APP_URL:-https://forzagym-production.up.railway.app}"
echo ""
echo "👥 Usuarios de prueba:"
echo "   • admin@admin.com / admin (Admin)"
echo "   • pedro@forza.com / teacher (Teacher)"
echo "   • sofia@forza.com / student (Student)"
echo ""
