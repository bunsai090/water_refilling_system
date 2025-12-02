# Water Refilling Station Management System

A complete web-based management system for water refilling stations built with PHP, HTML, and CSS.

## Features

- **Landing Page**: Clean, modern landing page with hero section and features
- **Authentication**: Login system with session management
- **Dashboard**: Overview with sales stats, pending orders, and quick actions
- **Orders Management**: Track and manage customer orders
- **Payments**: Monitor payment transactions
- **Customers**: Manage customer database
- **Inventory**: Track bottle and water stock levels
- **Reports**: Generate and download business reports
- **Profile**: User profile and settings management

## Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Apache/Nginx web server (or WAMP/XAMPP)
- Web browser (Chrome, Firefox, Edge, Safari)

## Installation

1. **Clone or extract the project** to your web server directory:
   ```
   c:\wamp64\www\water_refilling_system\
   ```

2. **Create the database**:
   - Open phpMyAdmin or MySQL command line
   - Create a new database named `water_refilling_db`
   ```sql
   CREATE DATABASE water_refilling_db;
   ```

3. **Configure database connection**:
   - Open `config/database.php`
   - Update the database credentials if needed:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'water_refilling_db');
     ```

4. **Start your web server**:
   - If using WAMP: Start WAMP services
   - If using XAMPP: Start Apache and MySQL

5. **Access the application**:
   - Open your browser and navigate to:
     ```
     http://localhost/water_refilling_system/
     ```

## Usage

### Login
- Navigate to `http://localhost/water_refilling_system/login.php`
- Enter any username and password (demo mode accepts any credentials)
- Click "Sign In" to access the dashboard

### Navigation
- Use the sidebar to navigate between different sections:
  - Dashboard: Overview and quick stats
  - Orders: Manage customer orders
  - Payments: Track transactions
  - Customers: Customer database
  - Inventory: Stock management
  - Reports: Generate reports
  - Profile: User settings

## Project Structure

```
water_refilling_system/
│
├── index.php                -> Landing Page
├── login.php                -> Login Page
├── logout.php               -> Logout Script
│
├── dashboard/               -> Dashboard Pages
│   ├── index.php            -> Dashboard Home
│   ├── orders.php           -> Orders Management
│   ├── payments.php         -> Payments Tracking
│   ├── customers.php        -> Customer Management
│   ├── inventory.php        -> Inventory Management
│   ├── reports.php          -> Reports Generation
│   └── profile.php          -> User Profile
│
├── controllers/             -> Business Logic
│   └── AuthController.php   -> Authentication Handler
│
├── views/                   -> UI Components
│   └── components/
│       ├── header.php       -> Header Component
│       ├── sidebar.php      -> Sidebar Navigation
│       └── footer.php       -> Footer Component
│
├── config/
│   └── database.php         -> Database Configuration
│
├── public/                  -> Static Assets
│   ├── css/
│   │   └── style.css        -> Main Stylesheet
│   └── js/
│       └── main.js          -> JavaScript Functions
│
└── README.md                -> This file
```

## Design Features

- **Modern UI**: Clean, professional design with sky blue color scheme
- **Responsive**: Works on desktop and tablet devices
- **Icons**: SVG icons throughout the interface
- **Status Badges**: Color-coded badges for order and payment status
- **Data Tables**: Well-organized tables for data management
- **Form Validation**: Client-side validation for forms

## Technologies Used

- **Backend**: PHP
- **Frontend**: HTML5, CSS3
- **JavaScript**: Vanilla JavaScript (no frameworks)
- **Database**: MySQL/MariaDB
- **Design**: Custom CSS (no CSS frameworks)

## Color Scheme

- Primary: Sky Blue (#0ea5e9)
- Success: Green (#10b981)
- Warning: Yellow (#f59e0b)
- Danger: Red (#ef4444)
- Info: Blue (#3b82f6)

## Future Enhancements

- Database integration with actual CRUD operations
- User authentication with password hashing
- Email notifications
- PDF report generation
- Advanced analytics and charts
- Mobile responsive optimization
- Dark mode support

## License

This project is provided as-is for educational and commercial use.

## Support

For issues or questions, please contact the development team.
