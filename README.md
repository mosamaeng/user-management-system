# User Management System

## Introduction
This User Management System is designed to handle user registration, authentication, and authorization. It provides a robust and secure way to manage user accounts and their roles within an application.

## Features
- User Registration
- User Login
- Password Reset
- Role-Based Access Control
- User Profile Management

## Installation

### Prerequisites
- PHP >= 7.4
- Composer
- MySQL

### Steps
1. **Install dependencies:**
    ```bash
    composer install
    ```

2. **Set up the database:**
    2. **Set up the database:**
        - Create a new MySQL database.
        - Update the database configuration in `config/db.php`.

    3. **Run migrations:**
        ```bash
        php yii migrate
        ```

    4. **Run Role-Based Access Control (RBAC) migrations:**
        ```bash
        php yii migrate --migrationPath=@yii/rbac/migrations/
        ```

4. **Start the application:**
    ```bash
    php yii serve
    ```

5. **Access the application:**
    Open your browser and navigate to `http://localhost:8080`.

## Default Credentials
- **Admin User:**
  - Username: `admin`
  - Password: `admin123`
