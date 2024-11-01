<?php
/*
Plugin Name: Vendor City
Plugin URI: http://themestulip.com/product-category/plugins/
Description: It will show all vendor list with location. 
version: 1.0.1
Author: Themestulip
Author URI: http://themestulip.com/product-category/plugins/
License: GPLv2 or later
Text Domain: vendor-city
*/
add_action( 'init', 'codex_vendor_init' );
function codex_vendor_init() {
	$labels = array(
		'name'               => _x( 'Vendor', 'post type general name', 'vendor-city' ),
		'singular_name'      => _x( 'Vendor', 'post type singular name', 'vendor-city' ),
		'menu_name'          => _x( 'Vendors', 'admin menu', 'vendor-city' ),
		'name_admin_bar'     => _x( 'Vendor', 'add new on admin bar', 'vendor-city' ),
		'add_new'            => _x( 'Add New', 'vendor', 'vendor-city' ),
		'add_new_item'       => __( 'Add New Vendor', 'vendor-city' ),
		'new_item'           => __( 'New Vendor', 'vendor-city' ),
		'edit_item'          => __( 'Edit Vendor', 'vendor-city' ),
		'view_item'          => __( 'View Vendor', 'vendor-city' ),
		'all_items'          => __( 'All Vendors', 'vendor-city' ),
		'search_items'       => __( 'Search Vendors', 'vendor-city' ),
		'parent_item_colon'  => __( 'Parent Vendors:', 'vendor-city' ),
		'not_found'          => __( 'No vendors found.', 'vendor-city' ),
		'not_found_in_trash' => __( 'No vendors found in Trash.', 'vendor-city' )
	);
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'vendor-city' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'vendor' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title',)
	);
	register_post_type( 'vendor', $args );
	flush_rewrite_rules();
}
function add_city_taxonomy_to_vendor(){
    $taxonomy = 'city';
    $object_type = 'vendor';
    $labels = array(
        'name'               => 'Cities',
        'singular_name'      => 'City',
        'search_items'       => 'Search Cities',
        'all_items'          => 'All Cities',
        'parent_item'        => 'Parent City',
        'parent_item_colon'  => 'Parent City:',
        'update_item'        => 'Update City',
        'edit_item'          => 'Edit City',
        'add_new_item'       => 'Add New City', 
        'new_item_name'      => 'New City Name',
        'menu_name'          => 'City'
    );    
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'how_in_nav_menus'  => true,
        'public'            => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'city')
    );    
    register_taxonomy($taxonomy, $object_type, $args); 
}
add_action('init','add_city_taxonomy_to_vendor');
function add_vendor_meta_boxes() {add_meta_box("vendor_contact_meta", "Contact Details", "add_contact_details_vendor_meta_box", "vendor", "normal", "low");}
function add_contact_details_vendor_meta_box(){
	global $post;
	$custom = get_post_custom($post->ID);
	echo '<style>.width99 {width:99%;}</style>';
	echo '<p><label>Vendor Name:</label><br />';
	echo '<input type="text" name="vendorname" value="'.esc_html(@$custom["vendorname"][0]).'" />';
	echo '</p><p>';
	echo '<label>Establishment Year:</label><br />';
	echo '<input type="text" name="establishment_year" value="'.intval(@$custom["establishment_year"][0]).'" />';
	echo '</p><p>';
	echo '<label>Street Name:</label><br />';
	echo '<input type="text" name="street_name" value="'.esc_html(@$custom["street_name"][0]).'"/>';
	echo '</p><p>';
	echo '<label>Area Name:</label><br />';
	echo '<input type="text" name="area_name" value="'.esc_html(@$custom["area_name"][0]).'"/>';
    echo '</p><p>';
	echo '<label>State:</label><br />';
	echo '<input type="text" name="state" value="'.esc_html(@$custom["state"][0]).'"/>';
	echo '</p><p>';
	echo '<label>Pin Code</label><br />';
	echo '<input type="text" name="pincode" value="'.intval(@$custom["pincode"][0]).'"/>';
	echo '</p>';
}
function save_vendor_custom_fields(){
global $post; 
  if($post){
	  if(!empty($_POST["vendorname"])){
		$vendorname = sanitize_text_field(@$_POST["vendorname"]);
		update_post_meta($post->ID, "vendorname", $vendorname);
	  }
	  if(!empty($_POST["establishment_year"])){
		$establishment_year = sanitize_text_field(@$_POST["establishment_year"]);
		update_post_meta($post->ID, "establishment_year", $establishment_year);
	  }
	  if(!empty($_POST["street_name"])){
		$street_name = sanitize_text_field(@$_POST["street_name"]);
		update_post_meta($post->ID, "street_name",$street_name);
	  }
	  if(!empty($_POST["area_name"])){
		$area_name = sanitize_text_field(@$_POST["area_name"]);
		update_post_meta($post->ID, "area_name",$area_name);
	  }
	  if(!empty($_POST["state"])){
		$state = sanitize_text_field(@$_POST["state"]);
		update_post_meta($post->ID, "state",$state);
	  }
	  if(!empty($_POST["pincode"])){
		$pincode = sanitize_text_field(@$_POST["pincode"]);
		update_post_meta($post->ID, "pincode",$pincode);
	  }
  }
}
add_action('admin_init', 'add_vendor_meta_boxes');
add_action('save_post', 'save_vendor_custom_fields');
include('shortcode.php');