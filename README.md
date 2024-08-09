# Laravel Project Installation and Usage Guide

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Environment Setup](#environment-setup)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [API Routes](#api-routes)
- [Web Routes](#web-routes)
- [Testing Webhooks](#testing-webhooks)
- [Optimization](#optimization)
- [Notes](#notes)

## Requirements

Before you start, make sure your system meets the following requirements:

- PHP >= 8.0
- Composer
- MySQL or any other supported database
- Laravel 10.x

## Installation

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/your-repo/your-project.git
    cd your-project
    ```

2. **Install PHP Dependencies:**

    Run the following command to install Laravel and its dependencies:

    ```bash
    composer install
    ```



## Environment Setup

1. **Create `.env` File:**

    Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

2. **Generate Application Key:**

    Run the following command to generate the application key:

    ```bash
    php artisan key:generate
    ```

3. **Configure Environment Variables:**

    Open the `.env` file and update the following fields:

    ```dotenv
    APP_NAME="Your Project Name"
    APP_ENV=local
    APP_KEY=base64:generated-key
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    WEBHOOK_URL=http://127.0.0.1:8000/api/check/webhook
    ```

## Database Setup

1. **Create Database:**

    Create a database for your project in MySQL:

    ```sql
    CREATE DATABASE your_database_name;
    ```

2. **Run Migrations:**

    Run the following command to migrate the database:

    ```bash
    php artisan migrate
    ```

3. **Seed Database :**

    you can populate the database with initial data:

    ```bash
    php artisan db:seed
    ```

4. **Link Storage:**

   To link the storage directory for file uploads, run the following command:

   ```bash
   php artisan storage:link

## Running the Application

1. **Start the Development Server:**

    Run the following command to start the Laravel development server:

    ```bash
    php artisan serve
    ```


## API Routes

The following API routes are available:
https://documenter.getpostman.com/view/30494622/2sA3s3GB1Q

### Authentication
- `POST /api/register` - Register a new user.
- `POST /api/login` - Log in a user.

### Products
- `GET /api/products` - List all products.
- `GET /api/products/{id}` - Get a single product by ID.
- `GET /api/products/category` - List all categories.

### Webhooks
- `POST /api/check/webhook` - Test webhook integration.

### Authenticated Routes (Require Sanctum Authentication)
- User Profile Management
    - `POST /api/user/update-profile` - Update user profile.
    - `GET /api/user/get-profile` - Get user profile.
    - `POST /api/user/change-password` - Change user password.
    - `POST /api/user/logout` - Log out user.

- Address Management
    - `POST /api/address` - Add a new address.
    - `GET /api/address` - Get all user addresses.

- Order Management
    - `POST /api/orders` - Place a new order.
    - `PUT /api/orders/{id}/status` - Update the status of an order.

- Cart Management
    - `POST /api/carts` - Add items to the cart.
    - `POST /api/carts/update_quantity` - Update item quantity in the cart.
    - `GET /api/carts` - Get all cart items.
    - `DELETE /api/carts/{id}` - Remove an item from the cart.
    - `DELETE /api/carts` - Clear the entire cart.

## Web Routes

The following web routes are available:

### User Management
- `GET /user/register` - Show the registration form.
- `POST /user/store` - Register a new user.
- `GET /user/login` - Show the login form.
- `POST /user/login` - Log in a user.
- `GET /user/logout` - Log out a user.

### Cart Management
- `GET /cart` - View cart.
- `POST /cart/add-to-cart` - Add an item to the cart.
- `POST /cart/{id}/destroy` - Remove an item from the cart.
- `POST /cart/order-store` - Place an order from the cart.

### Products
- `GET /` - View home page.
- `GET /website` - View all products.
- `GET /website/products/{product}` - View a single product.
- `GET /website/category/{id}` - Filter products by category.
- `POST /website/products/{id}/get-price` - Get the price of a product.

## Testing Webhooks

If you are testing webhooks locally, consider using [ngrok](https://ngrok.com/) to expose your local server to the internet:

1. Install `ngrok` and start it:

    ```bash
    ngrok http 8000
    ```

2. Update the `WEBHOOK_URL` in `.env` with the ngrok URL:

    ```dotenv
    WEBHOOK_URL=http://<ngrok-id>.ngrok.io/api/check/webhook
    ```

## Optimization

To optimize the application for production, run the following command:

```bash
php artisan optimize
