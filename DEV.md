## 🧩 Entidades y Campos Propuestos

### 1. Alumnos
- **id** (PK)
- **nombre**
- **apellido**
- **dni**
- **email**
- **telefono**
- **fecha_nacimiento**
- **direccion**
- **fecha_alta**
- **activo** (booleano)

### 2. Planes
- **id** (PK)
- **nombre**
- **descripcion**
- **precio**
- **duracion_dias**
- **activo** (booleano)

### 3. Inscripciones
- **id** (PK)
- **alumno_id** (FK → Alumnos)
- **plan_id** (FK → Planes)
- **fecha_inicio**
- **fecha_fin**
- **estado** (vigente / vencido / cancelado)

### 4. Pagos
- **id** (PK)
- **inscripcion_id** (FK → Inscripciones)
- **monto**
- **fecha_pago**
- **metodo_pago** (efectivo / tarjeta / transferencia)
- **comprobante_url** (opcional)

### 5. Profesores
- **id** (PK)
- **nombre**
- **apellido**
- **dni**
- **email**
- **telefono**
- **especialidad**
- **activo** (booleano)

### 6. Clases
- **id** (PK)
- **nombre**
- **descripcion**
- **profesor_id** (FK → Profesores)
- **horario_dia**
- **horario_hora**
- **capacidad_maxima**
- **activo** (booleano)

### 7. Asistencias
- **id** (PK)
- **alumno_id** (FK → Alumnos)
- **clase_id** (FK → Clases)
- **fecha**
- **presente** (booleano)

### 8. Usuarios (para gestión interna del sistema)
- **id** (PK)
- **nombre_usuario**
- **email**
- **password**
- **rol** (admin / recepcion / profesor)
- **activo** (booleano)

---

## 🔗 Relaciones Principales
- Un **Alumno** puede tener muchas **Inscripciones**.  
- Una **Inscripción** pertenece a un **Plan**.  
- Una **Inscripción** puede tener muchos **Pagos**.  
- Un **Profesor** puede dictar muchas **Clases**.  
- Un **Alumno** puede asistir a muchas **Clases** (relación N:M representada en **Asistencias**).  
- Un **Usuario** gestiona el sistema según su **rol**.

---
  
# TAREAS

## Módulo: Alumnos

- Crear modelo **Alumno** con campos: nombre, apellido, DNI, email, teléfono, apto_médico (archivo), estado (activo/inactivo).  
- Generar **Resource** en Filament para ABM completo (listado, creación, edición, eliminación).  
- Agregar búsqueda por nombre, apellido o DNI.  
- Mostrar columna de estado con colores o badges.  
- Permitir carga de archivo de apto médico (PDF o imagen).  
- Agregar vista de detalle del alumno con sus turnos, rutinas y pagos asociados (usando RelationManagers).  
- Validar campos obligatorios y formato de email.  
- Permitir filtrar alumnos activos/inactivos.  

---

## Módulo: Turnos

- Crear modelo **Turno** con día, hora, capacidad, profesor_id.  
- Generar **Resource** en Filament con ABM completo.  
- Relacionar turnos con alumnos mediante tabla pivote (por ejemplo `alumno_turno`).  
- Agregar **RelationManager** en `AlumnoResource` y `TurnoResource` para ver asignaciones cruzadas.  
- Validar que no se supere la capacidad máxima de alumnos por turno.  
- Mostrar contador de cupos ocupados/disponibles.  
- Evitar asignar un alumno a dos turnos que se solapen en día y hora.  

---

## Módulo: Pagos

- Crear modelo **Pago** con campos: alumno_id, fecha_pago, monto, mes_correspondiente, estado.  
- Generar **Resource** en Filament con ABM completo.  
- Agregar **RelationManager** de pagos dentro del `AlumnoResource`.  
- Calcular estado automáticamente: al día / atrasado / vencido.  
- Agregar badges o etiquetas visuales según el estado.  
- Agregar filtros por mes y estado.  
- Crear widget o gráfico en dashboard con resumen de pagos del mes.  

---

## Módulo: Rutinas

- Crear modelo **Rutina** con alumno_id, nombre, descripción, fecha_asignación.  
- Crear modelo **Ejercicio** (si se quiere más detalle) relacionado con Rutina.  
- Generar **Resource** en Filament para que el profesor pueda crear rutinas y asociarlas a alumnos.  
- Mostrar rutina actual del alumno y mantener historial.  
- Agregar **RelationManager** de rutinas dentro del `AlumnoResource`.  

---

## Módulo: Usuarios y Roles

- Usar autenticación nativa de Filament con **User model**.  
- Configurar roles y permisos (usando **Filament Shield** o **Spatie Laravel Permission**).  
- Crear roles: **Admin**, **Profesor**, **Alumno**.  
- Definir qué vistas y recursos puede ver cada rol:  
  - **Admin:** acceso completo.  
  - **Profesor:** acceso a alumnos, turnos y rutinas asignadas.  
  - **Alumno:** solo vista de perfil y sus datos.  
- Configurar login y logout con la interfaz de Filament.  

---

## Módulo: Dashboard y Reportes

- Crear **Dashboard** con widgets:  
  - Total de alumnos activos.  
  - Pagos al día / vencidos.  
  - Turnos ocupados por día.  
- Agregar gráficos usando los **Filament Widgets** (BarChart, StatsOverview).  
- Permitir filtrar métricas por mes o profesor.  
- Agregar acceso rápido a los módulos principales (botones de acción).  