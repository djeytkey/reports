<?php
if ($file_used == "sql_table") {
    $request = array();
    $start   = 0;

    $pw_from_date = $this->pw_get_woo_requests('pw_from_date', null, true);
    $pw_to_date   = $this->pw_get_woo_requests('pw_to_date', null, true);
    $date_format  = $this->pw_date_format($pw_from_date);

    $pw_id_order_status = $this->pw_get_woo_requests('pw_id_order_status', null, true);
    $pw_paid_customer   = $this->pw_get_woo_requests('pw_customers_paid', null, true);
    $txtProduct         = $this->pw_get_woo_requests('txtProduct', null, true);
    $pw_product_id      = $this->pw_get_woo_requests('pw_product_id', "-1", true);
    $category_id        = $this->pw_get_woo_requests('pw_category_id', '-1', true);

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    $brand_id = $this->pw_get_woo_requests('pw_brand_id', '-1', true);

    $limit = $this->pw_get_woo_requests('limit', 15, true);
    $p     = $this->pw_get_woo_requests('p', 1, true);

    $page         = $this->pw_get_woo_requests('page', null, true);
    $order_id     = $this->pw_get_woo_requests('pw_id_order', null, true);
    $pw_from_date = $this->pw_get_woo_requests('pw_from_date', null, true);
    $pw_to_date   = $this->pw_get_woo_requests('pw_to_date', null, true);

    $pw_txt_email = $this->pw_get_woo_requests('pw_email_text', null, true);

    $pw_txt_first_name = $this->pw_get_woo_requests('pw_first_name_text', null, true);

    $pw_detail_view     = $this->pw_get_woo_requests('pw_view_details', "no", true);
    $pw_country_code    = $this->pw_get_woo_requests('pw_countries_code', null, true);
    $state_code         = $this->pw_get_woo_requests('pw_states_code', '-1', true);
    $pw_payment_method  = $this->pw_get_woo_requests('payment_method', null, true);
    $pw_order_item_name = $this->pw_get_woo_requests('order_item_name', null, true);//for coupon
    $pw_coupon_code     = $this->pw_get_woo_requests('coupon_code', null, true);//for coupon

    $pw_publish_order  = $this->pw_get_woo_requests('publish_order', 'no',
        true);//if publish display publish order only, no or null display all order
    $pw_coupon_used    = $this->pw_get_woo_requests('pw_use_coupon', 'no', true);
    $pw_order_meta_key = $this->pw_get_woo_requests('order_meta_key', '-1', true);
    $pw_order_status   = $this->pw_get_woo_requests('pw_orders_status', '-1', true);
    //$pw_order_status  		= "'".str_replace(",","','",$pw_order_status)."'";

    $pw_paid_customer = str_replace(",", "','", $pw_paid_customer);
    //$pw_country_code		= str_replace(",","','",$pw_country_code);
    //$state_code		= str_replace(",","','",$state_code);
    //$pw_country_code		= str_replace(",","','",$pw_country_code);

    $pw_coupon_code  = $this->pw_get_woo_requests('coupon_code', '-1', true);
    $pw_coupon_codes = $this->pw_get_woo_requests('pw_codes_of_coupon', '-1', true);

    $pw_coupon_code  = '';
    $pw_coupon_codes = '';
    ////////////////////CUSTOM WORK/////////////////////
    $pw_coupon_code  = $this->pw_get_woo_requests('coupon_code', '-1', true);
    $pw_coupon_codes = $this->pw_get_woo_requests('pw_codes_of_coupon', '-1', true);
    //echo $pw_coupon_codes;
    if ($pw_coupon_codes != "-1") {
        $pw_coupon_codes = "'" . str_replace(",", "','", $pw_coupon_codes) . "'";
    }

    //echo $pw_coupon_codes;
    $coupon_discount_types = $this->pw_get_woo_requests('pw_coupon_discount_types', '-1', true);
    if ($coupon_discount_types != "-1") {
        $coupon_discount_types = "'" . str_replace(",", "','", $coupon_discount_types) . "'";
    }


    $pw_max_amount = $this->pw_get_woo_requests('max_amount', '-1', true);
    $pw_min_amount = $this->pw_get_woo_requests('min_amount', '-1', true);

    $pw_billing_post_code = $this->pw_get_woo_requests('pw_bill_post_code', '-1', true);

    ////ADDED IN V4.0
    $pw_variation_id   = $this->pw_get_woo_requests('pw_variation_id', '-1', true);
    $pw_variation_only = $this->pw_get_woo_requests('pw_variation_only', '-1', true);
    $pw_variations     = $pw_item_meta_key = '';
    if ($pw_variation_id != '-1' and strlen($pw_variation_id) > 0) {

        $pw_variations = explode(",", $pw_variation_id);
        //$this->print_array($pw_variations);
        $var      = array();
        $item_att = array();
        foreach ($pw_variations as $key => $value):
            $var[]      .= "attribute_pa_" . $value;
            $var[]      .= "attribute_" . $value;
            $item_att[] .= "pa_" . $value;
            $item_att[] .= $value;
        endforeach;
        $pw_variations    = implode("', '", $var);
        $pw_item_meta_key = implode("', '", $item_att);
    }
    $pw_variation_attributes    = $pw_variations;
    $pw_variation_item_meta_key = $pw_item_meta_key;

    $pw_hide_os = $this->pw_get_woo_requests('pw_hide_os', '"trash"', true);

    $pw_show_cog = $this->pw_get_woo_requests('pw_show_cog', 'no', true);

    ///////////HIDDEN FIELDS////////////
    $pw_hide_os         = $this->otder_status_hide;
    $pw_publish_order   = 'no';
    $pw_order_item_name = '';

    $pw_payment_method = '';

    $pw_order_meta_key = '';

    $data_format = $this->pw_get_woo_requests('date_format', get_option('date_format'), true);

    $amont_zero = '';
    //////////////////////

    /////////////////////////
    //APPLY PERMISSION TERMS
    $key = 'all_orders';

    $category_id = $this->pw_get_form_element_permission('pw_category_id', $category_id, $key);

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    $brand_id = $this->pw_get_form_element_permission('pw_brand_id', $brand_id, $key);

    $pw_product_id = $this->pw_get_form_element_permission('pw_product_id', $pw_product_id, $key);

    $pw_country_code = $this->pw_get_form_element_permission('pw_countries_code', $pw_country_code, $key);

    if ($pw_country_code != null && $pw_country_code != '-1') {
        $pw_country_code = "'" . str_replace(",", "','", $pw_country_code) . "'";
    }

    $state_code = $this->pw_get_form_element_permission('pw_states_code', $state_code, $key);

    if ($state_code != null && $state_code != '-1') {
        $state_code = "'" . str_replace(",", "','", $state_code) . "'";
    }

    $pw_order_status = $this->pw_get_form_element_permission('pw_orders_status', $pw_order_status, $key);

    if ($pw_order_status != null && $pw_order_status != '-1') {
        $pw_order_status = "'" . str_replace(",", "','", $pw_order_status) . "'";
    }
    ///////////////////////////


    $pw_variations_formated = '';

    if (strlen($pw_max_amount) <= 0) {
        $_REQUEST['max_amount'] = $pw_max_amount = '-1';
    }
    if (strlen($pw_min_amount) <= 0) {
        $_REQUEST['min_amount'] = $pw_min_amount = '-1';
    }

    if ($pw_max_amount != '-1' || $pw_min_amount != '-1') {
        if ($pw_order_meta_key == '-1') {
            $_REQUEST['order_meta_key'] = "_order_total";
        }
    }

    $last_days_orders = "0";
    if (is_array($pw_id_order_status)) {
        $pw_id_order_status = implode(",", $pw_id_order_status);
    }
    if (is_array($category_id)) {
        $category_id = implode(",", $category_id);
    }

    /////ADDED IN VER4.0
    //BRANDS ADDONS
    if (is_array($brand_id)) {
        $brand_id = implode(",", $brand_id);
    }

    if ( ! $pw_from_date) {
        $pw_from_date = date_i18n('Y-m-d');
    }
    if ( ! $pw_to_date) {
        $last_days_orders = apply_filters($page . '_back_day', $last_days_orders);//-1,-2,-3,-4,-5
        $pw_to_date       = date('Y-m-d', strtotime($last_days_orders . ' day', strtotime(date_i18n("Y-m-d"))));
    }

    $pw_sort_by  = $this->pw_get_woo_requests('sort_by', 'order_id', true);
    $pw_order_by = $this->pw_get_woo_requests('order_by', 'DESC', true);
    ///

    if ($p > 1) {
        $start = ($p - 1) * $limit;
    }

    if ($pw_detail_view == "yes") {
        $pw_variations_value    = $this->pw_get_woo_requests('variations_value', "-1", true);
        $pw_variations_formated = '-1';
        if ($pw_variations_value != "-1" and strlen($pw_variations_value) > 0) {
            $pw_variations_value = explode(",", $pw_variations_value);
            $var                 = array();
            foreach ($pw_variations_value as $key => $value):
                $var[] .= $value;
            endforeach;
            $result = array_unique($var);
            //$this->print_array($var);
            $pw_variations_formated = implode("', '", $result);
        }
        $_REQUEST['variations_formated'] = $pw_variations_formated;
    }


    //pw_first_name_text
    $pw_txt_first_name_cols        = '';
    $pw_txt_first_name_join        = '';
    $pw_txt_first_name_condition_1 = '';
    $pw_txt_first_name_condition_2 = '';

    //pw_email_text
    $pw_txt_email_cols        = '';
    $pw_txt_email_join        = '';
    $pw_txt_email_condition_1 = '';
    $pw_txt_email_condition_2 = '';

    //SORT BY
    $pw_sort_by_cols = '';

    //CATEGORY
    $category_id_join      = '';
    $category_id_condition = '';

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    $brand_id_join      = '';
    $brand_id_condition = '';

    //ORDER ID
    $pw_id_order_status_join      = '';
    $pw_id_order_status_condition = '';

    //COUNTRY
    $pw_country_code_join        = '';
    $pw_country_code_condition_1 = '';
    $pw_country_code_condition_2 = '';

    //STATE
    $state_code_join        = '';
    $state_code_condition_1 = '';
    $state_code_condition_2 = '';

    //PAYMENT METHOD
    $pw_payment_method_join        = '';
    $pw_payment_method_condition_1 = '';
    $pw_payment_method_condition_2 = '';

    //POSTCODE
    $pw_billing_post_code_join      = '';
    $pw_billing_post_code_condition = '';

    //COUPON USED
    $pw_coupon_used_join      = '';
    $pw_coupon_used_condition = '';

    //VARIATION ID
    $pw_variation_id_join      = '';
    $pw_variation_id_condition = '';

    ////ADDED IN V4.0
    //VARIATION
    $pw_variation_item_meta_key_join      = '';
    $sql_variation_join                   = '';
    $pw_show_variation_join               = '';
    $pw_variation_item_meta_key_condition = '';
    $sql_variation_condition              = '';

    //VARIATION ONLY
    $pw_variation_only_join      = '';
    $pw_variation_only_condition = '';

    //VARIATION FORMAT
    $pw_variations_formated_join      = '';
    $pw_variations_formated_condition = '';

    //ORDER META KEY
    $pw_order_meta_key_join      = '';
    $pw_order_meta_key_condition = '';

    //COUPON CODES
    $pw_coupon_codes_join      = '';
    $pw_coupon_codes_condition = '';

    //COUPON CODE
    $pw_coupon_code_condition = '';

    //DATA CONDITION
    $date_condition = '';

    //ORDER ID
    $order_id_condition = '';

    //PAID CUSTOMER
    $pw_paid_customer_condition = '';

    //PUBLISH ORDER
    $pw_publish_order_condition_1 = '';
    $pw_publish_order_condition_2 = '';

    //ORDER ITEM NAME
    $pw_order_item_name_condition = '';

    //txt PRODUCT
    $txtProduct_condition = '';

    //PRODUCT ID
    $pw_product_id_condition = '';

    //CATEGORY ID
    $category_id_condition = '';

    //ORDER STATUS ID
    $pw_id_order_status_condition = '';

    //ORDER STATUS
    $pw_order_status_condition = '';

    //HIDE ORDER STATUS
    $pw_hide_os_condition = '';

    ////ADDED IN VER4.0
    /// COST OF GOOD
    $pw_show_cog_cols      = '';
    $pw_show_cog_join      = '';
    $pw_show_cog_condition = '';


    if (($pw_txt_first_name and $pw_txt_first_name != '-1') || $pw_sort_by == "billing_name") {
        $pw_txt_first_name_cols = " CONCAT(pw_postmeta1.meta_value, ' ', pw_postmeta2.meta_value) AS billing_name,";
    }
    if ($pw_txt_email || ($pw_paid_customer && $pw_paid_customer != '-1' and $pw_paid_customer != "'-1'") || $pw_sort_by == "billing_email") {
        $pw_txt_email_cols = " postmeta.meta_value AS billing_email,";
    }

    if ($pw_sort_by == "status") {
        $pw_sort_by_cols = " terms2.name as status, ";
    }
    $sql_columns = " $pw_txt_first_name_cols $pw_txt_email_cols $pw_sort_by_cols";
    $sql_columns .= "
		IF ( (woocommerce_order_itemmeta.meta_key = '_fee_amount'), 1, 0) AS fee,

        billing_country.meta_value as billing_country,
        DATE_FORMAT(pw_posts.post_date,'%m/%d/%Y') 													AS order_date,
		pw_woocommerce_order_items.order_id 															AS order_id,
		pw_woocommerce_order_items.order_item_name 													AS product_name,
		pw_woocommerce_order_items.order_item_id														AS order_item_id,
		woocommerce_order_itemmeta.meta_value 														AS woocommerce_order_itemmeta_meta_value,
		(pw_woocommerce_order_itemmeta2.meta_value/pw_woocommerce_order_itemmeta3.meta_value) 			AS sold_rate,
		IF ( (woocommerce_order_itemmeta.meta_key = '_fee_amount'), woocommerce_order_itemmeta.meta_value , (pw_woocommerce_order_itemmeta4.meta_value/pw_woocommerce_order_itemmeta3.meta_value))AS product_rate,

		IF ( (woocommerce_order_itemmeta.meta_key = '_fee_amount'), woocommerce_order_itemmeta.meta_value , (pw_woocommerce_order_itemmeta4.meta_value))AS item_amount,
		(pw_woocommerce_order_itemmeta2.meta_value) 													AS item_net_amount,
		(pw_woocommerce_order_itemmeta4.meta_value - pw_woocommerce_order_itemmeta2.meta_value) 			AS item_discount,
		pw_woocommerce_order_itemmeta2.meta_value 														AS total_price,
		count(pw_woocommerce_order_items.order_item_id) 												AS product_quentity,
		woocommerce_order_itemmeta.meta_value 														AS product_id

		,pw_woocommerce_order_itemmeta3.meta_value 													AS 'product_quantity'
		,pw_posts.post_status 																			AS post_status
		,pw_posts.post_status 																			AS order_status

		";

//		if($pw_variation_id  && $pw_variation_id != "-1") {
//			$sql_columns .= " ,woocommerce_order_itemmeta22.meta_value AS variation_id ";
//		}

    ////ADDED IN V4.0
    if (($pw_variation_item_meta_key != "-1" and strlen($pw_variation_item_meta_key) > 1)) {
        $sql_columns .= " , pw_woocommerce_order_itemmeta_variation.meta_key AS variation_key";
        $sql_columns .= " , pw_woocommerce_order_itemmeta_variation.meta_value AS variation_value";
    }

    ////ADDED IN VER4.0
    /// COST OF GOOD
    if ($pw_show_cog == "yes") {
        $sql_columns .= " ,woo_itemmeta_cog.meta_value as cog ";
    }


    $sql_joins = "{$wpdb->prefix}woocommerce_order_items as pw_woocommerce_order_items

		LEFT JOIN  {$wpdb->prefix}posts as pw_posts ON pw_posts.ID=pw_woocommerce_order_items.order_id

		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta 	ON woocommerce_order_itemmeta.order_item_id		=	pw_woocommerce_order_items.order_item_id";

    ////ADDED IN V4.0
    if (($pw_variation_item_meta_key != "-1" and strlen($pw_variation_item_meta_key) > 1)) {
        $pw_variation_item_meta_key_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as pw_woocommerce_order_itemmeta_variation ON pw_woocommerce_order_itemmeta_variation.order_item_id= pw_woocommerce_order_items.order_item_id";
    }


    $sql_joins .= "
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta2 	ON pw_woocommerce_order_itemmeta2.order_item_id	=	pw_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta3 	ON pw_woocommerce_order_itemmeta3.order_item_id	=	pw_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta4 	ON pw_woocommerce_order_itemmeta4.order_item_id	=	pw_woocommerce_order_items.order_item_id AND pw_woocommerce_order_itemmeta4.meta_key='_line_subtotal'
        LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id = pw_posts.ID
        ";


    if ($category_id && $category_id != "-1") {
        $category_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as pw_term_relationships 			ON pw_term_relationships.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 				ON term_taxonomy.term_taxonomy_id	=	pw_term_relationships.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as pw_terms 						ON pw_terms.term_id					=	term_taxonomy.term_id";
    }

    /////ADDED IN VER4.0
    //BRANDS ADDONS
    if ($brand_id && $brand_id != "-1") {
        $brand_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as pw_term_relationships_brand 			ON pw_term_relationships_brand.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy_brand				ON term_taxonomy_brand.term_taxonomy_id	=	pw_term_relationships_brand.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as pw_terms_brand 						ON pw_terms_brand.term_id					=	term_taxonomy_brand.term_id";
    }

    if (($pw_id_order_status && $pw_id_order_status != '-1') || $pw_sort_by == "status") {
        $pw_id_order_status_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as pw_term_relationships2			ON pw_term_relationships2.object_id	= pw_woocommerce_order_items.order_id
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as pw_term_taxonomy2				ON pw_term_taxonomy2.term_taxonomy_id	= pw_term_relationships2.term_taxonomy_id";
        if ($pw_sort_by == "status") {
            $pw_id_order_status_join .= " LEFT JOIN  {$wpdb->prefix}terms 	as terms2 						ON terms2.term_id					=	pw_term_taxonomy2.term_id";
        }
    }

    if ($pw_txt_email || ($pw_paid_customer && $pw_paid_customer != '-1' and $pw_paid_customer != "'-1'") || $pw_sort_by == "billing_email") {
        $pw_txt_email_join = "
				LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=pw_woocommerce_order_items.order_id";
    }
    if (($pw_txt_first_name and $pw_txt_first_name != '-1') || $pw_sort_by == "billing_name") {
        $pw_txt_first_name_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta1 ON pw_postmeta1.post_id=pw_woocommerce_order_items.order_id
			LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta2 ON pw_postmeta2.post_id=pw_woocommerce_order_items.order_id";
    }

    if ($pw_country_code and $pw_country_code != '-1') {
        $pw_country_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta4 ON pw_postmeta4.post_id=pw_woocommerce_order_items.order_id";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta_billing_state ON pw_postmeta_billing_state.post_id=pw_posts.ID";
    }

    if ($pw_payment_method) {
        $pw_payment_method_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta5 ON pw_postmeta5.post_id=pw_woocommerce_order_items.order_id";
    }

    if ($pw_billing_post_code and $pw_billing_post_code != '-1') {
        $pw_billing_post_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta_billing_postcode ON pw_postmeta_billing_postcode.post_id	=	pw_posts.ID";
    }

    if ($pw_coupon_used == "yes") {
        $pw_coupon_used_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta6 ON pw_postmeta6.post_id=pw_woocommerce_order_items.order_id";
    }

    if ($pw_coupon_used == "yes") {
        $pw_coupon_used_join .= " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta7 ON pw_postmeta7.post_id=pw_posts.ID";
    }

//		if($pw_variation_id  && $pw_variation_id != "-1") {
//			$pw_variation_id_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta_variation			ON pw_woocommerce_order_itemmeta_variation.order_item_id 		= 	pw_woocommerce_order_items.order_item_id";
//		}

    if ($pw_variation_only && $pw_variation_only != "-1" && $pw_variation_only == "yes") {
        $pw_variation_only_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as pw_woocommerce_order_itemmeta_variation_o			ON pw_woocommerce_order_itemmeta_variation_o.order_item_id 		= 	pw_woocommerce_order_items.order_item_id";
    }

    if ($pw_variations_formated != "-1" and $pw_variations_formated != null) {
        $pw_variations_formated_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as pw_woocommerce_order_itemmeta8 ON pw_woocommerce_order_itemmeta8.order_item_id = pw_woocommerce_order_items.order_item_id";
        $pw_variations_formated_join .= " LEFT JOIN  {$wpdb->prefix}postmeta as pw_postmeta_variation ON pw_postmeta_variation.post_id = pw_woocommerce_order_itemmeta8.meta_value";
    }

    if ($pw_order_meta_key and $pw_order_meta_key != '-1') {
        $pw_order_meta_key_join = " LEFT JOIN  {$wpdb->prefix}postmeta as pw_order_meta_key ON pw_order_meta_key.post_id=pw_posts.ID";
    }

    if (($pw_coupon_codes != '' && $pw_coupon_codes != "-1") or ($pw_coupon_code && $pw_coupon_code != "-1")) {
        $pw_coupon_codes_join = " LEFT JOIN {$wpdb->prefix}woocommerce_order_items as pw_woocommerce_order_coupon_item ON pw_woocommerce_order_coupon_item.order_id = pw_posts.ID AND pw_woocommerce_order_coupon_item.order_item_type = 'coupon'";
    }


    ////ADDED IN VER4.0
    /// COST OF GOOD
    if ($pw_show_cog == "yes") {
        $pw_show_cog_join = " LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as woo_itemmeta_cog ON woocommerce_order_itemmeta.order_item_id	=	woo_itemmeta_cog.order_item_id  ";
    }


    $post_type_condition = "pw_posts.post_type = 'shop_order' AND billing_country.meta_key	= '_billing_country'";


    if ($pw_txt_email || ($pw_paid_customer && $pw_paid_customer != '-1' and $pw_paid_customer != "'-1'") || $pw_sort_by == "billing_email") {
        $pw_txt_email_condition_1 = "
				AND postmeta.meta_key='_billing_email'";
    }

    if (($pw_txt_first_name and $pw_txt_first_name != '-1') || $pw_sort_by == "billing_name") {
        $pw_txt_first_name_condition_1 = "
				AND pw_postmeta1.meta_key='_billing_first_name'
				AND pw_postmeta2.meta_key='_billing_last_name'";
    }

    $other_condition_1 = "
		AND ((woocommerce_order_itemmeta.meta_key = '_product_id'  AND pw_woocommerce_order_itemmeta3.meta_key='_qty') OR (woocommerce_order_itemmeta.meta_key = '_fee_amount'))

		AND pw_woocommerce_order_itemmeta2.meta_key='_line_total'
		";

    //AND woocommerce_order_itemmeta.meta_key = '_product_id'
    //AND pw_woocommerce_order_itemmeta3.meta_key='_qty'
//
//		if($pw_variation_id  && $pw_variation_id != "-1") {
//			$other_condition_1 .= " AND woocommerce_order_itemmeta22.meta_key = '_variation_id' ";
//		}


    if ($pw_country_code and $pw_country_code != '-1') {
        $pw_country_code_condition_1 = " AND pw_postmeta4.meta_key='_billing_country'";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_condition_1 = " AND pw_postmeta_billing_state.meta_key='_billing_state'";
    }

    if ($pw_billing_post_code and $pw_billing_post_code != '-1') {
        $pw_billing_post_code_condition = " AND pw_postmeta_billing_postcode.meta_key='_billing_postcode' AND pw_postmeta_billing_postcode.meta_value LIKE '%{$pw_billing_post_code}%' ";
    }

    if ($pw_payment_method) {
        $pw_payment_method_condition_1 = " AND pw_postmeta5.meta_key='_payment_method_title'";
    }

    if ($pw_from_date != null && $pw_to_date != null) {
        $date_condition = " AND DATE(pw_posts.post_date) BETWEEN STR_TO_DATE('" . $pw_from_date . "', '$date_format') and STR_TO_DATE('" . $pw_to_date . "', '$date_format')";
    }

    if ($order_id) {
        $order_id_condition = " AND pw_woocommerce_order_items.order_id = " . $order_id;
    }

    if ($pw_txt_email) {
        $pw_txt_email_condition_2 = " AND postmeta.meta_value LIKE '%" . $pw_txt_email . "%'";
    }

    if ($pw_paid_customer && $pw_paid_customer != '-1' and $pw_paid_customer != "'-1'") {
        $pw_paid_customer_condition = " AND postmeta.meta_value IN ('" . $pw_paid_customer . "')";
    }

    //if($pw_txt_first_name and $pw_txt_first_name != '-1') $sql .= " AND (pw_postmeta1.meta_value LIKE '%".$pw_txt_first_name."%' OR pw_postmeta2.meta_value LIKE '%".$pw_txt_first_name."%')";
    if ($pw_txt_first_name and $pw_txt_first_name != '-1') {
        $pw_txt_first_name_condition_2 = " AND (lower(concat_ws(' ', pw_postmeta1.meta_value, pw_postmeta2.meta_value)) like lower('%" . $pw_txt_first_name . "%') OR lower(concat_ws(' ', pw_postmeta2.meta_value, pw_postmeta1.meta_value)) like lower('%" . $pw_txt_first_name . "%'))";
    }

    //if($pw_id_order_status  && $pw_id_order_status != "-1") $sql .= " AND terms2.term_id IN (".$pw_id_order_status .")";

    if ($pw_publish_order == 'yes') {
        $pw_publish_order_condition_1 = " AND pw_posts.post_status = 'publish'";
    }

    if ($pw_publish_order == 'publish' || $pw_publish_order == 'trash') {
        $pw_publish_order_condition_2 = " AND pw_posts.post_status = '" . $pw_publish_order . "'";
    }

    //if($pw_country_code and $pw_country_code != '-1')	$sql .= " AND pw_postmeta4.meta_value LIKE '%".$pw_country_code."%'";

    //if($state_code and $state_code != '-1')	$sql .= " AND pw_postmeta_billing_state.meta_value LIKE '%".$state_code."%'";

    if ($pw_country_code and $pw_country_code != '-1') {
        $pw_country_code_condition_2 = " AND pw_postmeta4.meta_value IN (" . $pw_country_code . ")";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_condition_2 = " AND pw_postmeta_billing_state.meta_value IN (" . $state_code . ")";
    }

    if ($pw_payment_method) {
        $pw_payment_method_condition_2 = " AND pw_postmeta5.meta_value LIKE '%" . $pw_payment_method . "%'";
    }

    if ($pw_order_meta_key and $pw_order_meta_key != '-1') {
        $pw_order_meta_key_condition = " AND pw_order_meta_key.meta_key='{$pw_order_meta_key}' AND pw_order_meta_key.meta_value > 0";
    }

    if ($pw_order_item_name) {
        $pw_order_item_name_condition = " AND pw_woocommerce_order_items.order_item_name LIKE '%" . $pw_order_item_name . "%'";
    }

    if ($txtProduct && $txtProduct != '-1') {
        $txtProduct_condition = " AND pw_woocommerce_order_items.order_item_name LIKE '%" . $txtProduct . "%'";
    }

    if ($pw_product_id && $pw_product_id != "-1") {
        $pw_product_id_condition = " AND woocommerce_order_itemmeta.meta_value IN (" . $pw_product_id . ")";
    }

    //if($category_id  && $category_id != "-1") $sql .= " AND pw_terms.name NOT IN('simple','variable','grouped','external') AND term_taxonomy.taxonomy LIKE('product_cat') AND term_taxonomy.term_id IN (".$category_id .")";
    if ($category_id && $category_id != "-1") {
        $category_id_condition = " AND term_taxonomy.taxonomy LIKE('product_cat') AND term_taxonomy.term_id IN (" . $category_id . ")";
    }

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    if ($brand_id && $brand_id != "-1") {
        $brand_id_condition = " AND term_taxonomy_brand.taxonomy LIKE('" . __PW_BRAND_SLUG__ . "') AND term_taxonomy_brand.term_id IN (" . $brand_id . ")";
    }


    if ($pw_id_order_status && $pw_id_order_status != "-1") {
        $pw_id_order_status_condition = " AND pw_term_taxonomy2.taxonomy LIKE('shop_order_status') AND pw_term_taxonomy2.term_id IN (" . $pw_id_order_status . ")";
    }

    if ($pw_coupon_used == "yes") {
        $pw_coupon_used_condition = " AND( (pw_postmeta6.meta_key='_order_discount' AND pw_postmeta6.meta_value > 0) ||  (pw_postmeta7.meta_key='_cart_discount' AND pw_postmeta7.meta_value > 0))";
    }


    if ($pw_coupon_code != '' && $pw_coupon_code != "-1") {
        $pw_coupon_code_condition = " AND (pw_woocommerce_order_coupon_item.order_item_name IN ('{$pw_coupon_code}') OR pw_woocommerce_order_coupon_item.order_item_name LIKE '%{$pw_coupon_code}%')";
    }
    //echo $pw_coupon_codes.'---';

    if ($pw_coupon_codes != '' && $pw_coupon_codes != "-1") {
        $pw_coupon_codes_condition = " AND pw_woocommerce_order_coupon_item.order_item_name IN ({$pw_coupon_codes})";
    }

//		if($pw_variation_id  && $pw_variation_id != "-1") {
//			$pw_variation_id_condition = " AND pw_woocommerce_order_itemmeta_variation.meta_key = '_variation_id' AND pw_woocommerce_order_itemmeta_variation.meta_value IN (".$pw_variation_id .")";
//		}

    if ($pw_variation_only && $pw_variation_only != "-1" && $pw_variation_only == "yes") {
        $pw_variation_only_condition = " AND pw_woocommerce_order_itemmeta_variation_o.meta_key 	= '_variation_id'
					 AND (pw_woocommerce_order_itemmeta_variation_o.meta_value IS NOT NULL AND pw_woocommerce_order_itemmeta_variation_o.meta_value > 0)";
    }

    ////ADDED IN V4.0
    if (($pw_variation_item_meta_key != "-1" and strlen($pw_variation_item_meta_key) > 1)) {
        $pw_variation_item_meta_key_condition = " AND pw_woocommerce_order_itemmeta_variation.meta_key IN ('{$pw_variation_item_meta_key}')";
    }

    if ($pw_variations_formated != "-1" and $pw_variations_formated != null) {
        $pw_variations_formated_condition = "
			AND pw_woocommerce_order_itemmeta8.meta_key = '_variation_id' AND (pw_woocommerce_order_itemmeta8.meta_value IS NOT NULL AND pw_woocommerce_order_itemmeta8.meta_value > 0)";
        $pw_variations_formated_condition .= "
			AND pw_postmeta_variation.meta_value IN ('{$pw_variations_formated}')";
    }

    ////ADDED IN VER4.0
    /// COST OF GOOD
    if ($pw_show_cog == "yes") {
        $pw_show_cog_condition = " AND woo_itemmeta_cog.meta_key='" . __PW_COG_TOTAL__ . "' ";
    }


    if ($pw_order_status && $pw_order_status != '-1' and $pw_order_status != "'-1'") {
        $pw_order_status_condition = " AND pw_posts.post_status IN (" . $pw_order_status . ")";
    }

    if ($pw_hide_os && $pw_hide_os != '-1' and $pw_hide_os != "'-1'") {
        $pw_hide_os_condition = " AND pw_posts.post_status NOT IN ('" . $pw_hide_os . "')";
    }


    $sql = "SELECT $sql_columns FROM $sql_joins";

    $sql .= "$category_id_join $brand_id_join $pw_id_order_status_join $pw_txt_email_join $pw_txt_first_name_join
				$pw_country_code_join $state_code_join $pw_payment_method_join $pw_billing_post_code_join
				$pw_coupon_used_join $pw_variation_id_join $pw_variation_only_join $pw_variations_formated_join
				$pw_order_meta_key_join $pw_coupon_codes_join $pw_variation_item_meta_key_join $pw_show_cog_join ";

    $sql .= " Where $post_type_condition $pw_txt_email_condition_1 $pw_txt_first_name_condition_1
						$other_condition_1 $pw_country_code_condition_1 $state_code_condition_1
						$pw_billing_post_code_condition $pw_payment_method_condition_1 $date_condition
						$order_id_condition $pw_txt_email_condition_2 $pw_paid_customer_condition
						$pw_txt_first_name_condition_2 $pw_publish_order_condition_1 $pw_publish_order_condition_2
						$pw_country_code_condition_2 $state_code_condition_2 $pw_payment_method_condition_2
						$pw_order_meta_key_condition $pw_order_item_name_condition $txtProduct_condition
						$pw_product_id_condition $category_id_condition $brand_id_condition $pw_id_order_status_condition
						$pw_coupon_used_condition $pw_coupon_code_condition $pw_coupon_codes_condition $pw_variation_item_meta_key_condition
						$pw_variation_id_condition $pw_variation_only_condition $pw_variations_formated_condition $pw_show_cog_condition
						$pw_order_status_condition $pw_hide_os_condition ";

    $sql_group_by = " GROUP BY pw_woocommerce_order_items.order_item_id ";
    $sql_order_by = " ORDER BY {$pw_sort_by} {$pw_order_by}";

    $sql .= $sql_group_by . $sql_order_by;

    //print_r($search_fields);
//echo $sql;


    $columns_total = '';
    if ($pw_detail_view == "yes") {

        $columns = array(

            array('lable' => esc_html__('Order ID', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Date', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Status', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Coupon Code', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Customer Name', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Email', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 1', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 2', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Post Code', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing City', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing State', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing County', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            array('lable' => esc_html__('Shipping Address 1', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping Address 2', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping Post Code', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping City', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping State', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping County', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            array('lable' => esc_html__('Products', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('SKU', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Category', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Variation', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Qty.', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Rate', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Prod. Amt.', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),

            //SHIPPING AMNT
            array('lable'=>esc_html__('Shipping Tax Amt.',__PW_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
            array('lable'=>esc_html__('Order Tax Amt.',__PW_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
            array('lable'=>esc_html__('Total Tax Amt.',__PW_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
            array('lable' => esc_html__('Delivery charge', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Order total', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
        );


    } else {

        $columns = array(
            array('lable' => esc_html__('Customer Name', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Email', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 1', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 2', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Post Code', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing City', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing State', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing County', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Order ID', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Date', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Status', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Coupon Code', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            //SHIPPING AMNT
            array('lable' => esc_html__('Delivery charge', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Order total', __PW_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
        );

    }

    $columns          = array_values($columns);
    $this->table_cols = $columns;

} elseif ($file_used == "data_table") {

    $first_order_id = '';


    $order_items = $this->results;
    $categories  = array();
    $order_meta  = array();
    if (count($order_items) > 0) // print_r($order_items);
    {
        foreach ($order_items as $key => $order_item) {


            $order_id                              = $order_item->order_id;
            $order_items[$key]->billing_first_name = '';//Default, some time it missing
            $order_items[$key]->billing_last_name  = '';//Default, some time it missing
            $order_items[$key]->billing_email      = '';//Default, some time it missing

            if ( ! isset($order_meta[$order_id])) {
                $order_meta[$order_id] = $this->pw_get_full_post_meta($order_id);
            }

            //die(print_r($order_meta[$order_id]));

            foreach ($order_meta[$order_id] as $k => $v) {
                $order_items[$key]->$k = $v;
            }


            $order_items[$key]->order_total    = isset($order_item->order_total) ? $order_item->order_total : 0;
            $order_items[$key]->order_shipping = isset($order_item->order_shipping) ? $order_item->order_shipping : 0;


            $order_items[$key]->cart_discount  = isset($order_item->cart_discount) ? $order_item->cart_discount : 0;
            $order_items[$key]->order_discount = isset($order_item->order_discount) ? $order_item->order_discount : 0;
            $order_items[$key]->total_discount = isset($order_item->total_discount) ? $order_item->total_discount : ($order_items[$key]->cart_discount + $order_items[$key]->order_discount);


            $order_items[$key]->order_tax          = isset($order_item->order_tax) ? $order_item->order_tax : 0;
            $order_items[$key]->order_shipping_tax = isset($order_item->order_shipping_tax) ? $order_item->order_shipping_tax : 0;
            $order_items[$key]->total_tax          = isset($order_item->total_tax) ? $order_item->total_tax : ($order_items[$key]->order_tax + $order_items[$key]->order_shipping_tax);

            $transaction_id                    = "ransaction ID";
            $order_items[$key]->transaction_id = isset($order_item->$transaction_id) ? $order_item->$transaction_id : (isset($order_item->transaction_id) ? $order_item->transaction_id : '');
            $order_items[$key]->gross_amount   = ($order_items[$key]->order_total + $order_items[$key]->total_discount) - ($order_items[$key]->order_shipping + $order_items[$key]->order_shipping_tax + $order_items[$key]->order_tax);


            $order_items[$key]->billing_first_name = isset($order_item->billing_first_name) ? $order_item->billing_first_name : '';
            $order_items[$key]->billing_last_name  = isset($order_item->billing_last_name) ? $order_item->billing_last_name : '';
            $order_items[$key]->billing_name       = $order_items[$key]->billing_first_name .' '. $order_items[$key]->billing_last_name ;
            $order_items[$key]->billing_address_1  = $order_items[$key]->billing_address_1 ? $order_items[$key]->billing_address_1 : '';
            $order_items[$key]->billing_address_2  = $order_items[$key]->billing_address_2 ? $order_items[$key]->billing_address_2 : '';
            $order_items[$key]->billing_postcode   = $order_items[$key]->billing_postcode ? $order_items[$key]->billing_postcode : '';
            $order_items[$key]->billing_city       = $order_items[$key]->billing_city ? $order_items[$key]->billing_city : '';
            $order_items[$key]->billing_state      = $order_items[$key]->billing_state ? $order_items[$key]->billing_state : '';
            $order_items[$key]->billing_country    = $order_items[$key]->billing_country ? $order_items[$key]->billing_country : '';


            $order_items[$key]->shipping_address_1  = $order_items[$key]->shipping_address_1 ? $order_items[$key]->shipping_address_1 : '';
            $order_items[$key]->shipping_address_2  = $order_items[$key]->shipping_address_2 ? $order_items[$key]->shipping_address_2 : '';
            $order_items[$key]->shipping_postcode   = $order_items[$key]->shipping_postcode ? $order_items[$key]->shipping_postcode : '';
            $order_items[$key]->shipping_city       = $order_items[$key]->shipping_city ? $order_items[$key]->shipping_city : '';
            $order_items[$key]->shipping_state      = $order_items[$key]->shipping_state ? $order_items[$key]->shipping_state : '';
            $order_items[$key]->shipping_country    = $order_items[$key]->shipping_country ? $order_items[$key]->shipping_country : '';


        }
    }


    //print_r($order_items);

    $this->results = $order_items;


    //print_r($this->results);

    $items_render = array();


    ////ADDE IN VER4.0
    /// TOTAL ROWS VARIABLES
    $gross_amnt = $discount_amnt = $shipping_amnt = $shipping_tax_amnt = $cog_amnt = $profit_amnt =
    $order_tax_amnt = $total_tax_amnt = $part_refund_amnt = $order_count =
    $product_count = $product_qty = $total_rate = $product_amnt = $product_discount = $net_amnt = 0;

    $order_ids = [];

    foreach ($this->results as $items) {
        $index_cols = 0;
        //for($i=1; $i<=20 ; $i++){


        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $product_count++;

        $order_id         = $items->order_id;
        $fetch_other_data = '';

        if ( ! isset($this->order_meta[$order_id])) {
            $fetch_other_data = $this->pw_get_full_post_meta($order_id);
        }

        $new_order = false;
        if ($first_order_id == '') {
            $first_order_id = $items->order_id;
            $new_order      = true;
        } elseif ($first_order_id != $items->order_id) {
            $first_order_id = $items->order_id;
            $new_order      = true;
        }
        $pw_detail_view = $this->pw_get_woo_requests('pw_view_details', "no", true);





        if ($pw_detail_view == "yes") {
            if (1){



                $datatable_value .= ("<tr>");

                //order ID
                $order_id = $items->order_id;

                //CUSTOM WORK - 15862
                if (is_array(__CUSTOMWORK_ID__) && in_array('15862', __CUSTOMWORK_ID__)) {
                    $order_id = get_post_meta($order_id, '_order_number_formatted', true);
                }

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= ($order_id);
                $datatable_value .= ("</td>");

                //Date
                $date_format   = get_option('date_format');
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= date($date_format, strtotime($items->order_date));
                $datatable_value .= ("</td>");

                //Status
                $pw_table_value = isset($items->order_status) ? $items->order_status : '';

                if ($pw_table_value == 'wc-completed') {
                    $pw_table_value = '<span class="awr-order-status awr-order-status-' . sanitize_title($pw_table_value) . '" >' . ucwords(__($pw_table_value,
                            __PW_REPORT_WCREPORT_TEXTDOMAIN__)) . '</span>';
                } elseif ($pw_table_value == 'wc-refunded') {
                    $pw_table_value = '<span class="awr-order-status awr-order-status-' . sanitize_title($pw_table_value) . '" >' . ucwords(__($pw_table_value,
                            __PW_REPORT_WCREPORT_TEXTDOMAIN__)) . '</span>';
                } else {
                    $pw_table_value = '<span class="awr-order-status awr-order-status-' . sanitize_title($pw_table_value) . '" >' . ucwords(__($pw_table_value,
                            __PW_REPORT_WCREPORT_TEXTDOMAIN__)) . '</span>';
                }

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= str_replace("Wc-", "", $pw_table_value);
                $datatable_value .= ("</td>");


                $pw_table_value=$this->pw_get_woo_coupons($items->order_id);

                $display_class='';
                if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $pw_table_value;
                $datatable_value.=("</td>");


                //Name
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->billing_name;
                $datatable_value .= ("</td>");

                //Email
                $pw_table_value = isset($items->billing_email) ? $items->billing_email : '';
                $pw_table_value = $this->pw_email_link_format($pw_table_value, false);
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");


                //Address 1
                $pw_table_value = isset($items->billing_address_1) ? $items->billing_address_1 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //Address 2
                $pw_table_value = isset($items->billing_address_2) ? $items->billing_address_2 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //Postcode
                $pw_table_value = isset($items->billing_postcode) ? $items->billing_postcode : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //City
                $pw_table_value = isset($items->billing_city) ? $items->billing_city : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //State
                $pw_table_value = isset($items->billing_state) ? $items->billing_state : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //Country
                $pw_table_value = isset($items->billing_country) ? $items->billing_country : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");


                //Address 1
                $pw_table_value = isset($items->shipping_address_1) ? $items->shipping_address_1 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //Address 2
                $pw_table_value = isset($items->shipping_address_2) ? $items->shipping_address_2 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //Postcode
                $pw_table_value = isset($items->shipping_postcode) ? $items->shipping_postcode : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //City
                $pw_table_value = isset($items->shipping_city) ? $items->shipping_city : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //State
                $pw_table_value = isset($items->shipping_state) ? $items->shipping_state : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");

                //Country
                $pw_table_value = isset($items->shipping_country) ? $items->shipping_country : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");


                //Products
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->product_name;
                $datatable_value .= ("</td>");

                //SKU
                $display_class = '';
                $sku           = $this->pw_get_prod_sku($items->order_item_id, $items->product_id);
                if ($items->fee) {
                    $sku = 'Fee';
                }
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $sku;
                $datatable_value .= ("</td>");

                //Category
                $display_class = '';
                $categoriess   = $this->pw_get_cn_product_id($items->product_id, "product_cat");
                if ($items->fee) {
                    $categoriess = '';
                }
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $categoriess;
                $datatable_value .= ("</td>");

                //Variation
                $pw_table_value  = $this->pw_get_woo_variation($items->order_item_id);
                $order_item_id   = ($items->order_item_id);
                $attributes      = $this->pw_get_variaiton_attributes('order_item_id', '', $order_item_id);
                $varation_string = isset($attributes['item_varation_string']) ? $attributes['item_varation_string'] : array();
                $pw_table_value  = isset($varation_string[$order_item_id]['varation_string']) ? $varation_string[$order_item_id]['varation_string'] : "";

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $pw_table_value;
                $datatable_value .= ("</td>");


                //Qty.
                $display_class = '';
                $qty           = $items->product_quantity;
                if ($items->fee) {
                    $qty = 0;
                }
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $qty;

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_qty     += $items->product_quantity;
                $datatable_value .= ("</td>");

                //Rate
                $pw_table_value = isset($items->product_rate) ? $items->product_rate : 0;
                $pw_table_value = $pw_table_value == 0 ? $pw_null_val : $pw_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($pw_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $total_rate      += $pw_table_value;
                $datatable_value .= ("</td>");

                //Prod. Amt.
                $pw_table_value = isset($items->item_amount) ? $items->item_amount : 0;
                $pw_table_value = $pw_table_value == 0 ? $pw_null_val : $pw_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($pw_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');


                //Order Shipping Tax
                $display_class='';
                $pw_table_value = isset($items -> order_shipping_tax) ? $items -> order_shipping_tax : 0;
                $pw_table_value = $pw_table_value == 0 ? $pw_null_val : $pw_table_value;
                if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $this->price($pw_table_value,array("currency" => $fetch_other_data['order_currency'],"order_id"=>$items->order_id),'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $shipping_tax_amnt+=$pw_table_value;
                $datatable_value.=("</td>");

                //Order Tax
                $display_class='';
                $pw_table_value = isset($items -> order_tax) ? $items -> order_tax : 0;
                $pw_table_value = $pw_table_value == 0 ? $pw_null_val : $pw_table_value;
                if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $this->price($pw_table_value,array("currency" => $fetch_other_data['order_currency'],"order_id"=>$items->order_id),'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $order_tax_amnt+=$pw_table_value;
                $datatable_value.=("</td>");

                //Total Tax
                $display_class='';
                $pw_table_value = isset($items -> total_tax) ? $items -> total_tax : 0;
                $pw_table_value = $pw_table_value == 0 ? $pw_null_val : $pw_table_value;
                if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $this->price($pw_table_value,array("currency" => $fetch_other_data['order_currency'],"order_id"=>$items->order_id),'multi_currency');


                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_amnt    += $pw_table_value;
                $datatable_value .= ("</td>");

                //Order Shipping
                $display_class  = '';
                $pw_table_value = isset($items->order_shipping) ? $items->order_shipping : 0;
                $pw_table_value = $pw_table_value == 0 ? $pw_null_val : $pw_table_value;
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($pw_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $shipping_amnt   += $pw_table_value;
                $datatable_value .= ("</td>");

                //Net Amt.
                $pw_table_value    = isset($items->total_price) ? $items->total_price : 0;
                $order_refund_amnt = $this->pw_get_por_amount($items->order_id);
                $part_refund       = (isset($order_refund_amnt[$items->order_id]) ? $order_refund_amnt[$items->order_id] : 0);
                $pw_table_value    = isset($items->order_total) ? ($items->order_total) - $part_refund : 0;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($pw_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS

                if(!in_array($order_id,$order_ids))
                {
                    $order_count++;
                    $net_amnt        += $pw_table_value;
                }
                $order_ids[]=$order_id;


                $datatable_value .= ("</td>");

                $datatable_value .= ("</tr>");
            }

        }
    }

    ////ADDED IN VER4.0
    /// TOTAL ROW
    $datatable_value_total = '';
    $pw_detail_view        = $this->pw_get_woo_requests('pw_view_details', "no", true);
    $pw_show_cog           = $this->pw_get_woo_requests('pw_show_cog', 'no', true);
    $table_name            = $table_name_total = "details";

    if ($pw_detail_view == "yes") {
        $table_name_total = $table_name . "_with_items";

        $this->table_cols_total = $this->table_columns_total($table_name_total);
        if ($pw_show_cog != 'yes') {
            ////ADDE IN VER4.0
            /// COST OF GOOD
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
        }

        $datatable_value_total .= ("<tr>");
        $datatable_value_total .= "<td>$order_count</td>";
        $datatable_value_total .= "<td>$product_count</td>";
        $datatable_value_total .= "<td>$product_qty</td>";
        $datatable_value_total .= "<td>" . (($total_rate) == 0 ? $this->price(0) : $this->price($total_rate)) . "</td>";
        $datatable_value_total .= "<td>" . (($product_amnt) == 0 ? $this->price(0) : $this->price($product_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($product_discount) == 0 ? $this->price(0) : $this->price($product_discount)) . "</td>";
        $datatable_value_total .= "<td>" . (($net_amnt) == 0 ? $this->price(0) : $this->price($net_amnt)) . "</td>";

        if ($pw_show_cog == 'yes') {
            $datatable_value_total .= "<td>" . (($cog_amnt) == 0 ? $this->price(0) : $this->price($cog_amnt)) . "</td>";
            $datatable_value_total .= "<td>" . (($profit_amnt) == 0 ? $this->price(0) : $this->price($profit_amnt)) . "</td>";
        }
        $datatable_value_total .= ("</tr>");
    } else {
        $table_name_total = $table_name . "_no_items";

        $this->table_cols_total = $this->table_columns_total($table_name_total);
        if ($pw_show_cog != 'yes') {
            ////ADDE IN VER4.0
            /// COST OF GOOD
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
        }

        $datatable_value_total .= ("<tr>");
        $datatable_value_total .= "<td>$order_count</td>";
        $datatable_value_total .= "<td>" . (($gross_amnt) == 0 ? $this->price(0) : $this->price($gross_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($discount_amnt) == 0 ? $this->price(0) : $this->price($discount_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($shipping_amnt) == 0 ? $this->price(0) : $this->price($shipping_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($shipping_tax_amnt) == 0 ? $this->price(0) : $this->price($shipping_tax_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($order_tax_amnt) == 0 ? $this->price(0) : $this->price($order_tax_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($total_tax_amnt) == 0 ? $this->price(0) : $this->price($total_tax_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($part_refund_amnt) == 0 ? $this->price(0) : $this->price($part_refund_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($net_amnt) == 0 ? $this->price(0) : $this->price($net_amnt)) . "</td>";

        if ($pw_show_cog == 'yes') {
            $datatable_value_total .= "<td>" . (($cog_amnt) == 0 ? $this->price(0) : $this->price($cog_amnt)) . "</td>";
            $datatable_value_total .= "<td>" . (($profit_amnt) == 0 ? $this->price(0) : $this->price($profit_amnt)) . "</td>";
        }

        $datatable_value_total .= ("</tr>");
    }


} elseif ($file_used == "search_form") {
    ?>
    <form class='alldetails search_form_report' action='' method='post'>
        <input type='hidden' name='action' value='submit-form'/>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Date From', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="pw_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick"/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Date To', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="pw_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Order ID', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="pw_id_order" type="text" class=""/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Customer', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-user"></i></span>
            <input name="pw_first_name_text" type="text" class=""/>
        </div>

        <?php
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('pw_category_id');
        if ($this->get_form_element_permission('pw_category_id') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('pw_category_id') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Category', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                <?php
                $args = array(
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => 1,
                    'hierarchical' => 0,
                    'exclude'      => '',
                    'include'      => '',
                    'child_of'     => 0,
                    'number'       => '',
                    'pad_counts'   => false

                );

                //$categories = get_categories($args);
                $current_category = $this->pw_get_woo_requests_links('pw_category_id', '', true);

                $categories = get_terms('product_cat', $args);
                $option     = '';
                foreach ($categories as $category) {

                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($category->term_id, $permission_value)) {
                        continue;
                    }

                    $option .= '<option value="' . $category->term_id . '" ' . $selected . '>';
                    $option .= $category->name;
                    $option .= ' (' . $category->count . ')';
                    $option .= '</option>';
                }
                ?>
                <select name="pw_category_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('pw_category_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }

        ////ADDED IN VER4.0
        //BRANDS ADDONS
        ////////////////BRANDS-ADDON////////////
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('pw_brand_id');

        if (__PW_BRAND_SLUG__ && ($this->get_form_element_permission('pw_brand_id') || $permission_value != '')) {
            if ( ! $this->get_form_element_permission('pw_brand_id') && $permission_value != '') {
                $col_style = 'display:none';
            }

            //if(count($permission_value)==1) $col_style='display:none';
            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php echo __PW_BRAND_LABEL__; ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                <?php
                $args = array(
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => 1,
                    'hierarchical' => 0,
                    'exclude'      => '',
                    'include'      => '',
                    'child_of'     => 0,
                    'number'       => '',
                    'pad_counts'   => false

                );

                //$categories = get_categories($args);
                $current_category = $this->pw_get_woo_requests_links('pw_brand_id', '', true);

                $current_category = $permission_value;

                $categories = get_terms(__PW_BRAND_SLUG__, $args);
                $option     = '';
                foreach ($categories as $category) {
                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($category->term_id, $permission_value)) {
                        continue;
                    }

                    $option .= '<option value="' . $category->term_id . '" ' . $selected . '>';
                    $option .= $category->name;
                    $option .= ' (' . $category->count . ')';
                    $option .= '</option>';
                }
                ?>
                <select name="pw_brand_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('pw_brand_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }

        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('pw_product_id');
        if ($this->get_form_element_permission('pw_product_id') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('pw_product_id') && $permission_value != '') {
                $col_style = 'display:none';
            }

            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Product', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-gear"></i></span>
                <?php
                $products        = $this->pw_get_product_woo_data('all');
                $option          = '';
                $current_product = $this->pw_get_woo_requests_links('pw_product_id', '', true);
                //echo $current_product;

                foreach ($products as $product) {
                    $selected = '';
                    if (is_array($permission_value) && ! in_array($product->id, $permission_value)) {
                        continue;
                    }


                    if ($current_product == $product->id) {
                        $selected = "selected";
                    }
                    $option .= "<option $selected value='" . $product->id . "' >" . $product->label . " </option>";
                }


                ?>
                <select name="pw_product_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('pw_product_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }
        ?>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Customer', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-user"></i></span>
            <?php
            $customers = $this->pw_get_woo_customers_orders();
            $option    = '';
            foreach ($customers as $customer) {
                $option .= "<option value='" . $customer->id . "' >" . $customer->label . " ($customer->counts)</option>";
            }
            ?>
            <select name="pw_customers_paid[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>

        </div>

        <?php
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('pw_orders_status');
        if ($this->get_form_element_permission('pw_orders_status') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('pw_orders_status') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Status', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-check"></i></span>
                <?php
                $pw_order_status = $this->pw_get_woo_orders_statuses();

                ////ADDED IN VER4.0
                $shop_status_selected = '';
                /// APPLY DEFAULT STATUS AT FIRST
                if ($this->pw_shop_status) {
                    $shop_status_selected = explode(",", $this->pw_shop_status);
                }

                $option = '';
                foreach ($pw_order_status as $key => $value) {

                    $selected = "";
                    if (is_array($permission_value) && ! in_array($key, $permission_value)) {
                        continue;
                    }

                    ////ADDED IN VER4.0
                    /// APPLY DEFAULT STATUS AT FIRST
                    if (is_array($shop_status_selected) && in_array($key, $shop_status_selected)) {
                        $selected = "selected";
                    }

                    $option .= "<option value='" . $key . "' $selected >" . $value . "</option>";
                }
                ?>

                <select name="pw_orders_status[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('pw_orders_status') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>
                <input type="hidden" name="pw_id_order_status[]" id="pw_id_order_status" value="-1">
            </div>
            <?php
        }
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('pw_countries_code');
        if ($this->get_form_element_permission('pw_countries_code') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('pw_countries_code') && $permission_value != '')
                $col_style = 'display:none'

            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Country', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-globe"></i></span>
                <?php
                $country_data = $this->pw_get_paying_woo_state('billing_country');
                $country      = $this->pw_get_woo_countries();
                $option       = '';
                foreach ($country_data as $countries) {
                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($countries->id, $permission_value)) {
                        continue;
                    }


                    $pw_table_value = $country->countries[$countries->id];
                    $option         .= "<option value='" . $countries->id . "' $selected >" . $pw_table_value . "</option>";
                }

                $country_states      = $this->pw_get_woo_country_of_state();
                $json_country_states = json_encode($country_states);
                //print_r($json_country_states);
                ?>
                <select id="pw_adr_country" name="pw_countries_code[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('pw_countries_code') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

                <script type="text/javascript">
                    "use strict";
                    jQuery(document).ready(function ($) {

                        var country_state = '';
                        country_state =<?php echo $json_country_states?>;

                        $("#pw_adr_country").change(function () {
                            var country_val = $(this).val();

                            if (country_val == null) {
                                return false;
                            }

                            var option_data = Array();
                            var optionss = '<option value="-1">Select All</option>';
                            var i = 1;
                            $.each(country_state, function (key, val) {

                                if (country_val.indexOf(val.parent_id) >= 0 || country_val == "-1") {
                                    optionss += '<option value="' + val.id + '">' + val.label + '</option>';
                                    option_data[val.id] = val.label;
                                }
                                i++;
                            });

                            $('#pw_adr_state').empty(); //remove all child nodes
                            $("#pw_adr_state").html(optionss);
                            $('#pw_adr_state').trigger("chosen:updated");
                        });


                    });

                </script>

            </div>

            <?php
        }
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('pw_states_code');
        if ($this->get_form_element_permission('pw_states_code') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('pw_states_code') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('State', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-map"></i></span>
                <?php
                //$state_codes = $this->pw_get_paying_woo_state('shipping_state','shipping_country');
                //$this->pw_get_woo_country_of_state();
                //$this->pw_get_woo_bsn($items->billing_country,$items->billing_state_code);
                $state_codes = $this->pw_get_paying_woo_state('billing_state', 'billing_country');
                $option      = '';
                foreach ($state_codes as $state) {
                    $selected = "";
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($state->id, $permission_value)) {
                        continue;
                    }

                    $pw_table_value = $this->pw_get_woo_bsn($state->billing_country, $state->id);
                    $option         .= "<option $selected value='" . $state->id . "' >" . $pw_table_value . " ($state->billing_country)</option>";
                }
                ?>

                <select id="pw_adr_state" name="pw_states_code[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('pw_states_code') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }
        ?>

        <?php
        ////ADDED IN V4.0
        ?>
        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Variations', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-bolt"></i></span>
            <?php
            $option        = '';
            $pw_variations = $this->pw_get_woo_pv_atts('yes');

            $all_value = array();
            foreach ($pw_variations as $key => $value) {
                $selected    = '';
                $new_key     = str_replace("wcv_", "", $key);
                $option      .= "<option value='" . $new_key . "' >" . $value . " </option>";
                $all_value[] = $new_key;
            }

            if ( ! is_array($all_value)) {
                $all_value = '-1';
            } else {
                $all_value = implode(",", $all_value);
            }
            ?>

            <select name="pw_variation_id[]" multiple="multiple" size="5" data-size="5"
                    class="chosen-select-search variation_elements">
                <option value="<?php echo $all_value ?>"><?php _e('Select All',
                        __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Variation Only', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="pw_variation_only" type="checkbox" value="yes"/>

        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Postcode(Zip)', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-map-marker"></i></span>
            <input name="pw_bill_post_code" type="text"/>
        </div>


        <!--<div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Min & Max By', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-arrows-h"></i></span>
                    <select name="order_meta_key[]" id="order_meta_key2" class="order_meta_key normal_view_only">
                        <option value="-1">Select All</option>
                        <option value="_order_total">Order Net Amount</option>
                        <option value="_order_discount">Order Discount Amount</option>
                        <option value="_order_shipping">Order Shipping Amount</option>
                        <option value="_order_shipping_tax">Order Shipping Tax Amount</option>
                    </select>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Min Amount', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-battery-0"></i></span>
                    <input name="min_amount" type="text"/>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Max Amount', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-battery-4"></i></span>
                    <input name="max_amount" type="text"/>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>-->

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Email', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-envelope-o"></i></span>
            <input name="pw_email_text" type="text"/>
        </div>


        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Order By', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-sort-alpha-asc"></i></span>
            <div class="row">
                <div class="col-md-6">

                    <select name="sort_by" id="sort_by" class="sort_by">
                        <option value="order_id" selected="selected">Order ID</option>
                        <option value="billing_name">Name</option>
                        <option value="billing_email">Email</option>
                        <option value="order_date">Date</option>
                        <option value="post_status">Status</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="order_by" id="order_by" class="order_by">
                        <option value="ASC">Ascending</option>
                        <option value="DESC" selected="selected">Descending</option>
                    </select>
                </div>
            </div>
        </div>


        <!--CUSTOM WORK-->
        <div class="col-md-6">
            <div class="awr-form-title">
                <?php
                $pw_coupon_codes = $this->pw_get_woo_coupons_codes();
                $option          = '';
                foreach ($pw_coupon_codes as $coupon) {
                    $selected = '';

                    $option .= "<option $selected value='" . $coupon->id . "' >" . $coupon->label . " </option>";
                }
                ?>
                <?php _e('Coupon Codes', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-key"></i></span>
            <select name="pw_codes_of_coupon[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                <option value="-1"><?php _e('Select All', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>
        </div>

        <!--<div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Discount Type', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-money"></i></span>
                    <select name="pw_coupon_discount_types" >
                        <option value="-1"><?php _e('Select One', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <option value="percent"><?php _e('Percentage Discount', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <option value="fixed_cart"><?php _e('Fixed Cart Discount',
            __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <option value="fixed_product"><?php _e('Fixed Product Discount',
            __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                    </select>
                </div>-->

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Show Order Item Details', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="pw_view_details" type="checkbox" value="yes" checked/>

        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Coupon Used Only', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="pw_use_coupon" type="checkbox" value="yes"/>

        </div>


        <?php
        if (__PW_COG__ != '') {
            ?>

            <div class="col-md-6">
                <div class="awr-form-title">
                    <?php _e('SHOW JUST INCLUDE C.O.G & PROFIT', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    <br/>
                    <span class="description"><?php _e('Include just products with current Profit(Cost of good) plugin(Selected in Setting -> Add-on Settings -> Cost of Good).',
                            __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                <input name="pw_show_cog" type="checkbox" value="yes"/>

            </div>
            <?php
        }
        ?>


        <div class="col-md-12">
            <?php
            $pw_hide_os         = $this->otder_status_hide;
            $pw_publish_order   = 'no';
            $pw_order_item_name = '';
            $pw_coupon_code     = '';
            $pw_coupon_codes    = '';
            $pw_payment_method  = '';

            $pw_variation_only = $this->pw_get_woo_requests_links('pw_variation_only', '-1', true);
            $pw_order_meta_key = '';

            $data_format = $this->pw_get_woo_requests_links('date_format', get_option('date_format'), true);


            $amont_zero = '';

            ?>

            <input type="hidden" name="pw_hide_os" value="<?php echo $pw_hide_os; ?>"/>
            <input type="hidden" name="publish_order" value="<?php echo $pw_publish_order; ?>"/>
            <input type="hidden" name="order_item_name" value="<?php echo $pw_order_item_name; ?>"/>
            <input type="hidden" name="coupon_code" value="<?php echo $pw_coupon_code; ?>"/>
            <input type="hidden" name="payment_method" value="<?php echo $pw_payment_method; ?>"/>


            <input type="hidden" name="date_format" value="<?php echo $data_format; ?>"/>

            <input type="hidden" name="table_names" value="<?php echo $table_name; ?>"/>
            <div class="fetch_form_loading search-form-loading"></div>
            <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i>
                <span><?php echo esc_html__('Search', __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            <button type="button" value="Reset" class="button-secondary form_reset_btn"><i
                    class="fa fa-reply"></i><span><?php echo esc_html__('Reset Form',
                        __PW_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
        </div>

    </form>
    <?php
}

?>
