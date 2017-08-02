<div class="tool-box export-screen">
    <?php
    $order_statuses = wc_get_order_statuses();
    ?>
    <h3 class="title"><?php _e('Export Orders in Stamps.com XML Format:', 'wf_order_import_export_stamps_xml'); ?></h3>
    <p><?php _e('Export and download your orders in Stamps.com XML format. This file can be used to import orders into your Stamps.com Application.', 'wf_order_import_export_stamps_xml'); ?></p>
    <form action="<?php echo admin_url('admin.php?page=wf_woocommerce_order_im_ex_stamps_xml&action=export'); ?>" method="post">
        <p class="submit" style="padding-left: 10px;"><input type="submit" class="button button-primary" value="<?php _e('Export Orders', 'wf_order_import_export_stamps_xml'); ?>" /></p>
    </form>
</div>