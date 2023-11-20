<?php
/**
 * Plugin Name: Possa
 * Description: Transformez votre site WordPress en une plateforme de paiement en ligne sans tracas avec Possa. Conçu pour la simplicité et la commodité, Possa vous permet d'accepter des paiements directement depuis votre téléphone, sans nécessiter de compte bancaire. Possa élimine les barrières traditionnelles liées aux paiements en ligne, permettant à toute entreprise de démarrer rapidement. Plus besoin de comptes bancaires compliqués - avec Possa, vous êtes prêt à accepter des paiements en quelques étapes simples. Faites passer votre expérience de paiement à un niveau supérieur avec Possa. Téléchargez le plugin aujourd'hui et offrez à vos clients une expérience de paiement en ligne sans souci.
 * Version: 0.0.1
 * Author: AKC-Invent team
 * Author URI: https://www.akc-invent.cm
 * Plugin URI: https://www.akc-invent.cm/Possa
 */

 require_once plugin_dir_path(__FILE__) . '/includes/activation.php';

 function possa_activation() {
    if(!possa_woocommerce_check ()) {
        deactivate_plugins(plugin_basename(__FILE__));

        wp_die('Woocommerce est requis pour le bon fonctionnement de Possa. Veuillez l\'installer et l\'activer');
    }
 }

 register_activation_hook(__FILE__, 'possa_activation');