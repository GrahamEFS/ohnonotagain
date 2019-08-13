<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

/* ACTIONS */
#add_action('template_redirect', 'beanstalk_always_load_js_composer'); # UNCOMMENT to serve js_composer.min.css on every page.
add_action('wp_enqueue_scripts', 'enqueue_parent_styles' );


/* FILTERS */
#add_filter('stylesheet_uri', 'beanstalk_use_min_css', 10, 1); # UNCOMMENT TO SERVE style.min.css
add_filter ('style_loader_src', 'beanstalk_remove_cssjs_ver', 10, 2);
add_filter ('script_loader_src', 'beanstalk_remove_cssjs_ver', 10, 2);
#add_action('wp_footer', 'beanstalk_facebook_track_on_wpmailsent'); # UNCOMMENT TO TRACK FB CONVERSIONS ON WP MAIL SENT
/* SHORTCODES */

add_action('wp_enqueue_scripts', 'register_jacascript');

function register_jacascript() {
	wp_register_script('jquery-match-height', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js', array('jquery'));
	wp_register_script('match-height-testimonial', get_stylesheet_directory_uri() . '/match-height-testimonial.js', array('jquery', 'jquery-match-height'));
	wp_enqueue_script('jquery-match-height');
	wp_enqueue_script('match-height-testimonial');
}


/* FUNCTIONS - ACTIONS */

/**
 * Load Visual Composer CSS on pages that do not use Visual Composer.
 * I.E. Highend Team pages, Woocommerce Products, ETC.
 */
function beanstalk_always_load_js_composer() {
	$handle = 'js_composer_front';
	$src = "/wp-content/plugins/js_composer/assets/css/js_composer.min.css";
	$deps = array();

	if (!wp_style_is($handle, 'registered')) {
		wp_enqueue_style($handle, $src, $deps);
	} else if (!wp_style_is($handle, 'enqueued')) {
		wp_enqueue_style($handle);
	}
}

function enqueue_parent_styles() {
		wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css');
}


function beanstalk_facebook_track_on_wpmailsent() {
?>
<script>
		document.addEventListener( 'wpcf7mailsent', function( event ) {
			fbq('track', 'Lead');
		}, false );
</script>
<?php
}


/* FUNCTIONS - FILTERS */

/**
 * Serve minified CSS by replacing style.css with style.min.css .
 *
 * @param $stylesheet_uri
 *
 * @return mixed
 */
function beanstalk_use_min_css($stylesheet_uri) {
	return str_replace('style.css', 'style.min.css', $stylesheet_uri);
}

/**
 * Serve CSS and JS files without query string.
 * Removed for higher page speed scores!
 *
 * @param $stylesheet_uri
 *
 * @return mixed
 */
function beanstalk_remove_cssjs_ver($src) {
	if (strpos($src, '?ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}


/* FUNCTIONS - SHORTCODES */

/* FUNCTIONS */


add_action('wp_enqueue_scripts', 'efs_register_slick');

/**
 * Register slick.js dependecy in wordpress.
 * Enqueue slick stylesheets.
 */
function efs_register_slick() {
	$handle = "slick-js";
	$src = "//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js";
	$deps = array('jquery');
	$ver = false;
	$in_footer = true;
	wp_register_script($handle, $src, $deps, $ver, $in_footer);
	
	$handle = "slick-lightbox-js";
	$src = "//cdnjs.cloudflare.com/ajax/libs/slick-lightbox/0.2.12/slick-lightbox.min.js";
	$deps = array('jquery');
	$ver = false;
	$in_footer = true;
	wp_register_script($handle, $src, $deps, $ver, $in_footer);

	$handle = "slick-css";
	$src = "//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css";
	$deps = array();
	wp_enqueue_style($handle, $src, $deps);

	$handle = "slick-theme-css";
	$src = "//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css";
	$deps = array('slick-css');
	wp_enqueue_style($handle, $src, $deps);
	
	$handle = "slick-lightbox-css";
	$src = "//cdnjs.cloudflare.com/ajax/libs/slick-lightbox/0.2.12/slick-lightbox.css";
	$deps = array('slick-css');
	wp_enqueue_style($handle, $src, $deps);
	
}

add_action('acf/init', 'add_kiosk_solaredge_options');

function add_kiosk_solaredge_options() {
    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_5cc1f5d2ec232',
            'title' => 'Kiosk',
            'fields' => array(
                array(
                    'key' => 'field_5cc1f5f535072',
                    'label' => 'SITE API KEY',
                    'name' => 'site_api_key',
                    'type' => 'text',
                    'instructions' => '►To generate a Site API key:
In the Site Admin> Site Access tab > Access Control tab > API Access section:
1 Acknowledge reading and agreeing to the SolarEdge API Terms & Conditions.
2 Click Generate API key.
3 Copy the key.
4 Click Save.
5 Paste the key in the input box.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5cc1f8fb752cf',
                    'label' => 'SITE ID',
                    'name' => 'site_id',
                    'type' => 'text',
                    'instructions' => '►To retrieve a Site ID:
In the Site Admin> Site Access tab > Access Control tab > API Access section:
1 Copy the Site ID.
2 Paste the key in the input box.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5cc217ac7a7bc',
                    'label' => 'SITE QUOTE',
                    'name' => 'site_quote',
                    'type' => 'textarea',
                    'instructions' => 'Input the Quote form the site owner.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => '',
                ),
                array(
                    'key' => 'field_5cc1fbddc0703',
                    'label' => 'LAST UPDATED',
                    'name' => 'last_updated',
                    'type' => 'number',
                    'instructions' => 'Do not modify.	This is the timestamp of the last update time of this API.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 0,
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                ),
                array(
                    'key' => 'field_5cc1fbc1c0702',
                    'label' => 'SITE DATA',
                    'name' => 'site_data',
                    'type' => 'group',
                    'instructions' => 'The data retrieved from the API during the last request.	This data is cached and served on subsequent requests until the cache is cold.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5cc1fc9f30aef',
                            'label' => 'Site Name',
                            'name' => 'site_name',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc1fcab30af0',
                            'label' => 'Install Date',
                            'name' => 'install_date',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc2095e807e8',
                            'label' => 'Current Power',
                            'name' => 'current_power',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc2078a82c78',
                            'label' => 'Peak Power',
                            'name' => 'peak_power',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc20a633e554',
                            'label' => 'Last Month Energy',
                            'name' => 'monthly_energy',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc208cc43d48',
                            'label' => 'Lifetime Energy',
                            'name' => 'lifetime_energy',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc208d543d49',
                            'label' => 'Lifetime Revenue',
                            'name' => 'lifetime_revenue',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc20c009937e',
                            'label' => 'CO2 Emission Saved',
                            'name' => 'co2_emission_saved',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc20c189937f',
                            'label' => 'CO2 Emission UNIT',
                            'name' => 'co2_emission_unit',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc20c2899380',
                            'label' => 'Trees Planted',
                            'name' => 'trees_planted',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cc213ced3262',
                            'label' => 'Monthly Energy Data',
                            'name' => 'monthly_energy_data',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => 0,
                            'max' => 0,
                            'layout' => 'table',
                            'button_label' => '',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_5cc214add3263',
                                    'label' => 'Month Date',
                                    'name' => 'month_date',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                ),
                                array(
                                    'key' => 'field_5cc214e4d3264',
                                    'label' => 'Month Value',
                                    'name' => 'month_value',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_5cc2150dd3265',
                            'label' => 'Monthly Energy Data Unit',
                            'name' => 'monthly_energy_data_unit',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5cfe84cd5f5cd',
                            'label' => 'Site Power',
                            'name' => 'site_power',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'efs_kiosk',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
            ),
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_5cc9e94fb9ed1',
            'title' => 'Kiosk Navigation',
            'fields' => array(
                array(
                    'key' => 'field_5cc9e955662b9',
                    'label' => 'Kiosk Navigation',
                    'name' => 'kiosk_navigation',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5cc9e972662ba',
                            'label' => 'Button URL',
                            'name' => 'button_url',
                            'type' => 'url',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                        ),
                        array(
                            'key' => 'field_5cc9e98a662bb',
                            'label' => 'Button Label',
                            'name' => 'button_label',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-navigation',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

    endif;

}
