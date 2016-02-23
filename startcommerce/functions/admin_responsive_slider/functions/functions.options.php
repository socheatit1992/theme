<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
        global $of_options;
        $of_options = array();
////////////////////////////////////////////////////////////////////////////             
        $of_options[] = array( "name" => "Slider", "type" => "heading");
        
        $of_options[] = array( "name" => "Slider",
					"desc" => lang::_("Unlimited slider with drag and drop sortings."),
					"id" => "ready_responsive_slider",
					"std" => "",
					"type" => "slider");
                    
////////////////////////////////////////////////////////////////////////////
        $of_options[] = array( "name" => "Options", "type" => "heading");
     
        $slider_mode = array("fade", "slide");
        $of_options[] = array( "name" => "Slider Options",
					"desc" => "Animation type",
					"id" => "animation",
					"std" => "fade",
					"type" => "select",
					"options" => $slider_mode);
        
        $directions = array("horizontal", "vertical");
        $of_options[] = array( "name" => "",
					"desc" => "Sliding direction",
					"id" => "direction",
					"std" => "horizontal",
					"type" => "select",
					"options" => $directions);
                    
        $of_options[] = array( "name" => "",
					"desc" => "Slideshow speed",
					"id" => "slideshowspeed",
					"std" => "3000",
					"type" => "text"); 
                    
        $of_options[] = array( "name" => "",
					"desc" => "Animation speed",
					"id" => "animationspeed",
					"std" => "600",
					"type" => "text"); 
                    
        $of_options[] = array( "name" => "",
					"desc" => "Randomize slide order",
					"id" => "randomize",
					"std" => "0",
					"type" => "checkbox"); 
    }
}
?>
