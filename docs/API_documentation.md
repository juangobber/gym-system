# API Documentation (ForzaGym)

La aplicación expone endpoints REST (protegidos con Sanctum) para integraciones futuras. Todos los endpoints requieren autenticación Bearer salvo que se indique lo contrario.

## Base URL
```
https://{host}/api
```

## Endpoints

### 1. Listar turnos disponibles
```
GET /shifts
```
**Query params:** `day_of_week`, `activity_id`, `status` (optional).  
**Response 200:**
```json
[
  {
    "id": 10,
    "activity": "Funcional",
    "teacher": "Laura Torres",
    "day_of_week": "monday",
    "start_time": "08:00:00",
    "end_time": "09:00:00",
    "capacity": 15,
    "available": 3
  }
]
```

### 2. Inscribir alumno en un turno
```
POST /shifts/{shift}/enroll
```
**Body:**
```json
{
  "student_id": 5
}
```
**Response 201:** `{ "message": "Enrollment created" }`  
**Errores comunes:** `409` (sin cupos), `422` (solapamiento), `404` (shift inexistente).

### 3. Ver rutinas del alumno autenticado
```
GET /me/routines
```
**Response 200:**
```json
[
  {
    "id": 3,
    "name": "Rutina Juan",
    "start_date": "2025-01-10",
    "end_date": "2025-02-10",
    "description": "Circuito full body"
  }
]
```

### 4. Registrar un pago
```
POST /payments
```
**Body:**
```json
{
  "user_id": 5,
  "paid_at": "2025-02-28"
}
```
**Response 201:** `{ "message": "Payment stored" }`  
**Errores:** `409` (pago duplicado en la misma fecha), `404` (alumno inexistente).

### 5. Consultar perfil del usuario autenticado
```
GET /me/profile
```
**Response 200:**
```json
{
  "id": 5,
  "name": "Martina Gómez",
  "email": "martina@forza.com",
  "dni": "40123123",
  "phone": "2216666666",
  "last_payment": "2025-02-01",
  "payment_status": "Al día"
}
```

## Errores globales
| Código | Motivo |
|--------|--------|
| 401 | Token ausente o inválido. |
| 403 | El usuario no posee permisos/recurso ajeno. |
| 404 | Recurso inexistente. |
| 422 | Validación fallida (detalles en `errors`). |

## Notas de autenticación
- El login se maneja por Filament. Para la API, usar tokens de Sanctum (`/sanctum/token`) o Passport (pendiente).
- Cada token hereda el rol del usuario (admin/teacher/student). Los permisos descritos en el SRS también aplican a estos endpoints.
