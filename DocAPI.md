# API Documentation

## Auth APIs
| Method | Endpoint                       | Description                  | Auth      |
|--------|-------------------------------|------------------------------|-----------|
| POST   | /api/auth/register            | Register new user            | No        |
| POST   | /api/auth/login               | User login                   | No        |
| POST   | /api/auth/logout              | Logout (JWT)                 | Yes (JWT) |
| POST   | /api/auth/change_password     | Change password              | Yes (JWT) |
| POST   | /api/auth/reset_password      | Reset password               | No        |
| POST   | /api/auth/forgot_password     | Send reset password email    | No        |
| DELETE | /api/auth/delete_account/{id} | Delete account               | Yes (JWT) |

## Person APIs
| Method | Endpoint             | Description           | Auth      |
|--------|---------------------|-----------------------|-----------|
| GET    | /api/people         | List all people       | No        |
| POST   | /api/people         | Create person         | No        |
| GET    | /api/people/{id}    | Get person detail     | Yes (JWT) |
| PUT    | /api/people/{id}    | Update person         | Yes (JWT) |
| DELETE | /api/people/{id}    | Delete person         | Yes (JWT) |

## Admin APIs
| Method | Endpoint                        | Description                        | Auth (Admin) |
|--------|----------------------------------|-------------------------------------|--------------|
| GET    | /api/admin/unactive_person/{id}  | Deactivate a person by id           | Yes          |
| GET    | /api/admin/active_person/{id}    | Activate a person by id             | Yes          |
| GET    | /api/admin/unactive_all_person   | Deactivate all users (role=user)    | Yes          |
| GET    | /api/admin/active_all_person     | Activate all users (role=user)      | Yes          |
