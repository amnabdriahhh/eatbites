# EatBites 
## Restaurant Management System

## Description
EatBites is a comprehensive restaurant order tracking and management web application designed to streamline operations between customers, kitchen staff, and administrators. Customers scan QR codes at their tables to access the ordering platform, browse the menu, and place orders directly from their devices. Once orders are submitted, they are instantly visible to kitchen staff for preparation tracking and administrators for oversight. The platform facilitates real-time order processing, kitchen workflow management, and payment tracking within a unified ecosystem. Built with PHP and MySQL, EatBites provides an efficient digital solution for modern restaurant operations with role-based access control and responsive design.

## Features Included

### For Customers
- **Menu Discovery**: Browse and filter menu items across 5 categories (Western, Local, Desserts, Sides, Drinks).
- **Shopping Cart System**: Add items with quantity selection, modify cart contents, and view real-time totals.
- **Order Placement**: Submit orders with customer details and table number selection (1-30).
- **Responsive Design**: Optimized interface for desktop and mobile devices with light/dark theme support.

### For Kitchen Staff
- **Order Management**: View all incoming orders with real-time status updates.
- **Item Processing**: Mark individual items as completed or canceled, adjust quantities dynamically.
- **Filtering System**: Search orders by table number and filter by status (pending/preparing/completed/canceled).
- **Auto-Status Updates**: Automatic order status calculation based on item completion progress.

### For Administrators
- **Dashboard Analytics**: View statistics including total orders, revenue, and pending order counts.
- **Order Oversight**: Complete order history with detailed view and payment status management.
- **Staff Management**: Add, edit roles, and remove staff members (Admin/Kitchen roles).
- **Report Generation**: Export comprehensive PDF reports for orders and individual receipts.
- **Payment Tracking**: Update and monitor payment status (Paid/Unpaid) for all orders.

## How to Setup

### 1. Clone the Repository:
Download the project files to your local server directory (e.g., `htdocs` for XAMPP or `www` for WAMP).

### 2. Database Configuration:
- Open phpMyAdmin.
- Create a new database named `eatbites`.
- Import the provided SQL file: `eatbites__final_.sql`.
- The database includes pre-populated menu items (35 items), staff accounts, and sample orders.

### 3. Connection Setup:
The application uses standard XAMPP/WAMP credentials. Verify database connection in PHP files:
```php
$con = mysqli_connect("localhost", "root", "", "eatbites");
```

Update credentials if using different configuration:
- `$host = "localhost";`
- `$user = "root";`
- `$pass = "";`
- `$db = "eatbites";`

### 4. Directory Structure:
Ensure the following folders exist with proper permissions:
- `img/` - Contains logos and system images
- `menu/` - Contains menu item images (35 food images)

All images should be readable by the web server.

### 5. Launch:
Open your browser and navigate to:
```
http://localhost/eatbites/index.php
```

For customer access (no login required):
```
http://localhost/eatbites/homepage.php
```

## Credentials & Access

Access to the system is restricted based on user roles defined in the `users` table. The system checks the `$_SESSION['status']` variable to grant access to specific dashboards and features.

- **Admin Access**: Requires status = 'admin'. Grants full system access including dashboard, order management, staff management, and report generation.
- **Kitchen Access**: Requires status = 'kitchen'. Provides order processing interface with item status management and filtering capabilities.
- **Customer Access**: No authentication required. Public access to homepage, menu browsing, cart, and checkout.

## Demo Accounts

The following pre-configured accounts are available for testing. All passwords are stored using PHP's `password_hash()` function for security.

| Role    | Email Address      | Password  | Purpose                                          |
|---------|-------------------|-----------|--------------------------------------------------|
| Admin   | admin@gmail.com   | admin     | Test admin dashboard and management features     |
| Kitchen | kitchen@gmail.com | kitchen   | Test order processing and item status management |

### Optional: Quick Demo Setup
To create standardized demo accounts with password `123456`, navigate to:
```
http://localhost/eatbites/setup_demo.php
```

This creates:
- `admin_demo@eatbites.com` (Admin role)
- `kitchen_demo@eatbites.com` (Kitchen role)

**⚠️ Security Note**: These are demo accounts for testing only. In production, change all passwords, implement strong password policies, and remove demo accounts.

## Frameworks/Libraries Used

- **Core Language**: PHP 7.4+ (Server-side logic, session management, and MySQLi database operations).
- **Database**: MySQL/MariaDB 10.4+ (Relational data storage with 4 main tables: users, menu, orders, order_items).
- **Frontend Framework**: Bootstrap 5.3.8 (Responsive grid system, components, and utilities via CDN).
- **Styling**: CSS3 (Custom styling with CSS variables for theming, Flexbox/Grid layouts) and custom CSS files per page.
- **JavaScript**: Vanilla JS (Light/dark theme toggling, carousel functionality, and cart management).
- **PDF Generation**: Browser print functionality for receipts and order reports.
- **Security**: PHP `password_hash()` and `password_verify()` for secure authentication, session-based access control.

## Application Structure

The application follows a modular PHP architecture with role-based file organization:

**Authentication & Registration:**
`index.php`, `login_process.php`, `registration.php`, `registration_process.php`, `logout.php`, `setup_demo.php`

**Admin Interface:**
`admin.php`, `admin_order_view.php`, `manage_staff.php`, `export_orders_pdf.php`, `export_receipt_pdf.php`

**Kitchen Interface:**
`kitchen.php`, `kitchen_order_view.php`

**Customer Interface:**
`homepage.php`, `user_menu.php`, `cart.php`, `checkout.php`, `order_success.php`

**Database:**
`eatbites__final_.sql` (Contains schema, sample data, and 35 menu items)

**Assets:**
`img/` (logos and banners), `menu/` (35 food item images), CSS files (page-specific styling)

## Database Schema

EatBites uses a normalized relational database with the following structure:

| Table        | Key Fields                                                                 | Purpose                                        |
|--------------|---------------------------------------------------------------------------|------------------------------------------------|
| users        | id, name, email, password_hash, status, phone, address                    | Store staff accounts (admin/kitchen roles)     |
| menu         | id, name, description, price, category, image, status                     | Menu items (35 pre-loaded items in 5 categories) |
| orders       | id, customer_name, phone, table_no, total_price, order_status, payment_status, order_time | Customer orders with timestamps |
| order_items  | id, order_id, menu_id, menu_name, price, quantity, subtotal, item_status | Individual items per order with status tracking |

### Key Relationships:
- `order_items.order_id` → `orders.id` (Foreign key with CASCADE delete)
- Menu categories: western, local, desserts, sides, drinks
- Order status: pending, preparing, completed, canceled
- Item status: pending, completed, canceled
- Payment status: Paid, Unpaid

## Quick Start Guide

### Customer Workflow (No Login Required)
1. Navigate to `http://localhost/eatbites/homepage.php`
2. Click 'Order Now' or navigate to Menu
3. Browse items by category (All/Western/Local/Desserts/Sides/Drinks)
4. Select quantity and click 'Add to Cart'
5. Review cart and click 'Proceed to Checkout'
6. Fill in customer information and select table number
7. Click 'Place Order' - order is sent to kitchen

### Kitchen Staff Workflow
1. Login at `http://localhost/eatbites/index.php` with kitchen credentials
2. View orders dashboard (kitchen.php) - filter by status/table
3. Click 'View Order' on any order
4. Mark items as completed ✅ or canceled ❌
5. Adjust quantities using +/- buttons if needed
6. Order status updates automatically based on item completion

### Admin Workflow
1. Login at `http://localhost/eatbites/index.php` with admin credentials
2. View dashboard statistics (total orders, revenue, pending orders)
3. Click order ID to view full details and update payment status
4. Navigate to 'Staff' to manage team members and roles
5. Export reports via 'Export All Orders (PDF)' or individual receipts

## Troubleshooting

**Database Connection Error:**
Ensure MySQL service is running in XAMPP. Verify database name is 'eatbites' and credentials are correct (root with no password). Copy the eatbites SQL file and paste on the SQL section on phpmyadmin.

**Login Failed:**
Use demo accounts listed above. Clear browser cookies. Check user exists in database and password is correct.

**Images Not Displaying:**
Verify `img/` and `menu/` folders exist with all files. Check file permissions. Access via `http://localhost`, not `file://` protocol.

**PHP Code Displayed Instead of Executed:**
Ensure Apache is running. Access via `http://localhost/eatbites/`, not as file. Check PHP installation.

**Cart Not Updating:**
Enable sessions in PHP. Clear browser cookies. Check JavaScript is enabled in browser.

## System Information

| Property                  | Value                                    |
|---------------------------|------------------------------------------|
| Application Name          | EatBites Restaurant Management System    |
| Version                   | 1.0                                      |
| Database Name             | eatbites                                 |
| Default URL               | http://localhost/eatbites/               |
| Default DB User           | root                                     |
| Default DB Password       | (empty)                                  |
| Menu Items                | 35 items across 5 categories             |
| Supported Tables          | 1-30                                     |
| PHP Version Required      | 7.4 or higher                            |
| MySQL Version Required    | MySQL 5.7+ or MariaDB 10.4+              |

---

© 2026 EatBites Platform. All rights reserved.
