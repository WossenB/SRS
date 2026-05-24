# Birrama HR Management System

Complete, production-ready HR Management System for **Birrama Digital Commerce PLC**.

## 🚀 Tech Stack
- **Framework**: Laravel 11
- **Frontend**: Livewire 3 + Tailwind CSS
- **Database**: MySQL (Shared hosting compatible)
- **Queue**: Database driver
- **Storage**: Private disk for documents

## 🛠️ Implementation Details
- **Architecture**: Service Layer Pattern with Action-based workflows.
- **RBAC**: Granular permissions using Spatie Laravel Permission.
- **Security**: Field-level encryption for Salary, TIN, and Bank details. Secure document downloads.
- **Business Logic**:
    - Ethiopian Tax (2025 Slabs) and Pension math.
    - Leave overlap and balance validation.
    - Deterministic Payroll snapshots.
    - Optimistic locking for data integrity.

## 🏁 Quick Start
1. `composer install`
2. `php artisan migrate --seed`
3. `php artisan serve`

### Demo Logins
- **Admin**: `admin@birrama.com` / `password`

## 📊 SRS Status
- Phase 1 & 2 fully implemented.
- Secure Audit & Status logs enabled for all major actions.

## 🧪 Tests
- `php artisan test` (Unit and Feature tests for Payroll, Leave, and Timesheets).

## 📄 Documentation
- [User Manual](docs/USER_MANUAL.md)
- [Deployment Guide](DEPLOYMENT.md)
- [Acceptance Checklist](docs/ACCEPTANCE_CHECKLIST.md)

## 📜 License
Proprietary for Birrama Digital Commerce PLC.
