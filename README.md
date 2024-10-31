# Task Management System

This project is a task management system that allows users to manage tasks. Users can create tasks, assign them, and update the status of tasks. Additionally, notifications are sent to users at specific times.

## Features

- User registration and login.
- Admin users can create and assign tasks.
- Users can view tasks assigned to them.
- Update task status (completed or pending).
- Automatic notification to users one day before the task due date.
- Filter tasks by date.

## Requirements

- PHP >= 7.4
- Composer
- Laravel >= 8.x
- MySQL or another supported database
- Mail service (SMTP settings)

## Installation

1. **Clone the Project**

   ```bash
   git clone https://github.com/vahidzhe/task-managment
   cd project_name
2. **Install Dependencies**
    ```bash
    composer install
    ```
3. **Set Up Environment Variables**
   ```bash
    cp .env.example .env
    ```
    Then open the .env file and update the following settings:

    APP_NAME=Task Management System
    APP_ENV=local
    APP_KEY=base64:...
    APP_DEBUG=true
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.example.com
    MAIL_PORT=587
    MAIL_USERNAME=smtp_username
    MAIL_PASSWORD=smtp_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@example.com
    MAIL_FROM_NAME="${APP_NAME}"
4. **Set Up the Database**

    ```bash
    php artisan migrate
    ```
    Seed Example Data

    To add example data, run the following command:

    ```bash
    php artisan db:seed
    ```
5. **Install JWT Package**
    Install the required package for JWT-based authentication:
    ```bash
    composer require tymon/jwt-auth
6. **Set Up Queues**
    To handle notifications asynchronously, set the queue connection in your .env file:
    ```bash
    QUEUE_CONNECTION=database
    ```
    Run the queue worker using:
    
    ```bash
    php artisan queue:work
    ```
7. **Run the Scheduler**
   
   Start the task reminder scheduler to send notifications:

   ```bash
   php artisan schedule:work
   ```

8. **Start the Server** 

    To start the development server, run:
    ```bash
    php artisan serve
    ```