# 🗺️ ROADMAP Y ARQUITECTURA – AVIAPP

Este documento establece la hoja de ruta estratégica y el diseño arquitectónico de **AviApp**, un SaaS B2B2C de infraestructura médica y pasarela de recaudo recurrente de marca blanca para clínicas veterinarias en Colombia.

---

## 1. Diseño Arquitectónico (C4 Model)

Siguiendo las directrices del **Arquitecto Maestro**, definimos la estructura del sistema antes de entrar en código.

### Nivel 1: Contexto del Sistema
```mermaid
graph TD
    User["Propietario de Mascota (Cliente B2C)"]
    Admin["Administrador de Clínica (Tenant B2B)"]
    AviApp["Sistema AviApp (SaaS)"]
    MetaWS["WhatsApp Cloud API (Meta)"]
    Wompi["Pasarela de Pagos (Wompi)"]
    GoogleCal["Google Workspace Calendar API"]

    User -->|Afiliación y Carnet Digital| AviApp
    Admin -->|Gestión de Planes y Consumos| AviApp
    AviApp -->|Mensajería, Cobros y Bot| MetaWS
    AviApp -->|Sincronización de Citas| GoogleCal
    Wompi -->|Notificaciones de Pago (Webhooks)| AviApp
    MetaWS -->|Mensajes Entrantes (Webhooks)| AviApp
```

### Nivel 2: Contenedores
- **Frontend PWA (Next.js + Tailwind CSS)**: Desplegado en **Vercel**. Consume el backend FastAPI. Resuelve marcas blancas mediante subdominios dinámicos (ej: `el_manantial.aviapp.com`).
- **Backend API (FastAPI + Python)**: Desplegado de forma serverless en **GCP Cloud Run**. Maneja la lógica de negocio principal y las integraciones.
- **Base de Datos (GCP Firestore)**: Base de datos NoSQL multi-tenant para almacenamiento de baja latencia y alta concurrencia.
- **Admin Panel (Streamlit)**: Interfaz web de administración ligera para clínicas. Permite a los veterinarios listar afiliados y descontar servicios de forma inmediata.

### Nivel 3: Componentes (Clean Architecture)
```
┌────────────────────────────────────────────────────────┐
│ Presentación: Next.js PWA / Streamlit Admin            │
└───────────┬────────────────────────────────────────────┘
            │ (Peticiones HTTPS / JSON / Validaciones Zod)
┌───────────▼────────────────────────────────────────────┐
│ Dominio: Modelos Pydantic, Casos de Uso, Reglas        │
│          de Negocio (Recaudo, Cobertura, Agendamiento) │
└───────────┬────────────────────────────────────────────┘
            │ (Inyección de Dependencias)
┌───────────▼────────────────────────────────────────────┐
│ Infraestructura: Clientes de Firestore, Google API,    │
│                  Meta API, Webhooks de Pagos           │
└────────────────────────────────────────────────────────┘
```

---

## 2. Cronograma de Desarrollo e Inmediatos

### 📋 Fase 1: Gancho & Smoke Test — [✅ COMPLETO]
*Objetivo: Captar leads calificados y preparar la infraestructura base.*

1. **Infraestructura de Despliegue y Enrutamiento (Vercel)**:
   - Despliegue inicial en Vercel con el dominio `aviapp-six.vercel.app`.
   - Enrutamiento de marca blanca basado en slugs y paths en Next.js.
2. **Landing Page de Afiliación (Next.js + Tailwind)**:
   - Landing genérica del SaaS.
   - Template de landing de afiliación para el tenant (marca blanca).
   - Wizard completo de afiliación en 3 pasos con cálculo de mensualidades e inscripción.
3. **Control de Git y Deploy**:
   - Flujo de ramas `develop` -> `Preview URL` -> `main` configurado.

---

### 💳 Fase 2: MVP / Esencial - Recaudo, Consumos y Permanencia — [✅ COMPLETO]
*Objetivo: Flujo de caja directo por veterinaria, control de permanencia para rentabilidad y validación de cobro automático mensual.*

1. **Base de Datos Multi-Tenant (Supabase / PostgreSQL) — [✅ COMPLETO]**:
   - Esquema de base de datos (`tenants`, `plans`, `pets`, `clinical_history`, `audit_logs`, `vet_users`, `payment_logs`).
   - El esquema de `pets` incorpora variables de contrato: `id_contrato` (`contract_id`), `fecha_inicio`, `fecha_fin_contrato`, `months_paid`, `months_remaining`.
   - Políticas RLS robustas aplicadas en todas las tablas para aislamiento de datos.
2. **Lógica de Permanencia y Contrato — [✅ COMPLETO]**:
   - Permanencia mínima de 12 meses por defecto aceptada en el formulario de afiliación digital.
   - Generación automática de `contract_id` secuencial/único para evitar colisiones.
3. **Supabase Auth & Custom Token Hook — [✅ COMPLETO]**:
   - Edge Function en Deno que inyecta el `tenant_id` y el `rol` (vet_admin/vet_staff) en el token JWT durante el inicio de sesión.
4. **Integración de Pasarela de Pagos Multi-Tenant (Wompi) — [✅ COMPLETO]**:
   - Servicio [`wompi.service.ts`](file:///d:/NODIA/AVI-Plan/src/services/wompi.service.ts) y API Route `/api/wompi` diseñados bajo arquitectura multi-tenant real (Opción B).
   - Obtención dinámica de llaves API (`wompi_private_key`, `wompi_public_key`) de cada clínica desde Supabase.
   - Fallback inteligente a llaves globales solo para entornos de desarrollo.
5. **Registro de Logs de Transacciones (`payment_logs`) — [✅ COMPLETO]**:
   - Log de transacciones para control y auditoría.
6. **Interfaz de Autogestión de Llaves Wompi en Panel Admin — [✅ COMPLETO]**:
   - Creación de interfaz visual de edición dentro del panel `/admin/{slug}/config` para que la veterinaria configure sus propias llaves de pasarela, logo, colores y Nequi/Bancolombia de forma autónoma.
7. **Notificaciones Automáticas al Tutor B2C (Email Marca Blanca + WhatsApp Directo) — [✅ COMPLETO]**:
   - Envío automático del Carnet Digital QR y PDF descargable al correo del tutor tras la afiliación (`TutorWelcomeCarnetMail`), con copia oculta (BCC) a la clínica.
   - Envío automático de Comprobante Clínico de Canje (`TutorRedemptionReceiptMail`) en cada redención de mostrador con el saldo actualizado de beneficios.
8. **Consumo de Beneficios y Blindaje de Carencia en Mostrador — [✅ COMPLETO]**:
   - Terminal de mostrador (`/admin/{slug}/counter-redeem`) con escáner QR, barra de cupos y **Protección de Periodos de Carencia (Vesting)** automática por categoría (15/30/45/60 días) con opción de excepción médica auditada (`override_carencia`).

---

### 📅 Fase 3: Integración de Google Calendar (Días 16 a 22) — [✅ COMPLETO]
*Objetivo: Sincronización de agendas de veterinarios sin colisiones de horario.*

1. **Persistencia & Modelo de Citas (`appointments`) — [✅ COMPLETO]**:
   - Tabla multi-tenant con campos de fecha, hora, duración, estado, profesional y vinculación a beneficios clínicos del plan.
2. **Motor de Disponibilidad Anti-Colisión (`GoogleCalendarService.php`) — [✅ COMPLETO]**:
   - Cálculo dinámico de slots de 30/45/60 min libres vs ocupados para evitar doble reserva entre profesionales.
3. **Sincronización 1-Click con Google Calendar — [✅ COMPLETO]**:
   - Generación de enlace universal (`render?action=TEMPLATE`) con datos clínicos (paciente, especie, tutor, plan, clínica y dirección).
4. **Despacho de Recordatorio WhatsApp con Enlace al Calendario — [✅ COMPLETO]**:
   - Link personalizado directo al WhatsApp del tutor con la confirmación de la cita y el enlace para agregar el evento a su Google Calendar móvil.
5. **Panel Interactivo de Gestión de Citas (`/admin/{slug}/citas`) — [✅ COMPLETO]**:
   - Vista de agenda diaria/semanal, filtro por doctor, badges de estado en tiempo real y modal de creación inmediata.

---

### 🧠 Fase 4: Inteligencia Artificial & Triaje (Días 23 a 30) — [❌ PENDIENTE]
*Objetivo: Generación de Upselling de planes Esencial a Pro con AVI (Asistente Veterinario Inteligente).*

1. **Integración con Gemini**:
   - Agente de triaje médico basado en Gemini Pro (24/7).
   - Historial de conversación almacenado en base de datos por mascota.
2. **Restricción de Cobertura**:
   - Sólo responde a mascotas con suscripción activa en el plan "Pro + IA".

---

## 3. Modelos de Planes de Ejemplo "Blindados"

Para blindar la economía de la clínica y evitar abusos, los planes del MVP se configuran bajo tres pilares de protección técnica y contractual:
1. **Tokens Mensuales No Acumulativos**: Evita que acumulen servicios para gastarlos todos juntos.
2. **Periodos de Carencia (Vesting)**: Los servicios costosos (vacunación completa, profilaxis, laboratorios) requieren $N$ meses de antigüedad activa antes de poder ser solicitados, o en su defecto, activan una retención de cancelación.
3. **Amortización en Penalidad**: Si el cliente cancela antes de los 12 meses, la pasarela calcula una penalidad equivalente al **50% de las cuotas restantes** OR al **valor comercial de los servicios gastados** (lo que sea mayor).

### Plan 1: Esencial Canino/Felino (El Gancho)
*   **Precio Público**: $35.000 COP/mes (Contrato Anual).
*   **Tu Comisión (SaaS)**: $3.000 COP/mes.
*   **Servicios Mensuales (Tokens)**:
    *   1 Consulta médica general (No acumulativa).
    *   Soporte básico de urgencias por WhatsApp (Bot).
*   **Servicios Anuales (Con Carencia)**:
    *   Esquema de vacunación anual básico.
    *   *Blindaje*: Requiere **3 meses de antigüedad** para liberarse, o se cobra el costo comercial de la vacuna ($60.000 COP) si se solicita antes y se cancela el contrato.

### Plan 2: Vital Canino/Felino (El Recomendado)
*   **Precio Público**: $55.000 COP/mes (Contrato Anual).
*   **Tu Comisión (SaaS)**: $4.500 COP/mes.
*   **Servicios Mensuales (Tokens)**:
    *   1 Consulta general + 1 Consulta prioritaria/urgencia.
    *   Acceso ilimitado a **AVI (Asistente Veterinario Inteligente)** vía WhatsApp (Gemini).
*   **Servicios Semestrales/Anuales**:
    *   Esquema de vacunas completo + Desparasitación trimestral.
    *   Profilaxis dental básica (Limpieza de dientes).
    *   *Blindaje*: La profilaxis requiere **4 meses de antigüedad** activa. Los exámenes de laboratorio semestrales requieren **3 meses de antigüedad**.

### Plan 3: VIP Satelital / Premium
*   **Precio Público**: $75.000 COP/mes (Contrato Anual).
*   **Tu Comisión (SaaS)**: $10.000 COP/mes.
*   **Servicios Mensuales (Tokens)**:
    *   Consultas generales ilimitadas.
    *   Acceso VIP a AVI.
    *   Arriendo de Collar GPS IoT + plan de datos M2M incluido.
    *   Geo-cercas y alertas de escape automáticas por WhatsApp.
*   **Servicios Anuales**:
    *   Todo lo del plan Vital.
    *   1 Ecografía o examen especializado al año.
    *   *Blindaje*: El Collar GPS es propiedad de la plataforma (comodato). Si el cliente cancela, debe devolver el collar en perfecto estado en 5 días hábiles, o se le cobra el valor comercial del hardware ($150.000 COP) directo a la tarjeta registrada en Wompi, adicional a la penalidad de salida anticipada.

---

## 4. Mejora Continua (Propuestas de Arquitectura)

Para cada etapa de integración, presentamos las opciones técnica y económicamente viables:

### Hito A: Gestión de Subdominios de Marca Blanca
- **Opción A (Mejora Rápida - Alto Impacto)**: 
  - Usar el middleware de Next.js para reescribir dinámicamente las rutas basándose en el header `Host`, utilizando **Cloudflare Free** para el wildcard SSL.
  - *ROI*: $0 USD/mes de costo de infraestructura. Velocidad de implementación en 1 día.
- **Opción B (Mejora Estructural - Escalable)**:
  - Implementar **GCP HTTPS Load Balancer** con certificados SSL gestionados por Google y asignación de múltiples dominios personalizados vía API.
  - *ROI*: Altamente robusto, listo para nivel enterprise pero con costo base de ~$20 USD/mes. Recomendado sólo tras superar los 100 tenants activos.

### Hito B: Procesamiento de Mensajería del Bot (WhatsApp)
- **Opción A (Mejora Rápida - Alto Impacto)**:
  - Usar la cola en memoria asíncrona de FastAPI (`BackgroundTasks`) para procesar las llamadas de WhatsApp. Responder de inmediato `200 OK` a Meta y procesar la lógica/Gemini de fondo.
  - *ROI*: Costo cero y configuración de 1 hora. Adecuado para pilotos de hasta 50 veterinarias concurrentes.
- **Opción B (Mejora Estructural - Escalable)**:
  - Enrutar los webhooks entrantes a **Google Cloud Pub/Sub** y procesarlos con workers independientes o Cloud Run instances dedicadas.
  - *ROI*: Tolerancia completa a fallos e independencia de escalado del bot respecto a la API de negocio.

---

## 5. Próxima Decisión Requerida por el CEO

> [!IMPORTANT]
> **Aprobación del Roadmap**:
> ¿Aprobamos este Roadmap de 4 fases y su arquitectura para comenzar mañana a primera hora con la Fase 1 (Configuración de DNS/Cloudflare, Repositorio Base y Campaña de Smoke Test)?
