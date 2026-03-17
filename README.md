# Pruden - Drinks Distribution Platform

A modern web application for Pruden, a drinks distribution company. Built with Laravel, PHP, and Bootstrap 5.

## Features

### Customer Website
- Browse products by category (Water, Juice, Soft Drinks, Energy Drinks)
- Filter by product unit type (liters, jerry cans, cartons)
- View detailed product information
- Add products to shopping cart
- Checkout with customer information
- Payment via Mobile Money (MTN & Airtel)
- Order receipts

### Admin Dashboard
- **Dashboard**: View key metrics (orders, revenue, products, low stock items)
- **Orders Management**: View all orders, update order status, view order details
- **Inventory Management**: Track stock levels, record production, adjust inventory
- **Products Management**: Create, edit, and manage products
- **Reports**: View production and sales reports for the last 30 days

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL/MariaDB (in WAMP)
- Laravel 12

### Step 1: Environment Setup
```bash
cd c:\wamp64\www\Proden

# Generate app key
php artisan key:generate
```

### Step 2: Database Configuration
Edit `.env` file and configure your database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pruden
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Create Database
```bash
# In MySQL/phpMyAdmin, create database:
CREATE DATABASE pruden CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 4: Run Migrations
```bash
php artisan migrate
```

### Step 5: Seed Admin User & Products
```bash
# Run the admin seeder
php artisan db:seed --class=AdminSeeder
```

This will create:
- **Admin Account** - Email: `admin@pruden.com`, Password: `admin123`
- **Sample Products** - Water, Juice, Soft Drinks, Energy Drinks

### Step 6: Start Development Server
```bash
php artisan serve
# The app will be available at: http://localhost:8000
```

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@pruden.com | admin123 |

⚠️ **IMPORTANT**: Change the admin password immediately after first login!

## Project Structure

**Models**: Product, Category, Order, Cart, Inventory  
**Controllers**: ProductController, CartController, OrderController, AdminController, InventoryController  
**Views**: Shop pages (products, cart, checkout), Admin dashboard (orders, inventory, products)

## Next Steps

1. **Database Setup**: Follow installation steps 1-5 above
2. **Authentication**: Login as admin@pruden.com / admin123
3. **Add Products**: Use admin dashboard to add/manage products
4. **Integrate Payments**: Connect Swap payment gateway for MTN & Airtel Mobile Money
5. **Customize**: Update company details, colors, and branding

## Support

For issues or questions, refer to the Laravel documentation at https://laravel.com/docs/12.x

---

**Version**: 1.0 | **Last Updated**: March 2026
