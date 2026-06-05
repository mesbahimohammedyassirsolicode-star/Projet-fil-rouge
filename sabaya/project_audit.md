# Project Audit (Updated)

## Complete Modules
- **Authentication**: `auth/login.php`, `auth/register.php`, `auth/profile.php`, `auth/logout.php`.
- **Client Cart & Checkout**: Fully migrated to `products/cart.php` and `products/checkout.php` (redundant directories were successfully deleted).
- **Client Products & Search**: The `Product.php` model now includes `search()` and `getByCategory()` methods, and `index.php`, `about.php`, `category.php`, and `search.php` have been implemented.
- **Admin Categories**: `admin/categories/` (list, add, edit, delete).
- **Admin Products**: `admin/products/` (list, add, edit, delete).
- **Admin Orders**: `admin/orders/` (list, details, update-status).
- **Wishlist**: `wishlist/` and `models/Wishlist.php`.
- **Models**: `Category.php`, `Product.php`, `Order.php`.

## Partial Modules
- **Admin Users**: `admin/users/` has listing, details, and delete, but is missing user creation (`add.php`) and modification (`edit.php`).
- **Admin Contacts**: `admin/contact/` has listing, but is missing view, reply, and delete functionality.
- **User Model**: `models/User.php` is missing `create()` and `update()` methods.
- **Contact Model**: `models/Contact.php` is missing `find()` and `delete()` methods.

## Empty Files / Placeholders
The following files are under 100 bytes and contain only placeholder comments:

- `faq.php` (Status: PLACEHOLDER)
- `guide-entretien.php` (Status: PLACEHOLDER)
- `assets/css/admin.css` (Status: PLACEHOLDER)
- `assets/css/auth.css` (Status: PLACEHOLDER)
- `assets/css/cart.css` (Status: PLACEHOLDER)
- `assets/css/products.css` (Status: PLACEHOLDER)
- `assets/js/cart.js` (Status: PLACEHOLDER)
- `assets/js/main.js` (Status: PLACEHOLDER)
- `assets/js/validation.js` (Status: PLACEHOLDER)

*(Note: A search for `TODO` comments returned no results across the codebase).*

## Dead Links & Missing Features

### Pages Linked but Not Implemented
- **`shop.php`**: This file is linked in `about.php` (lines 16 and 113) but does not exist in the project directory. The actual shop page appears to be `products/products.php`.

### Missing Admin Features
- **User Management**: Cannot add new users or edit existing users from the admin panel.
- **Contact Management**: Cannot view full message details, delete messages, or mark them as resolved/replied.
- **Site Settings**: No global configuration or CMS capability for dynamic pages.

### Missing Client Features
- **Static Content**: The FAQ and Maintenance Guide pages (`faq.php`, `guide-entretien.php`) are still placeholders.
- **Password Reset**: Missing "Forgot Password" functionality.

## Recommended Next Steps
1. **Fix Dead Links**: Update the `href="shop.php"` links in `about.php` to point to `products/products.php`.
2. **Complete User CRUD**: Add `create()` and `update()` methods to `User.php`, and create `add.php` and `edit.php` in `admin/users/`.
3. **Complete Contact CRUD**: Add `find()` and `delete()` to `Contact.php`, and create `view.php` and `delete.php` in `admin/contact/`.
4. **Develop Remaining Static Pages**: Implement the design/content for `faq.php` and `guide-entretien.php`.
5. **Populate Empty Assets**: Write the actual CSS/JS for the placeholder files in the `assets/` directory or safely remove them if they are not linked in the HTML headers.
