# 🏋️‍♂️ Forza Gym --- Guía de Instalación

Guía de instalación y puesta en marcha del sistema de gestión Forza Gym
Proyecto: https://github.com/juangobber/gym-system

Sistema de gestión desarrollado en **Laravel + Filament**, levantado con
**Laravel Sail** y utilizando **MySQL** en contenedores Docker.

Esta guía cubre: - Instalación en **Windows + WSL2 + Docker Desktop**\
- Levantamiento de entorno completo con **Sail**\
- Migraciones, seeders y acceso inicial al panel de administración



## 📌 0. Prerrequisitos

### 🐧 WSL2 (Windows Subsystem for Linux)

1.  Abrí **PowerShell como Administrador**\

2.  Ejecutá:

    ``` bash
    wsl --install
    ```

Esto instala:

-   WSL
-   WSL2
-   Ubuntu por defecto

Reiniciar Windows (obligatorio)

Abrir Ubuntu desde el menú iniciar y crear usuario/contraseña.

Validar versión:

    wsl -l -v

Debe aparecer Ubuntu con VERSION 2.

### 🐳 Docker Desktop

Descargar desde: https://www.docker.com/products/docker-desktop/

Instalar marcando: ✔️ Use WSL 2 instead of Hyper-V

Abrí Docker Desktop → Settings:

**General** → ✔️ *Use the WSL 2 based engine*

**Resources** → *WSL Integration* → habilitar **Ubuntu**

Probar instalación:

    docker --version
    docker compose version



## 📌 1. Clonar el Proyecto

Abrí tu terminal de Ubuntu (WSL):

``` bash
cd ~
git clone https://github.com/juangobber/gym-system.git
cd gym-system
```

Verificar ubicación:

``` bash
pwd
```


## 📌 2. Iniciar proyecto para desarrollo local

Copiar `.env.example` a `.env`:

``` bash
cp .env.example .env
```

Instalar dependencias base:

``` bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Crear alias para Sail:

``` bash
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc
```

Iniciar el servidor local:

``` bash
sail up
```

Ejecutar Sail en segundo plano:

``` bash
sail up -d
```

Detener contenedores:

``` bash
sail down
```

Generar la APP_KEY:

``` bash
sail artisan key:generate
```

Ejecutar migraciones:

``` bash
sail artisan migrate
```

Instalar librerías de frontend:

``` bash
sail npm i
```

Compilar frontend para producción:

``` bash
sail npm run build
```

Servidor de desarrollo (Vite):

``` bash
sail npm run dev
```

Actualizar cambios del repositorio:

``` bash
git pull
sail composer install   # si cambiaron dependencias PHP
sail artisan migrate    # si hay nuevas migraciones
sail npm i              # si cambiaron dependencias JS
```

Pruebas manuales:

Abrir en el navegador `http://localhost`

Panel de administración (backoffice): `http://localhost/admin`

Crear usuario administrador:

``` bash
sail artisan make:filament-user
```

Ejecutar tests:

``` bash
sail test
```
