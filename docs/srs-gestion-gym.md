# SRS – ForzaGym Admin Panel

## 1. Introducción
### 1.1 Propósito
Definir los requisitos funcionales y no funcionales del panel de administración ForzaGym, utilizado para operar un gimnasio (turnos, actividades, rutinas y pagos).

### 1.2 Alcance
El sistema cubre:
- Gestión de usuarios (admin, teacher, student) y roles.
- Gestión de actividades, turnos y rutinas asignadas a alumnos.
- Registro de pagos y control de estado de cuotas.
- Portal para alumnos: perfil, rutinas y turnos disponibles.

### 1.3 Definiciones
- **Admin:** usuario con control total.
- **Teacher:** instructor que gestiona alumnos, turnos, rutinas y pagos.
- **Student:** alumno que consulta rutinas, perfil e inscripciones.
- **Shift:** turno o clase en el calendario semanal.

## 2. Actores
| Actor    | Descripción |
|----------|-------------|
| Admin    | Usuario responsable del sistema completo. |
| Teacher  | Instructor a cargo de actividades, rutinas y pagos. |
| Student  | Alumno que consume los servicios del gimnasio. |

## 3. Requisitos funcionales

| ID  | Descripción | Actores | Criterios de aceptación |
|-----|-------------|---------|-------------------------|
| RF-01 | CRUD de actividades | Admin, Teacher | Validar unicidad de nombre. Permitir activar/desactivar. Bloquear borrado si existen turnos asociados. |
| RF-02 | CRUD de turnos (shifts) | Admin, Teacher | Validar solapamiento por día/horario. Sólo actividades activas. Soft delete. |
| RF-03 | Gestión de rutinas | Admin, Teacher | Crear/editar rutinas asignadas a alumnos. Alumnos deben ver sólo las suyas. |
| RF-04 | Registro de pagos | Admin, Teacher | Registrar fecha de pago, estado (al día / vencido). Mostrar sólo el último pago por alumno. |
| RF-05 | Portal alumno | Student | Ver perfil, estado de pago, rutinas propias y turnos disponibles (inscribirse/desinscribirse). |
| RF-06 | Control de inscripciones | Student | No permitir inscribir si no hay cupos o si hay solapamiento. |

## 4. Requisitos no funcionales
| ID | Descripción |
|----|-------------|
| RNF-01 | Disponibilidad: el panel debe estar disponible durante horario administrativo (9-20hs). |
| RNF-02 | Seguridad: autenticación obligatoria, segregación por roles. |
| RNF-03 | Rendimiento: operaciones CRUD deben responder < 2s en red local. |
| RNF-04 | Portabilidad: ejecución en contenedores (Docker/Sail). |

## 5. Supuestos y restricciones
- Se asume conectividad estable a la base MySQL.
- El enrolamiento de alumnos en turnos depende de cupos configurados.
- No se incluye facturación electrónica.

## 6. Trazabilidad
| Actor / RF | RF-01 | RF-02 | RF-03 | RF-04 | RF-05 | RF-06 |
|------------|-------|-------|-------|-------|-------|-------|
| Admin      |  X    |  X    |  X    |  X    |  X    |       |
| Teacher    |  X    |  X    |  X    |  X    |       |       |
| Student    |       |       |  X    |  X (visualización) | X | X |

## 7. Anexos
- Diagramas de clases y mockups (pendiente).
