# alt.FPOS — Point-of-Sale System

A basic Point-of-Sale (POS) web application built with **CodeIgniter 4** and **PHP 8.x**. This is the first version of the system, featuring four pages with static PHP arrays as a temporary data source — no database is involved yet.

## Pages

| Page | Route | Description |
|------|-------|-------------|
| Home | `/` | Landing page with system overview and feature highlights |
| About | `/about` | Project details, tech stack, and development roadmap |
| Customer Accounts | `/customers` | Lists customer records (full name, email, phone) |
| User Accounts | `/users` | Lists staff/user records (username, full name, role) |

## Tech Stack

- **Framework:** CodeIgniter 4
- **Language:** PHP 8.x
- **Server:** XAMPP (Apache)
- **Dependencies:** Composer
- **Data Source:** Static PHP arrays (temporary)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/fabeyow/alt.FPOS.git
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file and configure:
   ```bash
   cp env .env
   ```
   Update `app.baseURL` in `.env` to match your local server path.

4. Open in your browser:
   ```
   http://localhost/codeigniter/TECHNICAL1/public/
   ```

## Project Structure

```
app/
├── Controllers/
│   ├── Pages.php          — Home and About pages
│   ├── Customers.php      — Customer Accounts (5 static records)
│   └── Users.php          — User Accounts (5 static records)
├── Views/
│   ├── layouts/main.php   — Shared layout with navigation
│   ├── pages/home.php     — Landing page
│   ├── pages/about.php    — About page
│   ├── customers/index.php — Customer listing table
│   └── users/index.php    — User listing table
└── Config/Routes.php      — Route definitions
```

## Sample Data

**Customers:** Maria Clara Santos, Juan Carlos Dela Cruz, Angela Mae Reyes, Roberto Miguel Torres, Patricia Anne Garcia

**Users:** admin_jose (Admin), mgr_carmela (Manager), cash_diego (Cashier), cash_liza (Cashier), staff_marco (Staff)

## Server Requirements

- PHP 8.2 or higher
- `intl` and `mbstring` PHP extensions
