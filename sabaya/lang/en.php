<?php
/**
 * Language file: English (en)
 * Sabaya Luxury — Localization System
 *
 * Structure: associative array $lang[key] = 'translation'
 * This file is the English translation. If a key is missing here,
 * the system falls back to the French (fr.php) file automatically.
 *
 * To activate English as default, set $_SESSION['lang'] = 'en'
 * or update the default in config/lang.php.
 */

$lang = [

    /* ────────────────────────────────────────────────
     * NAVIGATION & GLOBAL
     * ──────────────────────────────────────────────── */
    'nav_home'              => 'Home',
    'nav_products'          => 'Products',
    'nav_about'             => 'About',
    'nav_search'            => 'Search',
    'nav_wishlist'          => 'Wishlist',
    'nav_account'           => 'My Account',
    'nav_cart'              => 'Cart',
    'nav_login'             => 'Sign In',
    'nav_dashboard_admin'   => 'Dashboard',
    'nav_menu_open'         => 'Open navigation menu',

    /* ────────────────────────────────────────────────
     * HOMEPAGE
     * ──────────────────────────────────────────────── */
    'home_hero_title'       => 'The Art of<br>Modesty',
    'home_new_arrivals'     => 'New Arrivals',

    /* ────────────────────────────────────────────────
     * PRODUCTS PAGE
     * ──────────────────────────────────────────────── */
    'products_page_title'       => 'Modern Collection',
    'products_page_subtitle'    => 'Elevated essentials for the contemporary woman.',
    'products_filter_all'       => 'All',
    'products_view_details'     => 'View details',
    'products_view_details_btn' => 'View Details',
    'products_empty'            => 'No products available.',
    'products_brand'            => 'SABAYA',

    /* ────────────────────────────────────────────────
     * PRODUCT DETAILS PAGE
     * ──────────────────────────────────────────────── */
    'product_add_to_cart'       => 'Add to Cart',
    'product_add_to_wishlist'   => 'Add to Wishlist',
    'product_view_wishlist'     => 'View Wishlist',
    'product_color'             => 'Color',
    'product_size'              => 'Size',
    'product_breadcrumb_home'   => 'Home',
    'product_breadcrumb_collection' => 'Collection',

    /* ────────────────────────────────────────────────
     * WISHLIST
     * ──────────────────────────────────────────────── */
    'wishlist_title'            => 'My Wishlist',
    'wishlist_empty_title'      => 'No products in your wishlist.',
    'wishlist_empty_text'       => 'Explore our luxurious abaya collection and save your favourite pieces to find them here.',
    'wishlist_discover_btn'     => 'Discover our products',
    'wishlist_remove'           => 'Remove',
    'wishlist_continue_shopping'=> 'Continue shopping',

    /* ────────────────────────────────────────────────
     * CART
     * ──────────────────────────────────────────────── */
    'cart_title'                => 'My Cart',
    'cart_subtitle'             => 'Your Selection',
    'cart_empty_text'           => 'Your cart is empty.',
    'cart_discover_btn'         => 'Discover the Collection',
    'cart_col_image'            => 'Image',
    'cart_col_product'          => 'Product',
    'cart_col_price'            => 'Price',
    'cart_col_qty'              => 'Quantity',
    'cart_col_subtotal'         => 'Subtotal',
    'cart_col_action'           => 'Action',
    'cart_order_summary'        => 'Order Summary',
    'cart_total'                => 'Total',
    'cart_checkout_btn'         => 'Proceed to Checkout',
    'cart_continue_btn'         => 'Continue Shopping',
    'cart_remove'               => 'Remove',

    /* ────────────────────────────────────────────────
     * CHECKOUT
     * ──────────────────────────────────────────────── */
    'checkout_title'            => 'Checkout',
    'checkout_intro'            => 'Complete your delivery information to confirm your order.',
    'checkout_shipping_title'   => 'Delivery Information',
    'checkout_summary_title'    => 'Order Summary',
    'checkout_confirm_btn'      => 'Confirm Order',
    'checkout_back_to_cart'     => 'Back to Cart',
    'checkout_city'             => 'City',
    'checkout_address'          => 'Address',
    'checkout_postal_code'      => 'Postal Code',
    'checkout_qty_label'        => 'Quantity:',

    /* ────────────────────────────────────────────────
     * ORDER SUCCESS
     * ──────────────────────────────────────────────── */
    'order_success_title'       => 'Order Placed Successfully',
    'order_success_thanks'      => 'Thank you for your trust.',
    'order_success_whatsapp_msg'=> 'Please confirm your order via WhatsApp so our team can process it quickly.',
    'order_whatsapp_btn'        => 'Confirm via WhatsApp',
    'order_view_orders'         => 'View my orders',
    'order_continue_shopping'   => 'Continue shopping',

    /* ────────────────────────────────────────────────
     * MY ORDERS
     * ──────────────────────────────────────────────── */
    'my_orders_title'           => 'My Orders',
    'my_orders_subtitle'        => 'Find all your past orders on Sabaya Luxury',
    'my_orders_empty_title'     => 'No orders yet',
    'my_orders_empty_text'      => 'You have not placed any orders yet.',
    'my_orders_discover_btn'    => 'Discover the Collection',
    'my_orders_view_details'    => 'View Details',
    'my_orders_order_label'     => 'Order',
    'my_orders_total'           => 'Total',
    'my_orders_history_label'   => 'Your History',

    /* ────────────────────────────────────────────────
     * SEARCH
     * ──────────────────────────────────────────────── */
    'search_title'              => 'Product Search',
    'search_subtitle'           => 'Easily find products that match your style.',
    'search_placeholder'        => 'Search for a product...',
    'search_btn'                => 'Search',
    'search_results_title'      => 'Search Results',
    'search_empty_title'        => 'No products found.',
    'search_empty_text'         => 'Try different keywords or explore our collection.',
    'search_back_to_store'      => 'Back to store',

    /* ────────────────────────────────────────────────
     * AUTHENTICATION
     * ──────────────────────────────────────────────── */
    'login_title'               => 'Sign In',
    'login_legend'              => 'Login credentials',
    'login_email'               => 'Email',
    'login_password'            => 'Password',
    'login_submit'              => 'Sign In',
    'login_no_account'          => "Don't have an account?",
    'login_sign_up_link'        => 'Sign Up',

    'register_title'            => 'Create an Account',
    'register_legend'           => 'Registration Information',
    'register_nom'              => 'Last Name',
    'register_prenom'           => 'First Name',
    'register_phone'            => 'Phone',
    'register_email'            => 'Email',
    'register_password'         => 'Password',
    'register_confirm'          => 'Confirm Password',
    'register_submit'           => 'Sign Up',
    'register_have_account'     => 'Already have an account?',
    'register_login_link'       => 'Log In',

    /* ────────────────────────────────────────────────
     * PROFILE
     * ──────────────────────────────────────────────── */
    'profile_title'             => 'My Account',
    'profile_welcome'           => 'Welcome back,',
    'profile_logout'            => 'Sign Out',
    'profile_menu_personal_info'=> 'Personal Info',
    'profile_menu_cart'         => 'Cart',
    'profile_menu_wishlist'     => 'Wishlist',
    'profile_menu_orders'       => 'Order History',
    'profile_edit_title'        => 'Edit Details',
    'profile_last_name'         => 'Last Name',
    'profile_first_name'        => 'First Name',
    'profile_email'             => 'Email',
    'profile_phone'             => 'Phone',
    'profile_phone_placeholder' => 'e.g. 0612345678',
    'profile_save_btn'          => 'Save Changes',
    'profile_success'           => 'Your profile has been updated successfully.',

    /* Validation messages (profile) */
    'profile_err_last_name_required'  => 'Last name is required.',
    'profile_err_last_name_letters'   => 'Last name must contain only letters.',
    'profile_err_first_name_required' => 'First name is required.',
    'profile_err_first_name_letters'  => 'First name must contain only letters.',
    'profile_err_email_required'      => 'Email is required.',
    'profile_err_email_invalid'       => 'Invalid email address.',
    'profile_err_email_taken'         => 'This email is already used by another account.',
    'profile_err_phone_digits'        => 'Phone number must contain only digits.',

    /* ────────────────────────────────────────────────
     * ADMIN DASHBOARD — GLOBAL
     * ──────────────────────────────────────────────── */
    'admin_sidebar_title'       => 'Sabaya Admin',
    'admin_dashboard_link'      => 'Dashboard',
    'admin_products_link'       => 'Products',
    'admin_categories_link'     => 'Categories',
    'admin_orders_link'         => 'Orders',
    'admin_users_link'          => 'Clients',
    'admin_messages_link'       => 'Messages',
    'admin_stats_link'          => 'Statistics',
    'admin_logout'              => 'Sign Out',
    'admin_hello'               => 'Hello,',

    /* ────────────────────────────────────────────────
     * ADMIN — OVERVIEW
     * ──────────────────────────────────────────────── */
    'admin_overview_title'      => 'Overview',
    'admin_overview_subtitle'   => 'Welcome to your administration space.',
    'admin_search_placeholder'  => 'Search...',
    'admin_stat_total_products' => 'Total Products',
    'admin_stat_total_orders'   => 'Total Orders',
    'admin_stat_total_clients'  => 'Total Clients',
    'admin_stat_messages'       => 'Contact Messages',
    'admin_revenue_title'       => 'Revenue',
    'admin_chart_orders_title'  => 'Orders Evolution',
    'admin_quick_actions'       => 'Quick Actions',
    'admin_add_product_btn'     => 'Add Product',
    'admin_add_category_btn'    => 'Add Category',
    'admin_view_orders_btn'     => 'View Orders',
    'admin_view_clients_btn'    => 'View Clients',
    'admin_recent_orders'       => 'Recent Orders',
    'admin_view_all'            => 'View all',
    'admin_top_products'        => 'Top Selling Products',
    'admin_no_orders_yet'       => 'No orders yet.',
    'admin_no_sales_yet'        => 'No sales recorded.',

    /* ────────────────────────────────────────────────
     * ADMIN — PRODUCTS MANAGEMENT
     * ──────────────────────────────────────────────── */
    'admin_products_page_title' => 'Product Management',
    'admin_products_subtitle'   => 'View, edit, and manage your luxury inventory.',
    'admin_stat_total_products2'=> 'Total Products',
    'admin_stat_active_products'=> 'Active Products',
    'admin_stat_low_stock'      => 'Low Stock Products',
    'admin_stat_categories'     => 'Categories',
    'admin_new_product_btn'     => 'New Product',
    'admin_col_image'           => 'Image',
    'admin_col_product_name'    => 'Product Name',
    'admin_col_category'        => 'Category',
    'admin_col_price'           => 'Price',
    'admin_col_stock'           => 'Stock',
    'admin_col_actions'         => 'Actions',
    'admin_stock_out'           => 'Out of Stock',
    'admin_stock_low'           => 'Low Stock',
    'admin_stock_in'            => 'In Stock',
    'admin_view_sr'             => 'View',
    'admin_edit_sr'             => 'Edit',
    'admin_delete_sr'           => 'Delete',
    'admin_view_details_title'  => 'View details (open store page)',
    'admin_edit_product_title'  => 'Edit product',
    'admin_delete_product_title'=> 'Delete product',

    /* ────────────────────────────────────────────────
     * ADMIN — ADD/EDIT PRODUCT
     * ──────────────────────────────────────────────── */
    'admin_add_product_title'   => 'Add a Product',
    'admin_add_product_subtitle'=> 'Add a new product to the Sabaya Luxury catalogue.',
    'admin_product_info'        => 'Product Information',
    'admin_product_media'       => 'Product Media',
    'admin_product_description' => 'Product Description',
    'admin_product_name_label'  => 'Product name',
    'admin_product_category'    => 'Category',
    'admin_product_price'       => 'Price (MAD)',
    'admin_product_stock'       => 'Stock',
    'admin_product_size'        => 'Size',
    'admin_product_color'       => 'Color',
    'admin_upload_text'         => 'Drag & drop or click to add an image',
    'admin_upload_tip'          => 'Accepted formats: PNG, JPG, JPEG (Max. 5MB)',
    'admin_preview_label'       => 'Image preview',
    'admin_no_image_selected'   => 'No image selected',
    'admin_back_to_list'        => 'Back to list',
    'admin_add_product_submit'  => 'Add Product',
    'admin_update_product_submit'=> 'Update Product',

    /* ────────────────────────────────────────────────
     * ADMIN — CATEGORIES MANAGEMENT
     * ──────────────────────────────────────────────── */
    'admin_categories_title'    => 'Category Management',
    'admin_categories_subtitle' => 'View, edit, and manage your product categories.',
    'admin_new_category_btn'    => 'New Category',
    'admin_col_category_name'   => 'Category Name',
    'admin_stat_with_image'     => 'With Image',
    'admin_edit_category_title' => 'Edit category',
    'admin_delete_category_title'=> 'Delete category',

    /* ────────────────────────────────────────────────
     * ADMIN — ORDERS MANAGEMENT
     * ──────────────────────────────────────────────── */
    'admin_orders_title'        => 'Order Management',
    'admin_orders_subtitle'     => 'Track and manage all customer orders.',
    'admin_col_id'              => 'ID',
    'admin_col_client'          => 'Client',
    'admin_col_date'            => 'Date',
    'admin_col_total'           => 'Total',
    'admin_col_status'          => 'Status',
    'admin_stat_pending'        => 'Pending',
    'admin_stat_confirmed'      => 'Confirmed',
    'admin_stat_delivered'      => 'Delivered',
    'admin_no_orders'           => 'No orders yet.',
    'admin_back_to_dashboard'   => 'Back to Dashboard',
    'admin_view_details_sr'     => 'View details',
    'admin_update_status_title' => 'Update status',

    /* ────────────────────────────────────────────────
     * ADMIN — ORDER DETAILS
     * ──────────────────────────────────────────────── */
    'admin_order_details_title'         => 'Order Information',
    'admin_order_items_title'           => 'Ordered Products',
    'admin_order_client_info'           => 'Customer Information',
    'admin_order_number'                => 'Order number',
    'admin_order_date'                  => 'Order date',
    'admin_order_status_label'          => 'Status',
    'admin_order_total_label'           => 'Total',
    'admin_order_update_status_btn'     => 'Update Status',
    'admin_order_back'                  => 'Back to orders',
    'admin_col_qty'                     => 'Quantity',
    'admin_col_unit_price'              => 'Unit price',
    'admin_col_subtotal'                => 'Subtotal',
    'admin_order_total_row'             => 'Order total',
    'admin_no_items'                    => 'No products found for this order.',
    'admin_client_id_label'             => 'Client ID:',

    /* ────────────────────────────────────────────────
     * ADMIN — USERS MANAGEMENT
     * ──────────────────────────────────────────────── */
    'admin_users_title'         => 'User Management',
    'admin_users_subtitle'      => 'Manage client and administrator accounts on Sabaya Luxury.',
    'admin_stat_total_users'    => 'Total Users',
    'admin_stat_admins'         => 'Administrators',
    'admin_stat_clients'        => 'Clients',
    'admin_add_user_btn'        => 'Add User',
    'admin_col_user'            => 'User',
    'admin_col_email'           => 'Email',
    'admin_col_role'            => 'Role',
    'admin_role_admin'          => 'Administrator',
    'admin_role_client'         => 'Client',
    'admin_no_users'            => 'No users found.',

    /* ────────────────────────────────────────────────
     * ADMIN — USER DETAILS
     * ──────────────────────────────────────────────── */
    'admin_user_details_title'  => 'User Information',
    'admin_user_edit_btn'       => 'Edit',
    'admin_user_orders_title'   => 'User Orders',
    'admin_user_no_orders'      => 'This user has not placed any orders yet.',
    'admin_user_actions'        => 'Actions',
    'admin_user_edit_action'    => 'Edit user',
    'admin_user_delete_action'  => 'Delete user',
    'admin_user_view_orders'    => 'View orders',
    'admin_user_back'           => 'Back to users',
    'admin_user_profile_subtitle'=> 'Sabaya Luxury user profile.',
    'admin_user_id_label'       => 'User ID:',
    'admin_user_order_count'    => 'Number of orders',

    /* ────────────────────────────────────────────────
     * ADMIN — STATISTICS
     * ──────────────────────────────────────────────── */
    'admin_stats_title'         => 'Statistics',
    'admin_stats_subtitle'      => 'Performance analysis of the Sabaya Luxury store.',
    'admin_kpi_products'        => 'Products',
    'admin_kpi_categories'      => 'Categories',
    'admin_kpi_clients'         => 'Clients',
    'admin_kpi_orders'          => 'Orders',
    'admin_kpi_revenue'         => 'Revenue',
    'admin_kpi_avg_cart'        => 'Average cart:',
    'admin_chart_title'         => 'Orders & Revenue Evolution',
    'admin_insight_catalog'     => 'Product Catalogue',
    'admin_insight_orders'      => 'Order Activity',
    'admin_insight_growth'      => 'Client Growth',
    'admin_insight_perf'        => 'Store Performance',
    'admin_insight_total_prod'  => 'Total products',
    'admin_insight_active_cat'  => 'Active categories',
    'admin_insight_avg_per_cat' => 'Avg. / category',
    'admin_insight_total_orders'=> 'Total orders',
    'admin_insight_avg_cart'    => 'Average cart',
    'admin_insight_in_progress' => 'In progress',
    'admin_insight_total_members'=> 'Total registered',
    'admin_insight_orders_per_client'=> 'Orders / client',
    'admin_insight_spend_per_client' => 'Spend / client',
    'admin_insight_revenue'     => 'Revenue',
    'admin_insight_delivered'   => 'Delivered',
    'admin_insight_cancelled'   => 'Cancelled',

    /* ────────────────────────────────────────────────
     * LANGUAGE SWITCHER
     * ──────────────────────────────────────────────── */
    'lang_switcher_label'       => 'Language',
    'lang_fr'                   => 'FR',
    'lang_en'                   => 'EN',

    /* ────────────────────────────────────────────────
     * FOOTER
     * ──────────────────────────────────────────────── */
    'footer_brand_desc'         => 'Your destination for modern, elegant, premium-quality abayas in Morocco.',
    'footer_quick_links'        => 'Quick Links',
    'footer_contact'            => 'Contact',
    'footer_copyright'          => 'All rights reserved.',

];
