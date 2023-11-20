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
            $this->slug                 = 'possa_documentation';
            $this->image                = 'dashicons-smartphone';
            $this->page_title           = 'Possa';

            add_menu_page(
                $this->page_title,
                $this->menu_title,
                'manage_options',
                $this->slug,
                array($this, 'documentation_callback'),
                $this->image,
            );
        }

        public function documentation_callback() {
            echo '<div class="wrap">' . esc_html($this->page_title) . '</div>';
        }
    }
    $possa_menus = new Possa_Add_Menus();
}