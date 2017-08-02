<?php

/*
  Plugin Name: Stamps.com XML File Export Import (BASIC)
  Plugin URI: http://www.xadapter.com/product/order-xml-file-export-import-plugin-for-woocommerce/
  Description: Import and Export Order detail including line items, From and To your WooCommerce Store as Stamps.com XML.
  Author: XAdapter
  Author URI: http://www.xadapter.com/
  Version: 1.0.5
  Text Domain: wf_order_import_export_stamps_xml
 */

if (!defined('ABSPATH') || !is_admin()) {
    return;
}

define("WF_ORDER_IMP_EXP_STAMPS_XML_ID", "wf_order_imp_exp_stamps_xml");
define("WF_WOOCOMMERCE_ORDER_IM_EX_STAMPS_XML", "wf_woocommerce_order_im_ex_stamps_xml");

/**
 * Check if WooCommerce is active
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    if (!class_exists('WF_Order_Import_Export_Stamps_XML')) :

        /**
         * Main XML Import class
         */
        class WF_Order_Import_Export_Stamps_XML {

            /**
             * Constructor
             */
            public function __construct() {
                define('WF_OrderImpExpStampsXML_FILE', __FILE__);

                add_filter('woocommerce_screen_ids', array($this, 'woocommerce_screen_ids'));
                add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'wf_plugin_action_links'));
                add_action('init', array($this, 'load_plugin_textdomain'));
                add_action('init', array($this, 'catch_export_request'), 20);
                add_action('admin_init', array($this, 'register_importers'));

                include_once( 'includes/class-wf-orderimpexpstampsxml-system-status-tools.php' );
                include_once( 'includes/class-wf-orderimpexpstampsxml-admin-screen.php' );
                include_once( 'includes/importer/class-wf-orderimpexpstampsxml-importer.php' );

                if (defined('DOING_AJAX')) {
                    include_once( 'includes/class-wf-orderimpexpstampsxml-ajax-handler.php' );
                }
            }

            public function wf_plugin_action_links($links) {
                $plugin_links = array(
                    '<a href="' . admin_url('admin.php?page=wf_woocommerce_order_im_ex_stamps_xml') . '">' . __('Import Export', 'wf_order_import_export_stamps_xml') . '</a>',
                    '<a href="http://www.xadapter.com/support/forum/order-xml-file-export-import-plugin-for-woocommerce/">' . __('Support', 'wf_order_import_export_stamps_xml') . '</a>',
                );
                return array_merge($plugin_links, $links);
            }

            /**
             * Add screen ID
             */
            public function woocommerce_screen_ids($ids) {
                $ids[] = 'admin'; // For import screen
                return $ids;
            }

            /**
             * Handle localisation
             */
            public function load_plugin_textdomain() {
                load_plugin_textdomain('wf_order_import_export_stamps_xml', false, dirname(plugin_basename(__FILE__)) . '/lang/');
            }

            /**
             * Catches an export request and exports the data. This class is only loaded in admin.
             */
            public function catch_export_request() {
                if (!empty($_GET['action']) && !empty($_GET['page']) && $_GET['page'] == 'wf_woocommerce_order_im_ex_stamps_xml') {
                    switch ($_GET['action']) {
                        case "export" :
                            $user_ok = $this->hf_user_permission();
                            if ($user_ok) {
                            include_once( 'includes/exporter/class-wf-orderimpexpstampsxmlbase-exporter.php' );
                            WF_OrderImpExpStampsXMLBase_Exporter::do_export('shop_order');
                            } else {
                                wp_redirect(wp_login_url());
                            }
                            break;
                    }
                }
            }

            /**
             * Register importers for use
             */
            public function register_importers() {
                register_importer('woocommerce_wf_order_stamps_xml', 'WooCommerce Order XML', __('Import <strong>Orders</strong> to your store via a xml file.', 'wf_order_import_export_stamps_xml'), 'WF_OrderImpExpStampsXML_Importer::order_importer');
            }
            
            private function hf_user_permission() {
                // Check if user has rights to export
                $current_user = wp_get_current_user();
                $user_ok = false;
                $wf_roles = apply_filters('hf_user_permission_roles', array('administrator', 'shop_manager'));
                if ($current_user instanceof WP_User) {
                    $can_users = array_intersect($wf_roles, $current_user->roles);
                    if (!empty($can_users)) {
                        $user_ok = true;
                    }
                }
                return $user_ok;
            }

        }

        endif;

    new WF_Order_Import_Export_Stamps_XML();
}

add_filter('hf_order_stamps_xml_export_format', 'hf_order_xml_export_stamps_format', 10, 4);

function hf_order_xml_export_stamps_format($formated_orders, $raw_orders) {

    $order_details = array();
    foreach ($raw_orders as $order) {

        $order_data = array(
            'OrderDate' => $order['OrderDate'],
            'OrderID' => $order['OrderId'],
            'ShipMethod' => $order['ShippingMethod'],
            'MailClass' => 'first class',
            'Mailpiece' => 'package',
            'DeclaredValue' => $order['OrderTotal'],
            'Recipient' => array(
                'AddressFields' => array(
                    'FirstName' => $order['ShippingFirstName'],
                    'LastName' => $order['ShippingLastName'],
                    'Address1' => $order['ShippingAddress1'],
                    'Address2' => $order['ShippingAddress2'],
                    'Company' => $order['ShippingCompany'],
                    'City' => $order['ShippingCompany'],
                    'State' => $order['ShippingState'],
                    'ZIP' => $order['ShippingPostCode'],
                    'Country' => $order['ShippingCountry'],
                    'OrderedPhoneNumbers' => array(
                        'Number' => $order['BillingPhone']
                    ),
                    'OrderedEmailAddresses' => array(
                        'Address' => $order['BillingEmail']
                    )
                ),
            ),
            'WeightOz' => $order['OrderLineItems']['total_weight'],
            'RecipientEmailOptions' => array(
                'ShipmentNotification' => 'false'
            )
        );


        if ($order['StoreCountry'] !== $order['ShippingCountry']) {

            $order_data['CustomsInfo'] = array(
                'Contents' => array(
                    'Item' => array(
                        'Description' => 'HF' . $order['OrderId'],
                        'Quantity' => $order['OrderLineItems']['total_qty'],
                        'Value' => $order['OrderTotal'],
                        'WeightOz' => $order['OrderLineItems']['total_weight']
                    )
                ),
                'ContentsType' => 'other',
                'DeclaredValue' => $order['OrderTotal'],
                'UserAcknowledged' => TRUE
            );
        }

        if (sizeof($order['OrderLineItems']) >= 4) {
            unset($order['OrderLineItems']['total_weight']);
            unset($order['OrderLineItems']['total_qty']);
            unset($order['OrderLineItems']['weight_unit']);
            foreach ($order['OrderLineItems'] as $lineItems) {
                $order_data['OrderContents']['Item'][] = $lineItems;
            }
        }

        $order_details[] = $order_data;
    }
    $formated_orders = array('Print' => array('Item' => $order_details));
    return $formated_orders;
}
