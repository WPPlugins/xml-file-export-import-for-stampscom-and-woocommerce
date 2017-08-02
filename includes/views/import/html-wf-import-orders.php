<div class="wf-banner updated below-h2">
    <p class="main">
        <strong><?php _e('HikeForce Stamps.com XML File Export Import Plugin Premium version helps you to seamlessly export Orders in Stamps.com , Endicia, UPS Worldship and FedEx XML format and import back to your Woocommerce Store.', 'wf_order_import_export_stamps_xml'); ?></strong>
    <p>
        <?php _e('-Support for Endicia, UPS Worldship and FedEx.', 'wf_order_import_export'); ?><br/>
        <?php _e('-Filtering options while Export using Order Status, Start Date, End Date, Offset and Limit.', 'wf_order_import_export'); ?><br/>
        <?php _e('-Export orders right from the WooCommerce Admin Order Listing page.', 'wf_order_import_export'); ?><br/>
        <?php _e('-Import and Export orders from/to remote location via FTP.', 'wf_order_import_export'); ?><br/>
        <?php _e('-Excellent Support for setting it up!', 'wf_order_import_export'); ?><br/>
    </p>
</p>
<p>
    <a href="http://www.xadapter.com/product/order-xml-file-export-import-plugin-for-woocommerce/" target="_blank" class="button button-primary"><?php _e('Upgrade to Premium Version', 'wf_order_import_export_stamps_xml'); ?></a>
    <a href="orderxmlexportimportdemo.hikeforce.com/wp-admin/admin.php?page=wf_woocommerce_order_im_ex_xml" target="_blank" class="button"><?php _e('Live Demo', 'wf_order_import_export_stamps_xml'); ?></a>
    <a href="http://www.xadapter.com/2016/09/14/how-to-import-and-export-woocommerce-subscriptions-orders-using-order-coupon-subscription-export-import-plugin/" target="_blank" class="button"><?php _e('Documentation', 'wf_order_import_export_stamps_xml'); ?></a>
    <a target="_blank" class="docs button-primary" href="<?php echo plugins_url('stamps_com_sample.xml', WF_OrderImpExpStampsXML_FILE); ?>"><?php _e('Stamps.com Export sample Order XML', 'wf_order_import_export_stamps_xml'); ?></a>
    <a target="_blank" class="docs button-primary" href="<?php echo plugins_url('stamps_com_export_sample.xml', WF_OrderImpExpStampsXML_FILE); ?>"><?php _e('Stamps.com Import sample Order XML', 'wf_order_import_export_stamps_xml'); ?></a>
</p>
</div>
<style>
    .wf-banner img {
        float: right;
        margin-left: 1em;
        padding: 15px 0
    }
</style>

<div class="tool-box import-screen">
    <h3 class="title"><?php _e('Import Orders in XML Format:', 'wf_order_import_export_stamps_xml'); ?></h3>
    <p><?php _e('Import Orders in XML format from different sources (  from your computer OR from another server via FTP )', 'wf_order_import_export_stamps_xml'); ?></p>
    <p class="submit" style="padding-left: 10px;">
        <?php
        $import_url = admin_url('admin.php?import=woocommerce_wf_order_stamps_xml');
        ?>
        <a class="button button-primary" id="mylink" href="<?php echo $import_url; ?>"><?php _e('Update Orders', 'wf_order_import_export_stamps_xml'); ?></a>
        &nbsp;
        <br>
    </p>
</div>
