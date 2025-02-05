<?php
class Bootstrap_Navwalker extends Walker_Nav_Menu {

    // Start Level (This is for <ul> wrapping)
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $classes = array('navbar-nav', 'ms-auto');
        if ($depth > 0) {
            $classes[] = 'sub-menu'; // For submenus, if any.
        }
        $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', array_filter($classes)));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= "\n<ul$class_names>\n";
    }

    // Start Element (This is for <li> and <a> tags)
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';  // Add 'nav-item' to every <li>
        
        // Check if this is the current item
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';  // Add 'active' class if it's the current menu item
        }

        // Generate <a> tag classes
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . ' text-white ml-3 mr-3 pl-3 pr-3"' : '';

        // Output the <li> element
        $output .= '<li class="' . esc_attr($class_names) . '">';

        // Add the anchor tag
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '#';
        $atts['class'] = 'nav-link ' . ($depth == 0 ? 'text-white ml-3 mr-3 pl-3 pr-3' : '');
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        // Output the <a> element
        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= $item_output;
    }
}
?>