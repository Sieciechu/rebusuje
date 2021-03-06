<?php
/*

  Plugin Name: Hide Featured Image

  Plugin URI: http://shahpranav.com/2015/05/hide-featured-image-on-single-post/

  Description: To show/hide featured images on individual posts.

  Version: 1.2

  Author: shahpranaf

  Author URI: http://shahpranav.com/

  License: GPLv2 or later

 */


// Actions and hooks
add_action( 'add_meta_boxes', 'sh_post_types_custom_box' ); // WP 3.0+
add_action( 'admin_init', 'sh_post_types_custom_box', 1 ); // backwards compatible
add_action( 'save_post', 'sh_post_types_save_postdata' ); /* Do something with the data entered */
add_action( 'wp_head', 'sh_featured_image');
add_action( 'admin_menu', 'sh_settings_menu' );
add_action( 'admin_init', 'sh_hide_register_settings' );

/**
 *  Adds a box to the main column on the Post and Page edit screens
 * 
 * @since Hide Featured Image 1.0
 */
function sh_post_types_custom_box() {
    
    global $sh_post_types;
    $sh_post_types = get_post_types( '', 'names' );
    unset( $sh_post_types['attachment'], $sh_post_types['revision'], $sh_post_types['nav_menu_item'] );

    foreach ($sh_post_types as $post_type) {
        add_meta_box( 'hide_featured', __( 'Hide Featured Image?', 'HideImage' ), 'sh_featured_box', $post_type, 'side', 'default' );
    }
       
}

/**
 * Add metabox to posts.
 */
function sh_featured_box($post){
    wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );

    $hide_featured = get_post_meta( $post->ID, '_hide_featured', true ) ?: 1; // set "hide featured image check - yes" radio as default
    
    ?>

    <input type="radio" name="_hide_featured" value="1" <?php checked( $hide_featured, 1 ); ?>><?php _e( 'Yes', 'HideImage' ); ?>&nbsp;&nbsp;
    <input type="radio" name="_hide_featured" value="2" <?php checked( $hide_featured, 2 ); ?>><?php _e( 'No', 'HideImage' ); ?><?php
                                        
}

/** 
 * When the post is saved, saves our custom data 
 * 
 * @since Hide Featured Image 1.0
 */
function sh_post_types_save_postdata( $post_id ) {
    
    global $sh_post_types;

    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !wp_verify_nonce( @$_POST[$_POST['post_type'] . '_noncename'], plugin_basename( __FILE__ ) ) )
      return;

    // OK,nonce has been verified and now we can save the data according the the capabilities of the user
    if( in_array($_POST['post_type'], $sh_post_types) ) {
      if ( !current_user_can( 'edit_page', $post_id ) ) {
          return;
      } else {
          $hide_featured = ( isset( $_POST['_hide_featured'] ) && $_POST['_hide_featured'] == 1 ) ? '1' : $_POST['_hide_featured'];
          update_post_meta( $post_id, '_hide_featured', $hide_featured );     
      }
    }
}

/**
 *  To hide featured image from single post page
 * 
 * @since Hide Featured Image 1.0
 */
function sh_featured_image() {
    
    if( is_single() || is_page() ){

      $hide = false;
      $sh_hide_all = get_option('sh_hide_all_image');/* Hide all post or image */
      $hide_image =  get_post_meta( get_the_ID(), '_hide_featured', true );/* Hide single post */
      

      $hide = ( is_page() && isset( $sh_hide_all['page_image'] ) && $sh_hide_all['page_image'] && $hide_image != 2 ) ? true : $hide ; 
      $hide = ( is_singular( 'post' ) && isset( $sh_hide_all['post_image'] ) && $sh_hide_all['post_image'] && $hide_image != 2 ) ? true : $hide ; 
      $hide = ( isset( $hide_image ) && $hide_image && $hide_image != 2 )? true : $hide;/* Hide single post */
      
      if( $hide ){ ?>
          <style>
          .has-post-thumbnail img.wp-post-image{ display: none !important; }
          </style><?php
      }
    }
}

/**
 *  To add menu option in dashboard
 * 
 * @since Hide Featured Image 1.1
 */
function sh_settings_menu() {
    add_submenu_page(
          'options-general.php',          // admin page slug
          __( 'Hide Featured Image', 'HideImage' ), // page title
          __( 'Hide Featured Image', 'HideImage' ), // menu title
          'manage_options',               // capability required to see the page
          'sh_hide_options',                // admin page slug, e.g. options-general.php?page=wporg_options
          'sh_settings_page'            // callback function to display the options page
     );
}

/**
 * Register the settings
 */
function sh_hide_register_settings() {
     register_setting( 'sh_hide_options', 'sh_hide_all_image' );
}
 
/**
 *  To add settings page
 * 
 * @since Hide Featured Image 1.1
 */
function sh_settings_page() {
     if ( ! isset( $_REQUEST['settings-updated'] ) )
          $_REQUEST['settings-updated'] = false; ?>
 
     <div class="wrap">
           
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
           
          <div id="poststuff">
               <div id="post-body">
                    <div id="post-body-content">
                         <form method="post" action="options.php">
                              <?php settings_fields( 'sh_hide_options' ); ?>
                              <?php $hide_image = get_option( 'sh_hide_all_image' ); ?>
                              <table class="form-table">
                                   <tr valign="top"><th scope="row"><?php _e( 'Hide Image from all Posts(not Custom Post Type)?', 'HideImage' ); ?></th>
                                        <td>
                                            <?php $selected = ( isset( $hide_image['post_image'] ) ) ? $hide_image['post_image'] : 0; ?>                                                  
                                            <input type="radio" name="sh_hide_all_image[post_image]" value="1" <?php checked( $selected, 1 ); ?>><?php _e( 'Yes', 'HideImage' ); ?>&nbsp;&nbsp;
                                            <input type="radio" name="sh_hide_all_image[post_image]" value="0" <?php checked( $selected, 0 ); ?>><?php _e( 'No', 'HideImage' ); ?>
                                        </td>
                                    </tr>
                                    <tr valign="top"><th scope="row"><?php _e( 'Hide Image from all Pages?', 'HideImage' ); ?></th>
                                        <td>
                                            <?php $selected = ( isset( $hide_image['page_image'] ) ) ? $hide_image['page_image'] : 0; ?>                                                  
                                            <input type="radio" name="sh_hide_all_image[page_image]" value="1" <?php checked( $selected, 1 ); ?>><?php _e( 'Yes', 'HideImage' ); ?>&nbsp;&nbsp;
                                            <input type="radio" name="sh_hide_all_image[page_image]" value="0" <?php checked( $selected, 0 ); ?>><?php _e( 'No', 'HideImage' ); ?>
                                        </td>
                                   </tr>
                              </table><br>
                              <input type="submit" class="button button-primary" >
                         </form><br>
                         <h3>How to use "Hide Featured Image" Plugin ?</h3>
                         <ol>
                            <li>To hide featured images from all Posts(not Custom Post Types) Or from Pages, select the 'Yes' option above.</li>
                            <li>If you want to hide featured image from few posts/pages and not all, then edit that single page and select 'yes' to hide feature image from that particular post .</li>
                            <li>At any point, the option selected on single page/post will override the option provided in settings page. So if you have selected "Hide All" and want to show featured image on one post then you can select "No"(don't hide featured image) from edit page of that post.</li>
                            <li>For any query or detailed information please visit <a title="<?php _e( 'Plugin home', 'HideImage' ); ?>" href="http://shahpranav.com/2015/05/hide-featured-image-on-single-post/">Plugin Homepage</a>.</li>
                         </ol>

                    </div> <!-- end post-body-content -->
               </div> <!-- end post-body -->
          </div> <!-- end poststuff -->
     </div><?php
}
?>