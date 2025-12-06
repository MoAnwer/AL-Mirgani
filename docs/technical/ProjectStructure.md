# Project Folder Structure & Architecture

This document provides a detailed overview of the project's directory structure, explaining the purpose of key folders and the architectural patterns used.

## Root Directory Overview

The project follows a standard Laravel application structure with some specific architectural enhancements.

```text
/
├── app/                # Core application logic (Models, Services, Controllers)
├── bootstrap/          # Framework bootstrapping
├── config/             # Application configuration files
├── database/           # Migrations, Seeders, and Factories
├── docs/               # Project documentation
├── lang/               # Localization files
├── public/             # Web root (index.php, assets)
├── resources/          # Views, raw assets (CSS/JS)
├── routes/             # Route definitions (Modularized)
├── storage/            # Logs, compiled templates, file uploads
├── tests/              # Automated tests
└── vendor/             # Composer dependencies
```

---

## Detailed Directory Breakdown

### 1. App Directory (`app/`)
This is where the majority of the application logic resides. The project adopts a **Service-Oriented Architecture** to keep controllers thin and logic reusable.

*   **`Enums/`**: PHP Enums used for defining constant sets (e.g., `PaymentStatusEnum`, `ExpenseCategoryEnum`).
*   **`Events/`**: Event classes for decoupling logic (e.g., `PayrollPaid`).
*   **`Http/`**: Handles HTTP requests.
    *   **`Controllers/`**: Grouped by feature (e.g., `Employees`, `Users`). They delegate logic to Services.
    *   **`Requests/`**: Form Request classes for validation logic.
    *   **`Middleware/`**: HTTP middleware for request filtering.
*   **`Listeners/`**: Event listeners that handle side-effects (e.g., `EmployeePayrollIsPaid` which creates an expense record).
*   **`Models/`**: Eloquent ORM models representing database tables.
*   **`Notifications/`**: Notification classes for email/database alerts (e.g., `NewUserNotification`).
*   **`Providers/`**: Service providers for dependency injection and app bootstrapping.
*   **`Rules/`**: Custom validation rules (e.g., `RequiredIfBankak`, `UniqueInTables`).
*   **`Services/`**: **Core Business Logic**. Organized by module:
    *   `Auth/`: Authentication logic.
    *   `Employee/`: Employee management.
    *   `Payroll/`: Payroll processing.
    *   `Student/`: Student management.
    *   `User/`: User management.
*   **`Traits/`**: Reusable code traits.
*   **`View/`**: View Composers or Components.

### 2. Routes Directory (`routes/`)
Unlike a standard Laravel install, routes are **heavily modularized** into separate files for better maintainability.

*   `web.php`: Main entry point, likely includes other route files.
*   `auth.php`: Authentication routes.
*   `payrolls.php`: Payroll-related routes.
*   `employees.php`: Employee management routes.
*   `students.php`: Student management routes.
*   `reports.php`: Reporting routes.
*   `settings.php`: Application settings.
*   ...and others (`earning.php`, `expenses.php`, etc.).

### 3. Resources Directory (`resources/`)
Contains the frontend presentation layer.

*   **`views/`**: Blade templates.
    *   Likely organized by module (e.g., `payroll/`, `users/`, `employees/`) matching the Controller/Service structure.
*   **`css/`** & **`js/`**: Raw assets compiled via Vite.

### 4. Database Directory (`database/`)
*   **`migrations/`**: Database schema definitions.
*   **`seeders/`**: Data seeders for initial setup.
*   **`factories/`**: Model factories for generating test data.

---

## Architectural Patterns

### Service-Repository Pattern (Simplified)
The project strictly separates **Control** (Controllers) from **Logic** (Services).
*   **Controllers** are "thin": they handle the request, call a Service method, and return a response.
*   **Services** handle the "heavy lifting": validation, database transactions, and business rules.

### Event-Driven Actions
Side effects are handled via Events and Listeners.
*   *Example*: When a payroll is paid, the Service fires an Event. A Listener catches this event to record an Expense. This keeps the Payroll logic clean and decoupled from Expense logic.

### Modular Organization
Code is organized by **Domain/Feature** rather than just by Type.
*   Routes are split by feature.
*   Services are split by feature.
*   Controllers are grouped by feature.
This makes it easier to locate all code related to a specific feature (like "Payroll").
