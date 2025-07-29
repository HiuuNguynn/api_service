# API Documentation

## Auth APIs
| Method | Endpoint                       | Description                  | Auth      |
|--------|-------------------------------|------------------------------|-----------|
| POST   | /api/auth/login               | User login                   | No        |
| POST   | /api/auth/logout              | Logout (JWT)                 | Yes (JWT) |
| POST   | /api/auth/change_password     | Change password              | Yes (JWT) |
| POST   | /api/auth/reset_password      | Reset password               | No        |
| POST   | /api/auth/forgot_password     | Send reset password email    | No        |

## Person APIs
| Method | Endpoint                         | Description                 | Auth      |
|--------|----------------------------------|-----------------------------|-----------|
| GET    | /api/people/show_all_people      | List all people             | Yes (JWT) |
| PUT    | /api/people/update_user/{id}     | Update person               | Yes (JWT) |

## Admin APIs
| Method | Endpoint                        | Description                        | Auth (Admin) |
|--------|----------------------------------|-------------------------------------|--------------|
| POST   | /api/admin/register              | Register new admin                  | Yes          |
| POST   | /api/admin/set_role              | Set user role                       | Yes          |
| GET    | /api/admin/set_user/{id}         | Set user to default role            | Yes          |
| POST   | /api/admin/change_department     | Change user's department            | Yes          |
| GET    | /api/admin/restore_account/{id}  | Restore deleted user                | Yes          |
| GET    | /api/admin/export_users          | Export users to Excel               | Yes          |
| POST   | /api/admin/import_users          | Import users from Excel             | Yes          |
| GET    | /api/admin/users_deleted         | List deleted users                  | Yes          |
| GET    | /api/admin/send_emails_to_people | Send batch emails to users          | Yes          |
| DELETE | /api/admin/delete_account/{id}   | Delete user account                 | Yes          |
