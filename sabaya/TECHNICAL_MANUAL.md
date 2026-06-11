# SABAYA LUXURY — Technical User Manual
## Complete Software Development Guide & Project Documentation

---

# Chapter 1 — Introduction

## 1.1 Project Overview

**Sabaya Luxury** is a full-stack e-commerce web application specialized in luxury abayas and modest fashion. It is built as a PHP/MySQL application following the **Model-View-Controller (MVC-inspired)** architecture. The application targets the Moroccan market and provides a bilingual experience (French/English).

The project serves two main audiences:
- **Customers** (Front Office): Browse products, manage a cart, place orders, maintain wishlists, and contact the store.
- **Administrators** (Admin Panel): Manage products, categories, orders, users, messages, and view business statistics.

## 1.2 Business Context

| Attribute         | Value                                  |
|--------------------|----------------------------------------|
| Project Name       | Sabaya Luxury                         |
| Domain             | E-commerce — Luxury Fashion (Abayas)  |
| Target Market      | Morocco (Casablanca / Tangier)        |
| Currency           | Moroccan Dirham (MAD / DH)           |
| Languages          | French (default), English             |
| Order Confirmation | WhatsApp integration                  |

## 1.3 Key Features

- User registration and authentication with bcrypt password hashing
- Product catalog with category filtering and search
- Shopping cart (session-based)
- Checkout process with transactional order creation
- Wishlist (favorites) management
- Contact form with admin message management
- Admin dashboard with KPIs, charts (Chart.js), and CRUD operations
- Bilingual i18n system with cookie/session persistence
- SEO optimization: meta tags, Open Graph, Twitter Cards, JSON-LD structured data
- Responsive design with mobile-first approach

---

# Chapter 2 — Technologies Used

## 2.1 Technology Stack

| Layer            | Technology                            |
|------------------|---------------------------------------|
| **Backend**      | PHP 8.x (procedural + OOP)           |
| **Database**     | MySQL (via PDO with prepared statements) |
| **Frontend**     | HTML5, CSS3, Vanilla JavaScript       |
| **CSS Framework**| Custom CSS (no framework)             |
| **Icons**        | Font Awesome 6.5.1                    |
| **Charts**       | Chart.js 4.4.4                        |
| **Fonts**        | Google Fonts (Poppins)                |
| **Server**       | Apache (XAMPP/WAMP local development) |

## 2.2 Design Patterns

| Pattern                 | Where Used                                |
|-------------------------|-------------------------------------------|
| **Data Access Object**  | `models/*.php` — each model wraps PDO queries |
| **Singleton-like**      | `Database.php` — single connection point  |
| **Flash Messages**      | `$_SESSION['_toast']` — one-time notifications |
| **Template Inclusion**  | `includes/header.php`, `navbar.php`, `footer.php` |
| **i18n Key-Value**      | `lang/fr.php`, `lang/en.php` with `t()` helper |

---

# Chapter 3 — Project Architecture

## 3.1 Directory Structure

```
sabaya/
├── config/               # Configuration files
│   ├── Database.php      # PDO database connection class
│   └── lang.php          # i18n system initialization
├── lang/                 # Translation files
│   ├── fr.php            # French translations (637 keys)
│   └── en.php            # English translations (640 keys)
├── models/               # Data Access Layer (Model classes)
│   ├── Product.php       # Product CRUD + search + category filter
│   ├── Category.php      # Category CRUD
│   ├── User.php          # User management + order history
│   ├── Order.php         # Order lifecycle (address, order, lines, status)
│   ├── Wishlist.php      # Wishlist add/remove/list
│   └── Contact.php       # Contact message CRUD
├── includes/             # Shared UI components
│   ├── header.php        # <head>, SEO meta, JSON-LD, CSS
│   ├── navbar.php        # Navigation bar with language switcher
│   ├── footer.php        # Footer with links, social, copyright
│   └── toast-container.php  # Flash message container
├── auth/                 # Authentication pages
│   ├── login.php         # Login form + session creation
│   ├── register.php      # Registration form + validation
│   ├── logout.php        # Session destruction
│   └── profile.php       # User profile editing
├── products/             # Product & order pages (Front Office)
│   ├── products.php      # Product listing + category filter
│   ├── product-details.php  # Single product page
│   ├── category.php      # Products by category (standalone)
│   ├── search.php        # Search results page
│   ├── add-cart.php      # Add to cart action
│   ├── cart.php          # Cart display
│   ├── remove-cart.php   # Remove from cart action
│   ├── checkout.php      # Checkout form + order creation
│   ├── order-success.php # Order confirmation + WhatsApp redirect
│   └── my-orders.php     # User's order history
├── wishlist/             # Wishlist management
│   ├── add-wishlist.php  # Add product to wishlist
│   ├── remove-wishlist.php  # Remove from wishlist
│   └── wishlist.php      # Display wishlist
├── contact/              # Contact system
│   ├── contact.php       # Contact form page
│   └── send-message.php  # Message submission handler
├── admin/                # Administration panel
│   ├── dashboard.php     # Admin dashboard with KPIs + charts
│   ├── products/         # Product CRUD (add, edit, delete, list)
│   ├── categories/       # Category CRUD (add, edit, delete, list)
│   ├── orders/           # Order management (list, details, update-status)
│   ├── users/            # User management (list, details, add, edit, delete)
│   ├── contact/          # Message management (list, view, delete)
│   └── statistics/       # Advanced statistics page
├── assets/               # Static resources
│   ├── css/              # Stylesheets
│   ├── images/           # Product/category images, logo
│   └── js/               # JavaScript files
├── index.php             # Homepage
└── about.php             # About page (brand story)
```

## 3.2 Architecture Diagram

```
┌─────────────────────────────────────────────────────┐
│                    BROWSER (Client)                   │
│  HTML5 + CSS3 + Vanilla JS + Font Awesome + Chart.js │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP Requests
                       ▼
┌─────────────────────────────────────────────────────┐
│                  PHP APPLICATION LAYER                │
│                                                       │
│  ┌───────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │  View      │  │  Controller  │  │   Model      │  │
│  │  (PHP +    │◄─┤  (Page PHP   │──►  (Data      │  │
│  │   HTML)    │  │   files)     │  │   Access)    │  │
│  └───────────┘  └──────────────┘  └──────┬───────┘  │
│                                            │          │
│  ┌──────────────────────────────────────────┤          │
│  │  config/  │  includes/  │  lang/         │          │
│  │  (Database.php, lang.php)                │          │
│  └──────────────────────────────────────────┘          │
└──────────────────────┬──────────────────────────────┘
                       │ PDO (Prepared Statements)
                       ▼
┌─────────────────────────────────────────────────────┐
│                  MySQL DATABASE                       │
│  Tables: client, produits, categorie, commande,      │
│          ligne_commande, adresse, wishlist, contact   │
└─────────────────────────────────────────────────────┘
```

## 3.3 Request Lifecycle

1. User sends an HTTP request (e.g., `GET /products/products.php`)
2. The PHP page initializes: `session_start()`, loads `Database.php`, instantiates models
3. Models query MySQL via PDO prepared statements
4. The page sets metadata variables (`$pageTitle`, `$pageDescription`, etc.)
5. `header.php` is included — outputs `<head>` with SEO meta, JSON-LD, CSS
6. `navbar.php` is included — outputs navigation with session-aware links
7. The page renders its specific HTML content
8. `footer.php` is included — outputs footer + global JS scripts
9. Response is sent to the browser

---

# Chapter 4 — Database Structure

## 4.1 Entity Relationship Diagram

```
┌──────────────┐       ┌──────────────────┐       ┌──────────────┐
│   categorie  │       │    produits      │       │   client     │
├──────────────┤       ├──────────────────┤       ├──────────────┤
│ id_categorie │◄──┐   │ id_produit       │   ┌──►│ id_client    │
│ nom          │   │   │ nom              │   │   │ nom          │
│ image        │   └───┤ id_categorie     │   │   │ prenom       │
└──────────────┘       │ description      │   │   │ email        │
                       │ prix             │   │   │ telephone    │
                       │ stock            │   │   │ password     │
                       │ image            │   │   │ role         │
                       │ taille           │   │   └──────────────┘
                       │ couleur          │   │
                       └────────┬─────────┘   │
                                │             │
                       ┌────────┴─────────┐   │
                       │  ligne_commande   │   │
                       ├──────────────────┤   │
                       │ id_ligne_commande│   │
                       │ qte              │   │
                       │ prix             │   │
                       │ id_commande  ────┤───┤
                       │ id_produit ──────┤───┘
                       └──────────────────┘
                                │
                       ┌────────┴─────────┐   ┌──────────────┐
                       │    commande      │   │   adresse     │
                       ├──────────────────┤   ├──────────────┤
                       │ id_commande      │   │ id_adresse   │
                       │ datecmd          │   │ ville        │
                       │ statuscmd        │   │ adresse      │
                       │ total            │   │ code_postal   │
                       │ id_client ───────┤──►│ id_client    │
                       │ id_adresse ──────┤──►└──────────────┘
                       └──────────────────┘

┌──────────────┐       ┌──────────────┐
│   wishlist   │       │   contact    │
├──────────────┤       ├──────────────┤
│ id_wishlist  │       │ id_contact   │
│ id_client    │       │ nom          │
│ id_produit   │       │ email        │
└──────────────┘       │ sujet        │
                       │ message      │
                       │ date_message │
                       │ id_client    │
                       └──────────────┘
```

## 4.2 Table Definitions

### `client` — Users/Customers
| Column     | Type         | Description              |
|------------|--------------|--------------------------|
| id_client  | INT (PK, AI) | Auto-increment primary key |
| nom        | VARCHAR      | Last name                |
| prenom     | VARCHAR      | First name               |
| email      | VARCHAR (UQ) | Unique email address     |
| telephone  | VARCHAR      | Phone number             |
| password   | VARCHAR      | Bcrypt-hashed password   |
| role       | ENUM         | 'client' or 'admin'      |

### `produits` — Products
| Column       | Type         | Description              |
|--------------|--------------|--------------------------|
| id_produit   | INT (PK, AI) | Auto-increment primary key |
| nom          | VARCHAR      | Product name             |
| description  | TEXT         | Product description      |
| prix         | DECIMAL      | Price in MAD             |
| stock        | INT          | Available quantity       |
| image        | VARCHAR      | Image filename           |
| taille       | VARCHAR      | Size (e.g., "Unique")    |
| couleur      | VARCHAR      | Color (e.g., "Noir")     |
| id_categorie | INT (FK)     | Reference to categorie   |

### `categorie` — Product Categories
| Column       | Type         | Description              |
|--------------|--------------|--------------------------|
| id_categorie | INT (PK, AI) | Auto-increment primary key |
| nom          | VARCHAR      | Category name            |
| image        | VARCHAR      | Category image (nullable)|

### `commande` — Orders
| Column      | Type         | Description                       |
|-------------|--------------|-----------------------------------|
| id_commande | INT (PK, AI) | Auto-increment primary key        |
| datecmd     | DATETIME     | Order date (NOW())                |
| statuscmd   | VARCHAR      | Status: En attente/Confirmée/Expédiée/Livrée/Annulée |
| total       | DECIMAL      | Order total amount                |
| id_client   | INT (FK)     | Customer who placed the order     |
| id_adresse  | INT (FK)     | Delivery address                  |

### `ligne_commande` — Order Line Items
| Column          | Type         | Description              |
|-----------------|--------------|--------------------------|
| id_ligne_commande| INT (PK, AI)| Auto-increment primary key |
| qte             | INT          | Quantity ordered         |
| prix            | DECIMAL      | Unit price at order time |
| id_commande     | INT (FK)     | Parent order             |
| id_produit      | INT (FK)     | Product reference        |

### `adresse` — Delivery Addresses
| Column      | Type         | Description              |
|-------------|--------------|--------------------------|
| id_adresse  | INT (PK, AI) | Auto-increment primary key |
| ville       | VARCHAR      | City                     |
| adresse     | VARCHAR      | Street address           |
| code_postal | VARCHAR      | Postal code              |
| id_client   | INT (FK)     | Owner of the address     |

### `wishlist` — User Favorites
| Column      | Type         | Description              |
|-------------|--------------|--------------------------|
| id_wishlist | INT (PK, AI) | Auto-increment primary key |
| id_client   | INT (FK)     | User who saved the item  |
| id_produit  | INT (FK)     | Saved product            |

### `contact` — Contact Messages
| Column       | Type         | Description              |
|--------------|--------------|--------------------------|
| id_contact   | INT (PK, AI) | Auto-increment primary key |
| nom          | VARCHAR      | Sender's name            |
| email        | VARCHAR      | Sender's email           |
| sujet        | VARCHAR      | Message subject          |
| message      | TEXT         | Message body             |
| date_message | DATETIME     | Timestamp (NOW())        |
| id_client    | INT (FK, nullable) | Logged-in user (nullable for guests) |

---

# Chapter 5 — Authentication System

## 5.1 Overview

The authentication system uses **PHP sessions** and **bcrypt password hashing**. It is spread across four files in the `auth/` directory.

## 5.2 File-by-File Analysis

### `auth/login.php` — Login Page

**Purpose:** Authenticates users and creates sessions.

**Workflow:**
1. Display login form (email + password)
2. On POST: validate inputs, query `client` table by email
3. Verify password with `password_verify($password, $user['password'])`
4. On success: call `session_regenerate_id(true)` to prevent session fixation
5. Store user data in `$_SESSION`: `user_id`, `user_name`, `user_email`, `user_phone`, `role`
6. Redirect admin to `admin/dashboard.php`, regular users to `index.php`
7. Set flash toast message via `$_SESSION['_toast']`

**Security mechanisms:**
- `session_regenerate_id(true)` — prevents session fixation attacks
- `password_verify()` — constant-time bcrypt comparison
- Prepared statements — prevents SQL injection
- Role-based redirect — admin vs. client

**Session variables created:**
```php
$_SESSION['user_id']    // int — client ID
$_SESSION['user_name']  // string — "nom prenom"
$_SESSION['user_email'] // string — email
$_SESSION['user_phone'] // string — phone
$_SESSION['role']       // string — 'client' or 'admin'
```

### `auth/register.php` — Registration Page

**Purpose:** Creates new user accounts.

**Validation rules:**
- `nom`, `prenom`: required, letters only (regex: `/^[a-zA-ZÀ-ÿ\s]+$/u`)
- `email`: required, valid format (`filter_var`), unique in database
- `phone`: required, digits only, 10-14 characters
- `password`: required, minimum 8 characters, must match `confirme`

**Security:** Password is hashed with `password_hash($password, PASSWORD_DEFAULT)` before storage.

**What happens if removed:** No new users could register. The entire e-commerce flow would break since checkout requires authentication.

### `auth/logout.php` — Logout

**Purpose:** Destroys the user session.

```php
session_start();
session_unset();     // Remove all session variables
session_destroy();   // Destroy the session data on server
header("Location: login.php");
```

### `auth/profile.php` — User Profile

**Purpose:** Allows logged-in users to view and edit their personal information.

**Access control:** Redirects to login if `$_SESSION['user_id']` is not set.

**Features:**
- Displays avatar with user initials
- Edit form: name, email, phone
- Email uniqueness check (excludes current user)
- Updates session variables after successful save
- Sidebar links to cart, wishlist, and orders

---

# Chapter 6 — Front Office

## 6.1 Homepage (`index.php`)

**What it does:** Landing page featuring a hero section and the 8 newest products.

**Workflow:**
1. Instantiate `Product` and `Category` models
2. Fetch all products, take the first 8 with `array_slice()`
3. Render hero section with translated text
4. Render product grid with images, names, prices, and "See details" links

**Database operations:**
- `Product::getAll()` — `SELECT produits.*, categorie.nom FROM produits INNER JOIN categorie ... ORDER BY id_produit DESC`
- `Category::getAll()` — for potential navigation use

**SEO:** Sets `$pageTitle`, `$pageDescription`, `$pageKeywords` for meta tags.

## 6.2 About Page (`about.php`)

**What it does:** Brand storytelling page with 6 sections: Hero, Story, Mission, Values, Why Choose Us, and Call to Action.

**Key feature:** Entirely content-driven via i18n keys — no database queries needed. All text comes from `lang/fr.php` or `lang/en.php`.

**JSON-LD:** Outputs `AboutPage` schema with `Organization` mainEntity.

---

# Chapter 7 — Admin Panel

## 7.1 Architecture

The admin panel lives in `admin/` and uses its **own layout** (not the shared `header.php`/`footer.php`). Each admin page includes:
- Its own local `<!DOCTYPE html>` and `<head>`
- A sidebar navigation (duplicated in each file)
- Admin-specific CSS (`admin.css`)
- Session-based access control

**Access control pattern (used in every admin file):**
```php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit();
}
```

## 7.2 Dashboard (`admin/dashboard.php`)

**Purpose:** Central admin hub displaying KPIs, charts, and quick actions.

**Statistics computed:**
| Metric         | SQL Query                                    |
|----------------|----------------------------------------------|
| Total Products | `SELECT COUNT(*) FROM produits`              |
| Total Orders   | `SELECT COUNT(*) FROM commande`              |
| Total Clients  | `SELECT COUNT(*) FROM client`                |
| Total Messages | `SELECT COUNT(*) FROM contact`               |
| Total Revenue  | `SELECT SUM(total) FROM commande WHERE statuscmd != 'Annulée'` |
| Monthly Data   | `GROUP BY DATE_FORMAT(datecmd, '%Y-%m')` for last 12 months |

**Chart:** Dual-axis Chart.js line chart showing orders count (left Y-axis) and revenue (right Y-axis) over time.

**Quick actions:** Links to add product, add category, view orders, view clients.

**Recent orders table:** Last 5 orders with client name, date, status badge, and amount.

**Top products:** Best-selling products ranked by `SUM(ligne_commande.qte)`.

## 7.3 Statistics Page (`admin/statistics/index.php`)

**Purpose:** Deeper analytics with business insights.

**Additional metrics:**
- Average order value: `$totalRevenue / $totalOrders`
- Orders by status breakdown
- Products per category average
- Orders per client ratio
- Revenue per client

**Insight cards:** Catalogue, Orders Activity, Client Growth, Store Performance.

---

# Chapter 8 — Product Management

## 8.1 Model: `Product.php`

**Class:** `Product` — encapsulates all product database operations.

| Method              | Purpose                              | Parameters                     |
|---------------------|--------------------------------------|--------------------------------|
| `getAll()`          | Fetch all products with category name | None                           |
| `find($id)`         | Get single product by ID             | `$id` — product ID             |
| `create(...)`       | Insert new product                   | 8 parameters (name, desc, price, stock, image, size, color, category) |
| `update(...)`       | Update existing product              | 9 parameters (ID + 8 fields)   |
| `delete($id)`       | Remove product                       | `$id` — product ID             |
| `search($keyword)`  | Search products by name (LIKE)       | `$keyword` — search term       |
| `getByCategory($id)`| Filter products by category          | `$id_categorie`                |

**All methods use PDO prepared statements** to prevent SQL injection.

## 8.2 Admin Product CRUD

### `admin/products/list.php`
- Displays all products in a responsive table
- Shows stock status badges: In Stock (green), Low Stock ≤5 (orange), Out of Stock (red)
- Search bar filters products by name
- Action buttons: View (opens front-office detail), Edit, Delete (with JS confirm)
- Stats cards: Total, Active, Low Stock, Categories

### `admin/products/add.php`
- Form with drag-and-drop image upload
- Client-side image preview via `FileReader` API
- Server-side validation: all fields required, price > 0, stock ≥ 0
- Image saved as `timestamp_filename` to prevent collisions
- Uses `enctype="multipart/form-data"` for file upload

### `admin/products/edit.php`
- Pre-filled form with existing product data
- Same validation as add
- Option to replace image or keep current one

### `admin/products/delete.php`
- Receives product ID via GET
- Executes `Product::delete()` and redirects to list

---

# Chapter 9 — Category Management

## 9.1 Model: `Category.php`

| Method            | Purpose                     |
|-------------------|-----------------------------|
| `getAll()`        | All categories, sorted A-Z  |
| `find($id)`       | Single category by ID       |
| `findByName($nom)`| Single category by name     |
| `create($nom, $image)` | Insert new category    |
| `update($id, $nom, $image)` | Update category (image optional) |
| `delete($id)`     | Remove category             |

**Conditional update logic:** If `$image` is null, only the name is updated. This prevents overwriting existing images when editing just the name.

## 9.2 Admin Category CRUD

Files: `admin/categories/add.php`, `edit.php`, `delete.php`, `list.php`

Same pattern as products: form with image upload, table listing, confirmation before delete.

---

# Chapter 10 — Wishlist System

## 10.1 Model: `Wishlist.php`

| Method                  | Purpose                              |
|-------------------------|--------------------------------------|
| `add($id_client, $id_produit)` | Add to wishlist (with duplicate check) |
| `getUserWishlist($id_client)`  | Fetch user's saved products with JOIN |
| `delete($id, $id_client)`      | Remove item (scoped to user for security) |

**Duplicate prevention:**
```php
$check = $this->pdo->prepare("SELECT id_wishlist FROM wishlist WHERE id_client = :id_client AND id_produit = :id_produit");
$check->execute([...]);
if ($check->fetch()) { return true; } // Already exists, skip INSERT
```

## 10.2 Workflow

1. User clicks heart icon on product details → `wishlist/add-wishlist.php?id=X`
2. Requires login (redirects to `login.php` if not authenticated)
3. Model checks for duplicate, inserts if new
4. Flash toast: "Produit ajouté à votre liste de souhaits"
5. Redirect to `products.php`

**Removal:** `wishlist/remove-wishlist.php?id=X` — deletes by wishlist ID **AND** client ID (prevents cross-user deletion).

---

# Chapter 11 — Cart System

## 11.1 Architecture

The cart is **session-based** — no database table. Products are stored as an associative array:

```php
$_SESSION['cart'] = [
    5 => 2,   // Product ID 5, quantity 2
    12 => 1,  // Product ID 12, quantity 1
];
```

## 11.2 Operations

### Add to Cart (`products/add-cart.php`)
```php
$id = (int) $_GET['id'];           // Sanitize input
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;        // Increment if exists
} else {
    $_SESSION['cart'][$id] = 1;      // Add with qty 1
}
```
- No login required (guests can use cart)
- Flash toast on success
- Redirect to `cart.php`

### Display Cart (`products/cart.php`)
- Iterates `$_SESSION['cart']`, fetches each product from database
- Calculates subtotals: `$product['prix'] * $quantite`
- Shows total sum
- Empty state with "Discover collection" CTA
- Links: Remove item, Checkout, Continue shopping

### Remove from Cart (`products/remove-cart.php`)
```php
$id = (int) $_GET['id'];
if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);   // Remove item
}
```

### Cart Badge (Navbar)
```php
$cartCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cartCount = array_sum($_SESSION['cart']);  // Sum all quantities
}
```
The badge appears next to the bag icon when `$cartCount > 0`.

---

# Chapter 12 — Checkout Process

## 12.1 Overview

The checkout is the most complex business flow, implemented in `products/checkout.php`.

**Prerequisites:**
- User must be logged in (`$_SESSION['user_id']` required)
- Cart must not be empty

## 12.2 Workflow Diagram

```
User fills shipping form (city, address, postal code)
        │
        ▼
Server validates inputs + checks stock availability
        │
        ├── Errors → Display error messages, re-show form
        │
        ▼
Begin Database Transaction
        │
        ├── 1. INSERT into adresse (delivery address)
        ├── 2. INSERT into commande (order with status "En attente")
        ├── 3. For each cart item:
        │      ├── INSERT into ligne_commande (order line)
        │      └── UPDATE produits SET stock = stock - quantity
        │
        ├── Any failure → ROLLBACK
        │
        ▼
COMMIT Transaction
        │
        ▼
Build WhatsApp message with order details
        │
        ▼
Clear cart: unset($_SESSION['cart'])
        │
        ▼
Redirect to order-success.php?order_id=X
        │
        ▼
User clicks "Send via WhatsApp" → opens wa.me link with pre-filled message
```

## 12.3 Transaction Safety

```php
try {
    $orderModel->beginTransaction();
    
    $id_adresse = $orderModel->createAddress(...);
    if (!$id_adresse) throw new Exception("...");
    
    $id_commande = $orderModel->createOrder(...);
    if (!$id_commande) throw new Exception("...");
    
    foreach ($cart as $id_produit => $quantite) {
        $orderModel->createOrderLine(...);
        // UPDATE stock
    }
    
    $orderModel->commit();
} catch (Exception $e) {
    $orderModel->rollBack();  // All changes undone
    $errors[] = t('checkout_err_generic');
}
```

**Why transactions matter:** If the order is created but a line item fails (e.g., product deleted mid-checkout), the entire operation is rolled back. No partial orders can exist.

## 12.4 Stock Verification

Before creating the order, each product's stock is checked:
```php
if ($product['stock'] < $quantite) {
    $errors[] = "Stock insufficient for {product}";
}
```

## 12.5 WhatsApp Integration

After successful order:
```php
$whatsappLink = "https://wa.me/212613623407?text=" . urlencode($message);
```
The message includes: order ID, product list with quantities, total, and delivery city.

---

# Chapter 13 — Order Management

## 13.1 Customer View (`products/my-orders.php`)

- Lists all orders for the logged-in user
- Status badges with color coding:
  - `En attente` → pending (yellow)
  - `Confirmée` → confirmed (blue)
  - `Expédiée` → shipped (purple)
  - `Livrée` → delivered (green)
  - `Annulée` → cancelled (red)

## 13.2 Admin View (`admin/orders/list.php`)

- Lists all orders with client name, date, total, status
- Search by order ID, client name, or status
- Stats cards: Total, Pending, Confirmed, Delivered
- Actions: View details, Update status

## 13.3 Order Status Update (`admin/orders/update-status.php`)

- Visual radio-button selector for statuses
- Hidden `<select>` fallback for accessibility
- JavaScript syncs visual selector with hidden form field
- Toast notification on successful update

## 13.4 Model: `Order.php`

| Method                          | Purpose                           |
|---------------------------------|-----------------------------------|
| `createAddress(...)`            | INSERT delivery address, returns ID |
| `createOrder(...)`              | INSERT order with "En attente" status |
| `createOrderLine(...)`          | INSERT line item                  |
| `beginTransaction/commit/rollBack` | Transaction control            |
| `getUserOrders($id_client)`     | Fetch user's orders               |
| `getAllOrders()`                | Fetch all orders with client JOIN |
| `getOrderById($id)`             | Single order with client details  |
| `getOrderItems($id_commande)`   | Line items with product details   |
| `updateStatus($id, $status)`    | Update order status               |

---

# Chapter 14 — Statistics Dashboard

## 14.1 Dashboard KPIs

The dashboard uses **animated counters** powered by `counter.js`:

```html
<span class="counter" data-count="1234" aria-label="1234 produits">0</span>
```

**Counter.js features:**
- `IntersectionObserver` — only animates when visible (25% threshold)
- Ease-out quadratic easing for smooth deceleration
- Configurable: decimals, separators, suffix, duration
- `requestAnimationFrame` for 60fps animation
- Accessibility: `aria-label` set to final value immediately

## 14.2 Charts

Dual-axis Chart.js line chart:
- **Left Y-axis:** Number of orders (gold color `#C5AD59`)
- **Right Y-axis:** Revenue in DH (dark color `#1A1A1A`)
- **X-axis:** Months (`YYYY-MM` format)
- Data: Last 12 months, excluding cancelled orders

---

# Chapter 15 — Contact System

## 15.1 Contact Form (`contact/contact.php`)

**Features:**
- Two-column layout: contact info + form
- Available to both guests and logged-in users
- Validation: name (letters only), email (valid format), subject, message (all required)
- Stores `id_client` if logged in, `null` for guests
- Success redirect with `?success=1` parameter

**JSON-LD:** `ContactPage` schema with `ClothingStore` mainEntity, including address, hours, and contact details.

## 15.2 Alternative Handler (`contact/send-message.php`)

A simpler POST handler that requires login. The main `contact.php` handles both display and submission, making this file a legacy/alternative endpoint.

## 15.3 Admin Message Management

- `admin/contact/list.php` — Table of all messages
- `admin/contact/view.php` — Read individual message
- `admin/contact/delete.php` — Remove message

---

# Chapter 16 — Internationalization (i18n) System

## 16.1 Architecture

The i18n system is built around three components:

### `config/lang.php` — Language Resolver

**Language resolution priority:**
1. `$_GET['lang']` — URL parameter (e.g., `?lang=en`)
2. `$_SESSION['lang']` — Session variable
3. `$_COOKIE['sabaya_lang']` — Cookie (30-day persistence)
4. Default: `'fr'`

**Key function: `t($key, $fallback)`**
```php
function t(string $key, ?string $fallback = null): string {
    // 1. Check active language
    if (isset($lang[$key])) return $lang[$key];
    
    // 2. Fallback to French
    if ($activeLang !== 'fr') {
        // Load fr.php if not already loaded
        if (isset($frLang[$key])) return $frLang[$key];
    }
    
    // 3. Return fallback or key itself
    return $fallback ?? $key;
}
```

### `lang/fr.php` — French (637 translation keys)
### `lang/en.php` — English (640 translation keys)

Both files define a `$lang` associative array. Keys are organized by section:
- Navigation & Global
- Homepage
- Products Page
- Product Details
- Cart
- Checkout
- Orders
- Wishlist
- Contact
- Authentication (Login/Register)
- Profile
- About
- Footer
- Admin Panel

## 16.2 Language Switcher (Navbar)

```php
<a href="<?= $currentUrl ?>?lang=fr" class="lang-btn<?= $activeLang === 'fr' ? ' lang-btn--active' : '' ?>">FR</a>
<a href="<?= $currentUrl ?>?lang=en" class="lang-btn<?= $activeLang === 'en' ? ' lang-btn--active' : '' ?>">EN</a>
```

Preserves existing query parameters when switching languages.

---

# Chapter 17 — SEO & GEO (Generative Engine Optimization)

## 17.1 Meta Tags (Every Page)

Each page sets before including `header.php`:
```php
$pageTitle       = '...';
$pageDescription = '...';
$pageKeywords    = '...';
$pageImage       = '...';    // OG image
$canonicalUrl    = '...';    // Self-referencing canonical
$pageRobots      = '...';    // e.g., 'noindex, nofollow' for private pages
$ogType          = '...';    // 'website' or 'product'
```

## 17.2 Structured Data (JSON-LD)

### Global (all pages via `header.php`):
- **Organization** schema: name, logo, contact, address
- **WebSite** schema with **SearchAction** (enables Google sitelinks search box)

### Page-specific:
| Page               | Schema Type        | Key Properties                    |
|--------------------|--------------------|-----------------------------------|
| `products.php`     | `ItemList`         | Product list with positions       |
| `product-details.php` | `Product`      | Name, price (MAD), brand, color, size, availability |
| `search.php`       | `SearchResultsPage` + `ItemList` | Search results as structured list |
| `about.php`        | `AboutPage`        | Organization mainEntity           |
| `contact.php`      | `ContactPage`      | ClothingStore with hours, address |
| `wishlist.php`     | `CollectionPage`   | Number of items                   |

## 17.3 Open Graph & Twitter Cards

```html
<meta property="og:title" content="...">
<meta property="og:description" content="...">
<meta property="og:image" content="...">
<meta property="og:url" content="...">
<meta name="twitter:card" content="summary_large_image">
```

## 17.4 SEO Best Practices Applied

- `noindex, nofollow` on private pages (cart, checkout, profile, admin)
- Canonical URLs on all pages
- `loading="lazy"` on all product images
- Semantic HTML5 (`<main>`, `<article>`, `<nav>`, `<section>`, `<time>`)
- ARIA labels and roles for accessibility
- `<link rel="preconnect">` for Google Fonts performance

---

# Chapter 18 — JavaScript Features

## 18.1 `main.js` — Site-wide Scripts

**Mobile navigation toggle:**
- Toggles `.active` class on `#mobile-nav`
- Updates `aria-expanded` attribute
- Auto-closes when a link is clicked

**Scroll reveal animations:**
```javascript
const reveals = document.querySelectorAll('.reveal');
// On scroll: if element top < windowHeight - 100px → add 'active' class
```
Elements with `.reveal` class fade in when they enter the viewport.

## 18.2 `toast.js` — Notification System

**Architecture:** IIFE (Immediately Invoked Function Expression) exposing `window.SabayaToast`.

**Public API:**
```javascript
SabayaToast.show(message, type, title);
SabayaToast.success('Product added!');
SabayaToast.error('Something went wrong');
```

**Auto-fire mechanism:** On `DOMContentLoaded`, checks `#toast-container` for `data-flash-message` attribute (injected by PHP via `toast-container.php`). If present, automatically displays the toast.

**Features:**
- Auto-dismiss after 3000ms
- Click/keyboard dismiss (Enter, Escape)
- HTML escaping to prevent XSS
- Progress bar animation
- `aria-live="polite"` for screen readers

## 18.3 `counter.js` — Animated KPI Counters

(Described in Chapter 14.1)

## 18.4 `product-hover.js` — Wishlist Heart Animation

- Triggers CSS pulse animation on wishlist buttons
- Handles keyboard accessibility (Enter/Space)
- Manages `aria-hidden` on product card overlays during focus

## 18.5 `cart.js` and `validation.js`

Currently empty/placeholder files. Cart logic is handled server-side via PHP redirects.

---

# Chapter 19 — Security Measures

## 19.1 SQL Injection Prevention

**All database queries use PDO prepared statements:**
```php
$stmt = $this->pdo->prepare("SELECT * FROM client WHERE email = :email");
$stmt->execute([':email' => $email]);
```
User input is never concatenated into SQL strings.

## 19.2 Password Security

- **Storage:** `password_hash($password, PASSWORD_DEFAULT)` — uses bcrypt with auto-generated salt
- **Verification:** `password_verify($password, $user['password'])` — constant-time comparison
- **Minimum length:** 8 characters enforced on registration

## 19.3 Session Security

- `session_regenerate_id(true)` on login — prevents session fixation
- Session-based access control on every protected page
- Role verification: `$_SESSION['role'] === 'admin'`

## 19.4 XSS Prevention

**All output is escaped:**
```php
<?= htmlspecialchars($product['nom']) ?>
<?= htmlspecialchars($user['email']) ?>
```

The `htmlspecialchars()` function converts special characters to HTML entities, preventing script injection through user-generated content.

## 19.5 CSRF Considerations

**Current state:** The application does not implement CSRF tokens. Forms use POST method which provides basic protection, but adding CSRF tokens would strengthen security.

## 19.6 Input Validation

- **Registration:** Regex for names, email validation, phone digit check, password length
- **Profile:** Same validation with email uniqueness scoped to other users
- **Contact:** Name regex, email format, required fields
- **Checkout:** Address fields required, stock verification
- **Admin products:** Price > 0, stock ≥ 0, required fields

## 19.7 File Upload Security

- Images are renamed with `time()` prefix to prevent filename collisions
- `move_uploaded_file()` ensures only legitimate uploads
- Destination directory created with `mkdir(..., 0777, true)` if missing

## 19.8 Access Control Summary

| Resource                | Protection                              |
|-------------------------|------------------------------------------|
| Profile page            | `isset($_SESSION['user_id'])` check      |
| Checkout                | `isset($_SESSION['user_id'])` check      |
| Wishlist operations     | `isset($_SESSION['user_id'])` check      |
| All admin pages         | `$_SESSION['role'] === 'admin'` check    |
| Login/Register          | `noindex, nofollow` robots meta          |
| Admin pages             | `noindex, nofollow` robots meta          |

---

# Chapter 20 — Shared Components Deep Dive

## 20.1 `includes/header.php`

**Responsibilities:**
1. Start session if not active
2. Load i18n system (`config/lang.php`)
3. Compute `$baseUrl` dynamically (handles subdirectories)
4. Apply safe defaults for all page metadata
5. Output complete `<head>` with:
   - SEO meta tags
   - Open Graph tags
   - Twitter Card tags
   - Google Fonts (Poppins)
   - Global CSS (`style.css`, `product-hover.css`)
   - Font Awesome icons (CDN with integrity hash)
   - JSON-LD Organization + WebSite schemas
   - Page-specific `$extraHeadContent`

## 20.2 `includes/navbar.php`

**Conditional rendering:**
- **Guest:** Shows Login link
- **Logged-in client:** Shows Profile link
- **Logged-in admin:** Shows Dashboard link
- **Cart badge:** Shows item count when > 0

**Language switcher:** Preserves current URL parameters while appending `?lang=XX`.

## 20.3 `includes/footer.php`

- Three-column layout: Brand info + social links, Quick links, Contact info
- Toast CSS and JS scripts loaded globally
- Dynamic copyright year via `date('Y')`

## 20.4 `includes/toast-container.php`

**Flash message bridge between PHP and JavaScript:**

1. Reads `$_SESSION['_toast']` (set by PHP actions)
2. Outputs `<div id="toast-container" data-flash-message="..." data-flash-type="...">` 
3. Immediately unsets the session variable (consume-once pattern)
4. `toast.js` picks up the data attributes on DOMContentLoaded and displays the toast

---

# Chapter 21 — Configuration Files

## 21.1 `config/Database.php`

**Singleton-like database connection class:**

```php
class Database {
    private $host = "localhost";
    private $db_name = "sabaya";
    private $username = "root";
    private $password = "";
    
    public function getConnection() {
        $this->conn = new PDO(
            "mysql:host=...;dbname=...;charset=utf8mb4",
            $this->username, $this->password
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $this->conn;
    }
}
```

**Key configurations:**
- `charset=utf8mb4` — full Unicode support (emojis, Arabic)
- `ERRMODE_EXCEPTION` — throws exceptions on SQL errors (enables try/catch)
- `FETCH_ASSOC` — returns associative arrays (not numeric-indexed)

---

# Chapter 22 — Deployment & Environment

## 22.1 Requirements

| Component       | Minimum Version |
|-----------------|-----------------|
| PHP             | 8.0+            |
| MySQL           | 5.7+            |
| Apache          | 2.4+            |
| Browser         | Modern (Chrome, Firefox, Edge, Safari) |

## 22.2 Local Setup Steps

1. Install XAMPP/WAMP
2. Create MySQL database named `sabaya`
3. Import database schema (tables described in Chapter 4)
4. Clone project into `htdocs/sabaya/`
5. Start Apache + MySQL services
6. Access `http://localhost/sabaya/`

## 22.3 Base URL Computation

The application dynamically computes the base URL to work in any subdirectory:

```php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptDir !== '/' && $scriptDir !== '\\' && $scriptDir !== '') {
    $scriptDir = dirname($scriptDir);  // Go up one level
}
$baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/\\');
```

This ensures correct asset paths whether deployed at `/sabaya/` or at the domain root.

---

# Appendix A — File Interaction Map

```
index.php
  ├── config/Database.php → PDO connection
  ├── models/Product.php → getAll()
  ├── models/Category.php → getAll()
  ├── includes/header.php → HTML head + SEO
  │     └── config/lang.php → i18n system
  ├── includes/navbar.php → Navigation
  └── includes/footer.php → Footer + JS
        └── includes/toast-container.php → Flash messages

products/checkout.php
  ├── config/Database.php
  ├── models/Product.php → find() for each cart item
  ├── models/Order.php → createAddress(), createOrder(), createOrderLine()
  ├── auth/login.php (redirect if not logged in)
  └── products/order-success.php (redirect after success)

admin/dashboard.php
  ├── config/Database.php → Direct PDO queries for statistics
  ├── config/lang.php → Translations
  └── assets/js/counter.js → KPI animations
```

---

# Appendix B — Complete Page Index

| #  | File                              | Type        | Auth Required | Role     |
|----|-----------------------------------|-------------|---------------|----------|
| 1  | `index.php`                       | Page        | No            | Public   |
| 2  | `about.php`                       | Page        | No            | Public   |
| 3  | `auth/login.php`                  | Page+Action | No            | Public   |
| 4  | `auth/register.php`               | Page+Action | No            | Public   |
| 5  | `auth/logout.php`                 | Action      | No            | Public   |
| 6  | `auth/profile.php`                | Page+Action | Yes           | Client   |
| 7  | `products/products.php`           | Page        | No            | Public   |
| 8  | `products/product-details.php`    | Page        | No            | Public   |
| 9  | `products/category.php`           | Page        | No            | Public   |
| 10 | `products/search.php`             | Page        | No            | Public   |
| 11 | `products/add-cart.php`           | Action      | No            | Public   |
| 12 | `products/cart.php`               | Page        | No            | Public   |
| 13 | `products/remove-cart.php`        | Action      | No            | Public   |
| 14 | `products/checkout.php`           | Page+Action | Yes           | Client   |
| 15 | `products/order-success.php`      | Page        | No            | Public   |
| 16 | `products/my-orders.php`          | Page        | Yes           | Client   |
| 17 | `wishlist/add-wishlist.php`       | Action      | Yes           | Client   |
| 18 | `wishlist/remove-wishlist.php`    | Action      | Yes           | Client   |
| 19 | `wishlist/wishlist.php`           | Page        | Yes           | Client   |
| 20 | `contact/contact.php`             | Page+Action | No            | Public   |
| 21 | `contact/send-message.php`        | Action      | Yes           | Client   |
| 22 | `admin/dashboard.php`             | Page        | Yes           | Admin    |
| 23 | `admin/statistics/index.php`      | Page        | Yes           | Admin    |
| 24 | `admin/products/list.php`         | Page        | Yes           | Admin    |
| 25 | `admin/products/add.php`          | Page+Action | Yes           | Admin    |
| 26 | `admin/products/edit.php`         | Page+Action | Yes           | Admin    |
| 27 | `admin/products/delete.php`       | Action      | Yes           | Admin    |
| 28 | `admin/categories/list.php`       | Page        | Yes           | Admin    |
| 29 | `admin/categories/add.php`        | Page+Action | Yes           | Admin    |
| 30 | `admin/categories/edit.php`       | Page+Action | Yes           | Admin    |
| 31 | `admin/categories/delete.php`     | Action      | Yes           | Admin    |
| 32 | `admin/orders/list.php`           | Page        | Yes           | Admin    |
| 33 | `admin/orders/details.php`        | Page        | Yes           | Admin    |
| 34 | `admin/orders/update-status.php`  | Page+Action | Yes           | Admin    |
| 35 | `admin/users/list.php`            | Page        | Yes           | Admin    |
| 36 | `admin/users/add.php`             | Page+Action | Yes           | Admin    |
| 37 | `admin/users/edit.php`            | Page+Action | Yes           | Admin    |
| 38 | `admin/users/details.php`         | Page        | Yes           | Admin    |
| 39 | `admin/users/delete.php`          | Action      | Yes           | Admin    |
| 40 | `admin/contact/list.php`          | Page        | Yes           | Admin    |
| 41 | `admin/contact/view.php`          | Page        | Yes           | Admin    |
| 42 | `admin/contact/delete.php`        | Action      | Yes           | Admin    |

---

*Document generated for the Sabaya Luxury e-commerce project.*
*This manual covers all source files, database structures, business logic, security mechanisms, and architectural decisions.*
*Intended as a PFE defense appendix and future maintenance reference.*
