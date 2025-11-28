# Sistema de Gestión Forza Gym

Gestión integral de alumnos, turnos, pagos y rutinas — desarrollado con Laravel, Filament y Laravel Sail

## 🏋️‍♂️ Propósito y Alcance del Sistema

El Sistema de Gestión Forza Gym es una plataforma web diseñada para centralizar y digitalizar los procesos administrativos del gimnasio Forza Entrenamientos.
Su objetivo principal es brindar mayor eficiencia, control y accesibilidad tanto al dueño como a los profesores y alumnos.

## ✔ Funcionalidades incluidas

- ABM de alumnos
- ABM de turnos y horarios
- Asignación de turnos por parte de los profesores
- Gestión y control de pagos
- Login de usuarios
- Visualización de turnos y estado de pagos por los alumnos
- Carga de datos personales y apto médico
- Asignación de rutinas por profesores

## ❌ Exclusiones

- No incluye pasarela de pago online
- No incluye app móvil nativa (solo web responsive)
- No hay integración con sistemas contables externos

## 📌 Supuestos

- Los alumnos mantienen día y horario fijo
- Los profesores gestionan los turnos
- Todos los usuarios tienen acceso a internet

## 🔒 Restricciones

- Sistema disponible vía web
- Se prioriza usabilidad por sobre funcionalidades complejas
- Desarrollo en tiempo acotado

## 🖥️ Cómo ejecutar localmente

Para instrucciones detalladas, ver `/docs/INSTALL.md`

### Requisitos

- Docker
- Laravel Sail

### Pasos básicos

```bash
cp .env.example .env

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

alias sail='./vendor/bin/sail'
sail up
sail artisan key:generate
sail artisan migrate

sail npm i
sail npm run build # o npm run dev para live reload
```

### Acceso

- Frontend: http://localhost
- Admin (Filament): http://localhost/admin

## 🌐 Demo en producción

El sistema está deployado en Railway:

🔗 [http://gym-system-production-c3dc.up.railway.app/admin]

## 🔧 Dependencias y Variables de Entorno

El sistema utiliza:

- PHP 8.x (via Sail)
- Laravel 10+
- Filament
- MySQL (contenedor Sail)

### Variables de entorno relevantes

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=forza_gym
DB_USERNAME=sail
DB_PASSWORD=password
```

## 🚀 Estado del pipeline / Deploy

El proyecto se deploya automáticamente desde la rama main del repositorio mediante Railway Auto-Deploy.
No se utiliza CI/CD adicional ni badges de GitHub Actions.

## 📄 Documentación

### ✔ Documento SRS

El documento de especificación de requisitos se encuentra aquí:

📌 `/docs/srs-gestion-gym.md`

### ✔ Documentación de API

El sistema no expone API pública.
Filament gestiona internamente los endpoints utilizados por el panel administrativo.

## 🧠 Aprendizajes y Conclusiones

Durante el desarrollo de Sistema de Gestión Forza Gym se lograron aprendizajes clave:

### ⭐ Lo que intentamos

- Construir un sistema completo de gestión de gimnasio utilizando Laravel y Filament.
- Implementar un flujo administrativo real: alumnos → turnos → pagos → rutinas.

### ⭐ Lo que salió bien

- Filament permitió acelerar el desarrollo del backoffice.
- Sail facilitó el entorno de desarrollo unificado en Docker.
- Se logró un diseño modular y limpio de los modelos, migraciones y recursos.

### ⭐ Dificultades encontradas

- Manejo de relaciones complejas entre alumnos, turnos y pagos.
- Integración inicial con Sail y problemas comunes de permisos/migraciones.

### ⭐ Qué falta / Próximos pasos

- Posible incorporación de una API para app móvil.
- Agregar pasarela de pago online.
- Crear un dashboard más visual para dueños y profesores.

## 👥 Autores

- Juan Manuel Gobber
- Felipe Agustín Gobber