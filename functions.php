<?php 

add_action( 'after_setup_theme', 'unity_setup' );

if ( ! function_exists( 'unity_setup' ) ):

function unity_setup() {
	register_nav_menu( 'primary', __( 'Primary Menu', 'unity' ) );
	add_editor_style();
	}
endif; // unity_setup


/************* ENQUEUE CSS AND JS *****************/

function theme_styles()  
{ 
    // Bring in Open Sans from Google fonts

    wp_register_style( 'lato', 'http://fonts.googleapis.com/css?family=Lato:400,900');
    wp_register_style( 'foundation', get_template_directory_uri() . '/foundation/stylesheets/foundation.min.css', array(), '3.0', 'all' );
    
    wp_enqueue_style( 'lato' );
	wp_enqueue_style( 'foundation' );
}

add_action('wp_enqueue_scripts', 'theme_styles');

/************* ENQUEUE JS *************************/

/* pull jquery from google's CDN. If it's not available, grab the local copy. Code from wp.tutsplus.com :-) */

$url = 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'; // the URL to check against  
$test_url = @fopen($url,'r'); // test parameters  
if( $test_url !== false ) { // test if the URL exists  

    function load_external_jQuery() { // load external file  
        wp_deregister_script( 'jquery' ); // deregisters the default WordPress jQuery  
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'); // register the external file  
        wp_enqueue_script('jquery'); // enqueue the external file  
    }  

    add_action('wp_enqueue_scripts', 'load_external_jQuery'); // initiate the function  
} else {  

    function load_local_jQuery() {  
        wp_deregister_script('jquery'); // initiate the function  
        wp_register_script('jquery', bloginfo('template_url').'/foundation/javascripts/jquery.min.js', __FILE__, false, '1.7.2', true); // register the local file  
        wp_enqueue_script('jquery'); // enqueue the local file  
    }  

    add_action('wp_enqueue_scripts', 'load_local_jQuery'); // initiate the function  
}  

/* load modernizr from foundation */
function modernize_it(){
    wp_register_script( 'modernizr', get_template_directory_uri() . '/foundation/javascripts/modernizr.foundation.js' ); 
    wp_enqueue_script( 'modernizr' );
}
add_action( 'wp_enqueue_scripts', 'modernize_it' );

function foundation_js(){
    wp_register_script( 'foundation-navigation', get_template_directory_uri() . '/foundation/javascripts/jquery.foundation.navigation.js' ); 
    wp_enqueue_script( 'foundation-navigation', 'jQuery', '1.1', true );
}
add_action('wp_enqueue_scripts', 'foundation_js');

function wp_foundation_js(){
    wp_register_script( 'wp-foundation-js', get_template_directory_uri() . '/scripts.js', 'jQuery', '1.0', true);
    wp_enqueue_script( 'wp-foundation-js' );
}
add_action('wp_enqueue_scripts', 'wp_foundation_js');

// END head scripts 

// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
function all_settings_link() {
add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'all_settings_link');

// ADD A FAVICON
function childtheme_favicon() { ?>
	<link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/images/favicon.ico" />
<?php }
add_action('wp_head', 'childtheme_favicon');


function unity_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'unity' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'unity' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'unity' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'unity' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Home page sidebar. Only appears on home page
	register_sidebar( array(
		'name' => __( 'Homepage sidebar', 'unity' ),
		'id' => 'home-widget-area',
		'description' => __( 'These widgets only appear on the homepage', 'unity' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s"><div class="widget-wrap">',
		'after_widget' => '</div></li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
/** Register sidebars by running unity_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'unity_widgets_init' );


/** remove guff from header **/
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','rsd_link' );
remove_action('wp_head','adjacent_posts_rel_link_wp_head');
remove_action('wp_head','wp_generator');



/**------------ MAKE MENU SYSTEM WORK FOR FOUNDATION ------------------**/


//Replaces "current-menu-item" with "active"
function current_to_active($text){
        $replace = array(
                //List of menu item classes that should be changed to "active"
                'current_page_item' => 'active',
                'current_page_parent' => 'active',
                'current_page_ancestor' => 'active',
        );
        $text = str_replace(array_keys($replace), $replace, $text);
                return $text;
        }
add_filter ('wp_nav_menu','current_to_active');


// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// add the 'has-flyout' class to any li's that have children and add the arrows to li's with children
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            
            $class_names = $value = '';
            
            // If the item has children, add the dropdown class for foundation
            if ( $args->has_children ) {
                $class_names = "has-flyout ";
            }
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            
            $class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'. esc_attr( $class_names ) . '"';
           
            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            // if the item has children add these two attributes to the anchor tag
            // if ( $args->has_children ) {
            //     $attributes .= 'class="dropdown-toggle" data-toggle="dropdown"';
            // }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            // if the item has children add the caret just before closing the anchor tag
            if ( $args->has_children ) {
                $item_output .= '</a><a href="#" class="flyout-toggle"><span> </span></a>';
            }
            else{
                $item_output .= '</a>';
            }
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
            
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"flyout\">\n";
        }
            
        function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
            {
                $id_field = $this->db_fields['id'];
                if ( is_object( $args[0] ) ) {
                    $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
                }
                return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
            }       
}


?>