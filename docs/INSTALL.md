# INSTALL.md

# Instalación y ejecución local

## 1. Prerrequisitos
- Docker Desktop (o Docker Engine + Docker Compose).
- Node.js 18+, npm.
- Composer (opcional si querés ejecutar comandos fuera de Sail).
- WSL2 en caso de Windows.

## 2. Configuración inicial
1. Copiar variables de entorno:
   ```
   cp .env.example .env
   ```
2. Instalar dependencias PHP usando la imagen oficial de Sail:
   ```
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd)":/var/www/html \
       -w /var/www/html \
       laravelsail/php82-composer:latest \
       composer install --ignore-platform-reqs
   ```
3. Crear alias de Sail (opcional):
   ```
   echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
   source ~/.bashrc
   ```

## 3. Levantar el entorno
```
sail up           # para ver logs en consola
sail up -d        # para levantar en background
```
Bajar el stack:
```
sail down
```

## 4. Inicialización y dependencias
```
sail artisan key:generate
sail artisan migrate
sail npm install
sail npm run build      # o sail npm run dev para live server
```

## 5. Flujo de trabajo diario
```
git pull
sail composer install   # si cambió composer.json
sail artisan migrate    # si hay nuevas migraciones
sail npm install        # si cambió package.json
```

## 6. Verificación
- Navegar a `http://localhost`.
- Backoffice `http://localhost/admin`.
- Crear el usuario administrador:
  ```
  sail artisan make:filament-user
  ```
- Ejecutar tests:
  ```
  sail test
  ```

> Si necesitás construir el front en caliente:
> ```
> sail npm run dev
> ```

Con esto el proyecto queda listo para desarrollo local con Sail.
