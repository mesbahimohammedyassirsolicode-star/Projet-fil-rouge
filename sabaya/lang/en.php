<?php
/**
 * Language file: English (en)
 * Sabaya Luxury — Complete Localization System
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
    'home_hero_subtitle'    => 'SABAYA LUXURY',
    'home_hero_desc'        => 'Discover refined abaya collections, designed for modern women who seek elegance, comfort, and distinction.',
    'home_btn_collection'   => 'Explore the Collection',
    'home_btn_story'        => 'Our Story',
    'home_new_arrivals'     => 'New Arrivals',
    'home_view_details'     => 'View details',

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
    'products_search_placeholder'=> 'Search the collection...',

    /* ────────────────────────────────────────────────
     * CATEGORY PAGE
     * ──────────────────────────────────────────────── */
    'category_title_prefix'       => 'Abayas',
    'category_desc'               => 'Discover our selection of abayas in the {name} category. Elegant and modern pieces, designed for the woman of today.',
    'category_empty'              => 'No products found in this category.',

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
    'product_currency'          => 'MAD',
    'breadcrumb_label'            => 'Breadcrumb',
    'product_details_label'       => 'Product details',
    'product_alt_abaya'           => 'Abaya',
    'product_alt_size'            => 'size',
    'product_page_title_suffix'   => 'Sabaya Luxury — Modern Abayas',
    'product_page_description_suffix' => 'Available on Sabaya Luxury in Morocco.',
    'product_page_keywords'       => 'abaya, modest fashion, Sabaya Luxury, Morocco',

    /* ────────────────────────────────────────────────
     * WISHLIST
     * ──────────────────────────────────────────────── */
    'wishlist_title'            => 'My Wishlist',
    'wishlist_empty_title'      => 'No products in your wishlist.',
    'wishlist_empty_text'       => 'Explore our luxurious abaya collection and save your favourite pieces to find them here.',
    'wishlist_discover_btn'     => 'Discover our products',
    'wishlist_remove'           => 'Remove',
    'wishlist_continue_shopping'=> 'Continue shopping',
    'wishlist_hero_label'       => 'Personal Collection',
    'wishlist_hero_subtitle'    => 'Find your saved favourite products.',
    'wishlist_article_count'    => 'saved item(s)',
    'wishlist_details'          => 'View Details',
    'wishlist_brand'            => 'Sabaya Luxury',

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
    'checkout_eyebrow'          => 'Sabaya Luxury',
    'checkout_placeholder_city' => 'e.g., Casablanca',
    'checkout_placeholder_addr' => 'e.g., 12 Rue Al Amine, Maarif',
    'checkout_placeholder_postal'=> 'e.g., 20000',
    'checkout_error_title'      => 'Please fix the following errors:',

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
    'search_results_count'      => 'product(s) found',
    'search_label_hint'         => 'Enter a keyword to search for abayas or clothing.',
    'search_sr_label'           => 'Search for a product',

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
    'login_page_title'          => 'Login | Sabaya Luxury',
    'login_all_fields_required' => 'All fields are required',
    'login_invalid_credentials' => 'Incorrect email or password',
    'login_welcome_admin'       => 'Welcome to the administrator space.',
    'login_welcome_user'        => 'Login successful. Welcome, {name}!',

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
    'register_password_mismatch'=> 'Passwords do not match',
    'register_email_taken'      => 'This email is already in use',
    'register_password_length'  => 'Password must be at least 8 characters long',
    'register_phone_digits'     => 'Phone must contain only digits',
    'register_lastname_letters' => 'Last name must contain only letters',
    'register_firstname_letters'=> 'First name must contain only letters',
    'register_success'          => 'Account created successfully. You can now log in.',

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
    'profile_page_title'               => 'My Profile | Sabaya Luxury',
    'profile_page_description'         => 'Manage your Sabaya Luxury profile.',

    /* ────────────────────────────────────────────────
     * CONTACT
     * ──────────────────────────────────────────────── */
    'contact_page_title'        => 'Contact Us | Sabaya Luxury',
    'contact_hero_label'        => 'Customer Service',
    'contact_hero_title'        => 'Contact Sabaya Luxury',
    'contact_hero_subtitle'     => 'A question about our collections, an ongoing order, or personalised advice? Our team is here to provide you with an experience that meets your expectations.',
    'contact_info_title'        => 'Our Contact Details',
    'contact_info_intro'        => 'Feel free to reach out through whichever channel suits you best. We are available to answer all your questions.',
    'contact_label_email'       => 'Email',
    'contact_label_phone'       => 'Phone',
    'contact_label_address'     => 'Address',
    'contact_label_hours'       => 'Opening Hours',
    'contact_hours_value'       => 'Mon – Sat: 09:00 – 19:00<br>Sunday: Closed',
    'contact_form_title'        => 'Send us a message',
    'contact_form_name'         => 'Name',
    'contact_form_name_placeholder'=> 'Your full name',
    'contact_form_email'        => 'Email',
    'contact_form_email_placeholder'=> 'your@email.com',
    'contact_form_subject'      => 'Subject',
    'contact_form_subject_placeholder'=> 'Subject of your message',
    'contact_form_message'      => 'Message',
    'contact_form_message_placeholder'=> 'Describe your request in detail...',
    'contact_form_submit'       => 'Send Message',
    'contact_required'          => 'required',
    'contact_success_message'   => 'Your message has been sent successfully. We will reply as soon as possible.',
    'contact_err_name_required'   => 'Name is required',
    'contact_err_name_invalid'    => 'Name must contain only letters',
    'contact_err_email_required'  => 'Email is required',
    'contact_err_email_invalid'   => 'Invalid email address',
    'contact_err_subject_required'=> 'Subject is required',
    'contact_err_message_required'=> 'Message is required',

    /* ────────────────────────────────────────────────
     * ABOUT
     * ──────────────────────────────────────────────── */
    'about_hero_label'              => 'Sabaya Luxury',
    'about_hero_title'              => 'About <em>Sabaya Luxury</em>',
    'about_hero_subtitle'           => 'Timeless elegance at the service of the modern woman.',
    'about_story_title'             => 'Our Story',
    'about_story_p1'                => 'Sabaya Luxury was born from a deep passion for modest fashion and exceptional craftsmanship. Founded in Casablanca, our house draws inspiration from the richness of Moroccan heritage and contemporary international elegance.',
    'about_story_p2'                => 'Each piece in our collection is the result of meticulous know-how, where luxury is defined by the quality of fabrics, the precision of cuts, and attention to the smallest details. We believe that true elegance does not shout — it whispers.',
    'about_story_p3'                => 'Today, Sabaya Luxury accompanies a modern, demanding, and refined woman who refuses to choose between her values and her style. Our vision: to make each abaya a wearable work of art, timeless and deeply personal.',
    'about_mission_label'           => 'Our Mission',
    'about_mission_title'           => 'The art of modest fashion, reinvented with excellence.',
    'about_mission_p1'              => 'Our mission is to offer women abayas and modest fashion pieces of impeccable quality, combining tradition, comfort, and contemporary luxury.',
    'about_mission_p2'              => 'We rigorously select each fabric, collaborate with talented artisans, and design silhouettes that enhance without ever betraying the essence of the woman who wears them.',
    'about_mission_p3'              => 'At Sabaya Luxury, fashion is an act of trust — and we are committed to honouring that trust with absolute dedication.',
    'about_pillar_tradition_title'  => 'Tradition',
    'about_pillar_tradition_text'   => 'A precious cultural heritage, celebrated in every creation.',
    'about_pillar_comfort_title'    => 'Comfort',
    'about_pillar_comfort_text'     => 'Noble materials, soft and pleasant to wear every day.',
    'about_pillar_luxe_title'       => 'Luxury',
    'about_pillar_luxe_text'        => 'Artisanal excellence at the service of a rare and refined elegance.',
    'about_values_label'            => 'Our Values',
    'about_values_title'            => 'The pillars of our house',
    'about_value_quality_title'     => 'Quality',
    'about_value_quality_text'      => 'Premium fabrics, impeccable finishes, and rigorous control for pieces that stand the test of time.',
    'about_value_elegance_title'    => 'Elegance',
    'about_value_elegance_text'     => 'A clean, modern, and timeless aesthetic that transcends fleeting trends.',
    'about_value_authenticity_title'=> 'Authenticity',
    'about_value_authenticity_text' => 'A sincere commitment to our roots, our values, and the woman we dress.',
    'about_value_satisfaction_title'=> 'Customer Satisfaction',
    'about_value_satisfaction_text' => 'An impeccable experience, from discovery to delivery, for every Sabaya client.',
    'about_why_label'               => 'Why Sabaya',
    'about_why_title'               => 'Excellence, down to the last detail',
    'about_why_craft_title'         => 'Exceptional Craftsmanship',
    'about_why_craft_text'          => 'Each piece is crafted with meticulous care by experienced artisans, guaranteeing perfect finishes.',
    'about_why_fabrics_title'       => 'Noble and Sustainable Fabrics',
    'about_why_fabrics_text'        => 'We select only premium materials — silk, crepe, linen — for absolute comfort and remarkable durability.',
    'about_why_design_title'        => 'Exclusive Designs',
    'about_why_design_text'         => 'Our collections are designed in limited editions, giving every woman the certainty of wearing a unique and rare piece.',
    'about_why_shipping_title'      => 'Careful Delivery',
    'about_why_shipping_text'       => 'Luxurious packaging and fast delivery across Morocco, for an experience worthy of the greatest maisons.',
    'about_why_service_title'       => 'Personalised Service',
    'about_why_service_text'        => 'Our team listens to every client, offering style advice and bespoke support, from selection to delivery.',
    'about_why_privacy_title'       => 'Trust and Discretion',
    'about_why_privacy_text'        => 'Your privacy is sacred. Secure payments, protected data, and fully confidential delivery.',
    'about_cta_label'               => 'Explore our universe',
    'about_cta_title'               => 'Your next exceptional piece awaits.',
    'about_cta_btn'                 => 'Discover Our Collections',

    /* ────────────────────────────────────────────────
     * CHECKOUT VALIDATION
     * ──────────────────────────────────────────────── */
    'checkout_err_city_required'      => 'City is required',
    'checkout_err_address_required'   => 'Address is required',
    'checkout_err_postal_required'      => 'Postal code is required',
    'checkout_err_stock_insufficient' => 'Insufficient stock for: {product}',
    'checkout_err_generic'            => 'An error occurred while placing your order. Please try again.',

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
    'admin_toggle_menu'         => 'Open menu',
    'admin_search_label'        => 'Search',
    'admin_search_placeholder'  => 'Search...',
    'admin_my_profile'          => 'My profile',
    'admin_sidebar_aria'        => 'Admin menu',
    'admin_nav_aria'            => 'Main admin navigation',
    'admin_stats_aria_orders'   => 'Order statistics',
    'admin_orders_search_label' => 'Search for an order',
    'admin_orders_search_placeholder' => 'Search for an order...',
    'admin_orders_results_text' => 'Search results for',
    'admin_orders_table_caption' => 'List of all placed orders',

    /* ────────────────────────────────────────────────
     * ADMIN — OVERVIEW
     * ──────────────────────────────────────────────── */
    'admin_overview_title'      => 'Overview',
    'admin_overview_subtitle'   => 'Welcome to your administration space.',
    'admin_stat_total_products' => 'Total Products',
    'admin_stat_total_orders'   => 'Total Orders',
    'admin_stat_total_clients'  => 'Total Clients',
    'admin_stat_messages'       => 'Contact Messages',
    'admin_revenue_title'       => 'Revenue',
    'admin_chart_orders_title'  => 'Orders Evolution',
    'admin_quick_actions'       => 'Quick Actions',
    'admin_stats_aria'          => 'General statistics',
    'admin_orders_processed'    => 'orders processed',
    'admin_recent_orders_caption' => 'List of the 5 most recent orders',
    'admin_top_products_caption'  => 'Top 5 best-selling products',
    'admin_table_qty_sold'         => 'Qty Sold',
    'admin_chart_yaxis_orders'     => 'Orders',
    'admin_chart_yaxis_revenue'    => 'Revenue (MAD)',
    'admin_footer_copyright'       => 'Copyright &copy; %d Sabaya Luxury. All rights reserved.',
    'admin_add_product_btn'     => 'Add Product',
    'admin_add_category_btn'    => 'Add Category',
    'admin_view_orders_btn'     => 'View Orders',
    'admin_view_clients_btn'    => 'View Clients',
    'admin_recent_orders'       => 'Recent Orders',
    'admin_view_all'            => 'View all',
    'admin_top_products'        => 'Top Selling Products',
    'admin_no_orders_yet'       => 'No orders yet.',
    'admin_no_sales_yet'        => 'No sales recorded.',
    'admin_order_table_cmd'     => 'Order',
    'admin_order_table_client'  => 'Client',
    'admin_order_table_date'    => 'Date',
    'admin_order_table_status'  => 'Status',
    'admin_order_table_amount'  => 'Amount',

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
    'admin_products_list_title' => 'Product List',
    'admin_products_search_placeholder' => 'Search for a product...',
    'admin_no_products_found'   => 'No products found',
    'admin_products_results_text'=> 'Search results for',
    'admin_products_subtitle_default'=> 'Manage the details, prices, and stock of your creations.',
    'admin_pagination_showing'  => 'Showing',
    'admin_pagination_of'       => 'of',
    'admin_pagination_products' => 'products',

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
    'admin_categories_list_title'=> 'Category List',
    'admin_categories_search_placeholder'=> 'Search for a category...',
    'admin_no_categories_found' => 'No categories found',
    'admin_categories_results_text'=> 'Search results for',
    'admin_pagination_categories'=> 'categories',

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
    'admin_orders_list_title'   => 'Order List',
    'admin_orders_empty_back'   => 'Back to Dashboard',
    'admin_pagination_orders'   => 'orders',

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
    'admin_order_breadcrumb'            => 'Order',
    'admin_order_details_subtitle'      => 'Complete details of the customer order.',

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
    'admin_users_list_title'    => 'User List',
    'admin_users_subtitle_list' => 'View and manage your Sabaya community accounts.',
    'admin_pagination_users'    => 'users',

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
     * ADMIN — MESSAGES
     * ──────────────────────────────────────────────── */
    'admin_messages_page_title'   => 'Contact Messages',
    'admin_messages_subtitle'     => 'View and manage messages sent by clients.',
    'admin_messages_all_title'    => 'All Messages',
    'admin_stat_total_messages'   => 'Total Messages',
    'admin_stat_today'            => 'Today',
    'admin_stat_this_week'        => 'This Week',
    'admin_no_messages'           => 'No contact messages at the moment.',
    'admin_col_name'              => 'Name',
    'admin_col_subject'           => 'Subject',
    'admin_messages_search_placeholder'=> 'Search for a message...',
    'admin_pagination_messages'   => 'messages',

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
    'admin_total_orders_label'  => 'Total Orders',
    'admin_revenue_chart_label' => 'Revenue (MAD)',
    'admin_orders_chart_label'  => 'Orders',

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
    'footer_home'               => 'Home',
    'footer_shop'               => 'Shop',
    'footer_about'              => 'About',
    'footer_address'            => 'Tangier, Morocco',
    'footer_email'              => 'contact@sabaya.ma',
    'footer_phone'              => '+212 6XX XXX XXX',

    /* ────────────────────────────────────────────────
     * SITEMAP / META
     * ──────────────────────────────────────────────── */
    'site_name'                 => 'Sabaya Luxury',
    'site_tagline'              => 'Luxury Abaya and Modest Fashion Boutique',
    'meta_default_desc'         => 'Sabaya Luxury — Boutique en ligne d\'abayas modernes et élégantes au Maroc. Discover our collections of modest fashion, premium abayas, and refined women\'s clothing.',

    /* ────────────────────────────────────────────────
     * TOASTS / FLASH MESSAGES
     * ──────────────────────────────────────────────── */
    'toast_order_success'        => 'Your order has been placed successfully!',

    /* ────────────────────────────────────────────────
     * ORDER DETAILS (FRONT)
     * ──────────────────────────────────────────────── */
    'order_details_view'         => 'View details',

    /* ────────────────────────────────────────────────
     * ADMIN SHARED
     * ──────────────────────────────────────────────── */
    'admin_copyright'            => 'Copyright',
    'admin_order_breadcrumb_list'  => 'Back to orders',
    'admin_breadcrumb_back'      => 'Back',
    'admin_table_no_data'        => 'No data available.',

    /* ────────────────────────────────────────────────
     * WHATSAPP
     * ──────────────────────────────────────────────── */
    'whatsapp_order_intro'       => "Hello Sabaya Luxury\n\nI would like to confirm my order.\n\nOrder No.",
    'whatsapp_products'          => 'Products:',
    'whatsapp_total'               => 'Total',
    'whatsapp_city'                => 'City',
    'whatsapp_thanks'              => 'Thank you.',

];
