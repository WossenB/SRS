# 🏢 Birrama Digital Commerce PLC - HR Management System

### 🚀 Product Overview
A comprehensive, production-ready, SRS-compliant HRMS tailored for the Ethiopian market. Built with extreme focus on security, data integrity, and compliance.

### 🛠️ Tech Stack
- **Framework**: Laravel 11 (PHP 8.2+)
- **Frontend**: Livewire 3 + Tailwind CSS
- **Database**: MySQL (Optimized with indexes & virtual columns)
- **Security**: Spatie Permissions, AES-256 Encryption for sensitive data.
- **Hosting**: Shared-hosting compatible (Database queue, Local private storage).

### ⚡ Quick Start
```bash
# 1. Install dependencies
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Database setup (ensure MySQL/SQLite is ready)
php artisan migrate --seed

# 4. Start application
php artisan serve
```

### 👥 Demo Logins
| Role | Email | Password |
| :--- | :--- | :--- |
| **Super Admin** | `admin@birrama.com` | `password` |

### 🏛️ Architecture & Workflow
- **Service Layer Pattern**: All business logic (Payroll math, Leave validation) resides in dedicated Service classes.
- **RBAC**: 5 distinct roles with granular permissions (FR-AUTH-05).
- **State Machines**: Workflow transitions (Leave, Timesheets, Payroll) are logged and audited automatically.
- **Audit Trail**: Immutable logging of all record updates and status changes.

### 📊 Business Logic & Math
- **Ethiopian Tax (2025)**: Automated calculation based on income tax slabs and standard deductions (FR-PAY-02).
- **Pension**: Automated 7% employee and 11% employer contributions (FR-PAY-03).
- **Rounding Policy**: Tax (HALF_DOWN), Net/Pension (HALF_UP) - Centralized in `App\Support\Money`.
- **Leave**: Automated overlap detection and annual balance enforcement.
- **Concurrency**: Optimistic locking using `version` columns to prevent data overwrites.

### 🧪 Quality Assurance
- **Tests**: Comprehensive unit and feature tests covering core workflows.
- **Status**: Phase 1 & 2 fully implemented.
- **Acceptance**: [View Checklist](docs/ACCEPTANCE_CHECKLIST.md)

### 🚀 Production Deployment
- **Cron**: `* * * * * php artisan schedule:run >> /dev/null 2>&1`
- **Queue**: Optimized `database` driver running via scheduler every minute.
- [Detailed Deployment Guide](DEPLOYMENT.md)

---
**License**: Proprietary for Birrama Digital Commerce PLC.
