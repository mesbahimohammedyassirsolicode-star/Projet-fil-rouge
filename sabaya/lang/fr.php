<?php
/**
 * Fichier de langue : Français (fr)
 * Sabaya Luxury — Système de localisation complet
 *
 * Structure : tableau associatif $lang[clé] = 'traduction'
 * Langue par défaut. Toutes les autres langues se replient sur ce fichier
 * lorsqu'une clé est absente.
 */

$lang = [

    /* ────────────────────────────────────────────────
     * NAVIGATION & GLOBAL
     * ──────────────────────────────────────────────── */
    'nav_home'              => 'Accueil',
    'nav_products'          => 'Produits',
    'nav_about'             => 'À propos',
    'nav_search'            => 'Recherche',
    'nav_wishlist'          => 'Liste de souhaits',
    'nav_account'           => 'Mon Compte',
    'nav_cart'              => 'Panier',
    'nav_login'             => 'Connexion',
    'nav_dashboard_admin'   => 'Tableau de bord',
    'nav_menu_open'         => 'Ouvrir le menu de navigation',

    /* ────────────────────────────────────────────────
     * PAGE D'ACCUEIL
     * ──────────────────────────────────────────────── */
    'home_hero_title'       => "L'Art de la<br>Modestie",
    'home_hero_subtitle'    => 'SABAYA LUXURY',
    'home_hero_desc'        => "Découvrez des collections d'abayas raffinées, conçues pour les femmes modernes qui recherchent élégance, confort et distinction.",
    'home_btn_collection'   => 'Explorer la collection',
    'home_btn_story'        => 'Notre histoire',
    'home_new_arrivals'     => 'Nouvelles Arrivées',
    'home_view_details'     => 'Voir détails',

    /* ────────────────────────────────────────────────
     * PAGE PRODUITS
     * ──────────────────────────────────────────────── */
    'products_page_title'       => 'Collection Moderne',
    'products_page_subtitle'    => 'L\'essentiel raffiné pour la femme contemporaine.',
    'products_filter_all'       => 'Tous',
    'products_view_details'     => 'Voir détails',
    'products_view_details_btn' => 'Voir Détails',
    'products_empty'            => 'Aucun produit disponible.',
    'products_brand'            => 'SABAYA',
    'products_search_placeholder'=> 'Rechercher dans la collection...',

    /* ────────────────────────────────────────────────
     * PAGE CATÉGORIE
     * ──────────────────────────────────────────────── */
    'category_title_prefix'       => 'Abayas',
    'category_desc'               => 'Découvrez notre sélection d\'abayas dans la catégorie {name}. Des pièces élégantes et modernes, conçues pour la femme d\'aujourd\'hui.',
    'category_empty'              => 'Aucun produit trouvé dans cette catégorie.',

    /* ────────────────────────────────────────────────
     * PAGE DÉTAIL PRODUIT
     * ──────────────────────────────────────────────── */
    'product_add_to_cart'       => 'Ajouter au panier',
    'product_add_to_wishlist'   => 'Ajouter à la liste de souhaits',
    'product_view_wishlist'     => 'Voir la liste de souhaits',
    'product_color'             => 'Couleur',
    'product_size'              => 'Taille',
    'product_breadcrumb_home'   => 'Accueil',
    'product_breadcrumb_collection' => 'Collection',
    'product_currency'          => 'MAD',
    'breadcrumb_label'            => 'Fil d\'Ariane',
    'product_details_label'       => 'Détails du produit',
    'product_alt_abaya'           => 'Abaya',
    'product_alt_size'            => 'taille',
    'product_page_title_suffix'   => 'Sabaya Luxury — Abayas Modernes',
    'product_page_description_suffix' => 'Disponible sur Sabaya Luxury au Maroc.',
    'product_page_keywords'       => 'abaya, mode modeste, Sabaya Luxury, Maroc',

    /* ────────────────────────────────────────────────
     * LISTE DE SOUHAITS
     * ──────────────────────────────────────────────── */
    'wishlist_title'            => 'Ma Liste de Souhaits',
    'wishlist_empty_title'      => 'Aucun produit dans votre liste de souhaits.',
    'wishlist_empty_text'       => 'Explorez notre collection d\'abayas luxueuses et enregistrez vos pièces favorites pour les retrouver ici.',
    'wishlist_discover_btn'     => 'Découvrir nos produits',
    'wishlist_remove'           => 'Retirer',
    'wishlist_continue_shopping'=> 'Continuer vos achats',
    'wishlist_hero_label'       => 'Collection Personnelle',
    'wishlist_hero_subtitle'    => 'Retrouvez vos produits favoris enregistrés.',
    'wishlist_article_count'    => 'article(s) enregistré(s)',
    'wishlist_details'          => 'Voir Détails',
    'wishlist_brand'            => 'Sabaya Luxury',

    /* ────────────────────────────────────────────────
     * PANIER
     * ──────────────────────────────────────────────── */
    'cart_title'                => 'Mon Panier',
    'cart_subtitle'             => 'Votre Sélection',
    'cart_empty_text'           => 'Votre panier est vide.',
    'cart_discover_btn'         => 'Découvrir la Collection',
    'cart_col_image'            => 'Image',
    'cart_col_product'          => 'Produit',
    'cart_col_price'            => 'Prix',
    'cart_col_qty'              => 'Quantité',
    'cart_col_subtotal'         => 'Sous-total',
    'cart_col_action'           => 'Action',
    'cart_order_summary'        => 'Résumé de la Commande',
    'cart_total'                => 'Total',
    'cart_checkout_btn'         => 'Passer la Commande',
    'cart_continue_btn'         => 'Continuer mes Achats',
    'cart_remove'               => 'Supprimer',

    /* ────────────────────────────────────────────────
     * COMMANDE / CHECKOUT
     * ──────────────────────────────────────────────── */
    'checkout_title'            => 'Finaliser la commande',
    'checkout_intro'            => 'Complétez vos informations de livraison pour confirmer votre achat.',
    'checkout_shipping_title'   => 'Informations de livraison',
    'checkout_summary_title'    => 'Récapitulatif',
    'checkout_confirm_btn'      => 'Confirmer la commande',
    'checkout_back_to_cart'     => 'Retour au panier',
    'checkout_city'             => 'Ville',
    'checkout_address'          => 'Adresse',
    'checkout_postal_code'      => 'Code Postal',
    'checkout_qty_label'        => 'Quantité :',
    'checkout_eyebrow'          => 'Sabaya Luxury',
    'checkout_placeholder_city' => 'Ex : Casablanca',
    'checkout_placeholder_addr' => 'Ex : 12 Rue Al Amine, Maarif',
    'checkout_placeholder_postal'=> 'Ex : 20000',
    'checkout_error_title'      => 'Veuillez corriger les erreurs suivantes :',

    /* ────────────────────────────────────────────────
     * COMMANDE SUCCÈS
     * ──────────────────────────────────────────────── */
    'order_success_title'       => 'Commande enregistrée avec succès',
    'order_success_thanks'      => 'Merci pour votre confiance.',
    'order_success_whatsapp_msg'=> 'Veuillez confirmer votre commande via WhatsApp afin que notre équipe puisse la traiter rapidement.',
    'order_whatsapp_btn'        => 'Confirmer via WhatsApp',
    'order_view_orders'         => 'Voir mes commandes',
    'order_continue_shopping'   => 'Continuer mes achats',

    /* ────────────────────────────────────────────────
     * MES COMMANDES
     * ──────────────────────────────────────────────── */
    'my_orders_title'           => 'Mes Commandes',
    'my_orders_subtitle'        => 'Retrouvez l\'ensemble de vos commandes passées sur Sabaya Luxury',
    'my_orders_empty_title'     => 'Aucune commande',
    'my_orders_empty_text'      => 'Vous n\'avez pas encore passé de commande.',
    'my_orders_discover_btn'    => 'Découvrir la Collection',
    'my_orders_view_details'    => 'Voir Détails',
    'my_orders_order_label'     => 'Commande',
    'my_orders_total'           => 'Total',
    'my_orders_history_label'   => 'Votre Historique',

    /* ────────────────────────────────────────────────
     * RECHERCHE
     * ──────────────────────────────────────────────── */
    'search_title'              => 'Recherche de Produits',
    'search_subtitle'           => 'Trouvez facilement les produits qui correspondent à votre style.',
    'search_placeholder'        => 'Rechercher un produit...',
    'search_btn'                => 'Rechercher',
    'search_results_title'      => 'Résultats de recherche',
    'search_empty_title'        => 'Aucun produit trouvé.',
    'search_empty_text'         => 'Essayez avec d\'autres mots-clés ou explorez notre collection.',
    'search_back_to_store'      => 'Retour à la boutique',
    'search_results_count'      => 'produit(s) trouvé(s)',
    'search_label_hint'         => 'Saisissez un mot-clé pour rechercher des abayas ou vêtements.',
    'search_sr_label'           => 'Rechercher un produit',

    /* ────────────────────────────────────────────────
     * AUTHENTIFICATION
     * ──────────────────────────────────────────────── */
    'login_title'               => 'Connexion',
    'login_legend'              => 'Identifiants de connexion',
    'login_email'               => 'Email',
    'login_password'            => 'Mot de passe',
    'login_submit'              => 'Se connecter',
    'login_no_account'          => 'Vous n\'avez pas encore de compte ?',
    'login_sign_up_link'        => 'Créer un compte',
    'login_page_title'          => 'Connexion | Sabaya Luxury',
    'login_all_fields_required' => 'Tous les champs sont obligatoires',
    'login_invalid_credentials' => 'Email ou mot de passe incorrect',
    'login_welcome_admin'       => 'Bienvenue dans l\'espace administrateur.',
    'login_welcome_user'        => 'Connexion réussie. Bienvenue, {name} !',

    'register_title'            => 'Créer un compte',
    'register_legend'           => 'Informations d\'inscription',
    'register_nom'              => 'Nom',
    'register_prenom'           => 'Prénom',
    'register_phone'            => 'Téléphone',
    'register_email'            => 'Email',
    'register_password'         => 'Mot de passe',
    'register_confirm'          => 'Confirmer le mot de passe',
    'register_submit'           => 'S\'inscrire',
    'register_have_account'     => 'Vous avez déjà un compte ?',
    'register_login_link'       => 'Se connecter',
    'register_password_mismatch'=> 'Les mots de passe ne correspondent pas',
    'register_email_taken'      => 'L\'email est déjà utilisé',
    'register_password_length'  => 'Le mot de passe doit contenir au moins 8 caractères',
    'register_phone_digits'     => 'Le téléphone doit contenir uniquement des chiffres',
    'register_lastname_letters' => 'Le nom doit contenir uniquement des lettres',
    'register_firstname_letters'=> 'Le prénom doit contenir uniquement des lettres',
    'register_success'          => 'Compte créé avec succès. Vous pouvez maintenant vous connecter.',

    /* ────────────────────────────────────────────────
     * PROFIL
     * ──────────────────────────────────────────────── */
    'profile_title'             => 'Mon Compte',
    'profile_welcome'           => 'Bienvenue,',
    'profile_logout'            => 'Se déconnecter',
    'profile_menu_personal_info'=> 'Informations personnelles',
    'profile_menu_cart'         => 'Panier',
    'profile_menu_wishlist'     => 'Liste de souhaits',
    'profile_menu_orders'       => 'Historique des commandes',
    'profile_edit_title'        => 'Modifier mes informations',
    'profile_last_name'         => 'Nom',
    'profile_first_name'        => 'Prénom',
    'profile_email'             => 'Email',
    'profile_phone'             => 'Téléphone',
    'profile_phone_placeholder' => 'Ex : 0612345678',
    'profile_save_btn'          => 'Enregistrer les modifications',
    'profile_success'           => 'Votre profil a été mis à jour avec succès.',

    /* Validation messages (profil) */
    'profile_err_last_name_required'  => 'Le nom est obligatoire.',
    'profile_err_last_name_letters'   => 'Le nom doit contenir uniquement des lettres.',
    'profile_err_first_name_required' => 'Le prénom est obligatoire.',
    'profile_err_first_name_letters'  => 'Le prénom doit contenir uniquement des lettres.',
    'profile_err_email_required'      => 'L\'email est obligatoire.',
    'profile_err_email_invalid'       => 'Adresse email invalide.',
    'profile_err_email_taken'         => 'Cet email est déjà utilisé par un autre compte.',
    'profile_err_phone_digits'        => 'Le numéro de téléphone doit contenir uniquement des chiffres.',
    'profile_page_title'               => 'Mon Profil | Sabaya Luxury',
    'profile_page_description'         => 'Gérez votre profil Sabaya Luxury.',

    /* ────────────────────────────────────────────────
     * CONTACT
     * ──────────────────────────────────────────────── */
    'contact_page_title'        => 'Contactez-nous | Sabaya Luxury',
    'contact_hero_label'        => 'Service Client',
    'contact_hero_title'        => 'Contactez Sabaya Luxury',
    'contact_hero_subtitle'     => 'Une question sur nos collections, une commande en cours ou un conseil personnalisé ? Notre équipe est à votre écoute pour vous offrir une expérience à la hauteur de vos attentes.',
    'contact_info_title'        => 'Nos Coordonnées',
    'contact_info_intro'        => 'N\'hésitez pas à nous contacter par le moyen qui vous convient le mieux. Nous sommes disponibles pour répondre à toutes vos questions.',
    'contact_label_email'       => 'Email',
    'contact_label_phone'       => 'Téléphone',
    'contact_label_address'     => 'Adresse',
    'contact_label_hours'       => 'Heures d\'ouverture',
    'contact_hours_value'       => 'Lun – Sam : 09h00 – 19h00<br>Dimanche : Fermé',
    'contact_form_title'        => 'Envoyez-nous un message',
    'contact_form_name'         => 'Nom',
    'contact_form_name_placeholder'=> 'Votre nom complet',
    'contact_form_email'        => 'Email',
    'contact_form_email_placeholder'=> 'votre@email.com',
    'contact_form_subject'      => 'Sujet',
    'contact_form_subject_placeholder'=> 'Sujet de votre message',
    'contact_form_message'      => 'Message',
    'contact_form_message_placeholder'=> 'Décrivez votre demande en détail...',
    'contact_form_submit'       => 'Envoyer le message',
    'contact_required'          => 'obligatoire',
    'contact_success_message'   => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.',
    'contact_err_name_required'   => 'Le nom est obligatoire',
    'contact_err_name_invalid'    => 'Le nom doit contenir uniquement des lettres',
    'contact_err_email_required'  => 'L\'email est obligatoire',
    'contact_err_email_invalid'   => 'Adresse email invalide',
    'contact_err_subject_required'=> 'Le sujet est obligatoire',
    'contact_err_message_required'=> 'Le message est obligatoire',

    /* ────────────────────────────────────────────────
     * ABOUT
     * ──────────────────────────────────────────────── */
    'about_hero_label'              => 'Sabaya Luxury',
    'about_hero_title'              => 'À propos de <em>Sabaya Luxury</em>',
    'about_hero_subtitle'           => "L'élégance intemporelle au service de la femme moderne.",
    'about_story_title'             => 'Notre Histoire',
    'about_story_p1'                => "Sabaya Luxury est née d'une passion profonde pour la mode modeste et l'artisanat d'exception. Fondée à Casablanca, notre maison puise son inspiration dans la richesse du patrimoine marocain et l'élégance contemporaine internationale.",
    'about_story_p2'                => "Chaque pièce de notre collection est le fruit d'un savoir-faire méticuleux, où le luxe se définit par la qualité des tissus, la précision des coupes et l'attention portée aux moindres détails. Nous croyons que la vraie élégance ne crie pas — elle murmure.",
    'about_story_p3'                => "Aujourd'hui, Sabaya Luxury accompagne une femme moderne, exigeante et raffinée, qui refuse de choisir entre ses valeurs et son style. Notre vision : faire de chaque abaya une œuvre d'art portable, intemporelle et profondément personnelle.",
    'about_mission_label'           => 'Notre Mission',
    'about_mission_title'           => "L'art de la mode modeste, réinventé avec excellence.",
    'about_mission_p1'              => 'Notre mission est d\'offrir aux femmes des abayas et des pièces de mode modeste d\'une qualité irréprochable, alliant tradition, confort et luxe contemporain.',
    'about_mission_p2'              => 'Nous sélectionnons chaque tissu avec rigueur, collaborons avec des artisans talentueux et concevons des silhouettes qui subliment sans jamais trahir l\'essence de la femme qui les porte.',
    'about_mission_p3'              => 'Chez Sabaya Luxury, la mode est un acte de confiance — et nous nous engageons à honorer cette confiance avec une exigence absolue.',
    'about_pillar_tradition_title'  => 'Tradition',
    'about_pillar_tradition_text'   => "Un héritage culturel précieux, célébré dans chaque création.",
    'about_pillar_comfort_title'    => 'Confort',
    'about_pillar_comfort_text'     => 'Des matières nobles, douces et agréables à porter au quotidien.',
    'about_pillar_luxe_title'       => 'Luxe',
    'about_pillar_luxe_text'        => 'L\'excellence artisanale au service d\'une élégance rare et raffinée.',
    'about_values_label'            => 'Nos Valeurs',
    'about_values_title'            => 'Les piliers de notre maison',
    'about_value_quality_title'     => 'Qualité',
    'about_value_quality_text'      => 'Des tissus premium, des finitions impeccables et un contrôle rigoureux pour des pièces qui traversent le temps.',
    'about_value_elegance_title'    => 'Élégance',
    'about_value_elegance_text'     => 'Une esthétique épurée, moderne et intemporelle qui transcende les tendances passagères.',
    'about_value_authenticity_title'=> 'Authenticité',
    'about_value_authenticity_text' => 'Un engagement sincère envers nos racines, nos valeurs et la femme que nous habillons.',
    'about_value_satisfaction_title'=> 'Satisfaction Client',
    'about_value_satisfaction_text' => 'Une expérience irréprochable, de la découverte à la livraison, pour chaque cliente Sabaya.',
    'about_why_label'               => 'Pourquoi Sabaya',
    'about_why_title'               => "L'excellence, à chaque détail",
    'about_why_craft_title'         => "Artisanat d'exception",
    'about_why_craft_text'          => 'Chaque pièce est confectionnée avec un soin méticuleux par des artisans expérimentés, garantissant des finitions parfaites.',
    'about_why_fabrics_title'       => 'Tissus nobles et durables',
    'about_why_fabrics_text'        => 'Nous sélectionnons uniquement des matières premium — soie, crêpe, lin — pour un confort absolu et une durabilité remarquable.',
    'about_why_design_title'        => 'Designs exclusifs',
    'about_why_design_text'         => 'Nos collections sont pensées en éditions limitées, offrant à chaque femme la certitude de porter une pièce unique et rare.',
    'about_why_shipping_title'      => 'Livraison soignée',
    'about_why_shipping_text'       => 'Un emballage luxueux et une livraison rapide à travers tout le Maroc, pour une expérience digne des plus grandes maisons.',
    'about_why_service_title'       => 'Service personnalisé',
    'about_why_service_text'        => 'Notre équipe est à l\'écoute de chaque cliente, offrant conseils de style et accompagnement sur-mesure, du choix à la livraison.',
    'about_why_privacy_title'       => 'Confiance et discrétion',
    'about_why_privacy_text'        => 'Votre vie privée est sacrée. Paiements sécurisés, données protégées et livraison en toute confidentialité.',
    'about_cta_label'               => 'Explorez notre univers',
    'about_cta_title'               => 'Votre prochaine pièce d\'exception vous attend.',
    'about_cta_btn'                 => 'Découvrir Nos Collections',

    /* ────────────────────────────────────────────────
     * CHECKOUT VALIDATION
     * ──────────────────────────────────────────────── */
    'checkout_err_city_required'      => 'La ville est obligatoire',
    'checkout_err_address_required'   => 'L\'adresse est obligatoire',
    'checkout_err_postal_required'    => 'Le code postal est obligatoire',
    'checkout_err_stock_insufficient' => 'Stock insuffisant pour : {product}',
    'checkout_err_generic'            => 'Une erreur est survenue lors de la commande. Veuillez réessayer.',

    /* ────────────────────────────────────────────────
     * TABLEAU DE BORD ADMIN — GLOBAL
     * ──────────────────────────────────────────────── */
    'admin_sidebar_title'       => 'Sabaya Admin',
    'admin_dashboard_link'      => 'Tableau de bord',
    'admin_products_link'       => 'Produits',
    'admin_categories_link'     => 'Catégories',
    'admin_orders_link'         => 'Commandes',
    'admin_users_link'          => 'Clients',
    'admin_messages_link'       => 'Messages',
    'admin_stats_link'          => 'Statistiques',
    'admin_logout'              => 'Déconnexion',
    'admin_hello'               => 'Bonjour,',
    'admin_toggle_menu'         => 'Ouvrir le menu',
    'admin_search_label'        => 'Rechercher',
    'admin_search_placeholder'  => 'Rechercher...',
    'admin_my_profile'          => 'Mon profil',
    'admin_sidebar_aria'        => 'Menu administration',
    'admin_nav_aria'            => 'Navigation principale admin',
    'admin_stats_aria_orders'   => 'Statistiques des commandes',
    'admin_orders_search_label' => 'Rechercher une commande',
    'admin_orders_search_placeholder' => 'Rechercher une commande...',
    'admin_orders_results_text' => 'Résultats de recherche pour',
    'admin_orders_table_caption' => 'Liste de toutes les commandes passées',

    /* ────────────────────────────────────────────────
     * TABLEAU DE BORD ADMIN — OVERVIEW
     * ──────────────────────────────────────────────── */
    'admin_overview_title'      => 'Vue d\'ensemble',
    'admin_overview_subtitle'   => 'Bienvenue dans votre espace d\'administration.',
    'admin_stat_total_products' => 'Total Produits',
    'admin_stat_total_orders'   => 'Total Commandes',
    'admin_stat_total_clients'  => 'Total Clients',
    'admin_stat_messages'       => 'Messages Contact',
    'admin_revenue_title'       => 'Chiffre d\'Affaires',
    'admin_chart_orders_title'  => 'Évolution des Commandes',
    'admin_quick_actions'       => 'Actions Rapides',
    'admin_stats_aria'          => 'Statistiques générales',
    'admin_orders_processed'    => 'commandes traitées',
    'admin_recent_orders_caption' => 'Liste des 5 dernières commandes',
    'admin_top_products_caption'  => 'Classement des 5 produits les plus vendus',
    'admin_table_qty_sold'         => 'Quantité Vendue',
    'admin_chart_yaxis_orders'     => 'Commandes',
    'admin_chart_yaxis_revenue'    => 'Revenu (DH)',
    'admin_footer_copyright'       => 'Copyright &copy; %d Sabaya Luxury. Tous droits réservés.',
    'admin_add_product_btn'     => 'Ajouter Produit',
    'admin_add_category_btn'    => 'Ajouter Catégorie',
    'admin_view_orders_btn'     => 'Voir Commandes',
    'admin_view_clients_btn'    => 'Voir Clients',
    'admin_recent_orders'       => 'Dernières Commandes',
    'admin_view_all'            => 'Tout voir',
    'admin_top_products'        => 'Top Produits Vendus',
    'admin_no_orders_yet'       => 'Aucune commande pour le moment.',
    'admin_no_sales_yet'        => 'Aucune vente enregistrée.',
    'admin_order_table_cmd'     => 'Commande',
    'admin_order_table_client'  => 'Client',
    'admin_order_table_date'    => 'Date',
    'admin_order_table_status'  => 'Statut',
    'admin_order_table_amount'  => 'Montant',

    /* ────────────────────────────────────────────────
     * ADMIN — GESTION PRODUITS
     * ──────────────────────────────────────────────── */
    'admin_products_page_title' => 'Gestion des Produits',
    'admin_products_subtitle'   => 'Consultez, modifiez et gérez votre inventaire de luxe.',
    'admin_stat_total_products2'=> 'Total Produits',
    'admin_stat_active_products'=> 'Produits Actifs',
    'admin_stat_low_stock'      => 'Stock Faible',
    'admin_stat_categories'     => 'Catégories',
    'admin_new_product_btn'     => 'Nouveau Produit',
    'admin_col_image'           => 'Image',
    'admin_col_product_name'    => 'Nom du Produit',
    'admin_col_category'        => 'Catégorie',
    'admin_col_price'           => 'Prix',
    'admin_col_stock'           => 'Stock',
    'admin_col_actions'         => 'Actions',
    'admin_stock_out'           => 'Rupture de stock',
    'admin_stock_low'           => 'Stock faible',
    'admin_stock_in'            => 'En stock',
    'admin_view_sr'             => 'Voir',
    'admin_edit_sr'             => 'Modifier',
    'admin_delete_sr'           => 'Supprimer',
    'admin_view_details_title'  => 'Voir les détails (ouvrir la page boutique)',
    'admin_edit_product_title'  => 'Modifier le produit',
    'admin_delete_product_title'=> 'Supprimer le produit',
    'admin_products_list_title' => 'Liste des Produits',
    'admin_products_search_placeholder' => 'Rechercher un produit...',
    'admin_no_products_found'      => 'Aucun produit trouvé',
    'admin_products_results_text'  => 'Résultats de recherche pour',
    'admin_products_subtitle_default'=> 'Gérez les détails, les prix et les stocks de vos créations.',
    'admin_pagination_showing'  => 'Affichage de',
    'admin_pagination_of'       => 'sur',
    'admin_pagination_products' => 'produits',

    /* ────────────────────────────────────────────────
     * ADMIN — AJOUT / ÉDITION PRODUIT
     * ──────────────────────────────────────────────── */
    'admin_add_product_title'   => 'Ajouter un Produit',
    'admin_add_product_subtitle'=> 'Ajoutez un nouveau produit au catalogue Sabaya Luxury.',
    'admin_product_info'        => 'Informations Produit',
    'admin_product_media'       => 'Média Produit',
    'admin_product_description' => 'Description du produit',
    'admin_product_name_label'  => 'Nom du produit',
    'admin_product_category'    => 'Catégorie',
    'admin_product_price'       => 'Prix (DH)',
    'admin_product_stock'       => 'Stock',
    'admin_product_size'        => 'Taille',
    'admin_product_color'       => 'Couleur',
    'admin_upload_text'         => 'Glissez-déposez ou cliquez pour ajouter une image',
    'admin_upload_tip'          => 'Formats acceptés : PNG, JPG, JPEG (Max. 5 Mo)',
    'admin_preview_label'       => 'Aperçu de l\'image',
    'admin_no_image_selected'   => 'Aucune image sélectionnée',
    'admin_back_to_list'        => 'Retour à la liste',
    'admin_add_product_submit'  => 'Ajouter le Produit',
    'admin_update_product_submit'=> 'Mettre à jour le Produit',

    /* ────────────────────────────────────────────────
     * ADMIN — GESTION CATÉGORIES
     * ──────────────────────────────────────────────── */
    'admin_categories_title'    => 'Gestion des Catégories',
    'admin_categories_subtitle' => 'Consultez, modifiez et gérez les catégories de produits.',
    'admin_new_category_btn'    => 'Nouvelle Catégorie',
    'admin_col_category_name'   => 'Nom de la Catégorie',
    'admin_stat_with_image'     => 'Avec Image',
    'admin_edit_category_title' => 'Modifier la catégorie',
    'admin_delete_category_title'=> 'Supprimer la catégorie',
    'admin_categories_list_title'=> 'Liste des Catégories',
    'admin_categories_search_placeholder'=> 'Rechercher une catégorie...',
    'admin_no_categories_found' => 'Aucune catégorie trouvée',
    'admin_categories_results_text' => 'Résultats de recherche pour',
    'admin_pagination_categories'=> 'catégories',

    /* ────────────────────────────────────────────────
     * ADMIN — GESTION COMMANDES
     * ──────────────────────────────────────────────── */
    'admin_orders_title'        => 'Gestion des Commandes',
    'admin_orders_subtitle'     => 'Suivez et gérez toutes les commandes clients.',
    'admin_col_id'              => 'ID',
    'admin_col_client'          => 'Client',
    'admin_col_date'            => 'Date',
    'admin_col_total'           => 'Total',
    'admin_col_status'          => 'Statut',
    'admin_stat_pending'        => 'En Attente',
    'admin_stat_confirmed'      => 'Confirmées',
    'admin_stat_delivered'      => 'Livrées',
    'admin_no_orders'           => 'Aucune commande pour le moment.',
    'admin_back_to_dashboard'   => 'Retour au Tableau de bord',
    'admin_view_details_sr'     => 'Voir les détails',
    'admin_update_status_title' => 'Modifier le statut',
    'admin_orders_list_title'   => 'Liste des Commandes',
    'admin_orders_empty_back'   => 'Retour au Dashboard',
    'admin_pagination_orders'   => 'commandes',

    /* ────────────────────────────────────────────────
     * ADMIN — DÉTAILS COMMANDE
     * ──────────────────────────────────────────────── */
    'admin_order_details_title'         => 'Informations de la Commande',
    'admin_order_items_title'           => 'Produits Commandés',
    'admin_order_client_info'           => 'Informations Client',
    'admin_order_number'                => 'Numéro de commande',
    'admin_order_date'                  => 'Date de commande',
    'admin_order_status_label'          => 'Statut',
    'admin_order_total_label'           => 'Total',
    'admin_order_update_status_btn'     => 'Modifier le Statut',
    'admin_order_back'                  => 'Retour aux commandes',
    'admin_col_qty'                     => 'Quantité',
    'admin_col_unit_price'              => 'Prix unitaire',
    'admin_col_subtotal'                => 'Sous-total',
    'admin_order_total_row'             => 'Total commande',
    'admin_no_items'                    => 'Aucun produit trouvé pour cette commande.',
    'admin_client_id_label'             => 'ID client :',
    'admin_order_breadcrumb'            => 'Commande',
    'admin_order_details_subtitle'      => 'Détails complets de la commande client.',

    /* ────────────────────────────────────────────────
     * ADMIN — GESTION UTILISATEURS
     * ──────────────────────────────────────────────── */
    'admin_users_title'         => 'Gestion des Utilisateurs',
    'admin_users_subtitle'      => 'Gérez les comptes clients et administrateurs de Sabaya Luxury.',
    'admin_stat_total_users'    => 'Total Utilisateurs',
    'admin_stat_admins'         => 'Administrateurs',
    'admin_stat_clients'        => 'Clients',
    'admin_add_user_btn'        => 'Ajouter Utilisateur',
    'admin_col_user'            => 'Utilisateur',
    'admin_col_email'           => 'Email',
    'admin_col_role'            => 'Rôle',
    'admin_role_admin'          => 'Administrateur',
    'admin_role_client'         => 'Client',
    'admin_no_users'            => 'Aucun utilisateur trouvé.',
    'admin_users_list_title'    => "Liste des Utilisateurs",
    'admin_users_subtitle_list' => 'Consultez et gérez les comptes de votre communauté Sabaya.',
    'admin_pagination_users'    => 'utilisateurs',

    /* ────────────────────────────────────────────────
     * ADMIN — DÉTAILS UTILISATEUR
     * ──────────────────────────────────────────────── */
    'admin_user_details_title'  => 'Informations de l\'Utilisateur',
    'admin_user_edit_btn'       => 'Modifier',
    'admin_user_orders_title'   => 'Commandes de l\'Utilisateur',
    'admin_user_no_orders'      => 'Cet utilisateur n\'a pas encore passé de commande.',
    'admin_user_actions'        => 'Actions',
    'admin_user_edit_action'    => 'Modifier l\'utilisateur',
    'admin_user_delete_action'  => 'Supprimer l\'utilisateur',
    'admin_user_view_orders'    => 'Voir les commandes',
    'admin_user_back'           => 'Retour aux utilisateurs',
    'admin_user_profile_subtitle'=> 'Profil utilisateur Sabaya Luxury.',
    'admin_user_id_label'       => 'ID utilisateur :',
    'admin_user_order_count'    => 'Nombre de commandes',

    /* ────────────────────────────────────────────────
     * ADMIN — MESSAGES
     * ──────────────────────────────────────────────── */
    'admin_messages_page_title'   => 'Messages de Contact',
    'admin_messages_subtitle'     => 'Consultez et gérez les messages envoyés par les clients.',
    'admin_messages_all_title'    => 'Tous les Messages',
    'admin_stat_total_messages'   => 'Total Messages',
    'admin_stat_today'            => "Aujourd'hui",
    'admin_stat_this_week'        => 'Cette Semaine',
    'admin_no_messages'           => 'Aucun message de contact pour le moment.',
    'admin_col_name'              => 'Nom',
    'admin_col_subject'           => 'Sujet',
    'admin_messages_search_placeholder'=> 'Rechercher un message...',
    'admin_pagination_messages'   => 'messages',

    /* ────────────────────────────────────────────────
     * ADMIN — STATISTIQUES
     * ──────────────────────────────────────────────── */
    'admin_stats_title'         => 'Statistiques',
    'admin_stats_subtitle'      => 'Analyse des performances de la boutique Sabaya Luxury.',
    'admin_kpi_products'        => 'Produits',
    'admin_kpi_categories'      => 'Catégories',
    'admin_kpi_clients'         => 'Clients',
    'admin_kpi_orders'          => 'Commandes',
    'admin_kpi_revenue'         => 'Chiffre d\'affaires',
    'admin_kpi_avg_cart'        => 'Panier moyen :',
    'admin_chart_title'         => 'Évolution des Commandes & Revenus',
    'admin_insight_catalog'     => 'Catalogue Produits',
    'admin_insight_orders'      => 'Activité Commandes',
    'admin_insight_growth'      => 'Croissance Clients',
    'admin_insight_perf'        => 'Performance Boutique',
    'admin_insight_total_prod'  => 'Total produits',
    'admin_insight_active_cat'  => 'Catégories actives',
    'admin_insight_avg_per_cat' => 'Moyenne / catégorie',
    'admin_insight_total_orders'=> 'Total commandes',
    'admin_insight_avg_cart'    => 'Panier moyen',
    'admin_insight_in_progress' => 'En cours',
    'admin_insight_total_members'=> 'Total inscrits',
    'admin_insight_orders_per_client'=> 'Commandes / client',
    'admin_insight_spend_per_client' => 'Dépense / client',
    'admin_insight_revenue'     => 'Chiffre d\'affaires',
    'admin_insight_delivered'   => 'Livrées',
    'admin_insight_cancelled'   => 'Annulées',
    'admin_total_orders_label'  => 'Total Commandes',
    'admin_revenue_chart_label' => 'Revenu (DH)',
    'admin_orders_chart_label'  => 'Commandes',

    /* ────────────────────────────────────────────────
     * SÉLECTEUR DE LANGUE
     * ──────────────────────────────────────────────── */
    'lang_switcher_label'       => 'Langue',
    'lang_fr'                   => 'FR',
    'lang_en'                   => 'EN',

    /* ────────────────────────────────────────────────
     * PIED DE PAGE
     * ──────────────────────────────────────────────── */
    'footer_brand_desc'         => 'Votre destination pour des abayas modernes, élégantes et de haute qualité au Maroc.',
    'footer_quick_links'        => 'Liens Rapides',
    'footer_contact'            => 'Contact',
    'footer_copyright'          => 'Tous droits réservés.',
    'footer_home'               => 'Accueil',
    'footer_shop'               => 'Boutique',
    'footer_about'              => 'À propos',
    'footer_address'            => 'Tangier, Maroc',
    'footer_email'              => 'contact@sabaya.ma',
    'footer_phone'              => '+212 6XX XXX XXX',

    /* ────────────────────────────────────────────────
     * SITEMAP / META
     * ──────────────────────────────────────────────── */
    'site_name'                 => 'Sabaya Luxury',
    'site_tagline'              => 'Luxury Abaya and Modest Fashion Boutique',
    'meta_default_desc'         => "Sabaya Luxury — Boutique en ligne d'abayas modernes et élégantes au Maroc. Découvrez nos collections de mode modeste, abayas premium, et vêtements raffinés pour femmes.",

    /* ────────────────────────────────────────────────
     * TOASTS / FLASH MESSAGES
     * ──────────────────────────────────────────────── */
    'toast_order_success'        => 'Votre commande a été enregistrée avec succès !',

    /* ────────────────────────────────────────────────
     * ORDER DETAILS (FRONT)
     * ──────────────────────────────────────────────── */
    'order_details_view'         => 'Voir les détails',

    /* ────────────────────────────────────────────────
     * ADMIN SHARED
     * ──────────────────────────────────────────────── */
    'admin_copyright'            => 'Copyright',
    'admin_order_breadcrumb_list'  => 'Retour aux commandes',
    'admin_breadcrumb_back'      => 'Retour',
    'admin_table_no_data'        => 'Aucune donnée disponible.',

    /* ────────────────────────────────────────────────
     * WHATSAPP
     * ──────────────────────────────────────────────── */
    'whatsapp_order_intro'       => "Bonjour Sabaya Luxury\n\nJe souhaite confirmer ma commande.\n\nCommande N°",
    'whatsapp_products'          => 'Produits :',
    'whatsapp_total'               => 'Total',
    'whatsapp_city'                => 'Ville',
    'whatsapp_thanks'              => 'Merci.',

];
