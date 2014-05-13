<?php
global $wpdb;
$settings           = get_option( 'sfn_cart_addons', array() );
$terms              = get_terms( 'product_cat' );
$categories         = array();
$category_addons    = get_option( 'sfn_cart_addons_categories', array() );
$product_addons     = get_option( 'sfn_cart_addons_products', array() );

foreach ( $terms as $term ) {
    $used = false;
    foreach ( $category_addons as $c_addon ) {
        if ( $c_addon['category_id'] == $term->term_id ) {
            $used = true;
            break;
        }
    }

    if ( !$used ) {
        $categories[] = array('id' => $term->term_id, 'name' => $term->name);
    }
}
$js_categories = json_encode($categories);
?>
<div class="wrap woocommerce">
	<div id="icon-edit" class="icon32 icon32-posts-product"><br></div>
    <h2><?php _e('Cart Add-Ons', 'sfn_cart_addons'); ?></h2>

    <?php if (isset($_GET['updated'])): ?>
    <div id="message" class="updated"><p><?php _e('Settings updated', 'sfn_cart_addons'); ?></p></div>
    <?php endif; ?>

    <form action="admin-post.php" method="post">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="heading"><?php _e('Display Title', 'sfn_cart_addons'); ?></label>
                    </th>
                    <td>
                        <?php $settings['header_title'] = isset( $settings['header_title'] ) ? $settings['header_title'] : ''; ?>
                        <input type="text" name="header_title" id="heading" value="<?php echo esc_attr($settings['header_title']); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="number"><?php _e('Maximum number of upsells to show in the cart.', 'sfn_cart_addons'); ?></label>
                    </th>
                    <td>
                        <?php $settings['upsell_number'] = isset( $settings['upsell_number'] ) ? $settings['upsell_number'] : ''; ?>
                        <input type="text" name="upsell_number" id="number" value="<?php echo esc_attr($settings['upsell_number']); ?>" class="small-text" placeholder="6" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="default_products"><?php _e('Default Add-Ons', 'sfn_cart_addons'); ?></label>
                    </th>
                    <td>
                        <select id="default_products" name="default_products[]" class="ajax_chosen_select_products_and_variations" multiple data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>" style="width: 600px">
                        <?php if ( !empty($settings['default_addons'])) foreach ( $settings['default_addons'] as $product_id ): ?>
                            <option value="<?php echo esc_attr($product_id); ?>" selected><?php echo strip_tags(get_the_title($product_id) .' - #'. $product_id); ?></option>
                        <?php endforeach; ?>
                        </select>
                        <p class="description">
                            <?php _e('These products will be displayed on the cart page if there are no matching products and/or categories in the shopping cart from the settings below.', 'sfn_cart_addons'); ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h4><?php _e('Category Matches', 'sfn_cart_addons'); ?></h4>
        <p class="description">
            <?php _e('If a product in the shopping cart matches a category defined below, the cart upsells will display the matching products to show. Set the priority order to define which category upsells should be shown when items in the shopping cart match multiple categories. Categories with the highest priority will be the upsells that are displayed when there are multiple category matches in the cart.', 'sfn_cart_addons'); ?>
        </p>

        <table class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th width="50" scope="col" id="priority" class="manage-column column-usage_count" style=""><?php _e('Priority', 'sfn_cart_addons'); ?></th>
                    <th width="20%" scope="col" id="category" class="manage-column column-type" style=""><?php _e('Category', 'sfn_cart_addons'); ?></th>
                    <th scope="col" id="products" class="manage-column column-products" style=""><?php _e('Product Add-Ons', 'sfn_cart_addons'); ?></th>
                    <th width="10%" scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody id="cat_tbody">
                <?php
                if ( !empty($category_addons) ):
                    $p = 0;
                    foreach ( $category_addons as $x => $addons ):
                        $p++;
                        $category   = get_term( $addons['category_id'], 'product_cat' );
                ?>
                <tr scope="row">
                    <td style="text-align: center; vertical-align:middle;">
                        <span class="priority"><?php echo $p; ?></span>
                        <input type="hidden" name="category_priorities[]" value="<?php echo $x; ?>" size="3" />
                    </td>
                    <td class="post-title column-title">
                        <strong><?php echo stripslashes($category->name); ?></strong>
                        <input type="hidden" name="category[<?php echo $x; ?>]" value="<?php echo $addons['category_id']; ?>" />
                    </td>
                    <td>
                        <select id="cselect_<?php echo $x; ?>" name="category_products[<?php echo $x; ?>][]" class="ajax_chosen_select_products_and_variations" multiple data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>" style="width: 95%">
                        <?php foreach ($addons['products'] as $product_id): ?>
                            <option value="<?php echo $product_id; ?>" selected><?php echo strip_tags(get_the_title($product_id) .' - #'. $product_id); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </td>
                    <td align="center">
                        <a class="remove" href="#">remove row</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr scope="row" id="no_categories">
                    <td colspan="4" align="center">No add-ons defined</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="fue_table_footer">
            <div class="order_message"></div>
        </div>
        <br />
        <button type="button" id="add_category" class="button"><?php _e('+ Add Category', 'sfn_cart_addons'); ?></button>

        <h4><?php _e('Product Matches', 'sfn_cart_addons'); ?></h4>
        <p class="description">
            <?php _e('If a product in the shopping cart matches one of the products defined below, the cart upsells will display the matching products below to show. Set the priority to define which product upsells should be shown when items in the shopping cart are all defined. Products with the highest priority will be the upsells that are displayed when there are multiple products in the cart.', 'sfn_cart_addons'); ?>
        </p>

        <table class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th width="50" scope="col" id="priority" class="manage-column column-usage_count" style=""><?php _e('Priority', 'sfn_cart_addons'); ?></th>
                    <th width="20%" scope="col" id="category" class="manage-column column-type" style=""><?php _e('Product', 'sfn_cart_addons'); ?></th>
                    <th scope="col" id="products" class="manage-column column-products" style=""><?php _e('Product Add-Ons', 'sfn_cart_addons'); ?></th>
                    <th width="10%" scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody id="product_tbody">
                <?php
                if ( !empty($product_addons) ):
                    $p = 0;
                    foreach ( $product_addons as $x => $addons ):
                        $p++;
                        $product    = sfn_get_product( $addons['product_id'] );
                ?>
                <tr scope="row">
                    <td style="text-align: center; vertical-align:middle;">
                        <span class="priority"><?php echo $p; ?></span>
                        <input type="hidden" name="product_priorities[]" value="<?php echo $x; ?>" size="3" />
                    </td>
                    <td class="post-title column-title">
                        <strong><?php echo get_the_title( $addons['product_id'] ); ?></strong>
                        <input type="hidden" name="product[<?php echo $x; ?>]" value="<?php echo $addons['product_id']; ?>" />
                        <select name="product[<?php echo $x; ?>]" class="product-select" style="display:none;">
                            <option value="<?php echo $addons['product_id']; ?>" selected><?php echo $addons['product_id']; ?></option>
                        </select>
                    </td>
                    <td>
                        <select id="pselect_<?php echo $x; ?>" name="product_products[<?php echo $x; ?>][]" class="ajax_chosen_select_products_and_variations" multiple data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>" style="width: 95%">
                        <?php foreach ($addons['products'] as $product_id): ?>
                            <option value="<?php echo $product_id; ?>" selected><?php echo strip_tags(get_the_title($product_id) .' - #'. $product_id); ?></option>
                        <?php endforeach; ?>
                        </select>
                    </td>
                    <td align="center">
                        <a class="remove" href="#">remove row</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr scope="row" id="no_products">
                    <td colspan="4" align="center">No add-ons defined</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="fue_table_footer">
            <div class="order_message"></div>
        </div>
        <br />
        <button type="button" id="add_product" class="button"><?php _e('+ Add Product', 'sfn_cart_addons'); ?></button>

        <p class="submit">
            <input type="hidden" name="action" value="sfn_cart_addons_update_settings" />
            <input type="submit" name="save" value="<?php _e('Update Settings', 'sfn_cart_addons'); ?>" class="button-primary" />
        </p>

        <h4><?php _e('Use shortcodes on any page or post', 'sfn_cart_addons'); ?></h4>
        <p>[display-addons length=5 mode=loop] - Will use your theme's template<br />[display-addons length=4 mode=images_name] - Shows the product image along with the product name<br />[display-addons length=8 mode=images_name_price] - Will display product images with name and price
        </p>

        <h4><?php _e('Use directly in your theme', 'sfn_cart_addons'); ?></h4>
        <p>&lt;?php if ( function_exists('sfn_display_cart_addons') ) sfn_display_cart_addons($num, $display); ?&gt;<br />$num = the maximum number of add-ons to display, and $display can be one of the following: 'loop', 'images', 'images_name', 'images_name_price', 'names', 'names_price'
        </p>

    </form>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    // Sorting
    jQuery('#cat_tbody, #product_tbody').sortable({
        items:'tr',
        cursor:'move',
        axis:'y',
        handle: 'td',
        scrollSensitivity:40,
        helper:function(e,ui){
            ui.children().each(function(){
                jQuery(this).width(jQuery(this).width());
            });
            ui.css('left', '0');
            return ui;
        },
        start:function(event,ui){
            ui.item.css('background-color','#f6f6f6');
        },
        stop:function(event,ui){
            ui.item.removeAttr('style');
            update_priorities();
        }
    });
    var categories = jQuery.parseJSON('<?php echo addslashes($js_categories); ?>');
    jQuery("select.ajax_chosen_select_products_and_variations").ajaxChosen({
        method: 	'GET',
        url: 		ajaxurl,
        dataType: 	'json',
        afterTypeDelay: 100,
        data:		{
            action: 		'woocommerce_json_search_products_and_variations',
            security: 		'<?php echo wp_create_nonce("search-products"); ?>'
        }
    }, function (data) {
        var terms = {};

        jQuery.each(data, function (i, val) {
            terms[i] = val;
        });

        return terms;
    });

    jQuery("#add_category").click(function(e) {
        jQuery("#no_categories").remove();

        var options = '';

        // remove all selected categories
        for (var x = 0; x < categories.length; x++) {
            var used = false;
            jQuery(".category-select option:selected").each(function() {
                if (jQuery(this).val() == categories[x].id) {
                    used = true;
                    return false;
                }
            });

            if (!used) {
                options += '<option value="'+ categories[x].id +'">'+ categories[x].name +'</option>';
            }
        }

        if (options == '') {
            alert('<?php _e('All categories have been used', 'sfn_cart_addons'); ?>');
            return false;
        }

        var number;
        do {
            number = 1 + Math.floor(Math.random() * 9999999);
        } while (jQuery("#cselect_"+number).length > 0);

        var html = '<tr scope="row">\
        <td>\
            <input type="hidden" name="category_priorities[]" value="'+ number +'" size="3" />\
        </td>\
        <td class="post-title column-title">\
            <select name="category['+ number +']" class="category-select">\
            '+ options +'\
            </select>\
        </td>\
        <td>\
            <select id="cselect_'+ number +'" name="category_products['+ number +'][]" class="ajax_chosen_select_products_and_variations" multiple data-placeholder="<?php echo addslashes(__('Select a category&hellip;', 'woocommerce') ); ?>" style="width: 95%"></select>\
        </td>\
        <td align="center">\
        <a class="remove" href="#">remove row</a>\
        </td>\
        </tr>';
        jQuery("#cat_tbody").append(html);

        jQuery("#cselect_"+ number).ajaxChosen({
            method: 	'GET',
            url: 		ajaxurl,
            dataType: 	'json',
            afterTypeDelay: 100,
            data:		{
                action: 		'woocommerce_json_search_products_and_variations',
                security: 		'<?php echo wp_create_nonce("search-products"); ?>'
            }
        }, function (data) {
            var terms = {};

            jQuery.each(data, function (i, val) {
                terms[i] = val;
            });

            return terms;
        });
    });

    jQuery("#add_product").click(function(e) {
        jQuery("#no_products").remove();

        var options = '';

        var number;
        do {
            number = 1 + Math.floor(Math.random() * 9999999);
        } while (jQuery("#pselect_"+number).length > 0);

        var html = '<tr scope="row">\
        <td>\
            <input type="hidden" name="product_priorities[]" value="'+ number +'" size="3" />\
        </td>\
        <td class="post-title column-title">\
            <select id="product_'+ number +'" name="product['+ number +']" class="ajax_chosen_select_products_and_variations product-select" multiple data-placeholder="<?php echo addslashes( __('Search for a product&hellip;', 'woocommerce') ); ?>" style="width: 95%"></select>\
        </td>\
        <td>\
            <select id="pselect_'+ number +'" name="product_products['+ number +'][]" class="ajax_chosen_select_products_and_variations" multiple data-placeholder="<?php echo addslashes( __('Search for a product&hellip;', 'woocommerce') ); ?>" style="width: 95%"></select>\
        </td>\
        <td align="center">\
        <a class="remove" href="#">remove row</a>\
        </td>\
        </tr>';
        jQuery("#product_tbody").append(html);

        jQuery("#product_"+number).ajaxChosen({
            method: 	'GET',
            url: 		ajaxurl,
            dataType: 	'json',
            afterTypeDelay: 100,
            data:		{
                action: 		'woocommerce_json_search_products_and_variations',
                security: 		'<?php echo wp_create_nonce("search-products"); ?>'
            }
        }, function (data) {
            var terms = {};

            jQuery.each(data, function (i, val) {
                var selected = false;
                jQuery(".product-select option:selected").each(function() {
                    if (i == jQuery(this).val()) {
                        selected = true;
                        return false;
                    }
                });

                if ( !selected ) {
                    terms[i] = val;
                }
            });

            return terms;
        });

        jQuery("#pselect_"+number).ajaxChosen({
            method: 	'GET',
            url: 		ajaxurl,
            dataType: 	'json',
            afterTypeDelay: 100,
            data:		{
                action: 		'woocommerce_json_search_products_and_variations',
                security: 		'<?php echo wp_create_nonce("search-products"); ?>'
            }
        }, function (data) {
            var terms = {};

            jQuery.each(data, function (i, val) {
                terms[i] = val;
            });

            return terms;
        });
    });

    jQuery("select.product-select").live("change", function() {
        // remove the first option to limit to only 1 product selected
        if (jQuery(this).find("option:selected").length > 1) {
            jQuery(jQuery(this).find("option:selected")[0]).remove();
            jQuery(this).trigger("liszt:updated");
        }
    });

    jQuery(".remove").live("click", function(e) {
        e.preventDefault();
        jQuery(this).parents("tr").remove();
    });
});

function update_priorities() {
    jQuery('#cat_tbody tr').each(function(x){
        jQuery(this).find('td .priority').html(x+1);
    });

    jQuery('#product_tbody tr').each(function(x){
        jQuery(this).find('td .priority').html(x+1);
    });
}
</script>
