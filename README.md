<div align="center">

<h1>🍽️ E-Waiter 2.0</h1>

<p>
  <strong>A full-stack restaurant management system built with CodeIgniter 4</strong><br/>
  Manage tables, take orders, process bills, and track sales — all in one place.
</p>

<p>
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white"/>
  <img src="https://img.shields.io/badge/Razorpay-Integrated-02042B?style=for-the-badge&logo=razorpay&logoColor=white"/>
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge"/>
</p>

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Screenshots](#-screenshots)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Database Schema](#-database-schema)
- [Project Structure](#-project-structure)
- [Getting Started](#-getting-started)
- [User Roles & Workflows](#-user-roles--workflows)
- [Payment Integration](#-payment-integration)
- [Configuration](#-configuration)
- [License](#-license)

---

## 🧾 Overview

**E-Waiter 2.0** is a web-based restaurant management system designed to digitalize the end-to-end dining experience. It supports three distinct user roles — **Admin**, **Waiter**, and **Chef** — each with a dedicated interface and responsibility.

Waiters log in and select a table, browse the digital menu, and place orders. Chefs see incoming orders in real time and mark them prepared. Admins manage everything: the menu, staff accounts, restaurant branding, table count, and a rich analytics dashboard.

Bills are generated with itemized totals and support **Cash**, **UPI**, and **Card** payments via **Razorpay**, with automatic QR code generation for UPI. SMS notifications are powered by **Twilio**.

---

## 📸 Screenshots

### 1. Waiter Login
The entry point for all waiters. Displays the restaurant logo and a clean login form with session-based authentication.

![Waiter Login](screenshots/01-login.svg)

---

### 2. Table Dashboard
After login, the waiter sees a live table grid. **Yellow** tables are occupied; **cream** tables are available. Clicking a table sets the session and redirects to the menu. Supports dark mode.

![Table Dashboard](screenshots/02-table-dashboard.svg)

---

### 3. Menu Page
Full digital menu with scrollable category icons (Soups, Starter, Salads, Sabji, Roti, Drinks, Rice, Desserts). Each dish card shows its image, price, and a ± quantity control. A floating cart summary shows item count and running total.

![Menu Page](screenshots/03-menu.svg)

---

### 4. Billing & Payment
Auto-generated bill showing all ordered items with quantities, per-item price, GST, and grand total. The waiter selects a payment mode (Cash / UPI / Card) and clicks **Pay Now**. Razorpay handles UPI and Card; cash payments complete instantly. The bill can also be printed.

![Billing Page](screenshots/04-billing.svg)

---

### 5. Admin Dashboard
A dark-mode analytics dashboard with four KPI cards (today's sales, order count, active tables, monthly revenue) and three Chart.js charts: Sales by Date (bar), Top 10 Items Sold (horizontal bar), and Sales by Payment Mode (donut). Includes a live recent-transactions feed.

![Admin Dashboard](screenshots/05-admin-dashboard.svg)

---

### 6. Chef Dashboard
A clean order queue for the kitchen. Each row shows the order ID, item name, special notes, quantity, and table number. Chefs click **Prepared** to mark an item done; completed rows turn green and the button becomes disabled.

![Chef Dashboard](screenshots/06-chef-dashboard.svg)

---

### 7. Admin Menu Management
Full CRUD for the menu: add dishes with image upload, category, price, ingredients (JSON), and a "Trending" flag. Existing dishes can be edited or deleted from the table view. Supports categories: Soups, Starter, Salads, Sabji, Roti, Drinks, Rice, Desserts, and a custom "Other" option.

![Admin Menu Management](screenshots/07-admin-menu.svg)

---

## ✨ Features

### Waiter
- Secure session login with credential validation
- Live table grid showing available / occupied status
- Full digital menu browsable by category with images
- Add, update, and remove items from an active order
- Per-item special notes for the kitchen
- View current order summary before billing
- Generate itemized bill with GST calculation
- One-click payment processing (Cash, UPI, Card)

### Chef
- Dedicated login portal
- Real-time order queue (auto-refresh)
- Mark individual items as prepared
- Visual distinction between pending and completed items
- Special notes visible per order item

### Admin
- Secure admin login panel
- **Dashboard**: today's sales, order count, active tables, monthly revenue
- **Chart.js analytics**: sales trends, top-selling items, payment mode breakdown
- **Menu management**: add / edit / delete dishes, image upload, trending flag, ingredient tracking
- **Waiter management**: add / remove waiter accounts with credentials
- **Chef management**: add / remove chef accounts
- **Restaurant settings**: name, address, phone, logo, table count
- **Transaction log**: full daily transaction history with payment mode
- **Forgot password** via OTP (Twilio SMS)
- Dark mode across all Admin views

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | CodeIgniter 4 (PHP 8.1+) |
| **Database** | MySQL / MariaDB |
| **Frontend Styling** | Tailwind CSS (CDN) |
| **Charts** | Chart.js |
| **Payment Gateway** | Razorpay SDK v2.9 |
| **SMS / OTP** | Twilio SDK v8.5 |
| **QR Code Generation** | endroid/qr-code |
| **Dependency Manager** | Composer |
| **Testing** | PHPUnit 10 + FakerPHP |

---

## 🗄️ Database Schema

The project uses a single database (`sem6project`) with 7 tables:

```
admindetails          — Admin user credentials (id, username, password, phonenumber)
admin_control         — Restaurant settings (name, address, logo, table_count, etc.)
chefdetails           — Chef accounts (id, name, password)
waiterdetails         — Waiter accounts (id, waitername, password)
dishrate              — Menu items (id, itemname, itemprice, itemcategory, imgurl, itemingredient, isTrending)
tableorder            — Live orders (id, tableno, itemname, quantity, notes, served)
dailytransaction      — Completed bills (id, itemname, itemquantitie, total, paymentmode, tablenumber, datetime)
```

Import the included `sem6project.sql` file to get started with sample data.

---

## 📂 Project Structure

```
E-Waiter2.0/
├── app/
│   ├── Controllers/
│   │   ├── Home.php          # Waiter flows: login, tables, menu, orders, billing, payments
│   │   ├── Admin.php         # Admin flows: dashboard, dishes, waiters, chefs, settings
│   │   ├── Chef.php          # Chef flows: login, order queue, mark prepared
│   │   └── BaseController.php
│   ├── Models/
│   │   ├── AdminModel.php
│   │   ├── AdminControlModel.php
│   │   ├── DishModel.php
│   │   ├── OrderModel.php
│   │   ├── WaiterModel.php
│   │   ├── ChefModel.php
│   │   └── DailyTransactionModel.php
│   ├── Views/
│   │   ├── index.php              # Waiter login
│   │   ├── tablebook.php          # Table selection grid
│   │   ├── menu.php               # Digital menu
│   │   ├── vieworder.php          # Order summary
│   │   ├── billing.php            # Bill generation & payment
│   │   ├── chef.php               # Chef login
│   │   ├── chefdashboard.php      # Kitchen order queue
│   │   ├── admindashboard.php     # Admin analytics dashboard
│   │   ├── adminmenu.php          # Dish CRUD
│   │   ├── adminwaiter.php        # Waiter management
│   │   ├── adminchef.php          # Chef management
│   │   └── admincontrol.php      # Restaurant settings
│   ├── Config/
│   └── Filters/                   # Auth guards for each role
├── public/
│   ├── images/                    # Category images & food photos
│   └── uploads/                   # Logo & dish image uploads
├── sem6project.sql                # Full database dump with sample data
├── composer.json
└── README.md
```

---

## 🚀 Getting Started

### Prerequisites

- PHP **8.1** or higher with extensions: `intl`, `mbstring`, `mysqlnd`, `curl`, `json`
- **MySQL** or **MariaDB**
- **Composer** (dependency manager)
- A web server: **Apache** (with `mod_rewrite`) or **Nginx**, or PHP's built-in server for development

### Installation

**1. Clone the repository**
```bash
git clone https://github.com/DharmShah/E-Waiter2.0.git
cd E-Waiter2.0
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Set up the environment file**
```bash
cp env .env
```

Then open `.env` and configure:
```ini
# App
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

# Database
database.default.hostname = localhost
database.default.database = sem6project
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi
```

**4. Import the database**
```bash
mysql -u root -p sem6project < sem6project.sql
```
Or import via phpMyAdmin: create a database named `sem6project`, then import `sem6project.sql`.

**5. Set folder permissions**
```bash
chmod -R 775 writable/
chmod -R 775 public/uploads/
```

**6. Start the development server**
```bash
php spark serve
```

Visit **http://localhost:8080** in your browser.

### Default Credentials (from sample data)

| Role | Username | Password |
|---|---|---|
| Admin | `dharm` | `1234` |
| Waiter | `lala` | `lalala` |
| Chef | _(set via admin panel)_ | _(set via admin panel)_ |

> ⚠️ **Change all default passwords** before deploying to production.

---

## 👥 User Roles & Workflows

### Waiter Flow
```
/ (Login)  →  /tablebook (Select Table)  →  /menu (Browse & Order)
          →  /vieworder (Review)         →  /billing (Pay & Clear Table)
```

### Chef Flow
```
/chef (Login)  →  /chefdashboard (View Queue → Mark Prepared)
```

### Admin Flow
```
/admin (Login)  →  /admindashboard (Analytics)
               →  /adminmenu      (Add/Edit/Delete Dishes)
               →  /adminwaiter    (Manage Waiters)
               →  /adminchef      (Manage Chefs)
               →  /admincontrol   (Restaurant Settings, Logo, Table Count)
```

---

## 💳 Payment Integration

E-Waiter 2.0 integrates **Razorpay** for digital payment processing.

### Supported Modes

| Mode | Flow |
|---|---|
| **Cash** | Order is archived immediately, table is cleared |
| **UPI** | Razorpay generates a payment link + QR code; waiter shows it to customer |
| **Card** | Razorpay checkout is triggered via the frontend JS SDK |

### Setup

1. Create a [Razorpay account](https://razorpay.com) and get your API key pair.
2. Replace the test credentials in `app/Controllers/Home.php`:
   ```php
   $api = new Api('YOUR_KEY_ID', 'YOUR_KEY_SECRET');
   ```

> The project currently uses test-mode credentials. **Never commit live API keys to version control.**

---

## ⚙️ Configuration

### Twilio SMS (OTP / Forgot Password)
Used in the admin forgot-password flow. Configure your Twilio credentials inside the relevant controller method:
```php
use Twilio\Rest\Client;
$client = new Client('TWILIO_SID', 'TWILIO_AUTH_TOKEN');
```

### Restaurant Branding
From the Admin panel → **Restaurant Settings**, you can update:
- Restaurant name, address, phone number
- Logo (uploaded image used on login pages and bills)
- Total number of tables

### Adding Menu Categories
The admin panel supports predefined categories (Soups, Starter, Salads, Sabji, Roti, Drinks, Rice, Desserts) and a custom **"Other"** option where you can type a new category name.

---

## 🧪 Running Tests

```bash
composer test
```

Tests live in the `tests/` directory and use PHPUnit with FakerPHP for fixtures.

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

<div align="center">

Made with ❤️ by [DharmShah](https://github.com/DharmShah)

</div>
