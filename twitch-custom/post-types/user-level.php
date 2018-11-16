<?php

add_action( 'init', 'create_user_level' );
function create_user_level() {
    register_post_type( 'user_level',
        array(
            'labels' => array(
                'name' => 'User Levels',
                'singular_name' => 'User Level',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New level',
                'edit' => 'Edit',
                'edit_item' => 'Edit level',
                'new_item' => 'New level',
                'view' => 'View',
                'view_item' => 'View level',
                'search_items' => 'Search level',
                'not_found' => 'No levels found',
                'not_found_in_trash' => 'No levels found in Trash',
                'parent' => 'Parent Community',
            ),
 
            'public' => true,
            'show_ui' => true,
            'supports' => array( 'author'),
            'taxonomies' => array( '' ),
			'rewrite' => array('slug' => 'levels'),
            'has_archive' => false
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
    'id'             => 'user_level',          // meta box id, unique per meta box
    'title'          => 'User Information',          // meta box title
    'pages'          => array('user_level'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => true,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $level_meta =  new AT_Meta_Box($config);
  
	$level_meta->addSelect('user_level',array('cub'=>'Chilled Cubs','ctig'=>'Cold Tiger'),array('name'=> 'User Level ', 'std'=> array('cub')));
  //text field
  $level_meta->addText($prefix.'user_name',array('name'=> 'User Name'));
 
  //Finish Meta Box Declaration 
  $level_meta->Finish();
}
?>