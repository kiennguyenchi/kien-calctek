# Kien Calctek

Kien Calctek is a modern, API-driven calculator built to demonstrate full-stack development principles. It features a reactive UI, a persistent "ticker tape" history, and support for both basic and complex mathematical expressions.

## 🚀 Features

- **API-Driven Architecture:** All calculations are processed on the backend via RESTful API endpoints.
- **Complex Expressions:** Handles basic operators (`+`, `-`, `*`, `/`) as well as complex chains with parentheses, exponents, and square roots (e.g., `sqrt((((9*9)/12)+(13-4))*2)^2`).
- **Ticker Tape History:** Real-time history of calculations that can be individually deleted or completely cleared.
- **Error Handling:** Gracefully catches invalid math syntax and division-by-zero errors, displaying friendly UI feedback without breaking the app.
- **Test Coverage:** Includes PHPUnit feature and unit tests for the API and calculation logic.

## 🛠️ Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Vue 3 (Composition API), Vite, Axios
- **Styling:** Tailwind CSS v4
- **Database:** SQLite (Chosen for easy portability and zero-config setup for reviewers)

## 📦 Requirements

Before you begin, ensure you have the following installed:

- [PHP 8.2+](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/)
- [Node.js & npm](https://nodejs.org/)

## ⚙️ Installation & Setup

Follow these steps to get the project running on your local machine.

**1. Clone the repository**

**2. Install PHP & Node dependencies**

```
composer install
```

```
npm install
```

**3. Configure Environment Variables**

Copy the example environment file:

```
cp .env.example .env
```

Generate application key:

```
php artisan key:generate
```

**4. Run Database Migrations**

```
php artisan migrate
```

**5. Running the application**

Backend:

```
php artisan serve
```

Frontend:

```
npm run dev
```

## 🧪 Running Tests

This application includes automated tests to ensure the calculation logic and API endpoints function correctly. To run the test suite:

```
php artisan test
```
