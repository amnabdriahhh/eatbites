# 🍴 EatBites - Restaurant Ordering System

A modern, full-featured restaurant ordering and management system built with PHP and MySQL. EatBites provides a seamless experience for customers to browse menus and place orders, while giving restaurant staff powerful tools to manage orders and operations.

![EatBites](https://img.shields.io/badge/PHP-7.4+-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [User Roles](#user-roles)
- [Project Structure](#project-structure)
- [Usage Guide](#usage-guide)
- [Demo Accounts](#demo-accounts)
- [Screenshots](#screenshots)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### Customer Features
- **Browse Menu**: View categorized menu items (Western, Local, Desserts, Sides, Drinks)
- **Shopping Cart**: Add items to cart with quantity controls
- **Order Placement**: Easy checkout with customer details and table selection
- **Order Confirmation**: Success page with order confirmation
- **Dark Mode**: Toggle between light and dark themes
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices

### Admin Features
- **Dashboard**: Overview of all orders with status tracking
- **Order Management**: View, update payment status, and manage orders
- **Staff Management**: Add, edit roles (Admin/Kitchen), and remove staff members
- **Order Filtering**: Filter by status, table number, and payment status
- **PDF Export**: Generate and print order reports and receipts
- **Real-time Updates**: Live order status tracking

### Kitchen Staff Features
- **Order Queue**: View pending and active orders
- **Item Management**: Mark items as completed or canceled
- **Quantity Adjustment**: Modify item quantities before completion
- **Status Tracking**: Automatic order status updates based on item completion
- **Search & Filter**: Find orders by table number or status

---

## 💻 System Requirements

- **Web Server**: Apache 2.4+ or Nginx
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Browser**: Modern browser with JavaScript enabled (Chrome, Firefox, Safari, Edge)

### Recommended Environment
- **XAMPP** (Windows/Mac/Linux)
- **WAMP** (Windows)
- **MAMP** (Mac)
- **LAMP** (Linux)

---

## 🚀 Installation

### Step 1: Clone or Download the Project

```bash
# Clone the repository
git clone https://github.com/yourusername/eatbites.git

# Or download and extract the ZIP file to your web server directory
```

### Step 2: Move to Web Server Directory

Move the project folder to your web server's root directory:

- **XAMPP**: `C:\xampp\htdocs\eatbites`
- **WAMP**: `C:\wamp\www\eatbites`
- **MAMP**: `/Applications/MAMP/htdocs/eatbites`
- **Linux**: `/var/www/html/eatbites`

### Step 3: Start Your Web Server

Start Apache and MySQL services from your control panel (XAMPP/WAMP/MAMP).

---

## 🗄️ Database Setup

### Method 1: Using phpMyAdmin (Recommended)

1. Open phpMyAdmin in your browser: `http://localhost/phpmyadmin`
2. Click on **"New"** to create a new database
3. Enter database name: `eatbites`
4. Set collation to: `utf8mb4_general_ci`
5. Click **"Create"**
6. Select the `eatbites` database
7. Click on **"Import"** tab
8. Choose file: `eatbites__final_.sql`
9. Click **"Go"** to import

### Method 2: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE eatbites;

# Import the SQL file
mysql -u root -p eatbites < eatbites__final_.sql
```

### Database Configuration

The default database connection settings are in each PHP file:

```php
$con = mysqli_connect("localhost", "root", "", "eatbites");
```

If your MySQL has a different username/password, update this line in all PHP files.

---

## 👥 User Roles

EatBites has three user roles with different access levels:

| Role | Access | Capabilities |
|------|--------|--------------|
| **Admin** | Full access | Manage orders, staff, view reports, export PDFs |
| **Kitchen** | Kitchen dashboard | View orders, update item status, manage order queue |
| **Customer** | Public access | Browse menu, add to cart, place orders |

---

## 📁 Project Structure

```
eatbites/
│
├── index.php                    # Login page
├── registration.php             # Staff registration form
├── registration_process.php     # Registration handler
├── login_process.php            # Login authentication
├── logout.php                   # Logout handler
│
├── homepage.php                 # Customer homepage
├── user_menu.php               # Menu browsing page
├── cart.php                    # Shopping cart
├── checkout.php                # Order checkout
├── order_success.php           # Order confirmation
│
├── admin.php                   # Admin dashboard
├── admin_order_view.php        # Admin order details
├── manage_staff.php            # Staff management
├── export_orders_pdf.php       # Orders report PDF
├── export_receipt_pdf.php      # Order receipt PDF
│
├── kitchen.php                 # Kitchen dashboard
├── kitchen_order_view.php      # Kitchen order details
│
├── setup_demo.php              # Demo account setup
├── eatbites__final_.sql        # Database schema & data
│
├── img/                        # Images and logos
├── menu/                       # Menu item images
├── css/                        # Stylesheets
└── README.md                   # This file
```

---

## 📖 Usage Guide

### For Customers

1. **Browse Menu**
   - Visit `http://localhost/eatbites/homepage.php`
   - Click "Order Now" or navigate to Menu
   - Browse items by category (All, Western, Local, Desserts, Sides, Drinks)

2. **Add to Cart**
   - Select quantity using +/- buttons
   - Click "Add to Cart"
   - View cart counter in navigation

3. **Checkout**
   - Go to Cart page
   - Review items and quantities
   - Click "Proceed to Checkout"
   - Fill in customer details and table number
   - Click "Place Order"

### For Admin

1. **Login**
   - Visit `http://localhost/eatbites/index.php`
   - Enter admin credentials
   - Access admin dashboard

2. **Manage Orders**
   - View all orders with status filters
   - Click on order to view details
   - Update payment status
   - Export orders as PDF

3. **Manage Staff**
   - Navigate to Staff Management
   - View all staff members
   - Change staff roles (Admin/Kitchen)
   - Delete staff members

### For Kitchen Staff

1. **Login**
   - Visit `http://localhost/eatbites/index.php`
   - Enter kitchen credentials
   - Access kitchen dashboard

2. **Process Orders**
   - View pending orders
   - Click on order to see items
   - Mark items as completed (✅) or canceled (❌)
   - Adjust quantities if needed
   - Order status updates automatically

---

## 🔐 Demo Accounts

### Quick Setup Demo Accounts

Run the demo setup script: `http://localhost/eatbites/setup_demo.php`

This creates two demo accounts:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin_demo@eatbites.com | 123456 |
| Kitchen | kitchen_demo@eatbites.com | 123456 |

### Default Accounts (from database import)

| Role | Email | Password (hashed) |
|------|-------|-------------------|
| Admin | amna@gmail.com | Use registration to set |
| Kitchen | amalin@gmail.com | Use registration to set |

**Note**: For security, passwords are hashed. You can either:
- Run `setup_demo.php` for quick testing
- Register new accounts through the registration page

---

## 🖼️ Screenshots

### Customer Interface
- **Homepage**: Hero banner with best sellers showcase
- **Menu Page**: Categorized menu with add to cart functionality
- **Cart**: Shopping cart with quantity controls
- **Checkout**: Customer information and table selection

### Admin Dashboard
- **Overview**: Order statistics and recent orders
- **Order Management**: Detailed order view with payment status
- **Staff Management**: Add, edit, and remove staff members
- **Reports**: PDF export for orders and receipts

### Kitchen Dashboard
- **Order Queue**: Real-time order tracking
- **Item Management**: Individual item status control
- **Search & Filter**: Quick order lookup by table or status

---

## 🛠️ Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB
- **Frontend**: 
  - HTML5
  - CSS3 (Custom + Bootstrap 5.3.8)
  - JavaScript (ES6)
- **UI Framework**: Bootstrap 5.3.8
- **Icons**: Unicode emojis
- **Features**:
  - Session-based authentication
  - Password hashing (PHP password_hash)
  - Responsive design
  - Dark mode toggle
  - PDF generation

---

## 🎨 Customization

### Color Scheme

The project uses CSS custom properties for easy theming:

```css
:root {
    --dark-red: #8B0000;
    --yellow: #FFD700;
    --white: #FFFFFF;
}
```

Modify these values in your CSS files to change the color scheme.

### Menu Items

Add or modify menu items directly in the database:

```sql
INSERT INTO menu (name, description, price, category, image, status) 
VALUES ('Item Name', 'Description', 12.50, 'western', 'image.jpg', 'available');
```

### Table Numbers

Default: 30 tables (1-30)

To change, edit `checkout.php`:

```php
for ($i = 1; $i <= 50; $i++) { // Change 30 to 50 for 50 tables
    echo "<option value='$i'>$i</option>";
}
```

---

## 🔒 Security Considerations

- **Password Hashing**: All passwords are hashed using `password_hash()`
- **SQL Injection**: Use prepared statements for production (currently uses basic escaping)
- **Session Security**: Sessions are used for authentication
- **Role-based Access**: Pages check user role before granting access

### Recommended Security Improvements for Production:

1. Use prepared statements for all database queries
2. Implement CSRF protection
3. Add input validation and sanitization
4. Use HTTPS for production
5. Set strong session configurations
6. Implement rate limiting for login attempts

---

## 🐛 Troubleshooting

### Common Issues

**1. Database Connection Error**
- Check if MySQL is running
- Verify database name is `eatbites`
- Check username/password in connection string

**2. Images Not Loading**
- Ensure images are in correct folders (`img/` and `menu/`)
- Check file permissions
- Verify image paths in code

**3. Session Issues**
- Check if `session_start()` is at the top of PHP files
- Clear browser cookies/cache
- Verify PHP session configuration

**4. Dark Mode Not Persisting**
- Check browser's localStorage support
- Clear browser cache
- Check JavaScript console for errors

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Areas for Improvement

- [ ] Add user customer accounts
- [ ] Implement real-time order notifications
- [ ] Add order history for customers
- [ ] Integrate payment gateway
- [ ] Add inventory management
- [ ] Implement email notifications
- [ ] Add analytics dashboard
- [ ] Multi-language support

---

## 📝 License

This project is licensed under the MIT License - see below for details:

```
MIT License

Copyright (c) 2026 EatBites

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 📧 Contact & Support

- **Project Creator**: EatBites Development Team
- **Year**: 2026
- **Email**: support@eatbites.com (placeholder)

---

## 🎯 Roadmap

### Version 2.0 (Planned)
- [ ] Customer registration and login
- [ ] Order tracking for customers
- [ ] QR code menu scanning
- [ ] Table reservation system
- [ ] Digital payment integration
- [ ] Customer feedback system

### Version 3.0 (Future)
- [ ] Mobile app (iOS/Android)
- [ ] Multi-branch support
- [ ] Advanced analytics and reporting
- [ ] Loyalty program
- [ ] API for third-party integrations

---

## 🙏 Acknowledgments

- Bootstrap team for the excellent UI framework
- PHP community for documentation and support
- All contributors and testers

---

**Made with ❤️ by the EatBites Team**

*Last Updated: January 2026*
