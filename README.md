# ForzaGym Admin Panel

## Propósito y alcance
ForzaGym es un panel administrativo desarrollado con Laravel + Filament para gestionar un gimnasio. Permite a administradores y profesores crear actividades, turnos y rutinas; registrar pagos; administrar alumnos y docentes; y ofrecer a los alumnos un portal de autogestión (perfil, rutinas asignadas y turnos disponibles).

## Cómo ejecutar localmente
1. Clonar el repositorio.
2. Seguir los pasos detallados en [`docs/INSTALL.md`](docs/INSTALL.md) (Docker + Sail).
3. Crear un usuario de Filament (`sail artisan make:filament-user`) y acceder a `http://localhost/admin`.

### Demo / credenciales
No hay demo pública; usar el entorno local y el usuario creado en el paso 3.

## Dependencias y variables de entorno
- Docker + Docker Compose (Sail)
- PHP 8.2, Composer
- Node.js 18, npm
- MySQL 8
- Variables principales: `APP_URL`, `APP_PORT`, `DB_*` (ver `.env.example` y la guía de instalación).

## Estado del pipeline
![Deploy](https://github.com/your-org/gestion-gym/actions/workflows/deploy.yml/badge.svg)

## Documentación relacionada
- 📄 [SRS IEEE](docs/srs-gestion-gym.md)
- 🔌 [Documentación de API](docs/API_documentation.md)
- ⚙️ [Guía de instalación](docs/INSTALL.md)

## Aprendizajes y conclusiones
- **Lo que intentamos:** modelar los procesos cotidianos del gimnasio (creación de turnos, rutinas y pagos) sobre Filament y Laravel Sail.
- **Lo que salió bien:** la separación de roles (admin, teacher, student) y la automatización del enrolamiento en turnos + pagos.
- **Lo que falta / próximos pasos:** acabar una API pública, mejorar los reportes financieros y automatizar notificaciones (pagos vencidos).

---
> Para más detalles sobre requisitos funcionales, API y despliegue consultá la carpeta `docs/` y el workflow `.github/workflows/deploy.yml`.
