# INSTALL.md

## Prerrequisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (o Docker Engine + Docker Compose).
- [Node.js 18+](https://nodejs.org/) y npm.
- [Composer](https://getcomposer.org/) si vas a correr comandos fuera de Sail.
- WSL2 (en Windows) ya configurado para este repositorio.

## Variables de entorno

1. Copiá el archivo de ejemplo:
   ```
   cp .env.example .env
   ```
2. Editá `.env` con tus credenciales locales:
   - `APP_URL=http://localhost`
   - `APP_PORT=80`
   - `DB_HOST=mysql`
   - `DB_DATABASE=forza_gym`
   - `DB_USERNAME=sail`
   - `DB_PASSWORD=password`
3. Generá la APP_KEY luego de levantar Sail (`sail artisan key:generate`).

## Instalación

```
# Dependencias PHP (dentro de Sail)
./vendor/bin/sail composer install

# Dependencias front
./vendor/bin/sail npm install
```

> Si preferís instalar fuera de Sail:
> ```
> composer install --ignore-platform-reqs
> npm install
> ```

## Levantar el entorno local

```
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm run build
```

### Crear usuario de Filament

```
./vendor/bin/sail artisan make:filament-user
```

## Verificación

1. Abrí `http://localhost/admin` e iniciá sesión con el usuario creado.
2. Revisá que los recursos de Filament (Activities, Shifts, Students, Payments, etc.) estén disponibles según tu rol.
3. Probar enrolamiento en turnos: `http://localhost/admin/available-shifts`.
4. Revisar perfil / rutinas: `http://localhost/admin/perfil`.

Para bajar el entorno:
```
./vendor/bin/sail down
```
