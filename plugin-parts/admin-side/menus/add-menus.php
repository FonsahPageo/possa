<?php
/**
 * Main file for menus in wordpress administration
 */
if(!'ABSPATH') {
    return;
}

if(!class_exists('Possa_Add_Menus')) {

    class Possa_Add_Menus {

        public function __construct() {
            add_action('admin_menu', array($this, 'create_menus'));
        }

        public function create_menus() {
            $this->menu_title           = 'Possa';
            $this->slug                 = 'possa_activation';
            $this->image                = 'dashicons-smartphone';
            $this->page_title           = 'Possa';

            add_menu_page(
                $this->page_title,
                $this->menu_title,
                'manage_options',
                $this->slug,
                array($this, 'activation_callback'),
                $this->image,
            );
        }

        public function activation_callback() {

            $url = admin_url('admin.php?page=wc-settings&tab=checkout'); // Utilisation de admin_url() pour obtenir l'URL d'administration.

            wp_safe_redirect($url);
            exit();
        }
    }
    $possa_menus = new Possa_Add_Menus();
}