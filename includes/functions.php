<?php

add_shortcode('star', 'wp_star_shortcode');
function wp_star_shortcode(){
$rate = get_post_meta( get_the_ID(), 'meta-text', true );
if ( $rate ) {
$args = array(
   'rating' => $rate,
   'type' => '',
   'number' => '',
'echo' => false,
);
$mytest = "<div class='entry-terms'><strong>My Rating:   " .  wp_star_rating( $args ) . "</strong></div>" ;

	}
return $mytest ;
    }

add_action( 'init', 'wp_star_shortcode');



function star_enqueue_plugin_scripts($plugin_array)
{
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["star_button_plugin"] =  STAR_PLUGIN_URL . "includes/index.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "star_enqueue_plugin_scripts");

function star_register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, "star");
    return $buttons;
}

add_filter("mce_buttons", "star_register_buttons_editor");
function star_shortcode_button_script()
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
               
                //this function is used to retrieve the selected text from the text editor
				/*
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }
*/
                QTags.addButton(
                    "star_shortcode",
                    "Star Rating",
                    callback
                );

                function callback()
                {
                    
                    QTags.insertContent("[star]");
                }
            </script>
        <?php
    }
}

add_action("admin_print_footer_scripts", "star_shortcode_button_script");