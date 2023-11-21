<?php
/**
 * Main file needed to add Orange Money gateway to woocommerce
 */

 if(!defined('ABSPATH')) {
    return;
 }

 if (!class_exists('Possa_Mtn_Mobile_Money_Gateway')) {

    class Possa_Mtn_Mobile_Money_Gateway extends WC_Payment_Gateway  {

        public function __construct() {
            $this->id                   = 'Possa_Mtn_Mobile_Money_Gateway';
            $this->title                = 'Mobile Money';
            $this->has_fields           = true;
            $this->icon                 = plugin_dir_url(__FILE__) . '../../../images/mtn-mobile-money.jpg';
            $this->method_title         = 'Mobile Money';
            $this->method_description   = 'Recevez des paiements grâce à MTN Mobile Money directement sur votre site ';

            // Ajouter les paramètres de la passerelle
            $this->init_form_fields();
            $this->init_settings();  // Cette méthode est définie dans la classe WC_Payment_Gateway

            // Initialisation des valeurs des paramètres
            $this->enabled      = $this->get_option('enabled');
            $this->api_key      = $this->get_option('api_key');
            $this->api_url      = '';

            // Ajouter les hooks de gestion des paiements
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));
        }

        /**
         * Initialiser les champs de configuration dans l'administration WooCommerce
         */
        public function init_form_fields() {
            $this->form_fields = array(
                'enabled'   => array(
                    'title'             => 'Activer / Désactiver ',
                    'type'              => 'checkbox',
                    'label'             => 'Activer MTN Mobile Money Gateway ',
                    'default'           => 'no',
                ),
                'title'    => array(
                    'title'             => 'Mobile Money',
                    'type'              => 'text',
                    'label'             => 'Titre',
                    'description'       => 'Le nom qui va s\'afficher sur la plateforme de paiement',
                    'default'           => 'Mobile Money',
                    'desc_tip'          => true,
                ),
                'description'   => array(
                    'title'             => 'Description',
                    'type'              => 'textarea',
                    'default'           => 'description',
                    'desc_tip'          => true,
                ),
                'instructions'  => array(
                    'title'             => 'Instructions',
                    'type'              => 'textarea',
                    'default'           => 'Instructions qui seront affichées pour donner des instructions au client',
                    'desc_tip'          => true,
                    'label'             => 'Instructions',
                ),
                'api_key'   => array(
                    'title'             => 'MTN Mobile Money API Key',
                    'type'              => 'text',
                    'label'             => 'Clé d\'Api MTN Mobile Money',
                ),
                'merchant_id'   => array(
                    'title'             => 'merchant_id',
                    'type'              => 'text',
                    'default'           => '6 77 77 77 77 ',
                ),
                'api_secret'    => array(
                    'title'             => 'MTN Mobile Money API Secret',
                    'type'              => 'text',
                    'label'             => 'Secret D\'API MTN Mobile Money',
                    'default'           => '',
                ),
            );

            $this->form_fields['test_mode'] = array(
                'title'   => 'Test Mode',
                'type'    => 'checkbox',
                'label'   => 'Enable Test Mode',
                'default' => 'no',
            );

            // Vous n'avez probablement pas besoin de ce filtre, retirez-le pour le moment
            // add_filter('woocommerce_settings_api_form_fields_' . $this->id, array($this, 'add_test_mode_description'));
        }

        // Ajoutez une description pour le mode de test dans les paramètres de la passerelle
        public function add_test_mode_description($form_fields) {
            $form_fields['test_mode']['description'] = 'Activez ceci pour utiliser le moyen de paiement en mode test.';
            return $form_fields;
        }

        // Utilisez cette méthode pour obtenir l'URL correcte de l'API en fonction du mode de test
        private function get_api_url() {
            $base_url = $this->get_option('test_mode') === 'yes' ? 'URL_DE_MTN_MOBILE_MONEY_API_TEST' : 'URL_DE_MTN_MOBILE_MONEY_API';
            return $base_url;
        }

        /**
         * Chargement des scripts et des styles si nécessaires
         */
        public function enqueue_scripts() {
            // Ajouter ici le chargement des scripts et des styles nécessaires
        }

        /**
         * Gestion du paiement lors de la soumission de la commande
         */
        public function process_payment($order_id) {
            // Logique de traitement du paiement avec MTN Mobile Money
            // Envoie des détails à MTN Mobile Money et gestion de la réponse

            // Marquez la commande traitée
            $order = wc_get_order($order_id);
            $order->update_status('processing', __('Paiement reçu via MTN Mobile Money. ', 'possa'));

            // Rediriger l'utilisateur vers la page de réussite.
            return array(
                'result'    => 'success',
                'redirect'  => $this->get_return_url($order),
            );
        }

        /**
         * Affiche la page de confirmation après le paiement.
         *
         * @param int $order_id ID de la commande.
         */
        public function receipt_page($order_id) {
            // Ajoutez ici le contenu de la page de confirmation après le paiement.
        }

        
    }
    

    // Enregistrer la passerelle dans WooCommerce 
    function add_mtn_mobile_money_gateway($gateways) {
        $gateways[] = 'Possa_Mtn_Mobile_Money_Gateway';
        return $gateways;
    }

    add_filter('woocommerce_payment_gateways', 'add_mtn_mobile_money_gateway');
}
