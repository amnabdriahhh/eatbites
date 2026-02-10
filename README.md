# EatBites  
## Restaurant Management System

## Description
EatBites is a comprehensive restaurant order tracking and management web application designed to streamline operations between customers, kitchen staff, and administrators. Customers scan QR codes at their tables to access the ordering platform, browse the menu, and place orders directly from their devices. Once orders are submitted, they are instantly visible to kitchen staff for preparation tracking and administrators for oversight. The platform facilitates real-time order processing, kitchen workflow management, and payment tracking within a unified ecosystem. Built with PHP and MySQL, EatBites provides an efficient digital solution for modern restaurant operations with role-based access control and responsive design

---

## Features Included

### For Customers
- Menu Discovery: Browse and filter menu items across 5 categories (Western, Local, Desserts, Sides, Drinks).
- Shopping Cart System: Add items with quantity selection, modify cart contents, and view real-time totals.
- Order Placement: Submit orders with customer details and table number selection (1-30).
- Responsive Design: Optimized interface for desktop and mobile devices with light/dark theme support.

### For Kitchen Staff
- Order Management: View all incoming orders with real-time status updates.
- Item Processing: Mark individual items as completed or canceled, adjust quantities dynamically.
- Filtering System: Search orders by table number and filter by status (pending/preparing/completed/canceled).
- Auto-Status Updates: Automatic order status calculation based on item completion progress.

### For Administrators
- Dashboard Analytics: View statistics including total orders, revenue, and pending order counts.
- Order Oversight: Complete order history with detailed view and payment status management.
- Staff Management: Add, edit roles, and remove staff members (Admin/Kitchen roles).
- Report Generation: Export comprehensive PDF reports for orders and individual receipts.
- Payment Tracking: Update and monitor payment status (Paid/Unpaid) for all orders.

---

## How to Setup

### 1. Clone the Repository
Download the project files to your local server directory (e.g., htdocs for XAMPP or www for WAMP).

### 2. Database Configuration
- Open phpMyAdmin.
- Create a new database named `eatbites`.
- Import the provided SQL file: `eatbites__final_.sql`.
- The database includes pre-populated menu items (35 items), staff accounts, and sample orders.

### 3. Connection Setup
The application uses standard XAMPP/WAMP credentials. Verify database connection in PHP files:

```php
$con = mysqli_connect("localhost", "root", "", "eatbites");
