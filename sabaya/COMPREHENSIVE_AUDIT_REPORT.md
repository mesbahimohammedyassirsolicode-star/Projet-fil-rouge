# SABAYA LUXURY — COMPREHENSIVE PROJECT AUDIT REPORT

**Auditor:** Senior PHP Architect / Full-Stack Auditor / Security Reviewer / SEO & GEO Specialist / PFE Examiner  
**Date:** June 8, 2026  
**Project:** Sabaya Luxury — E-commerce Abaya & Modest Fashion Boutique  
**Stack:** PHP 8.x / MySQL (PDO) / Vanilla JS / CSS Custom Properties / Font Awesome / Chart.js  

---

# Executive Summary

Sabaya Luxury is a PHP e-commerce application for selling abayas and modest fashion in Morocco. The project implements a complete purchase flow (browse → cart → checkout → order confirmation with WhatsApp), a full admin panel (dashboard, products, categories, orders, users, contact, statistics), user authentication, wishlist, and search functionality.

**Strengths:** The project demonstrates solid foundational security practices — PDO prepared statements are used consistently throughout, `password_hash()` with `PASSWORD_DEFAULT` secures passwords, `session_regenerate_id(true)` is called on login, and output is escaped with `htmlspecialchars()` in most locations. The CSS architecture is comprehensive with responsive breakpoints at 992px, 768px, and 480px. JSON-LD structured data (Organization, WebSite, Product, SearchResultsPage) is properly implemented. Admin pages include good accessibility attributes (aria-labels, aria-hidden on SVGs, aria-expanded, keyboard support with Escape key).

**Weaknesses:** The project has critical security gaps: zero CSRF protection on any form, destructive admin actions (delete product/category/user) performed via GET requests, and no database transactions during checkout — risking data corruption if a partial failure occurs. The architecture is purely procedural with no MVC separation, significant code duplication (admin sidebar repeated in ~15 files at ~60 lines each), and monolithic CSS (style.css at 3,586 lines). Several files are empty placeholders (cart.js, validation.js, client/ directory). Stock validation exists but operates outside a transaction, making it susceptible to race conditions.

---

# Project Completion Percentage

| Module | Status | Completion |
|--------|--------|------------|
| Homepage | Functional | 100% |
| Product Catalog | Functional | 95% (no AJAX filtering) |
| Product Details | Functional | 100% |
| Cart | Functional | 90% (quantity not editable inline) |
| Checkout | Functional | 85% (no transaction, no CSRF) |
| User Auth (Login/Register) | Functional | 90% (no CSRF, weak validation) |
| User Profile | Functional | 100% |
| Wishlist | Functional | 95% |
| Search | Functional | 100% |
| Order History | Functional | 100% |
| Contact Form | Functional | 95% |
| About Page | Functional | 100% |
| Admin Dashboard | Functional | 100% |
| Admin Products CRUD | Functional | 90% (delete via GET, no CSRF) |
| Admin Categories CRUD | Functional | 90% (delete via GET, no CSRF) |
| Admin Orders | Functional | 100% |
| Admin Users | Functional | 85% (delete via GET, no CSRF, double delete bug) |
| Admin Contact | Functional | 95% |
| Admin Statistics | Functional | 100% |
| Responsive Design | Implemented | 95% |
| SEO / Meta | Implemented | 85% |
| Structured Data (GEO) | Partial | 70% |
| Accessibility | Partial | 65% |

**Overall Project Completion: 88%**

---

# Structure Report

## Folder Organization

```
sabaya/
├── admin/           ✅ Admin panel (CRUD pages)
│   ├── categories/  ✅ Category management
│   ├── contact/     ✅ Contact message management
│   ├── orders/      ✅ Order management
│   ├── products/    ✅ Product management
│   ├── statistics/  ✅ Analytics dashboard
│   └── users/       ✅ User management
├── assets/
│   ├── css/         ✅ Stylesheets (5 files)
│   ├── images/      ✅ Organized by type (logo, categories, products)
│   └── js/          ⚠️ JavaScript (2 empty files)
├── auth/            ✅ Authentication pages
├── client/          ❌ Empty directory — unused
├── config/          ✅ Database configuration
├── contact/         ✅ Contact form + handler
├── includes/        ✅ Shared header, navbar, footer
├── models/          ✅ Data models (6 classes)
├── products/        ✅ Product pages + cart + checkout
└── wishlist/        ✅ Wishlist pages
```

## Findings

| Issue | Severity | Location |
|-------|----------|----------|
| Empty `client/` directory | Low | `client/` |
| Empty JS file: `cart.js` (only a comment) | Low | `assets/js/cart.js` |
| Empty JS file: `validation.js` (only a comment) | Low | `assets/js/validation.js` |
| File naming inconsistency: `add-cart.php` / `remove-cart.php` vs `add-wishlist.php` / `remove-wishlist.php` (hyphen vs underscore varies in codebase) | Low | `products/`, `wishlist/` |
| Existing audit files from prior work: `frontend_audit_report.md`, `project_testing_report.md` | Info | Root |
| No `.htaccess` or routing configuration | Medium | Root |
| No `composer.json` or dependency management | Low | Root |
| No environment configuration (DB credentials hardcoded) | High | `config/Database.php` |

---

# Security Report

## CRITICAL Issues

### 1. No CSRF Protection on Any Form
**Severity: CRITICAL**  
**Affected files:** ALL form submissions across the project

No anti-CSRF token is implemented anywhere. Every POST form is vulnerable to Cross-Site Request Forgery attacks:
- `auth/login.php` — login form
- `auth/register.php` — registration form
- `products/checkout.php` — order placement
- `admin/products/add.php` — product creation
- `admin/products/edit.php` — product modification
- `admin/categories/add.php` — category creation
- `admin/categories/edit.php` — category modification
- `admin/orders/update-status.php` — status change
- `admin/users/add.php` — user creation
- `admin/users/edit.php` — user modification
- `admin/contact/delete.php` — contact deletion
- `contact/send-message.php` — contact form
- `auth/profile.php` — profile update

**Impact:** An attacker can trick an authenticated admin into creating/deleting products, changing order statuses, or placing orders on behalf of a user.

### 2. Destructive Admin Actions via GET (CSRF + IDOR)
**Severity: CRITICAL**  
**Affected files:**
- `admin/products/delete.php` — deletes product via `$_GET['id']` with no confirmation
- `admin/categories/delete.php` — deletes category via `$_GET['id']` with no confirmation
- `admin/users/delete.php` — deletes user via `$_GET['id']` with minimal check

All three files perform permanent deletions triggered by simple GET requests. No POST confirmation, no CSRF token, no "are you sure?" step. A malicious link in an email or image tag can trigger deletion:
```
<img src="https://sabaya.ma/admin/products/delete.php?id=5">
```

**Note:** `admin/contact/delete.php` is the ONLY admin delete page that correctly uses POST with a confirmation form. This pattern should be applied to all delete operations.

### 3. No Database Transactions During Checkout
**Severity: CRITICAL**  
**Affected file:** `products/checkout.php` (lines 74-163)

The checkout process performs 4 separate database operations without a transaction:
1. `createAddress()` — INSERT into adresse
2. `createOrder()` — INSERT into commande
3. `createOrderLine()` — INSERT into ligne_commande (loop)
4. Direct `UPDATE produits SET stock = stock - :qte` (loop)

If any operation fails after the first succeeds, the database is left in an inconsistent state. For example, if `createOrderLine()` fails for the second product, the order exists but is incomplete, and stock was decremented for the first product but not the second.

**Required fix:** Wrap in `$pdo->beginTransaction()` / `$pdo->commit()` / `$pdo->rollBack()`.

### 4. Double Delete Bug in Users
**Severity: HIGH**  
**Affected file:** `admin/users/delete.php` (lines 35-36)

```php
$userModel->delete($id);
$userModel->delete($id);  // Duplicate call
```

The `delete()` method is called twice on the same user ID. While the second call silently fails (row no longer exists), this is a clear bug indicating copy-paste error and lack of testing.

## HIGH Issues

### 5. Database Error Messages Exposed to Users
**Severity: HIGH**  
**Affected file:** `config/Database.php` (line 36)

```php
die("Erreur : " . $e->getMessage());
```

PDOException messages may contain database schema details, table names, and connection info. This should log the error and display a generic message to the user.

### 6. File Upload Lacks Server-Side MIME Validation
**Severity: HIGH**  
**Affected files:** `admin/products/add.php`, `admin/products/edit.php`, `admin/categories/add.php`, `admin/categories/edit.php`

File uploads only check `$_FILES['image']['error'] === 0` but never validate the file type on the server side. The HTML `accept="image/*"` attribute is trivially bypassed. An attacker could upload a PHP web shell disguised as an image.

**Current upload code (products/add.php, line 42-53):**
```php
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = time() . '_' . $_FILES['image']['name'];  // Preserves original filename
    $destination = "../../assets/images/products/" . $imageName;
    if (!is_dir("../../assets/images/products/")) {
        mkdir("../../assets/images/products/", 0777, true);  // World-writable!
    }
    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
}
```

**Issues:**
- No `mime_content_type()` or `finfo_file()` check
- Original filename preserved (special characters possible)
- `mkdir()` with `0777` permissions (world-writable)
- No file size limit enforcement on server side
- Upload directory is within the web root (executable PHP files would be accessible)

### 7. Input Encoding Misuse in Register
**Severity: MEDIUM**  
**Affected file:** `auth/register.php` (lines 14-19)

```php
$nom = htmlspecialchars($_POST['nom']);       // ❌ Wrong: encoding on INPUT
$prenom = htmlspecialchars($_POST['prenom']); // ❌ Wrong: encoding on INPUT
$phone = htmlspecialchars($_POST['phone']);   // ❌ Wrong: encoding on INPUT
$email = htmlspecialchars($_POST['email']);   // ❌ Wrong: encoding on INPUT
$password = htmlspecialchars($_POST['password']); // ❌ Wrong: alters password
```

`htmlspecialchars()` is applied on INPUT instead of OUTPUT. This:
1. Alters data before storage (e.g., `O'Brien` becomes `O&#39;Brien` in DB)
2. The password is modified by `htmlspecialchars()`, which could change its value before hashing
3. Output escaping should happen at display time, not storage time

### 8. No Rate Limiting on Login
**Severity: MEDIUM**  
**Affected file:** `auth/login.php`

No brute-force protection exists. An attacker can attempt unlimited login combinations.

### 9. No Stock Validation in Cart / Add-to-Cart
**Severity: MEDIUM**  
**Affected files:** `products/add-cart.php`, `products/cart.php`

Stock is validated only at checkout submission. A user can add more items to the cart than available stock and only discover the issue at checkout. This is a poor user experience and could be exploited for inventory denial.

## LOW Issues

### 10. `remove-cart.php` Uses GET Without CSRF
**Severity: LOW**  
**Affected file:** `products/remove-cart.php`

Cart removal uses GET with no CSRF protection. While the impact is limited (only affects the user's own session), it violates REST conventions for state-changing operations.

### 11. `categories/delete.php` Missing `(int)` Cast
**Severity: LOW**  
**Affected file:** `admin/categories/delete.php` (line 23)

```php
$id = $_GET['id']; // No (int) cast, unlike products/delete.php and users/delete.php
```

While prepared statements prevent SQL injection, the missing type cast is inconsistent with the pattern used in other delete files.

### 12. Hardcoded WhatsApp Number
**Severity: LOW**  
**Affected file:** `products/order-success.php`

Phone number `212613623407` is hardcoded. Should be a configuration constant.

### 13. No Password Complexity Requirements Beyond Length
**Severity: LOW**  
**Affected file:** `auth/register.php`

Only `strlen($password) < 8` is checked. No requirements for uppercase, numbers, or special characters.

## POSITIVE Security Findings

| Practice | Status | Location |
|----------|--------|----------|
| PDO prepared statements | ✅ Everywhere | All models and direct queries |
| `password_hash()` with `PASSWORD_DEFAULT` | ✅ Correct | `auth/register.php`, `admin/users/add.php` |
| `password_verify()` for login | ✅ Correct | `auth/login.php` |
| `session_regenerate_id(true)` on login | ✅ Correct | `auth/login.php` (line 34) |
| Admin role check | ✅ Correct | All admin files |
| Authentication required for sensitive actions | ✅ Correct | Cart, checkout, wishlist, contact |
| `(int)` type cast on GET IDs | ✅ Mostly consistent | Most files (except categories/delete) |
| `htmlspecialchars()` on output | ✅ Most locations | Product details, admin lists, etc. |
| Admin delete via POST (contact only) | ✅ Good pattern | `admin/contact/delete.php` |
| POST method check on contact form | ✅ Correct | `contact/send-message.php` |
| `rel="noopener noreferrer"` on external links | ✅ Correct | `products/order-success.php` |

---

# SEO Report

## Meta Titles
| Page | Title | Status |
|------|-------|--------|
| Homepage | Dynamic via `$pageTitle` | ✅ |
| Product Details | `{Product Name} \| Sabaya Luxury — Abayas Modernes` | ✅ Good |
| Products | Dynamic via `$pageTitle` | ✅ |
| Search | Dynamic via `$pageTitle` | ✅ |
| Cart | Set in page | ✅ |
| Checkout | `Finaliser la commande \| Sabaya Luxury` | ✅ |
| Login | `Connexion \| Sabaya Luxury` | ✅ |
| Register | `Inscription \| Sabaya Luxury` | ✅ |
| About | Dynamic | ✅ |
| Contact | Dynamic | ✅ |
| Admin pages | Self-contained titles | ✅ |

## Meta Descriptions
- ✅ All front-office pages set `$pageDescription`
- ✅ Auth and admin pages use `noindex, nofollow`
- ✅ Search page uses `noindex, follow` (correct for search results)

## Canonical URLs
- ✅ `header.php` generates canonical URL automatically (line 63)
- ✅ Product details sets explicit `$canonicalUrl` (line 43)

## Open Graph & Twitter Cards
- ✅ Comprehensive OG tags in `header.php` (type, site_name, title, description, image, url, locale)
- ✅ Twitter Card tags (summary_large_image)
- ✅ Product details sets `ogType = 'product'`

## Heading Hierarchy
| Issue | Severity | Location |
|-------|----------|----------|
| Mixed French/English in headings | Low | `auth/login.php` line 103: "Don't have an account?", `auth/register.php` line 148: "Already have an account?" |
| Heading hierarchy generally correct | ✅ | Most pages use h1 → h2 properly |

## Semantic HTML
- ✅ `<main>`, `<section>`, `<nav>`, `<aside>`, `<header>`, `<footer>` used correctly
- ✅ `<fieldset>` and `<legend>` on forms
- ✅ `<dl>`, `<dt>`, `<dd>` for key-value pairs in admin
- ✅ Breadcrumb navigation on product details

## Internal Linking
- ✅ Navbar links to all main sections
- ✅ Product cards link to details
- ✅ Breadcrumb navigation on product details
- ⚠️ No sitemap.xml
- ⚠️ No robots.txt (beyond meta robots tags)

---

# GEO Report (Schema.org / Structured Data)

## Implemented Schemas

| Schema Type | Location | Status |
|-------------|----------|--------|
| Organization | `includes/header.php` (lines 92-117) | ✅ Complete with name, description, logo, contactPoint, address, email |
| WebSite + SearchAction | `includes/header.php` (lines 119-137) | ✅ Complete with search URL pattern |
| Product | `products/product-details.php` (lines 46-71) | ✅ Complete with name, description, image, brand, offers, color, size |
| SearchResultsPage | `products/search.php` | ✅ With ItemList |
| ItemList | `products/search.php` | ✅ ListItem array |

## Missing Schema Opportunities

| Schema Type | Priority | Location |
|-------------|----------|----------|
| BreadcrumbList | Medium | Product details, category pages — visual breadcrumb exists but no structured data |
| ContactPage | Low | `contact/contact.php` — no ContactPage schema |
| LocalBusiness | Low | Could enhance Organization schema on homepage |
| FAQPage | Low | About page could benefit |

## JSON-LD Quality
- ✅ All JSON-LD uses `htmlspecialchars()` for dynamic values
- ✅ `@id` references used for linking Organization and WebSite
- ✅ Product schema includes `availability`, `priceCurrency: "MAD"`, seller info
- ⚠️ Product availability is hardcoded as `InStock` regardless of actual stock level

---

# Accessibility Report

## Strengths

| Practice | Status | Location |
|----------|--------|----------|
| `aria-label` on sections | ✅ | Admin pages, search, cart, checkout |
| `aria-hidden="true"` on decorative SVGs | ✅ | All admin sidebar SVGs |
| `aria-expanded` on toggle buttons | ✅ | Admin sidebar toggle, mobile nav |
| `aria-controls` on sidebar toggle | ✅ | Admin pages |
| `aria-current="page"` on active nav item | ✅ | Admin sidebar |
| `role="alert"` on error messages | ✅ | Login, register, admin forms |
| `<fieldset>` / `<legend>` on forms | ✅ | Login, register, admin forms |
| `<label for="">` / `<input id="">` pairs | ✅ | Most forms |
| `sr-only` class defined | ✅ | CSS |
| `focus-visible` styling | ✅ | `style.css` |
| `loading="lazy"` on product images | ✅ | Category, search pages |
| Descriptive `alt` text on product images | ✅ | Product details (includes color and size) |
| Keyboard: Escape closes admin sidebar | ✅ | Admin JS |
| Keyboard: Mobile nav toggle accessible | ✅ | `main.js` |

## Gaps

| Issue | Severity | Location |
|-------|----------|----------|
| No skip navigation link | Medium | `includes/header.php` |
| Inline styles for error display (`style="color: red; margin-bottom: 15px;"`) | Low | `auth/login.php` line 82, `auth/register.php` line 111 |
| Cart quantity not editable (display only) | Medium | `products/cart.php` |
| Form inputs missing `required` attribute on some auth forms | Low | `auth/login.php`, `auth/register.php` |
| No focus management after page navigation | Low | Global |
| Color contrast not verified | Info | CSS needs manual audit |
| `autocomplete` attributes missing on auth forms | Low | `auth/login.php`, `auth/register.php` |

---

# Responsive Report

## Breakpoints Implemented

| Breakpoint | Target | Files |
|------------|--------|-------|
| 1024px | Tablet (admin) | `admin.css` |
| 992px | Tablet (front) | `style.css`, `cart.css` |
| 900px | Tablet (profile) | `profile.css` |
| 768px | Mobile landscape | `style.css`, `admin.css`, `auth.css`, `cart.css` |
| 560px | Small mobile (profile) | `profile.css` |
| 480px | Small mobile | `style.css`, `admin.css`, `cart.css` |

## Responsive Patterns

| Component | Desktop | Tablet | Mobile | Status |
|-----------|---------|--------|--------|--------|
| Admin sidebar | Fixed sidebar | Collapsed (icon only) | Drawer overlay | ✅ Excellent |
| Product grids | 4 columns | 2 columns | 1 column | ✅ |
| Data tables | Full table | Scroll | Card layout | ✅ |
| Cart page | Table layout | Scroll | Stacked cards | ✅ |
| Checkout | 2-column grid | Stacked | Stacked | ✅ |
| Profile | Sidebar + content | Horizontal tabs | Stacked | ✅ |
| Navbar | Horizontal links | Hamburger menu | Hamburger menu | ✅ |
| Auth pages | Centered form | Scaled | Full width | ✅ |

## Issues

| Issue | Severity | Location |
|-------|----------|----------|
| `style.css` is 3,586 lines (monolithic, hard to maintain) | Medium | `assets/css/style.css` |
| CSS custom properties duplicated between `style.css` and `admin.css` | Low | CSS files |
| Some hardcoded pixel values alongside CSS custom properties | Low | Various CSS |

---

# Architecture Report

## MVC Separation Level: Minimal

The project uses a **procedural PHP** approach with model classes only. There is no formal MVC framework:

- **Models:** ✅ 6 model classes in `models/` (Category, Contact, Order, Product, User, Wishlist) — encapsulate DB queries
- **Views:** ❌ No template engine — HTML is inline within PHP files
- **Controllers:** ❌ No controller layer — business logic mixed directly in page files

**Example of mixed concerns** (`products/checkout.php`):
- Lines 1-38: Business logic (cart validation, total calculation)
- Lines 41-166: Form processing (validation, order creation, stock update)
- Lines 169-180: View preparation (CSS, metadata)
- Lines 183-308: HTML output

## Code Duplication

| Duplication | Estimated Lines | Location |
|-------------|-----------------|----------|
| Admin sidebar HTML | ~60 lines × ~12 files ≈ 720 lines | All admin pages |
| Admin sidebar JS (toggle + overlay + Escape) | ~25 lines × ~12 files ≈ 300 lines | All admin pages |
| Admin top header HTML | ~15 lines × ~12 files ≈ 180 lines | All admin pages |
| Admin footer | ~3 lines × ~12 files ≈ 36 lines | All admin pages |
| Base URL calculation | ~7 lines, repeated in 5+ files | header.php, auth pages, checkout |
| `getUserOrders()` method | 15 lines duplicated | `Order.php` AND `User.php` |
| Database instantiation (`new Database(); $pdo = $db->getConnection();`) | 2 lines × 20+ files | Every PHP file |
| **Total estimated duplication** | **~1,260+ lines** | |

## OOP Quality

| Aspect | Assessment |
|--------|------------|
| Model encapsulation | ✅ Models use private `$pdo`, public methods |
| Prepared statements | ✅ All queries use prepared statements |
| Type hints | ❌ No type declarations on method parameters or return types |
| Constructor injection | ✅ PDO injected via constructor |
| Error handling | ❌ No try/catch in model methods, no error return types |
| Validation | ❌ No validation logic in models (all in page files) |
| Method naming consistency | ⚠️ Mixed: `find()`, `getAll()`, `getUserOrders()` vs `createOrder()`, `createOrderLine()` |

## Reusability & Maintainability

| Issue | Impact |
|-------|--------|
| No autoloader — manual `require_once` everywhere | Adding a new model requires updating all dependent files |
| No dependency injection container | Database connection manually created in every file |
| No configuration management | DB credentials hardcoded in `Database.php` |
| No routing system | URL structure is tied directly to file paths |
| No template/layout system | Header/footer includes work, but no content blocks or inheritance |
| Admin pages are standalone HTML (not using `header.php`) | Consistency burden, no shared head management |
| Empty JS files included in pages | Dead code, wasted HTTP requests |

---

# Checkout Audit

## Order Flow Analysis

```
1. User adds to cart → add-cart.php (GET, stores in session)
2. Views cart → cart.php (reads session)
3. Proceeds to checkout → checkout.php (validates auth + cart)
4. Submits order → checkout.php POST handler:
   a. Validates ville, adresse, code_postal (required fields)
   b. Validates stock for each cart item ✅
   c. Creates address → createAddress()
   d. Creates order → createOrder()
   e. For each cart item:
      - Creates order line → createOrderLine()
      - Decrements stock → direct SQL UPDATE
   f. Builds WhatsApp message
   g. Clears cart
   h. Redirects to order-success.php
```

## Critical Findings

| Issue | Severity | Detail |
|-------|----------|--------|
| **No transaction** | CRITICAL | `beginTransaction()` / `commit()` / `rollBack()` are NOT used. Partial failures leave inconsistent data. |
| Stock validation outside transaction | HIGH | Race condition: two users could simultaneously pass stock validation for the same limited item. |
| No `id_adresse` linked to order | HIGH | `createAddress()` is called but the returned `id_adresse` is never used or stored on the order. The address is created but orphaned. |
| Total computed from session, not revalidated | MEDIUM | `$total` is calculated before the form submission and reused. If prices change between page load and form submit, the total could be stale. |
| No order confirmation email | LOW | Only WhatsApp integration, no email notification. |
| WhatsApp number hardcoded | LOW | `order-success.php` |

## Missing `id_adresse` Link — Detail

In `checkout.php` (line 78-83):
```php
$id_adresse = $orderModel->createAddress($ville, $adresse, $code_postal, $id_client);
```
The `$id_adresse` is captured but **never passed** to `createOrder()`. The `commande` table likely has no `id_adresse` column, meaning the shipping address is created but never associated with the order. This is a functional bug.

---

# Remaining Weaknesses

1. **No CSRF protection** — affects every form in the application
2. **No database transactions** — checkout integrity at risk
3. **GET-based deletions** in admin — violates HTTP conventions, enables CSRF attacks
4. **No file upload validation** — server accepts any file type
5. **Address not linked to order** — functional bug in checkout
6. **Double delete call** in `admin/users/delete.php` — copy-paste bug
7. **Input encoding misuse** — `htmlspecialchars()` on input instead of output in register.php
8. **No environment configuration** — DB credentials hardcoded
9. **Exposed error messages** — `die()` with PDOException details
10. **Monolithic CSS** — style.css at 3,586 lines hinders maintainability
11. **Significant code duplication** — ~1,260+ lines of duplicated admin sidebar/header/footer/JS
12. **Empty placeholder files** — cart.js, validation.js, client/ directory
13. **No autoloader or dependency management** — manual require_once everywhere
14. **Mixed language in UI** — French/English inconsistency in auth pages
15. **No brute-force protection** on login

---

# Critical Issues (Priority Order)

| # | Issue | Category | Severity |
|---|-------|----------|----------|
| 1 | No CSRF protection on any form | Security | CRITICAL |
| 2 | Admin delete via GET (products, categories, users) | Security | CRITICAL |
| 3 | No database transactions during checkout | Security/Integrity | CRITICAL |
| 4 | File upload has no server-side MIME validation | Security | HIGH |
| 5 | Database error messages exposed via `die()` | Security | HIGH |
| 6 | Address created but not linked to order | Functional Bug | HIGH |
| 7 | Double delete() call in users/delete.php | Functional Bug | HIGH |
| 8 | `htmlspecialchars()` on input instead of output (register.php) | Security | MEDIUM |
| 9 | mkdir with 0777 permissions | Security | MEDIUM |
| 10 | No rate limiting on login | Security | MEDIUM |

---

# Recommended Improvements

## Priority 1 — Critical Security (Must Fix)

1. **Implement CSRF tokens** on all forms:
   - Generate a random token per session, include as hidden field in every form
   - Validate token on POST submission
   - Apply to: login, register, checkout, all admin forms, contact form, profile update

2. **Convert all delete actions to POST** with confirmation:
   - Refactor `admin/products/delete.php`, `admin/categories/delete.php`, `admin/users/delete.php`
   - Follow the existing pattern from `admin/contact/delete.php` (POST confirmation form)
   - Add CSRF token to the confirmation form

3. **Wrap checkout in a database transaction**:
   ```php
   $pdo->beginTransaction();
   try {
       // createAddress, createOrder, createOrderLine, UPDATE stock
       $pdo->commit();
   } catch (Exception $e) {
       $pdo->rollBack();
       // handle error
   }
   ```

## Priority 2 — High Impact

4. **Add server-side file upload validation**:
   - Use `finfo_file()` to verify MIME type
   - Whitelist allowed types (image/jpeg, image/png, image/webp)
   - Generate random filenames (don't preserve original names)
   - Set upload directory permissions to 0755, not 0777
   - Store uploads outside the web root or use `.htaccess` to prevent PHP execution

5. **Hide database error details**:
   ```php
   } catch (PDOException $e) {
       error_log($e->getMessage());
       die("Une erreur est survenue. Veuillez réessayer plus tard.");
   }
   ```

6. **Fix the address-order link**: Pass `$id_adresse` to `createOrder()` and add `id_adresse` column to `commande` table.

7. **Fix double delete bug**: Remove the duplicate `$userModel->delete($id)` line in `admin/users/delete.php`.

8. **Fix input encoding in register.php**: Remove `htmlspecialchars()` from input processing; apply it only at output time.

## Priority 3 — Architecture & Maintainability

9. **Extract admin sidebar into an include file**: Create `admin/includes/sidebar.php` to eliminate ~720 lines of HTML duplication and ~300 lines of JS duplication.

10. **Split style.css into modular files**: Break the 3,586-line file into component-based files (navbar.css, hero.css, products.css, footer.css, etc.)

11. **Remove empty/unused files**: Delete `cart.js` (empty), `validation.js` (empty), `client/` directory.

12. **Add environment configuration**: Move DB credentials to a `.env` file or environment variables.

13. **Add type declarations** to model methods for better IDE support and runtime safety.

## Priority 4 — SEO & Accessibility

14. **Add BreadcrumbList structured data** on product details and category pages (visual breadcrumbs already exist).

15. **Add skip navigation link** at the top of every page for keyboard users.

16. **Remove inline styles** from error messages in login.php and register.php; use CSS classes instead.

17. **Create a sitemap.xml and robots.txt** for search engine crawling.

18. **Add `autocomplete` attributes** to auth form inputs (e.g., `autocomplete="email"`, `autocomplete="current-password"`).

---

# Final Score /10

| Category | Weight | Score | Weighted |
|----------|--------|-------|----------|
| Structure | 10% | 7/10 | 0.70 |
| Architecture | 15% | 4/10 | 0.60 |
| Security | 25% | 4/10 | 1.00 |
| Checkout Integrity | 10% | 5/10 | 0.50 |
| SEO | 10% | 8/10 | 0.80 |
| GEO (Structured Data) | 5% | 7/10 | 0.35 |
| Accessibility | 10% | 7/10 | 0.70 |
| Responsive Design | 10% | 9/10 | 0.90 |
| Code Quality | 5% | 5/10 | 0.25 |

**Final Score: 5.8 / 10**

---

# Production Readiness

## Verdict: NOT READY

The application **cannot be deployed to production** in its current state due to:

1. **Zero CSRF protection** — any authenticated user can be tricked into performing unwanted actions
2. **GET-based deletions** — admin data can be destroyed via simple link clicks or image tags
3. **No checkout transactions** — database corruption risk on partial failures
4. **No file upload validation** — server is open to arbitrary file upload attacks
5. **Exposed database errors** — internal information leakage

**Minimum requirements for production:**
- Implement CSRF tokens on all forms
- Convert all destructive actions to POST
- Add database transactions to checkout
- Validate file uploads server-side
- Hide database error details
- Fix the address-order link bug
- Set appropriate directory permissions

---

# PFE Defense Readiness

## Verdict: MODERATELY PREPARED (with caveats)

### Strengths to Present

1. **Security fundamentals are solid** — PDO prepared statements everywhere, password hashing, session regeneration, role-based access control. These demonstrate understanding of core web security.

2. **Complete e-commerce flow** — Browse → Cart → Checkout → Order Confirmation with WhatsApp integration. The full user journey is functional.

3. **Comprehensive admin panel** — 7 admin modules (Dashboard, Products, Categories, Orders, Users, Contact, Statistics) with full CRUD operations and Chart.js analytics.

4. **Good SEO implementation** — Dynamic meta tags, Open Graph, Twitter Cards, canonical URLs, proper robots directives, and multiple JSON-LD schemas.

5. **Responsive design** — Well-implemented breakpoints with mobile-first patterns (table-to-card conversion, drawer sidebar, hamburger navigation).

6. **Accessibility awareness** — ARIA attributes, keyboard navigation, semantic HTML, fieldset/legend usage, focus-visible styling.

### Weaknesses to Prepare For

1. **"Why no CSRF protection?"** — Be ready to explain this is a known gap and describe how you would implement it (session token, hidden field, validation on POST).

2. **"Why no MVC?"** — Acknowledge the procedural approach, explain the model layer exists, and discuss how you would refactor toward MVC.

3. **"Why no transactions in checkout?"** — This is the most critical functional gap. Explain the risk and describe the `beginTransaction/commit/rollBack` solution.

4. **"Why GET for deletions?"** — Know that HTTP convention requires POST/DELETE for state-changing operations. The contact delete page shows you know the correct pattern.

5. **"What about the address not linked to the order?"** — Be honest about this bug and describe the fix.

6. **"Why is `htmlspecialchars()` used on input in register.php?"** — Acknowledge this is incorrect. Output encoding should happen at display time, not storage time.

### Key Talking Points

- The project demonstrates end-to-end capability: database design, backend logic, frontend design, responsive CSS, SEO, and structured data.
- Security foundations are present (prepared statements, password hashing, session management) but the application layer (CSRF, transaction safety) needs strengthening.
- The code duplication (admin sidebar) shows room for architectural improvement — this is an opportunity to discuss refactoring strategies.
- The JSON-LD implementation shows awareness of modern SEO beyond basic meta tags.

**Estimated defense readiness: 6.5/10** — functional project with clear articulation of known gaps and planned improvements.
