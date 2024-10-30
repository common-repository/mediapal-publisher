<?php
   /*
   Plugin Name: MediaPal Publisher
   Plugin URI: http://mediapal.net
   Description: MediaPal is an advertisement tool that bridges the gap between publishers and advertisers by bringing advertisers to publishers. Professional adverts served to the correct audience always! 
   Version: 1.0.1
   Author: Nano Digital
   Author URI: https://www.nanodigital.co.ke
   License: GPL2
   */

// add_action('admin_menu', 'mediapal_setup_menu');
dynamic_sidebar( 'Mediapal Rectangle' );
dynamic_sidebar( 'Mediapal MPU' );
 
/** 
Removed the code to add a menu item to the client site to show them the stats for each of the banners or their impressions and click through rates.

Will return it in future interations.

*/


/**Start of Background 
**
**
*/

//Background 
/*function mediapal_insert_background_ad($content) {
    $url = get_site_url();
    if(is_page() || is_single()) {
        $beforecontent = "<iframe id='mediapal_zone' class='idrws_pdf_short' frameborder='0' src='https://ads.mediapal.net/?mediapalzoneid=543&publisher=".$url."&adzone_is_background=1' padding='1' publisher='".$url."' adzone_is_background='1' stretch='1'  width='100%' height='auto' scrolling='no'></iframe>";
        $fullcontent = $beforecontent . $content;
        // $fullcontent = $content . $aftercontent;
    } else {
        $fullcontent = $content;
    }
    
    return $fullcontent;
}

add_filter('the_content', 'mediapal_insert_background_ad');
*/
/** End of Background 
*/


/** Start of Header 
**
**
*/

// function mediapal_insert_into_header() {
//     $url = get_site_url();
//     echo '<div align="center"><iframe id="mediapal_zone" frameborder="0" style="display:block;" src="https://ads.mediapal.net/?mediapalzoneid=536&publisher='.$url.'" width="728" height="90" scrolling="no"></iframe></div>';
// }
// add_action( 'wp_head', 'mediapal_insert_into_header' );

/** End of Header 
*/


/**Start of Footer 
**
**
*/

function mediapal_insert_into_footer() {
    $url = get_site_url();
    echo '<div align="center"><iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=548&publisher='.$url.'" publisher="" width="100%" height="100%"  scrolling="no"></iframe></div>';
}
add_action( 'get_footer', 'mediapal_insert_into_footer' );

/** End of Footer 
*/


/**Start of Sidebar 
**
**
*/

// function mediapal_widgets_init() {
 
//     register_sidebar( array(
//         'name' => __( 'Main Sidebar', 'wpb' ),
//         'id' => 'sidebar-1',
//         'description' => __( 'The main sidebar appears on the right on each page except the front page template', 'wpb' ),
//         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
//         'after_widget' => '</aside>',
//         'before_title' => '<h3 class="widget-title">',
//         'after_title' => '</h3>',
//     ) );
 
//     register_sidebar( array(
//         'name' => 'mediapal',
//         'id' => 'sidebar-2',
//         'description' => __( 'Appears on the static front page template', 'wpb' ),
//         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
//         'after_widget' => '</aside>',
//         'before_title' => '<h3 class="widget-title">',
//         'after_title' => '</h3>',
//     ) );
// }
 
// add_action( 'widgets_init', 'mediapal_widgets_init' ); 

// dynamic_sidebar( 'wpb' ); 
// dynamic_sidebar( 'mediapal' ); 


//Skyscapers and Sidebar 
add_action( 'widgets_init', 'mediapal_widget' );

function mediapal_widget()
{
  // Register widget.
  register_widget( 'mediapal_sidebar_widgets' );

  // Register two sidebars.
  $sidebars = array ( 'a' => 'Mediapal Rectangle', 'b' => 'Mediapal MPU' );
  foreach ( $sidebars as $sidebar )
  {
    register_sidebar(
      array (
        'name'          => $sidebar,
        'id'            => $sidebar,
        'before_widget' => '',
        'after_widget'  => ''
      )
    );
  }


  // We don't want to undo user changes, so we look for changes first.
  $active_widgets = get_option( 'sidebars_widgets' );

  if ( ! empty ( $active_widgets[ $sidebars['a'] ] )
    or ! empty ( $active_widgets[ $sidebars['b'] ] )
  )
  { // Okay, no fun anymore. There is already some content.
    return;
  }

  // The sidebars are empty, let's put something into them.

  // Note that widgets are numbered. We need a counter:
  $counter = 1;
  $url = get_site_url();
  // Add a 'demo' widget to the top sidebar …
  $active_widgets[ $sidebars['a'] ][0] = 'mediapal_widget-' . $counter;
  // … and write some text into it:
  $mediapal_widget_content[ $counter ] = array ( 'text' => '<div align="center"><iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=581&publisher="'.$url.'"" width="300" height="250" scrolling="no"></iframe></div>', 'title' => 'Sidebar' );
  #update_option( 'widget_mediapal_widget', $mediapal_widget_content );

  $counter++;


  // Okay, now to our second sidebar. We make it short.
  $active_widgets[ $sidebars['b'] ][] = 'mediapal_widget-' . $counter;
  #$mediapal_widget_content = get_option( 'widget_mediapal_widget', array() );
  $mediapal_widget_content[ $counter ] = array ( 'text' => '<div align="center"><iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=539&publisher="'.$url.'"" width="300" height="600" scrolling="no"></iframe></div>' );
  update_option( 'widget_mediapal_widget', $mediapal_widget_content );

  // Now save the $active_widgets array.
  update_option( 'sidebars_widgets', $active_widgets );
}


// Sidebar widget to hold Skyscraper ./
class mediapal_sidebar_widgets extends WP_Widget
{
  public function __construct()
  {                      // id_base        ,  visible name
    parent::__construct( 'mediapal_widget', 'Mediapal Sponsored' );
  }

  public function widget( $args, $instance )
  {
    echo $args['before_widget'], wpautop( $instance['text'] ), $args['after_widget'];
  }

  public function form( $instance )
  {
    $url = get_site_url();
    $text = isset ( $instance['text'] )
      ? esc_textarea( $instance['text'] ) : '';
    printf(
      '<iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=539&publisher="'.$url.'"" width="300" height="250" scrolling="no"></iframe>',
      $this->get_field_id( 'text' ),
      $this->get_field_name( 'text' ),
      $text
    );
  }
}

/**
 * Debug helper
 *
 * @param string $option
 * @return void
 */
function mediapal_option_dump( $option )
{
  $value = get_option( $option, '-novalue-' );
  printf(
    '<pre>option: <b>%1$s</b><br>%2$s</pre>',
    $option,
    esc_html( var_export( $value, TRUE ) )
  );
}

// Header sidebar
  register_sidebar(array(
    'name' => __('MediaPal Header', 'dividend'),
    'description'   => __( 'MediaPal Top', 'dividend' ),
    'id' => 'widget-header',
    'before_widget' => '<div id="%1$s" class="widget-header">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));

// Load widget.
add_action( 'widgets_init', 'mediapal_header_widgets' );

// Register widget.
function mediapal_header_widgets() {
  register_widget( 'mediapal_header_widgets' );
}

// Widget class.
class mediapal_header_widgets extends WP_Widget {


/**
 * Widget setup
 */
function __construct() {

  // Widget settings
  $widget_ops = array(
    'classname' => 'mediapal_header_widgets',
    'description' => __('A widget for 728 x 90 top bar', 'dividend' )
  );

  // Widget control settings
  $control_ops = array(
    'width' => 728,
    'height' => 90,
    'id_base' => 'mediapal_header_widgets'
  );

  // Create the widget
  parent::__construct( 'mediapal_header_widgets',  $widget_ops, $control_ops );
  
}

/**
 * Display widget.
 *
 * @param array $args
 * @param array $instance
 */
function widget( $args, $instance ) {
  extract( $args );

  // Variables from the widget settings
  $title = '';
  $ad = '';
  $link = '';
  $url = get_site_url();

  // Before widget (defined by theme functions file)
  echo $before_widget;

  // Display the widget title if one was input
  if ( $title )
    echo $before_title . $title . $after_title;
    
  // Display a containing div
  echo '<div id="mediapal_header_widgets-2" class="widget-header"><div class="ad-728">';

  // Display Ad
  // if ( $link )
    echo '<iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=621&publisher='.$url.'" width="728" height="90" scrolling="no"></iframe>';
    
  // elseif ( $ad )
    // echo '<img src="' . esc_url( $ad ) . '" width="728" height="90" alt="" />';
    
  echo '</div></div>';

  // After widget (defined by theme functions file)
  echo $after_widget;
}

}

/** End of Sidebar 
*/


/**Start of Interstitial 
**
**
*/

//Interstitial Ads Begining of Posts/Pages
/*function mediapal_insert_before_content($content) {
    $url = get_site_url();
    if(is_single()) {
        $beforecontent = '<iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=540&publisher='.$url.'" publisher="'.$url.'" background="1" width="300" height="250" scrolling="no" align="left" style="margin:10px;"></iframe>';
        $fullcontent = $beforecontent . $content;
    } else {
        $fullcontent = $content;
    }
    
    return $fullcontent;
}

add_filter('the_content', 'mediapal_insert_before_content');*/

//Interstitial  End of Posts.
add_filter('the_content', 'mediapal_insert_after_content');

function mediapal_insert_after_content($content) {
    $url = get_site_url();
    if(is_single()) {
        $aftercontent = "<div align='center'><iframe id='mediapal_zone' class='idrws_pdf_short' frameborder='0' src='https://ads.mediapal.net/?mediapalzoneid=547&publisher=".$url."' width='100%' height='100%' style=''  scrolling='no'></iframe></div>";
        $fullcontent = $content . $aftercontent;
    } else {
        $fullcontent = $content;
    }
    
    return $fullcontent;
}


//Insterstitial second paragraph Rectangle
add_filter( 'the_content', 'mediapal_insert_post_rectangle' );
// add_filter( 'the_content', 'mediapal_insert_post_leaderboard' );
 
function mediapal_insert_post_rectangle( $content ) {
    $url = get_site_url();
    $ad_code = '<iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=540&publisher='.$url.'" width="300" height="250" scrolling="no"  align="left" style="margin:10px;"></iframe></iframe>';
 
    if ( is_single() && ! is_admin() ) {
        return mediapal_insert_after_paragraph( $ad_code, 1, $content );
    }
     
    return $content;
}

//Insterstitial fifth paragraph 
// function mediapal_insert_post_leaderboard( $content ) {
//     $url = get_site_url();
//     $ad_code = '<div align="center"><iframe id="mediapal_zone" frameborder="0" src="https://ads.mediapal.net/?mediapalzoneid=547&publisher='.$url.'" width="728" height="90" scrolling="no"></iframe></div>';
    
//     $closing_p = '</p>';
//     $paragraphs = explode( $closing_p, $content );
//     if (count($paragraphs) > 5){
//       if ( is_single() && ! is_admin() ) {
//           return mediapal_insert_after_paragraph( $ad_code, 5, $content );
//       }
//     }
     
//     return $content;
// }

// Interstitial Parent Function
  
function mediapal_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
 
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
 
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
     
    return implode( '', $paragraphs );
}



?>