# 1. Introducción

El presente documento constituye la Especificación de Requisitos de Software (SRS) del sistema “Forza Entrenamientos”, desarrollado como proyecto académico para la Tecnicatura Universitaria en Programación (UTN – Facultad Regional Delta, sede Zárate).

El objetivo de este documento es definir de forma clara y estructurada los requisitos funcionales y no funcionales del sistema, así como sus restricciones, interfaces y supuestos.

El sistema “Forza Entrenamientos” tiene como propósito principal digitalizar y centralizar la gestión de un gimnasio, permitiendo a los administradores y profesores realizar tareas de inscripción de alumnos, control de pagos, asignación de turnos y registro de rutinas, mientras que los alumnos podrán acceder a su información personal y estado de pagos mediante una plataforma web responsive.

## 1.1 Propósito

Este documento está destinado al equipo de desarrollo, docentes supervisores y al cliente simulado, quienes lo utilizarán como referencia para el diseño, desarrollo, validación y mantenimiento del sistema.

## 1.2 Alcance

El presente documento especifica los requisitos del Sistema de Gestión Integral “Forza Entrenamientos”, una aplicación web destinada a optimizar la administración de un gimnasio.

El sistema permitirá gestionar inscripciones de alumnos, turnos, pagos y rutinas personalizadas, brindando acceso diferenciado para el dueño, los profesores y los alumnos.

El sistema incluye las siguientes funcionalidades principales:

- ABM de alumnos, turnos y rutinas.
- Registro y control de pagos.
- Visualización de horarios y estado de pagos.
- Carga de aptos médicos y datos personales.
- Acceso mediante roles diferenciados (dueño, profesor, alumno).

El producto se desarrollará como una aplicación web responsive, independiente y de uso interno, con posibilidad de futuras ampliaciones o integraciones con sistemas contables o pasarelas de pago en versiones posteriores.

## 1.3 Personal Involucrado

- **Nombre:** Juan Manuel Gobber  
  **Rol:** Desarrollador  
  **Responsabilidades:** Desarrollo integral

- **Nombre:** Felipe Agustin Gobber  
  **Rol:** Desarrollador  
  **Responsabilidades:** Desarrollo integral

## 1.6 Referencia

Este documento presenta la especificación de requisitos del sistema Forza Entrenamientos, detallando los aspectos necesarios para su análisis, diseño e implementación.

- En el Capítulo 1 se describe la introducción general del sistema, incluyendo su propósito, alcance y participantes involucrados.
- El Capítulo 2 aborda la descripción general del producto, sus características principales, restricciones y supuestos.
- El Capítulo 3 detalla los requisitos específicos del sistema, tanto funcionales como no funcionales, así como las interfaces y demás condiciones técnicas.

# 2. Descripción General

## 2.1 Perspectiva del producto

El sistema propuesto es un producto independiente, desarrollado exclusivamente para el gimnasio Forza Entrenamientos. No forma parte de un ecosistema mayor ni depende de otros módulos externos; su función es centralizar y digitalizar los procesos administrativos y operativos del gimnasio.

El sistema se concibe como una aplicación web de gestión integral, accesible tanto para el dueño como para profesores y alumnos. Su arquitectura organiza de manera interna módulos como: gestión de alumnos, administración de turnos, registro de pagos y asignación de rutinas. Estas funcionalidades interactúan entre sí dentro del propio sistema, sin conexiones con aplicaciones externas.

## 2.2 Funcionalidad del producto

El sistema permitirá llevar adelante, de forma centralizada y digital, las operaciones esenciales del gimnasio. Las funcionalidades principales incluyen:

- Gestión de alumnos (ABM): registro, modificación y baja de alumnos, incluyendo datos personales, contacto y apto médico digitalizado.
- Gestión de turnos y horarios (ABM): creación y administración de turnos fijos según día, horario y capacidad máxima.
- Asignación de turnos: los profesores podrán asignar alumnos a turnos de acuerdo con su disponibilidad.
- Control y registro de pagos: carga manual de pagos mensuales, visualización del estado de pago.
- Acceso de alumnos: consulta de información personal, rutinas asignadas, horarios y estado de pagos.
- Gestión de rutinas: los profesores podrán registrar rutinas personalizadas y asignarlas a los alumnos.

Estas funcionalidades permitirán un mayor control administrativo, seguimiento de asistencia, organización de horarios y comunicación clara entre los actores del gimnasio.

## 2.3 Características de los usuarios

### Tipos de usuario

- **Dueño del gimnasio:** responsable de la administración general.  
- **Profesores:** encargados de asignar turnos, registrar rutinas y verificar pagos.  
- **Alumnos:** usuarios finales que consultan su información, horarios y pagos.

### Formación

- Dueño y profesores: nivel educativo medio a avanzado; experiencia básica en sistemas de gestión.  
- Alumnos: nivel variado; se asume manejo básico de navegadores web.

### Habilidades

- Manejo básico de PC o dispositivo móvil.  
- Capacidad para ingresar datos simples, visualizar información y navegar por una interfaz web.  
- Profesores y dueño: habilidades adicionales de gestión y organización.

### Actividades

- Dueño: supervisión del funcionamiento general, control de pagos y reportes.  
- Profesores: gestión de turnos, cargas de rutinas, confirmación de pagos.  
- Alumnos: consulta de su perfil, horarios y estado de pagos.

## 2.4 Restricciones

- El sistema deberá ser accesible vía web, siendo obligatorio que funcione de forma responsive para diferentes dispositivos.  
- Se priorizará usabilidad y simplicidad, asegurando que todos los usuarios puedan interactuar fácilmente sin capacitación técnica avanzada.  
- No se implementará en esta versión una pasarela de pagos online; los pagos se registrarán manualmente.  
- No se desarrollará una aplicación móvil nativa.  
- No habrá integración con sistemas contables o externos.  
- El desarrollo debe realizarse en un plazo acotado de 3 a 4 meses, lo cual limita la complejidad y alcance de las funcionalidades.  
- El sistema debe operar bajo las tecnologías seleccionadas (Laravel como framework backend y Filament para panel administrativo).

## 2.5 Suposiciones y dependencias

- Los alumnos mantienen día y horario fijos, sin un sistema dinámico de reservas.  
- El gimnasio cuenta con un número limitado de profesores, quienes gestionarán los turnos y rutinas.  
- Todos los usuarios disponen de acceso a internet para utilizar la aplicación.  
- Se asume disponibilidad del entorno de hosting compatible con PHP, Laravel y base de datos.  
- Cambios en políticas internas del gimnasio (formas de pago, asignación de horarios, número de alumnos por turno) podrían requerir ajustes en los requisitos.

## 2.6 Evolución previsible del sistema

En futuras versiones del sistema se prevé:

- Integración con pasarelas de pago online (ej.: MercadoPago).  
- Implementación de un sistema dinámico de reservas por parte de los alumnos.  
- Reportes avanzados de asistencia, pagos, métricas de alumnos y rendimiento del gimnasio.
# 3. Requisitos específicos

## 3.1 Requisitos comunes de los interfaces

### 3.1.1 Interfaces de usuario

El sistema presenta una interfaz web moderna desarrollada con **Filament** (Laravel admin panel), accesible a través de navegadores web estándar. Los usuarios interactúan con paneles de control específicos según su rol (Admin, Profesor, Alumno).

**Características visuales:**
- Panel administrativo responsivo con navegación lateral
- Formularios de entrada validados en cliente y servidor
- Tablas de datos con paginación, búsqueda y filtrado
- Notificaciones en tiempo real (éxito, advertencia, error)
- Diseño oscuro/claro adaptable
- Colores corporativos de ForzaGym (#FF750F, #1B1B18)


## 3.2 Requisitos funcionales

### 3.2.1 Gestión de Actividades (Clases/Disciplinas)

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-01 |
| **Nombre de requisito** | CRUD de Actividades |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Alta / Esencial |

**Descripción:**

Administradores y Profesores pueden crear, leer, actualizar y eliminar actividades (disciplinas/clases como "Yoga", "Funcional", "Musculación").

**Funcionalidades:**
- Crear nueva actividad con nombre único, descripción y estado activo/inactivo
- Listar actividades con búsqueda y filtrado por nombre o estado
- Editar nombre, descripción y estado de una actividad
- Soft delete: no permitir borrado físico si existen turnos asociados
- Validación: nombre requerido y único en la BD

**Validaciones:**
- DNI de input: nombre no vacío, longitud 3-100 caracteres
- Unicidad: no dos actividades con igual nombre
- Integridad referencial: bloquear eliminación si hay turnos asignados


---

### 3.2.2 Gestión de Turnos (Shifts)

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-02 |
| **Nombre de requisito** | CRUD de Turnos (Shifts) |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Alta / Esencial |

**Descripción:**

Administradores y Profesores crean turnos (instancias de una actividad en día/hora específica). Los alumnos pueden consultarlos e inscribirse.

**Funcionalidades:**
- Crear turno: seleccionar actividad, profesor, día de semana, hora inicio/fin, capacidad máxima
- Validar ausencia de solapamientos: no permitir dos turnos del mismo profesor en horarios solapados
- Listar turnos: mostrar actividad, profesor, día, horario, capacidad y cupos disponibles
- Editar turno (solo si no hay alumnos inscritos, o con control de cambios)
- Soft delete: marcar como eliminado sin borrar registro
- Enrolamiento automático: alumnos pueden inscribirse si hay cupos
- Validación de conflictos: al inscribirse, verificar no solapamiento con otros turnos del alumno

**Validaciones:**
- Horario: `start_time < end_time`
- Capacidad: número positivo > 0
- Solapamiento: `(T1.start < T2.end) AND (T1.end > T2.start)` para mismo profesor mismo día
- Actividad: solo actividades activas


---

### 3.2.3 Gestión de Rutinas

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-03 |
| **Nombre de requisito** | Gestión de Rutinas de Entrenamiento |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Media / Deseado |

**Descripción:**

Profesores y Administradores asignan rutinas personalizadas a alumnos. Cada rutina contiene ejercicios, series, repeticiones y descripción.

**Funcionalidades:**
- Crear rutina: nombre, descripción, fechas inicio/fin, alumno(s) asignado(s)
- Listar rutinas: filtrar por alumno, profesor, estado activo/inactivo
- Editar rutina (solo profesor asignado o admin)
- Vista de rutina: mostrar detalles 
- Alumnos ven solo sus rutinas asignadas en su perfil
- Soft delete

**Validaciones:**
- Nombre requerido, único por alumno
- Fecha inicio ≤ fecha fin (si ambas presentes)
- Alumno debe existir

---

### 3.2.4 Registro de Pagos

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-04 |
| **Nombre de requisito** | Registro y Gestión de Pagos |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Alta / Esencial |

**Descripción:**

Administradores registran pagos de alumnos (cuotas mensuales). El sistema calcula automáticamente el estado de pago (al día/vencido) basado en el último pago.

**Funcionalidades:**
- Registrar pago: alumno, fecha de pago, monto (opcional)
- Listar pagos con filtros: alumno, estado, rango de fechas
- Mostrar solo último pago por alumno en vistas de perfil
- Cálculo automático de estado: 
  - **Al día:** último pago hace ≤ 30 días
  - **Vencido:** último pago hace > 30 días o sin pagos
- Validación de duplicados: evitar dos pagos el mismo día para el mismo alumno
- Historial de pagos por alumno

**Validaciones:**
- Alumno requerido y debe existir en BD
- Fecha de pago no futura
- Monto ≥ 0
- No duplicados: (user_id, DATE(paid_at)) único

---

### 3.2.5 Gestión de Usuarios y Roles

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-05 |
| **Nombre de requisito** | CRUD de Usuarios y Asignación de Roles |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Alta / Esencial |

**Descripción:**

Administradores crean y gestionan usuarios del sistema, asignando roles (Admin, Profesor, Alumno) y permisos asociados.

**Funcionalidades:**
- Crear usuario: nombre, email, DNI, teléfono, contraseña, rol, estado activo/inactivo
- Validación de DNI único en la BD
- Listar usuarios con búsqueda por nombre, email, DNI
- Editar usuario (datos, rol, estado)
- Soft delete: marcar como inactivo en lugar de borrar
- Roles predefinidos: Admin, Teacher, Student
- Control de permisos por rol (implementado en `canViewAny`, `canEdit`, etc.)

**Validaciones:**
- Email válido y único
- DNI único (formato: 1-20 caracteres)
- Contraseña: mínimo 8 caracteres, hash bcrypt
- Nombre requerido, 3-150 caracteres
- Teléfono: formato opcional, máx. 30 caracteres


---

### 3.2.6 Perfil de Usuario y Consulta de Pagos

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-06 |
| **Nombre de requisito** | Perfil de Usuario y Consulta de Estado de Pagos |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Media / Deseado |

**Descripción:**

Alumnos acceden a su perfil personal donde ven datos personales, estado de pago y rutinas asignadas.

**Funcionalidades:**
- Vista protegida (solo usuario autenticado)
- Mostrar: nombre, email, DNI, teléfono, rol
- Mostrar último pago y estado (Al día / Vencido)
- Listar rutinas asignadas con enlace a vista detallada
- Opción de editar datos personales (nombre, teléfono, email)
- Logout desde el perfil

**Validaciones:**
- Usuario autenticado obligatorio
- No permitir edición de rol ni DNI

---

### 3.2.7 Enrolamiento en Turnos Disponibles

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RF-07 |
| **Nombre de requisito** | Enrolamiento y Desenrolamiento en Turnos |
| **Tipo** | Requisito Funcional |
| **Fuente del requisito** | Especificación de negocio (ForzaGym) |
| **Prioridad** | Alta / Esencial |

**Descripción:**

Alumnos visualizan turnos disponibles (según su rol y permisos) y pueden inscribirse o desapuntarse, respetando límites de capacidad y evitando solapamientos.

**Funcionalidades:**
- Página de turnos disponibles con listado filtrable
- Filtros: actividad, profesor, día de semana
- Para cada turno mostrar: actividad, profesor, día, horario, capacidad, cupos libres
- Badge de estado: "Inscripto", "Inscribirse", "Sin cupos"
- Acción de toggle: inscribirse/desapuntarse con confirmación
- Validación de solapamiento al inscribirse
- Mostrar notificaciones de éxito/error

**Validaciones:**
- Usuario debe estar autenticado
- No solapamientos: verificar no tener otro turno en ese horario (con tolerancia de minutos)
- Cupos disponibles: capacity - count(enrolled) > 0
- Un alumno no puede inscribirse 2 veces en el mismo turno

---

### 3.3.2 Seguridad

| Propiedad | Valor |
|-----------|-------|
| **Número de requisito** | RNF-02 |
| **Nombre de requisito** | Seguridad y Control de Acceso |
| **Tipo** | Requisito No Funcional |
| **Prioridad** | Alta / Esencial |

**Especificación:**

**Autenticación:**
- Contraseñas hasheadas con bcrypt (Laravel default, `$2y$`)
- Sesión segura con CSRF token en formularios
- Timeout de sesión: 120 minutos (configurable)

**Autorización (Control de Acceso):**
- Basada en roles: Admin, Teacher, Student
- Cada recurso (Resource) valida `canViewAny()`, `canEdit()`, `canDelete()`, `canCreate()`
- Admin: acceso total a todos los recursos
- Teacher: CRUD de actividades, turnos, rutinas; ver pagos (no editar); no borrar usuarios
- Student: vista solo de perfil, turnos disponibles, rutinas asignadas; sin acceso a crear/editar

**Integridad de datos:**
- Soft deletes: registros no se borran físicamente, se marcan como eliminados
- Timestamps: `created_at`, `updated_at` en todas las tablas
- Unicidad: DNI único por usuario, email único, nombre único por actividad
- Integridad referencial: claves foráneas con cascada (soft delete)
