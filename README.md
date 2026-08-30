# 🐾 AVI SaaS Platform — Monolito Laravel 12 + Microservicio IA + Multi-Tenant

Plataforma SaaS Multi-Tenant de gestión de membresías y canjes de planes de salud preventiva para clínicas veterinarias.

## 🏛️ Arquitectura del Sistema

```
                      ┌────────────────────────────────────────┐
                      │            CLIENTES / TUTORES          │
                      └───────────────────┬────────────────────┘
                                          │ (Storefront / Subdominios)
                                          ▼
                      ┌────────────────────────────────────────┐
                      │    Monolito Laravel 12 + Livewire 3    │
                      │  - Filament 4 (SuperAdmin & VetAdmin)  │
                      │  - BenefitLedgerService (Atómico)      │
                      │  - Webhooks Pasarelas (Wompi/Bold)     │
                      └───────┬───────────────┬────────────────┘
                              │               │
                 (SQL / Pool) │               │ (HTTP :8001)
                              ▼               ▼
        ┌─────────────────────────┐       ┌─────────────────────────┐
        │  PostgreSQL 17 (avi-db) │       │  FastAPI IA (avi-ai)    │
        │  - Tenants, Pets, Plans │       │  - Recomendación Planes │
        │  - Subscriptions Ledger │       │  - RAG Asistente Vet    │
        └─────────────────────────┘       └─────────────────────────┘
```

## 📦 Estructura de Módulos

1. **Base de Datos Multi-Tenant (PostgreSQL):** Aislamiento por `tenant_id`, catálogo de planes, ledger de saldo de beneficios (`subscription_benefit_balances`) y registro de canjes (`benefit_redemptions`).
2. **Monolito Laravel 12:**
   - **Filament SuperAdmin:** Gestión de clínicas, métricas de MRR y planes SaaS.
   - **Filament VetAdmin:** Dashboard de clínica, gestión de tutores/mascotas y punto de canje rápido en recepción (`CounterRedeem`).
   - **Livewire Storefront:** Landing dinámica por clínica con branding personalizado y checkout veloz.
   - **BenefitLedgerService:** Control de concurrencia y transacciones atómicas con bloqueo pesimista.
3. **Microservicio FastAPI (Puerto 8001):** Motor de IA para recomendación de planes basado en especie, edad, preexistencias y presupuesto.

## 🚀 Despliegue en VPS (Easypanel)

Servicios configurados en la red privada de Docker:
- `avi-db` (PostgreSQL 17)
- `avi-redis` (Redis 7)
- `avi-app` (Laravel 12 / PHP 8.3)
- `avi-ai` (Python 3.12 / FastAPI)
