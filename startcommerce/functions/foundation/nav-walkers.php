<?php 

class nav_bar_walker extends Walker_Nav_Menu {
 
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $element->has_children = !empty($children_elements[$element->ID]);
        $element->classes[] = ($element->current || $element->current_item_ancestor) ? 'active' : '';
        $element->classes[] = ($element->has_children) ? 'has-flyout' : '';
		
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }	
	
    function start_el(&$output, $item, $depth, $args) {
        $item_html = '';
        parent::start_el($item_html, $item, $depth, $args);	
		
        $classes = empty($item->classes) ? array() : (array) $item->classes;	
 
        if(in_array('has-flyout', $classes)) {
            $item_html = str_replace('</a>', '</a><a href="'.esc_attr($item->url).'" class="flyout-toggle"><span> </span></a>', $item_html);
        }
		
        $output .= $item_html;
    }
 
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $output .= "\n<ul class=\"sub-menu flyout\">\n";
    }
    
} // end nav bar walker

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
	 protected $_levelsClosed = array();
    function start_lvl(&$output, $depth){
      $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
	  $output .= "</option>\n";	//Close parent option element
	  $this->_levelsClosed[$depth] = true;
    }

    function end_lvl(&$output, $depth){
      $indent = str_repeat("\t", $depth); // don't output children closing tag
    }

    function start_el(&$output, $item, $depth, $args){
      // add spacing to the title based on the depth
      $item->title = str_repeat("&nbsp;", $depth * 4).$item->title;

      parent::start_el($output, $item, $depth, $args);

      // no point redefining this method too, we just replace the li tag...
      $output = str_replace('<li', '<option value="'.esc_attr($item->url).'" ', $output);
	  
	  $output = preg_replace('/<a.+href=\".+\">/is', '', $output);
	  $output = preg_replace('/<\/a>/is', '', $output);
    }

    function end_el(&$output, $item, $depth){
		if(isset($this->_levelsClosed[$depth]) && $this->_levelsClosed[$depth])
			$this->_levelsClosed[$depth] = false;	//This was closed on child levels draw
		else
			$output .= "</option>\n"; // replace closing </li> with the option tag
    }
}


?>