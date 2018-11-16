<?php

add_action( 'init', 'create_user_profile' );
function create_user_profile() {
    register_post_type( 'user_profile',
        array(
            'labels' => array(
                'name' => 'Community Profiles',
                'singular_name' => 'Member Profile',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Profile',
                'edit' => 'Edit',
                'edit_item' => 'Edit Profile',
                'new_item' => 'New Profile',
                'view' => 'View',
                'view_item' => 'View Profile',
                'search_items' => 'Search Profiles',
                'not_found' => 'No Profiles found',
                'not_found_in_trash' => 'No Profiles found in Trash',
                'parent' => 'Parent Community',
            ),
 
            'public' => true,
            'show_ui' => true,
            'supports' => array( 'title' , 'thumbnail' , 'author'),
            'taxonomies' => array( '' ),
			'rewrite' => array('slug' => 'members'),
            'has_archive' => true
        )
    );
}

define('ROOTDIR', plugin_dir_path(__DIR__));
require_once(ROOTDIR . 'meta-box-class/my-meta-box-class.php');
if (is_admin()){
  /* 
   * prefix of meta keys, optional
   * use underscore (_) at the beginning to make keys hidden, for example $prefix = '_ba_';
   *  you also can make prefix empty to disable it
   * 
   */
  $prefix = '';
  /* 
   * configure your meta box
   */
  $config = array(
    'id'             => 'user_metabox',          // meta box id, unique per meta box
    'title'          => 'User Information',          // meta box title
    'pages'          => array('user_profile'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => true,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $my_meta =  new AT_Meta_Box($config);
  
    //Image field
  $my_meta->addImage($prefix.'chan_logo',array('name'=> 'Channel Logo' , 'desc' => 'Your Channel Logo'));
  //text field
  $my_meta->addText($prefix.'chan_name',array('name'=> 'Channel Name' , 'desc' => 'Your Channels Name as it appears on Twitch.tv'));
  //wysiwyg field
  $my_meta->addWysiwyg($prefix.'chan_about',array('name'=> 'About' , 'desc' => 'About you and your channel'));
  
  $my_meta->addSelect('user_level',array('cub'=>'Chilled Cubs','ctig'=>'Cold Tiger' ,'mcub'=>'Mango Cubs' ,'elitemod'=>'Elite Mods'),array('name'=> 'User Level ', 'std'=> array('cub')));
  
  //Finish Meta Box Declaration 
  $my_meta->Finish();
}
  add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
     if ( get_post_type() == 'user_profile' ) {
        if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-user-profile.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __DIR__ ) . 'templates/archive-user-profile.php';
            }
        } else if (is_single() ){
            //check if file exists in the theme first,
            //otherwise serve the file from the plugin
            if ( $theme_file_single = locate_template ( array ( 'single-user-profile.php' ) ) ) {
                $template_path = $theme_file_single;
            } else {
                $template_path = plugin_dir_path( __DIR__ ) . 'templates/single-user-profile.php' ;
            }
        }
    } 
    return $template_path;
	}
?>