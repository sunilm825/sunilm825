<?php
if( class_exists('acf') ) {
	if( function_exists('acf_add_options_page') ) {

		acf_add_options_page(array(
			'page_title' 	=> 'Theme Option',
			'menu_title'	=> 'Theme Option',
			'menu_slug' 	=> 'theme-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'      => false
		));
	}
}
/*
 * remove comment
 */
add_action( 'admin_init', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}
/*
 * For menu selected class
 */
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) )
	 {
             $classes[] = 'selected ';
     }
	 if( in_array('current_page_parent', $classes) ){
             $classes[] = 'selected';
     }
	 return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function parent_nav_class($classes, $item){
     if(in_array('menu-item-has-children',$classes)){
             $classes[] = 'parent';
     }
     if(in_array('current-menu-item',$classes) || in_array('current-page-ancestor',$classes) || in_array('current-menu-ancestor',$classes)){
             $classes[] = 'selected ';
     }
     return $classes;
}

add_filter('nav_menu_css_class' , 'parent_nav_class' , 10 , 3);
/*Fevicon Image*/
function add_my_favicon() {
   $favicon_path = get_field('favicon_image', 'option');

   echo '<link rel="shortcut icon" href="' . $favicon_path . '" />';
}
//add_action( 'wp_head', 'add_my_favicon' ); //front end
//add_action( 'admin_head', 'add_my_favicon' ); //admin end
//add_action( 'login_head', 'add_my_favicon' );  //Login end

function remove_footer_admin () {
	echo '<span id="footer-thankyou">Web design by <a target="_blank" title="viitorcloud" href="https://viitorcloud.com/" target="_blank">Viitorcloud</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

?>

<?php 
function custom_loginlogo() {
//$logo = get_field('logo','option'); 
echo '<style type="text/css">
h1 a {background-image: url('.$logo['url'].') !important;background-size: 196px 113px !important;width:196px !important;height:113px !important;}
</style>';
}
add_action('login_head', 'custom_loginlogo');
add_filter( 'login_headerurl', 'custom_loginlogo_url' );

function custom_loginlogo_url($url) {
	return site_url();
}

/*
 * For Contact Form 7 Mail tempalte
 */
function custom_mail_components($wpcf7_data, $form = null) {
 	 $logo_url = get_field('demo_site_logo','option');
 	 $wpcf7_data['body'] = str_replace('[logo_url]', $logo_url , $wpcf7_data['body'] );

	 $site_url = get_site_url();
	 $wpcf7_data['body'] = str_replace('[site_url]', $site_url , $wpcf7_data['body'] );

	 $site_phone = get_field('demo_phone_no','option');
	 $wpcf7_data['body'] = str_replace('[site_phone]', $site_phone , $wpcf7_data['body'] );

	 $site_email = get_field('demo_email_address','option');
	 $wpcf7_data['body'] = str_replace('[site_email]', $site_email , $wpcf7_data['body'] );

	 $site_name = get_bloginfo('name');
	 $wpcf7_data['body'] = str_replace('[site_name]', $site_name , $wpcf7_data['body'] );

	 $site_year = '&copy; '.date("Y") .' '. get_bloginfo('name').'. All Rights Reserved.';
	 $wpcf7_data['body'] = str_replace('[site_year]', $site_year , $wpcf7_data['body'] );

     return $wpcf7_data;
}

add_filter( 'wpcf7_mail_components', 'custom_mail_components');

/*
 * To Disable Update WordPress nag
 */

function remove_core_updates() {
	 if(! current_user_can('update_core')){return;}
	 add_action('init', create_function('$a',"remove_action( 'init', 'wp_version_check' );"),2);
	 add_filter('pre_option_update_core','__return_null');
	 add_filter('pre_site_transient_update_core','__return_null');
}
add_action('after_setup_theme','remove_core_updates');

remove_action('load-update-core.php','wp_update_plugins');
add_filter('pre_site_transient_update_plugins','__return_null');

/*
 * inner banner code
 */
function demo_custom_innner_banner_code(){  
$inner_banner_image= get_field('inner_banner_image');
$banner_image_default= get_field('banner_image_default','option');
$banner_option= get_field('banner_option');
?>
	    <section class="page-heading" style="background-image:url(<?php if($inner_banner_image){ echo $inner_banner_image; } else { echo $banner_image_default; } ?>);">
                <div class="container">
                    <div class="page_heading_main">
						<span class="h1"><?php echo get_the_title(); ?></span>
					</div>
                    <ul class="breadcrumb">
                        <?php echo mhl_custom_breadcrumbs(); ?>
                    </ul>
                </div>
        </section>
<?php } ?>
<?php 
	// disable for posts
	add_filter('use_block_editor_for_post', '__return_false', 10);

/* Hide Editor From specific pages*/

add_action( 'admin_init', 'hide_editor' );
function hide_editor() {
  // Get the Post ID.
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  if( !isset( $post_id ) ) return;
  // Hide the editor on the page titled 'Homepage'
  $homepgname = $post_id;
  if($homepgname == '' || $homepgname == '' || $homepgname == '' ){ 
	remove_post_type_support('page', 'editor');
  } 
}

function shailan_custom_login_styles(){
?> <style type="text/css">
body.login{ background: #000 url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/banner1.jpg") 50% no-repeat fixed !important; background-size:cover !important; background-position: center; }
}
</style><?php
}
add_action('login_head', 'shailan_custom_login_styles');

function add_theme_scripts() {
    
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/vendor/animate.css/animate.min.css', array(), '1.1', 'all');
    wp_enqueue_style( 'aos', get_template_directory_uri() . '/assets/vendor/aos/aos.css', array(), '1.1', 'all');
    wp_enqueue_style( 'bootstrap.min', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), '1.1', 'all');
    wp_enqueue_style( 'bootstrap-icons', get_template_directory_uri() . '/assets/vendor/bootstrap-icons/bootstrap-icons.css', array(), '1.1', 'all');
    wp_enqueue_style( 'glightbox.min', get_template_directory_uri() . '/assets/vendor/glightbox/css/glightbox.min.css', array(), '1.1', 'all');
    wp_enqueue_style( 'swiper-bundle.min', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css', array(), '1.1', 'all');
    wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.1', 'all');
    
    wp_enqueue_script( 'purecounter', get_template_directory_uri() . '/assets/vendor/purecounter/purecounter.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'aos', get_template_directory_uri() . '/assets/vendor/aos/aos.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'bootstrap.bundle', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'glightbox', get_template_directory_uri() . '/assets/vendor/glightbox/js/glightbox.min.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'isotope.pkgd', get_template_directory_uri() . '/assets/vendor/isotope-layout/isotope.pkgd.min.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'swiper-bundle', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'noframework.waypoints', get_template_directory_uri() . '/assets/vendor/waypoints/noframework.waypoints.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'validate', get_template_directory_uri() . '/assets/vendor/php-email-form/validate.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array ( 'jquery' ), 1.1, true);

  }
  add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


  // The action callback function.
/*function example_callback( $arg1, $arg2) {
   echo 'hello sunil';
}
add_action( 'example_action', 'example_callback', 10, 2);*/

/*
 * Trigger the actions by calling the 'example_callback()' function
 * that's hooked onto `example_action` above.
 *
 * - 'example_action' is the action hook.
 * - $arg1 and $arg2 are the additional arguments passed to the callback.
$value = do_action( 'example_action', $arg1, $arg2 );

