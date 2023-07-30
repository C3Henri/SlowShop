# 🚀 SlowShop: Your Friendly Neighborhood Online Store 🛍

SlowShop is a Laravel-based API-only project for your shopping needs. It's designed to be a fun, flexible platform for online shopping - perfect for those lazy Sundays when you just want to shop from the comfort of your couch! This project includes both admin and client areas, allowing for a wide range of functionalities. SlowShop was created purely as a hobby project and a practice ground to keep skills sharp. So, please note that it might not follow some production-level best practices. But hey, we're all here to learn and improve, right? 😄

## 🏁 Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### 📋 Prerequisites

- Git
- Composer
- PHP >= 8.2
- MySQL >= 5.7

### ⏳ Installation

1. Clone the repo:
    ```
    git clone https://github.com/C3Henri/SlowShop.git
    ```

2. Change into the project directory:
    ```
    cd slowshop
    ```

3. Install PHP dependencies:
    ```
    composer install
    ```

4. Copy the example env file and make the required configuration changes in the `.env` file:
    ```
    cp .env.example .env
    ```

5. Generate a new application key:
    ```
    php artisan key:generate
    ```

6. Run the database migrations (Set the database connection in `.env` before migrating):
    ```
    php artisan migrate
    ```

7. Start the local development server:
    ```
    php artisan serve
    ```

You can now access the server at http://localhost:8000 🎉

## 👥 User Guide

There are two main areas in SlowShop: The **Admin Area** and the **Client Area**.

### Admin Area
- Admin users can manage products, categories, clients, and more.

### Client Area
- Clients can browse products, make orders, and post product reviews.

## 📨 Email Notifications

SlowShop comes with built-in email notifications to keep users informed. Here are the emails you can expect:

- Account activation: After signing up, users receive an email with a token to activate their account.
- Password recovery: If a user forgets their password, they can request a password recovery email with a token to reset their password.
- Password change confirmation: When a user changes their password, they receive an email confirmation for security purposes.

## 🙋‍♀️ Contributing

We welcome contributions from everyone. Please read our [contributing guidelines](CONTRIBUTING.md).

## 📜 License

The SlowShop project is open-source software licensed under the [MIT license](LICENSE.md).

## 📧 Contact

If you have any questions, feel free to reach out!

## 🎈 Enjoy Your Shopping with SlowShop! 🎈
