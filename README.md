# CURD Laravel Project

## Backend Features

This project provides backend APIs and logic for a user management system (User/Person) with the following main features:

- **Authentication & Account Management:**
  - Register, login, logout, change password, and password reset via API
  - Simultaneous creation of User and Person on registration
  - API token management (API Token)
  - Basic role-based access: admin, user

- **Person Management (CRUD):**
  - Create, list, view details, update, and delete Person via API
  - Manage Person/User status (activate/deactivate individually or in bulk)

- **Batch Email Sending:**
  - Support for sending automated batch emails to multiple users (only active users), using queue and command

- **Admin Controls:**
  - API/command for admin to activate/deactivate users, including bulk operations

- **Validation & Error Handling:**
  - Input validation with clear error messages
  - Handle not found, unauthorized, and invalid status cases

- **Sample Data Seeding:**
  - Includes a sample admin account for login and API testing

## Notes
- All features are implemented as RESTful APIs or artisan commands, ready for integration with any frontend or external system.
- No user interface (UI) or frontend is included in this backend scope.
