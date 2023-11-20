<?php
/**
 * Main file for submenus in WordPress administration
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Possa_Add_SubMenus')) {

    class Possa_Add_SubMenus {

        public function __construct() {
            add_action('admin_menu', array($this, 'create_submenus_documentation'));
            add_action('admin_menu', array($this, 'create_submenus_settings'));          
        }

        public function create_submenus_documentation() {
            $this->submenu_title  = 'Documentation';
            $this->slug           = 'possa_documentation';
            $this->page_title     = 'Documentation';
            $this->parent_slug    = 'possa_activation';

            add_submenu_page(
                $this->parent_slug,
                $this->page_title,
                $this->submenu_title,
                'manage_options',
                $this->slug,
                array($this, 'documentation_callback'), // Utilisation de array($this, 'activation_callback') pour spécifier la méthode de la classe. 
            );
        }

        public function documentation_callback() {
            echo '<div class="wrap"><h2>' . esc_html($this->page_title) . '</h2></div>';
        }

        public function create_submenus_settings() {
            $this->submenu_title  = 'Paramètres';
            $this->slug           = 'possa_settings';
            $this->page_title     = 'Paramètres';
            $this->parent_slug    = 'possa_activation';

            add_submenu_page(
                $this->parent_slug,
                $this->page_title,
                $this->submenu_title,
                'manage_options',
                $this->slug,
                array($this, 'settings_callback'), // Utilisation de array($this, 'activation_callback') pour spécifier la méthode de la classe. 
            );
        }

        public function settings_callback() {
            echo '<div class="wrap"><h2>' . esc_html($this->page_title) . '</h2></div>';
        }
    }

    $possa_submenus = new Possa_Add_SubMenus();
}
