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


## 📌 2. Configurar Variables de Entorno

Copiar el archivo:

``` bash
cp .env.example .env
```

Editar el `.env`:

    APP_NAME="Forza Gym"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://127.0.0.1:8000

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=forza_gym
    DB_USERNAME=sail
    DB_PASSWORD=password

La APP_KEY se generará más adelante.


## 📌 3. Instalar Dependencias (Composer)


    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs


Debería crearse la carpeta **vendor/**.


## 📌 4. Levantar Contenedores con Sail

``` bash
./vendor/bin/sail up -d
```


## 📌 5. Generar APP_KEY

``` bash
./vendor/bin/sail artisan key:generate
```

## 📌 6. Migraciones y Seeders

``` bash
./vendor/bin/sail artisan migrate:fresh --seed
```

✔️ Datos creados por seeders:\
- Roles\
- Permisos\
- Usuario administrador

**👤 Usuario Administrador**\
Email: `admin@admin.com`\
Contraseña: `admin`


## 📌 7. Instalar Dependencias Frontend

``` bash
./vendor/bin/sail npm install
```


## 📌 8. Ejecutar Frontend

### 🔧 Modo desarrollo (recomendado)

``` bash
./vendor/bin/sail npm run dev
```

### 📦 Compilación (producción)

``` bash
./vendor/bin/sail npm run build
```


## 📌 9. Acceder al Sistema

Abrí tu navegador:

Aplicación:\
http://localhost

Panel de administración (Filament):\
http://localhost/admin

Ingresá con las credenciales del administrador creadas por los seeders.


## 📌 10. (Opcional) Crear Alias para Sail

``` bash
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc
```

Ahora podés usar:

    sail up -d
    sail artisan migrate
    sail npm run dev

