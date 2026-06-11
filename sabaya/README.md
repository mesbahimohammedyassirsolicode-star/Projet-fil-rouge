# Sabaya Luxury

Sabaya Luxury is a PHP-based e-commerce web application for a modest fashion boutique selling abayas and related products. The project includes a customer-facing storefront, user authentication, shopping cart, checkout flow, wishlist, search, contact form, and a full admin panel for managing products, categories, orders, messages, and users.

## Features

- Homepage with product highlights
- Product catalog with categories and search
- Product detail pages
- Shopping cart and checkout
- Order history for logged-in users
- Wishlist functionality
- Contact form for customer messages
- User authentication: register, login, profile
- Admin panel:
  - Dashboard
  - Product CRUD
  - Category CRUD
  - Order management
  - Contact message management
  - User management
  - Statistics
- Multi-language support (French / English)

## Requirements

- PHP 8.x
- MySQL / MariaDB
- Web server (Apache, Nginx, or PHP built-in server)
- PDO extension enabled

## Installation

1. Clone or copy the project into your web server document root.
2. Create a MySQL database named `sabaya`.
3. Import the project database schema and seed data if available.
4. Update database credentials in `config/Database.php` if needed:

```php
private $host = "localhost";
private $db_name = "sabaya";
private $username = "root";
private $password = "";
```

5. Open the application in your browser: `http://localhost/sabaya/` or the appropriate local URL.

## Project Structure

- `index.php` — homepage
- `about.php` — about page
- `contact/contact.php` — contact form page
- `contact/send-message.php` — contact form handler
- `auth/` — authentication pages (`login.php`, `register.php`, `profile.php`, `logout.php`)
- `products/` — storefront pages, cart, checkout, orders, product details, search
- `wishlist/` — wishlist actions and page
- `admin/` — admin area with dashboards and management pages
- `assets/` — CSS, JavaScript, and images
- `includes/` — shared header, footer, navbar, toast container
- `config/` — database configuration and language loader
- `models/` — PHP model classes for database entities
- `lang/` — translation files

## Database

The project uses a MySQL database accessed through `config/Database.php`. The PDO connection is configured with `utf8mb4` and exception error mode.

## Localization

Language strings are defined in `lang/en.php` and `lang/fr.php`, and the current language is managed through `config/lang.php`.

## Notes

- This project is built with procedural PHP and uses PDO prepared statements for database access.
- The admin panel is not protected by a routing framework; access control is handled with PHP logic in each admin page.
- There is no composer dependency management or environment file by default.

## Recommendations

- Add CSRF protection for forms.
- Move database credentials to an environment configuration file.
- Add a `.env` or config file for easier deployment.
- Consider refactoring repetitive admin UI components into reusable includes.

## License

This project does not include a license file. Add a `LICENSE` if you want to specify usage terms.
