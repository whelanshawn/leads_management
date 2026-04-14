leads management system built with PHP, PostgreSQL, and Vue.

Tech
PHP (OOP + PDO)
PostgreSQL
Vue.js
WAMP (local setup)


Create Database
Create a database called: leads
and run these SQL commands to create the tables:

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password TEXT,
    role VARCHAR(10),
    deleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE leads (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    created_by INT,
    assigned_to INT,
    status VARCHAR(20) DEFAULT 'new',
    deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

-- Three default users, each with different role (password = P@55word)
Role 1 = Admin
Role 2 = Secretary 
Role 3 - General User
Default Password: P@55word

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@test.com', '$2y$10$F5ONkCtcHIsliRah2N188eaKw2zpPYy7kaoqTS8NTDGTaq5u8VjZu', 'role1'),
('Manager User', 'manager@test.com', '$2y$10$F5ONkCtcHIsliRah2N188eaKw2zpPYy7kaoqTS8NTDGTaq5u8VjZu', 'role2'),
('Basic User', 'user@test.com', '$2y$10$F5ONkCtcHIsliRah2N188eaKw2zpPYy7kaoqTS8NTDGTaq5u8VjZu', 'role3');

DB Config
config/db.php

$host = 'localhost';
$port = '5432';
$dbname = 'leads';
$username = 'postgres';
$password = 'postgres';


Start WAMP + PostgreSQL, then open:
http://localhost/Leads/

Users can:
Login
Create leads
View leads
Update leads
Delete leads
Admin users can also manage users.

Login
Default User Accounts:
Login:
admin@test.com
manager@test.com
user@test.com

Password for above accounts: P@55word
Roles
role1 → Admin
role2 → Manager
role3 → Basic
API (basic)

Auth:
POST /api/auth/login.php

Leads:
// intentionally left /api/leads/list.php unprotected to allow "guest view"
GET /api/leads/list.php
GET /api/leads/get.php?id=1
POST /api/leads/create.php
PUT /api/leads/update.php?id=1
DELETE /api/leads/delete.php?id=1

Users:
GET /api/users/list.php
POST /api/users/create.php
DELETE /api/users/delete.php?id=1


*** Please Note: ***
These would be the next steps if expanding the project.
Currently unable to assign leads. (currently auto-assigned to creator)
User validation is very basic (email format, user name, and password rules are not fully enforced)
When admin creates a user, default password is:P@55word (best would be an email to user to create a new password)
Only a basic last updated by has been implemented — not a full audit trail. A sql history table should be created recording all actions.
Dynamic Navbar
A real project would not include the config/db.php file (gitignore)



