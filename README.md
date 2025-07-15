# Tasker - PHP Task Management System

Tasker is a simple PHP-based task management system for administrators and users.

##  Features

- Admin can add, edit, and delete users
- Admin can assign tasks with deadlines
- Users can view and update task status
- Task statuses: Pending, In Progress, Completed
- Email notifications when a task is assigned

## Built With

- PHP 
- MySQL
- HTML/CSS + Vanilla JavaScript

## Setup Instructions

1. Clone the repository
2. Import the SQL dump from `/sql/task_manager.sql` into your database 
3. Update `config/db.php` with your DB credentials
4. Start your server (e.g., XAMPP or WAMP)
5. Visit: `http://localhost/Tasker/public/`

## Default Admin Credentials

- **Email**: `admin@task.local`  
- **Password**: `Admin@123`
