<?php
// Enqueue theme styles and scripts
function analogdigitalmedia_enqueue_assets() {
    wp_enqueue_style('main-style',  get_template_directory_uri() . '/assets/css/style.css', array('css'), null, true);
    wp_enqueue_script('main-script', get_template_directory_uri() . 'assets/js/main.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'analogdigitalmedia_enqueue_assets');

// Register navigation menus
function analogdigitalmedia_register_menus() {
    register_nav_menus( array(
        'primary' => __('Primary Menu', 'analogdigitalmedia'),
    ));
}
add_action('init', 'analogdigitalmedia_register_menus');

// Register theme support for various features
function analogdigitalmedia_theme_setup() {
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'width'       => 100,
        'height'      => 50,
        'flex-height' => True,
        'flex-width'  => True,
    ));



    // Add support for custom header
    add_theme_support('custom-header', array(

        'flex-height'   => false,
        'flex-width'    => false,
        'header-text'   => false,
    ));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ));

    // Add support for HTML5 markup
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Add support for post formats
    add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');

    // Add support for title tag
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'analogdigitalmedia_theme_setup');


// Force custom logo size to 100px x 50px in the Customizer
function custom_logo_size( $html ) {
    // Check if the logo has been set
    if ( has_custom_logo() ) {
        $logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
        
        if (isset($logo[0])) {
            $html = str_replace('src="' . $logo[0] . '"', 'src="' . $logo[0] . '" width="100" height="50"', $html);
        }
    }
    return $html;
}
add_filter('get_custom_logo', 'custom_logo_size');



// Register widget areas
function analogdigitalmedia_widgets_init() {
    // Sidebar widget area
    register_sidebar(array(
        'name'          => __('Sidebar', 'analogdigitalmedia'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'analogdigitalmedia'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    // Footer widget area
    register_sidebar(array(
        'name'          => __('Footer', 'analogdigitalmedia'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'analogdigitalmedia'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'analogdigitalmedia_widgets_init');

// Include header and footer from the "templates" folder
function analogdigitalmedia_get_custom_header() {
    if (locate_template('templates/header.php', true, true)) {
        return;
    }
    get_header(); // Fallback to default header if not found
}

function analogdigitalmedia_get_custom_footer() {
    if (locate_template('templates/footer.php', true, true)) {
        return;
    }
    get_footer(); // Fallback to default footer if not found
}

function theme_footer_setup( $wp_customize ) {
    // Register menus
    register_nav_menus( array(
        'footer-menu-1' => __( 'Footer Menu 1', 'textdomain' ),
        'footer-menu-2' => __( 'Footer Menu 2', 'textdomain' ),
        'footer-menu-3' => __( 'Footer Menu 3', 'textdomain' ),
        'footer-menu-4' => __( 'Footer Menu 4', 'textdomain' ),
    ) );

    // Register widget area for large footer column
    register_sidebar( array(
        'name'          => __( 'Footer Large Column', 'textdomain' ),
        'id'            => 'footer-large',
        'before_widget' => '<div class="footer-large-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    // Add section for Social Media Links in Customizer
    $wp_customize->add_section( 'social_links_section', array(
        'title'       => __( 'Social Media Links', 'textdomain' ),
        'priority'    => 30,
        'description' => __( 'Add your social media links here.' ),
    ) );

    // Add settings and controls for social media URLs
    $social_media = array( 'Facebook', 'Twitter', 'Instagram', 'LinkedIn', 'YouTube' );

    foreach ( $social_media as $social ) {
        $slug = strtolower( $social );
        $wp_customize->add_setting( "social_{$slug}_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( "social_{$slug}_url", array(
            'label'    => __( "{$social} URL", 'textdomain' ),
            'section'  => 'social_links_section',
            'type'     => 'url',
        ) );
    }

    // Add section for Footer Logo
    $wp_customize->add_section( 'footer_logo_section', array(
        'title'       => __( 'Footer Logo', 'textdomain' ),
        'priority'    => 35,
        'description' => __( 'Upload the logo for the footer.' ),
    ) );

    $wp_customize->add_setting( 'footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',  // Changed to save URL instead of ID
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo_control', array(
        'label'    => __( 'Footer Logo', 'textdomain' ),
        'section'  => 'footer_logo_section',
        'settings' => 'footer_logo',
    ) ) );

    // Add section for Footer Description
    $wp_customize->add_section( 'footer_description_section', array(
        'title'       => __( 'Footer Description', 'textdomain' ),
        'priority'    => 40,
        'description' => __( 'Add a description for the footer.' ),
    ) );

    $wp_customize->add_setting( 'footer_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'footer_description_control', array(
        'label'    => __( 'Footer Description', 'textdomain' ),
        'section'  => 'footer_description_section',
        'settings' => 'footer_description',
        'type'     => 'textarea',
    ) );
}

add_action( 'customize_register', 'theme_footer_setup' );





function custom_cta_button_register( $wp_customize ) {
    // Adding the section for CTA settings
    $wp_customize->add_section( 'cta_button_section', array(
        'title' => __('CTA Button', 'textdomain'),
        'priority' => 30,
    ));

    // Register CTA Button Text Setting
    $wp_customize->add_setting( 'cta_button_text', array(
        'default' => __('Call to Action', 'textdomain'),
        'transport' => 'refresh',
    ));

    // Register CTA Button URL Setting
    $wp_customize->add_setting( 'cta_button_url', array(
        'default' => '#',
        'transport' => 'refresh',
    ));

    // Add Text Input control for the CTA Button Text
    $wp_customize->add_control( 'cta_button_text_control', array(
        'label' => __('CTA Button Text', 'textdomain'),
        'section' => 'cta_button_section',
        'settings' => 'cta_button_text',
        'type' => 'text',
    ));

    // Add URL Input control for the CTA Button URL
    $wp_customize->add_control( 'cta_button_url_control', array(
        'label' => __('CTA Button URL', 'textdomain'),
        'section' => 'cta_button_section',
        'settings' => 'cta_button_url',
        'type' => 'url',
    ));
}
add_action( 'customize_register', 'custom_cta_button_register' );


function theme_footer_customize_register( $wp_customize ) {
    // Add section for Footer Settings
    $wp_customize->add_section( 'footer_settings_section', array(
        'title'       => __( 'Footer Settings', 'textdomain' ),
        'priority'    => 150,
        'description' => __( 'Customize the footer content' ),
    ) );

    // Add setting for Site Copyright Text
    $wp_customize->add_setting( 'footer_copyright_text', array(
        'default'           => '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All Rights Reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'footer_copyright_text_control', array(
        'label'    => __( 'Footer Copyright Text', 'textdomain' ),
        'section'  => 'footer_settings_section',
        'settings' => 'footer_copyright_text',
        'type'     => 'text',
    ) );

    // Add setting for Terms and Conditions page
    $wp_customize->add_setting( 'footer_terms_page', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'footer_terms_page_control', array(
        'label'    => __( 'Select Terms and Conditions Page', 'textdomain' ),
        'section'  => 'footer_settings_section',
        'settings' => 'footer_terms_page',
        'type'     => 'dropdown-pages',
    ) );

    // Add setting for Privacy Policy page
    $wp_customize->add_setting( 'footer_privacy_page', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'footer_privacy_page_control', array(
        'label'    => __( 'Select Privacy Policy Page', 'textdomain' ),
        'section'  => 'footer_settings_section',
        'settings' => 'footer_privacy_page',
        'type'     => 'dropdown-pages',
    ) );
}

add_action( 'customize_register', 'theme_footer_customize_register' );





class Bootstrap_Nav_Walker extends Walker_Nav_Menu {
 private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_menu_class[] = '';
    foreach($this->current_item->classes as $class) {
      if(in_array($class, $this->dropdown_menu_alignment_values)) {
        $dropdown_menu_class[] = $class;
      }
    }
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = 'nav-item nav-link text-regular-bold';
    $classes[] = 'nav-item-' . $item->ID;
    if ($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-menu dropdown-menu-end ';
    }

    $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item text-regular-bold ' : 'nav-link  ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
}
}


function custom_section_shortcode($atts) {
    // Set default values for the attributes
    $atts = shortcode_atts(
        array(
            'left_title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            'left_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error ipsum accusantium porro nesciunt asperiores, officia dolorem maxime ullam at veniam blanditiis quibusdam totam odit vel deleniti sequi animi minima eligendi!',
            'button_text' => 'Learn More',
            'button_url' => 'Learn More',
            'right_text1' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit ex aspernatur inventore quasi veniam, a cupiditate vel iste error atque soluta. Animi deleniti deserunt a eius numquam voluptatibus, labore distinctio.',
            'right_text2' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati commodi id tenetur cumque minima pariatur quos illum assumenda doloribus vero soluta debitis, et delectus eveniet officiis. Facere ut quae dolorem.',
            'right_image1' => 'https://placehold.co/300x400',
            'right_image2' => 'https://placehold.co/300x400',
            'typed_items' => 'Designer, Developer, Freelancer, Photographer', // New attribute for customization
            'typed_first_item' => 'Photographer', // New attribute for customization
            'rotating_frist_item' => 'Designer', // New attribute for customization
            'rotating_items' => 'Designer, Developer, Freelancer, Photographer', // New attribute for customization

        ),
        $atts
    );

    // Sanitize attributes to avoid errors or security risks
    $left_title = $atts['left_title'];
    $left_text = esc_html($atts['left_text']);
    $button_text = esc_html($atts['button_text']);
    $button_url = esc_html($atts['button_url']);
    $right_text1 = esc_html($atts['right_text1']);
    $right_text2 = esc_html($atts['right_text2']);
    $right_image1 = esc_url($atts['right_image1']);
    $right_image2 = esc_url($atts['right_image2']);
    $typed_items = esc_html($atts['typed_items']);
    $typed_first_item = esc_html($atts['typed_first_item']);
    $rotating_frist_item = esc_html($atts['rotating_frist_item']);
    $rotating_items = esc_html($atts['rotating_items']);

    // Start the output buffer
    ob_start(); ?>

    <style>
        /* Custom animation duration */
        .animate__animated {
            --animate-duration: 2s;
        }

        .hidden {
            display: none;
        }
    </style>
    <!--<div class="container-fluid m-2 py-3" height="100vh">
        <div class="section-container" id="content-section-1">
            <div class="row p-0 m-0">
                <!-- Left Side 
                <div class="col-lg-6 d-flex flex-column justify-content-center hidden  animate__animated animate__fadeInLeft" id="left-section-1">
                    <div class="container m-0 p-0 d-flex flex-column justify-content-between h-100">
                    <h1 class="h1 mb-4 pl-2 mt-5">
                        <span class="typed" data-typed-items="<?php // echo $typed_items; ?>"><?php //echo $typed_first_item; ?></span><span class="typed-cursor typed-cursor--blink"></span>
                    </h1>
                    <p>
                        
                    </p>
                    <div class="d-flex w-100 justify-content-center mb-5">
                        <button class="button primary flex-grow-1 mx-2">Read More</button>
                        <button class="button secondary flex-grow-1 mx-2">Subscribe Now</button>
                    </div>
                </div>

                </div>

                <!-- Right Side 
                <div class="col-lg-6 hidden animate__animated animate__fadeInRight mx-auto d-flex justify-content-center align-items-center" id="right-section-1">
                    <div class="row">
                        <div class="col-lg-6 mb-2 p-1 animate__animated animate__zoomIn">
                            
                            <img src="<?php  // echo $right_image1; ?>" alt="Placeholder Image" class="img-fluid banner-image">
                            <p class="text-large-normal mt-3">
                                <?php // echo $right_text1; ?>
                            </p>
                        </div>
                        <div class="col-lg-6 mb-2 p-1  animate__animated animate__zoomIn">
                            <p class="text-large-normal mb-3">
                                <?php  // echo $right_text2; ?>
                            </p>
                            <img src="<?php  // echo $right_image2; ?>" alt="Placeholder Image" class="img-fluid banner-image">
                        </div>
                </div>
            </div>
        </div>
    </div>  -->

    <div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content" id="content-section-1">
        <p class="text-large-medium "> # Where Learning Meets Real-World Success – Your Pathway to Practical Excellence!</p>
        <h1 class="h1 mb-4 pl-2  text-white"><span class="typed" data-typed-items=" <?php  echo $typed_items; ?>"> <?php echo $typed_first_item; ?></span><span class="typed-cursor typed-cursor--blink" > </span></h1>
        <p class="text-large-normal"> <span id="rotating-text" class="text-large-normal mb-4 pl-2" data-change-items="   <?php  // echo $rotating_items; ?>"> <?php  // echo $rotating_frist_item; ?> </span></p>
        <div class="d-flex w-100 justify-content-center mb-5 gap-3">
            <button class="button primary" onclick="window.location.href='<?php echo esc_url($button_url); ?>'">
                <?php echo esc_html($button_text); ?>
            </button>

        </div>
    </div>
</div>
<style>
    .hero-section {
        position: relative;
        background: url('https://theanalogdigital.in/wp-content/uploads/2025/01/pexels-bikibez-8921700-scaled.jpg') no-repeat center center/cover;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Dark overlay for better text readability */
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }

    </style>
    <?php
    // Return the generated HTML content
    return ob_get_clean();
}

add_shortcode('custom_section', 'custom_section_shortcode');



function create_testimonial_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'testimonials'; // Table name with WordPress prefix
    $charset_collate = $wpdb->get_charset_collate();

    // SQL to create the testimonials table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        rating TINYINT(1) NOT NULL CHECK (rating BETWEEN 1 AND 5), -- Ensure rating is between 1 and 5
        description TEXT NOT NULL,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Optional: Add initial sample data (remove if not needed)
    $existing_data = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    if ($existing_data === null || $existing_data == 0) {
        $wpdb->insert($table_name, [
            'name' => 'John Doe',
            'rating' => 5,
            'description' => 'This is a sample testimonial.',
            'status' => 'approved',
        ]);
    }
}

// Hook to run this function when the theme is activated
add_action('after_switch_theme', 'create_testimonial_table');



function testimonial_submission_form() {
    ob_start();
    ?>
    <div class="container mt-5">
        <h2>Submit Your Testimonial</h2>
        <form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="form">
            <div class="mb-3">
                <label for="testimonial_name" class="form-label">Your Name</label>
                <input type="text" id="testimonial_name" name="testimonial_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="testimonial_rating" class="form-label">Rating (1 to 5)</label>
                <input type="number" id="testimonial_rating" name="testimonial_rating" class="form-control" min="1" max="5" required>
            </div>

            <div class="mb-3">
                <label for="testimonial_description" class="form-label">Testimonial</label>
                <textarea id="testimonial_description" name="testimonial_description" class="form-control" required></textarea>
            </div>

            <button type="submit" name="submit_testimonial" class="btn btn-primary">Submit Testimonial</button>
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit_testimonial'])) {
            $name = sanitize_text_field($_POST['testimonial_name']);
            $rating = intval($_POST['testimonial_rating']);
            $description = sanitize_textarea_field($_POST['testimonial_description']);
            $status = 'pending'; // Default status

            global $wpdb;
            $wpdb->insert(
                $wpdb->prefix . 'testimonials',
                array(
                    'name' => $name,
                    'rating' => $rating,
                    'description' => $description,
                    'status' => $status
                )
            );

            echo '<div class="alert alert-success mt-3">Thank you for your testimonial. It is under review.</div>';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('testimonial_form', 'testimonial_submission_form');




function testimonial_admin_menu() {
    add_menu_page(
        'Testimonials',             // Page title
        'Testimonials',             // Menu title
        'manage_options',           // Capability
        'testimonials',             // Menu slug
        'testimonial_admin_page',   // Callback function
        'dashicons-testimonial',    // Icon
        25                          // Position
    );
}
add_action('admin_menu', 'testimonial_admin_menu');





function testimonial_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // Handle Add/Edit Form Submission
    if (isset($_POST['save_testimonial'])) {
        $name = sanitize_text_field($_POST['testimonial_name']);
        $rating = intval($_POST['testimonial_rating']);
        $description = sanitize_textarea_field($_POST['testimonial_description']);
        $status = sanitize_text_field($_POST['testimonial_status']);
        $image_url = '';

        // Fetch existing image if editing
        if (isset($_POST['testimonial_id']) && $_POST['testimonial_id']) {
            $testimonial = $wpdb->get_row("SELECT * FROM $table_name WHERE id = " . intval($_POST['testimonial_id']));
            $image_url = $testimonial->image;
        }

        // Handle image upload
        if (isset($_FILES['testimonial_image']) && $_FILES['testimonial_image']['error'] === 0) {
            $upload = wp_upload_bits($_FILES['testimonial_image']['name'], null, file_get_contents($_FILES['testimonial_image']['tmp_name']));
            if (!$upload['error']) {
                $image_url = $upload['url'];
            }
        }

        // Insert or Update Testimonial
        if (isset($_POST['testimonial_id']) && $_POST['testimonial_id']) {
            // Update testimonial
            $wpdb->update(
                $table_name,
                [
                    'name' => $name,
                    'rating' => $rating,
                    'description' => $description,
                    'status' => $status,
                    'image' => $image_url
                ],
                ['id' => intval($_POST['testimonial_id'])]
            );
        } else {
            // Insert new testimonial
            $wpdb->insert(
                $table_name,
                [
                    'name' => $name,
                    'rating' => $rating,
                    'description' => $description,
                    'status' => $status,
                    'image' => $image_url
                ]
            );
        }
    }

    // Handle Approve/Reject Actions
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = sanitize_text_field($_GET['action']);
        $testimonial_id = intval($_GET['id']);

        if ($action === 'approve') {
            $wpdb->update(
                $table_name,
                ['status' => 'approved'], // Set status to "approved"
                ['id' => $testimonial_id]
            );
            echo '<div class="notice notice-success is-dismissible"><p>Testimonial approved successfully.</p></div>';
        } elseif ($action === 'reject') {
            $wpdb->update(
                $table_name,
                ['status' => 'rejected'], // Set status to "rejected"
                ['id' => $testimonial_id]
            );
            echo '<div class="notice notice-warning is-dismissible"><p>Testimonial rejected successfully.</p></div>';
        }
    }

    // Fetch Testimonials
    $testimonials = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 7");

    echo '<div class="wrap"><h1>Manage Testimonials</h1>';

    // If editing a testimonial
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $testimonial = $wpdb->get_row("SELECT * FROM $table_name WHERE id = " . intval($_GET['id']));
        include 'templates/testimonial_edit_form.php'; // Include the form
    } else {
        // Display blank form for new testimonial
        echo '<h2>Add New Testimonial</h2>';
        include 'templates/testimonial_edit_form.php'; // Form will be blank when no testimonial is loaded
    }

    // Display list of testimonials
    echo '<h2>Existing Testimonials</h2>';
    include 'templates/testimonial_list.php';

    echo '</div>';
}


// Shortcode to display testimonials with Owl Carousel
function display_testimonials_shortcode($atts) {
    global $wpdb;

    // Parse shortcode attributes
    $atts = shortcode_atts([
        'count' => 5, // Default number of testimonials to display
        'heading' => 'Testimonials', // Default heading
        'subheading' => 'Subheading Testimonials Section', // Default subheading
    ], $atts, 'display_testimonials');

    $table_name = $wpdb->prefix . 'testimonials';
    $count = intval($atts['count']);
    $heading = esc_html($atts['heading']);
    $subheading = esc_html($atts['subheading']);

    // Fetch the latest approved testimonials
    $testimonials = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE status = 'approved' ORDER BY created_at DESC LIMIT %d", $count)
    );

    // Start output buffering
    ob_start();

    if (!empty($testimonials)) {
    // Add Owl Carousel wrapper
    echo '<div  id="testimonials">
       
        <p class="text-large-normal "><em>' . $subheading . '</em></p>
        <h2 class="h2 ">' . $heading . '</h2>
       
    <div class="owl-carousel owl-theme testimonial-carousel h-auto">';

    foreach ($testimonials as $testimonial) {
        echo '<div class="item border-none" >';
        echo '<div class="card border-0 testimonial-card p-3 mb-4 shadow-medium bg-surface-light" style="border-radius:0px; border-top-left-radius: 25px; border-bottom-right-radius: 25px; min-height:180px;">'; // Set consistent height

        // First Row: Star Rating, Name, Image
        echo '<div class="row">';
        echo '<div class="col-8">';
        echo '<div class="row">';
        echo '<div class="col-12">';
        echo '<div class="star-rating mb-2">';

        // Display stars based on the rating
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $testimonial->rating) {
                echo '<span class="fa fa-star checked text-warning" style="max-height:23px; max-width:20px;"></span>';
            } else {
                echo '<span class="fa fa-star"></span>';
            }
        }

        echo '</div>'; // Close star-rating
        echo '</div>';
        echo '<div class="col-12">';
        echo '<h5 class="card-title mb-0">' . esc_html($testimonial->name) . '</h5>';
        echo '</div>';
        echo '</div>'; // Close inner row
        echo '</div>'; // Close col-md-9

        // Display image
        echo '<div class="col-3 text-center">';
        $image = !empty($testimonial->image) ? esc_url($testimonial->image) : 'https://via.placeholder.com/150';
        echo '<img src="' . $image . '" class="circular-image"   alt="' . esc_html($testimonial->name) . '">';
        echo '</div>'; // Close col-md-3
        echo '</div>'; // Close first row

        // Second Row: Description
        echo '<div class="row mt-3">';
        echo '<div class="col-12">';
        echo '<p class="card-text">' . esc_html($testimonial->description) . '</p>';
        echo '</div>';
        echo '</div>'; // Close second row

        echo '</div>'; // Close card
        echo '</div>'; // Close item
    }

    echo '</div></div></div> <br>'; // Close Owl Carousel wrapper
} else {
    echo '<p>No testimonials available at the moment.</p>';
}
	
	

    return ob_get_clean();
}
add_shortcode('display_testimonials', 'display_testimonials_shortcode');

// Register the contact form shortcode
function custom_contact_form() {
    ob_start();
    ?>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
        <h2 class="h2">Level Up your Skills !</h2>
        <p class="text-large-normal">You can also reach us out at <a href="mailto:contact@theanalogdigital.in">contact@theanalogdigital.in</a>.</p>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="phone">Your Phone</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label for="institution">Company/College/Institution</label>
            <input type="text" id="institution" name="institution" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label for="message">Your Message</label>
        <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <button type="submit" name="submit_contact_form" class="button primary mt-2">Submit</button>
    </div>
    <input type="hidden" name="action" value="handle_contact_form">
</form>

    <?php
    return ob_get_clean();
}

// Add the shortcode to display the contact form
add_shortcode('contact_form', 'custom_contact_form');

// Handle the form submission using admin-post.php
function handle_contact_form_submission() {
    if (isset($_POST['submit_contact_form'])) {
        // Get and sanitize form data
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $institution = sanitize_text_field($_POST['institution']);
        $message = sanitize_textarea_field($_POST['message']);

        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_form_submissions'; // Table name

        // Insert the data into the database
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'institution' => $institution,
                'message' => $message
            )
        );

        // Redirect to a thank you page or back to the form page
        wp_redirect($_SERVER['HTTP_REFERER'] . '?submission=success');
        exit;
    }
}
add_action('admin_post_handle_contact_form', 'handle_contact_form_submission');
add_action('admin_post_nopriv_handle_contact_form', 'handle_contact_form_submission');

// Handle success message (optional)
function display_success_message() {
    if (isset($_GET['submission']) && $_GET['submission'] == 'success') {
        echo '<p>Thank you for your message. We will get back to you soon!</p>';
    }
}
add_action('wp_footer', 'display_success_message');


// Function to create the table on theme activation
function create_contact_form_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form_submissions'; // Name of the table
    $charset_collate = $wpdb->get_charset_collate();

    // SQL query to create the table
    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NOT NULL,
        institution VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Include the upgrade function to ensure the table is created on theme activation
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Hook to create the table on theme activation
add_action('after_switch_theme', 'create_contact_form_table');

// Create a custom admin page to view contact form submissions
function custom_contact_form_admin_menu() {
    add_menu_page(
        'Contact Form Submissions', // Page title
        'Contact Form Submissions', // Menu title
        'manage_options',          // Capability required to view the page
        'contact_form_submissions', // Menu slug
        'contact_form_submissions_page', // Function to display the page
        'dashicons-feedback',      // Icon
        6                          // Position of the menu item
    );
}
add_action('admin_menu', 'custom_contact_form_admin_menu');

// Function to display the submissions page
function contact_form_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form_submissions';

    // Fetch all the contact form submissions
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");

    echo '<div class="wrap">';
    echo '<h1>Contact Form Submissions</h1>';
    if ($submissions) {
        echo '<table class="widefat fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Name</th>
                        <th scope="col" class="manage-column">Email</th>
                        <th scope="col" class="manage-column">Phone</th>
                        <th scope="col" class="manage-column">Institution</th>
                        <th scope="col" class="manage-column">Message</th>
                        <th scope="col" class="manage-column">Date</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($submissions as $submission) {
            echo '<tr>';
            echo '<td>' . esc_html($submission->name) . '</td>';
            echo '<td>' . esc_html($submission->email) . '</td>';
            echo '<td>' . esc_html($submission->phone) . '</td>';
            echo '<td>' . esc_html($submission->institution) . '</td>';
            echo '<td>' . esc_html($submission->message) . '</td>';
            echo '<td>' . esc_html($submission->submission_date) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>
            </table>';
    } else {
        echo '<p>No submissions yet.</p>';
    }
    echo '</div>';
}


function custom_buttons_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'left_button1' => 'Button 1',  // Default text for the first button
            'left_button2' => 'Button 2',  // Default text for the second button
            'left_button1_link' => '#',    // Default link for the first button
            'left_button2_link' => '#',    // Default link for the second button
        ), 
        $atts
    );

    // Return the HTML output with links and button structure
    return '
        <div class="d-flex w-100 justify-content-center align-items-center h-100">
            <button class="button primary flex-grow-1 mx-2">
                <a href="' . esc_url($atts['left_button1_link']) . '" class="no-style-link">
                    ' . esc_html($atts['left_button1']) . '
                </a>
            </button>
            <button class="button secondary flex-grow-1 mx-2">
                <a href="' . esc_url($atts['left_button2_link']) . '" class="no-style-link">
                    ' . esc_html($atts['left_button2']) . '
                </a>
            </button>
        </div>
    ';
}

// Register the shortcode
add_shortcode('custom_buttons', 'custom_buttons_shortcode');



function bootstrap_blog_card_grid_shortcode($atts) {
    // Attributes for the shortcode
    $atts = shortcode_atts(
        array(
            'count' => 8, // Default number of posts to display
        ),
        $atts,
        'blog_cards_bootstrap'
    );

    // Query to fetch the latest posts
    $query_args = array(
        'post_type' => 'post',
        'posts_per_page' => $atts['count'],
    );
    $blog_query = new WP_Query($query_args);

    // HTML output with Bootstrap grid and cards
    $output = '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">';
    if ($blog_query->have_posts()) {
        while ($blog_query->have_posts()) {
            $blog_query->the_post();

            // Card Template using Bootstrap
            $output .= '<div class="col mb-4">';
            $output .= '<div class="card h-100">';
            if (has_post_thumbnail()) {
                $output .= '<img src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '" class="card-img-top" alt="' . get_the_title() . '">';
            } else {
                $output .= '<img src="' . esc_url(get_template_directory_uri()) . '/default-image.jpg" class="card-img-top" alt="Default Image">';
            }
            $output .= '<div class="card-body">';
            $output .= '<h5 class="card-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h5>';
            $output .= '<p class="card-text">' . wp_trim_words(get_the_excerpt(), 15, '...') . '</p>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    } else {
        $output .= '<p>No blogs found.</p>';
    }
    $output .= '</div>';

    // Reset post data
    wp_reset_postdata();

    return $output;
}
add_shortcode('blog_cards_bootstrap', 'bootstrap_blog_card_grid_shortcode');


function bootstrap_pagination($query = null) {
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }

    $pages = paginate_links(array(
        'total'        => $query->max_num_pages,
        'current'      => max(1, get_query_var('paged')),
        'type'         => 'array',
        'prev_text'    => '&laquo; Prev',
        'next_text'    => 'Next &raquo;',
        'end_size'     => 1,
        'mid_size'     => 2,
    ));

    if (is_array($pages)) {
        echo '<ul class="pagination justify-content-center">';
        foreach ($pages as $page) {
            $class = strpos($page, 'current') !== false ? ' active' : '';
            echo '<li class="page-item' . $class . '">' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }
        echo '</ul>';
    }
}


/**
 * Custom Pagination with Bootstrap
 */
function custom_bootstrap_pagination() {
    global $wp_query;

    // Check if there's more than one page
    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    // Set up pagination arguments
    $args = array(
        'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format'       => '?paged=%#%',
        'current'      => max(1, get_query_var('paged')),
        'total'        => $wp_query->max_num_pages,
        'type'         => 'array',
        'prev_text'    => __('&laquo; Previous', 'textdomain'),
        'next_text'    => __('Next &raquo;', 'textdomain'),
        'mid_size'     => 1,
    );

    $pagination_links = paginate_links($args);

    if ($pagination_links) {
        echo '<nav aria-label="Page navigation" class="mt-4">';
        echo '<ul class="pagination justify-content-center">';

        foreach ($pagination_links as $link) {
            // Check if the link contains "current" class
            if (strpos($link, 'current') !== false) {
                echo '<li class="page-item active">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            } elseif (strpos($link, 'dots') !== false) {
                echo '<li class="page-item disabled">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            } else {
                echo '<li class="page-item">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            }
        }

        echo '</ul>';
        echo '</nav>';
    }
}


function owl_carousel_shortcode($atts) {
    // Default attributes, will be overwritten by user input
    $atts = shortcode_atts(
        array(
            'items' => '', // No default, user will input items as array
        ),
        $atts
    );

    // Start output buffering
    ob_start();

    // Check if 'items' is not empty and is an array
    if (!empty($atts['items'])) {
        $items = explode('|', $atts['items']); // Split items by pipe (|)
        echo '<div id="courseslist"><div class="container mt-5  d-none d-lg-block"><div class="owl-carousel owl-theme desktop-only">';
        
        // Loop through the items
        foreach ($items as $index => $item) {
            $item_data = explode(',', $item);

            $image = isset($item_data[0]) && !empty($item_data[0]) ? $item_data[0] : 'https://placehold.co/1279x572';
            $caption = isset($item_data[1]) ? $item_data[1] : 'Caption ' . ($index + 1);
            $heading = isset($item_data[2]) ? $item_data[2] : 'Heading ' . ($index + 1);
            $subheading = isset($item_data[3]) ? $item_data[3] : 'Subheading ' . ($index + 1);
            $button_1_text = isset($item_data[4]) ? $item_data[4] : 'Button 1';
            $button_1_url = isset($item_data[5]) ? $item_data[5] : '#';
            $button_2_text = isset($item_data[6]) ? $item_data[6] : 'Button 2';
            $button_2_url = isset($item_data[7]) ? $item_data[7] : '#';

            echo '<div class="item ">
                    <img src="'.esc_url($image).'" alt="Image '.($index + 1).'">
                    <div class="overlay">
                        <p class="text-large-bold">'.esc_html($caption).'</p>
                        <h1 class="h1 text-dark">'.esc_html($heading).'</h1>
                        <h3 class="text-regular-bold mb-4">'.esc_html($subheading).'</h3>
                        <div class="overlay-buttons">
                            <button class="button primary">
                                <a href="'.esc_url($button_1_url).'" class="no-style-link">'.esc_html($button_1_text).'</a>
                            </button>
                            <button class="button secondary">
                                <a href="'.esc_url($button_2_url).'" class="no-style-link">'.esc_html($button_2_text).'</a>
                            </button>
                        </div>
                    </div>
                </div>';
        }

        echo '</div></div></div>'; // Close desktop carousel

        // Mobile view
        echo '<div class="container mt-3 mobile-only">';
        foreach ($items as $index => $item) {
            $item_data = explode(',', $item);

            $image = isset($item_data[0]) ? $item_data[0] : 'https://placehold.co/1279x572';
            $caption = isset($item_data[1]) ? $item_data[1] : 'Caption ' . ($index + 1);
            $heading = isset($item_data[2]) ? $item_data[2] : 'Heading ' . ($index + 1);
            $subheading = isset($item_data[3]) ? $item_data[3] : 'Subheading ' . ($index + 1);
            $button_1_text = isset($item_data[4]) ? $item_data[4] : 'Button 1';
            $button_1_url = isset($item_data[5]) ? $item_data[5] : '#';
            $button_2_text = isset($item_data[6]) ? $item_data[6] : 'Button 2';
            $button_2_url = isset($item_data[7]) ? $item_data[7] : '#';

            echo '<div class="mobile-card">
                    <img src="'.esc_url($image).'" alt="Image '.($index + 1).'" class="card-img">
                    <div class="card-content">
                        <p class="text-large-bold">'.esc_html($caption).'</p>
                        <h2 class="h2 text-dark">'.esc_html($heading).'</h2>
                        <h3 class="text-regular-bold mb-3">'.esc_html($subheading).'</h3>
                        <div class="card-buttons">
                            <button class="button primary">
                                <a href="'.esc_url($button_1_url).'" class="no-style-link">'.esc_html($button_1_text).'</a>
                            </button>
                            <button class="button secondary">
                                <a href="'.esc_url($button_2_url).'" class="no-style-link">'.esc_html($button_2_text).'</a>
                            </button>
                        </div>
                    </div>
                </div>';
        }
        echo '</div>'; // Close mobile container
    }

    return ob_get_clean();
}
add_shortcode('owl_carousel', 'owl_carousel_shortcode');

// CSS to handle visibility
function owl_carousel_styles() {
    echo '<style>
        @media (max-width: 768px) {
            .desktop-only { display: none; }
        }
        @media (min-width: 769px) {
            .mobile-only { display: none; }
        }
        .mobile-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin: 10px 0;
        }
        .card-img {
            width: 100%;
            border-radius: 8px;
        }
        .card-content {
            padding: 10px;
        }
        .card-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .button {
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
        }
        .primary {
            background: #007bff;
            color: white;
        }
        .secondary {
            background: #6c757d;
            color: white;
        }
        .no-style-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
    </style>';
}
add_action('wp_head', 'owl_carousel_styles');



function tools_covered_shortcode($atts) {
    // Default image data as a JSON string
    $default_tools = 'https://theanalogdigital.in/wp-content/uploads/2025/02/google-ads.png, https://theanalogdigital.in/wp-content/uploads/2025/02/google-keyword-planner.png, https://theanalogdigital.in/wp-content/uploads/2025/02/google-my-business.png, https://theanalogdigital.in/wp-content/uploads/2025/02/youtube.png,facebook-ads.png, https://theanalogdigital.in/wp-content/uploads/2025/02/meta-business-suite.png, https://theanalogdigital.in/wp-content/uploads/2025/02/chatgpt.png, https://theanalogdigital.in/wp-content/uploads/2025/02/linkedin.png, https://theanalogdigital.in/wp-content/uploads/2025/02/x-twitter.png, https://theanalogdigital.in/wp-content/uploads/2025/02/google-analytics.png, https://theanalogdigital.in/wp-content/uploads/2025/02/google-tag-manager.png';


    // Parse shortcode attributes
    $atts = shortcode_atts([
        'tools' => $default_tools, 
        'heading' => 'Tools Covered',
        'caption' => 'Learn More',
    ], $atts, 'tools_covered');

    // Decode tools data
    $tools = explode(',', $atts['tools']);    
    $heading = esc_html($atts['heading']);
    $caption = esc_html($atts['caption']);

    ob_start(); // Start output buffering
    ?>
    <div class="section-container">
        <p class="text-large-normal"><em><?php echo $caption; ?></em></p>
        <h2 class="h2"><?php echo $heading; ?></h2>
        <div class="row text-center align-items-center">
            <?php foreach ($tools as $tool) : ?>
                <div class="col-6 col-md-2 mb-3 d-flex justify-content-center align-items-center">
                    <img src="<?php echo esc_attr(trim($tool)); ?>" alt="" class="img-fluid tools-logo p-2"  style="max-width: 161px; height: auto; flex-shrink: 0;" />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <style>
        .custom-list img {
            transition: transform 0.3s ease;
        }
        .custom-list img:hover {
            transform: scale(1.1);
        }
        .custom-list p {
            margin-top: 10px;
            font-weight: 500;
            font-size: 14px;
            color: #333;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('tools_covered', 'tools_covered_shortcode');



// Add a shortcode for the profile card
function profile_card_shortcode($atts) {
    // Extract attributes if needed
    $atts = shortcode_atts(
        array(
            'name' => 'John Doe',
            'position' => 'Web Developer',
            'image' => 'https://placehold.co/300x390',
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'linkedin' => '#',
            'youtube' => '#',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, sint amet ducimus ex corrupti, recusandae sit consequatur perspiciatis obcaecati similique nemo nihil corporis sed quis itaque? Ducimus repellat beatae magnam?',
            'heading' => 'Meet the Team',
            'caption' => 'Learn More',
        ),
        $atts,
        'profile_card'
    );

    // Create the HTML content
    ob_start();
    ?>
    <div class="section-container">
    <p class="text-large-normal"><?php echo esc_html($atts['caption']); ?></p>
    <h2 class="h2"><?php echo esc_html($atts['heading']); ?></h2>
    <div class="row align-items-center gy-4">
    <!-- Image Section -->
    <div class="col-md-4 col-12 text-center text-md-start">
        <img src="<?php echo esc_url($atts['image']); ?>" class="trainer-img img-fluid rounded" alt="<?php echo esc_attr($atts['name']); ?>">
    </div>

    <!-- Content Section -->
    <div class="col-md-8 col-12">
        <div class="row align-items-center">
            <!-- Name & Position -->
            <div class="col-md-6 col-12 text-center text-md-start">
                <h2 class="h2 mb-1"><?php echo esc_html($atts['name']); ?></h2>
                <p class="text-large-normal text-muted"><?php echo esc_html($atts['position']); ?></p>
            </div>

            <!-- Social Links -->
            <div class="col-md-6 col-12 text-center text-md-end mt-2 mt-md-0">
                <?php if (!empty($atts['facebook'])): ?>
                    <a href="<?php echo esc_url($atts['facebook']); ?>" class="me-2"><i class="bi bi-facebook text-dark fs-4"></i></a>
                <?php endif; ?>
                <?php if (!empty($atts['twitter'])): ?>
                    <a href="<?php echo esc_url($atts['twitter']); ?>" class="me-2"><i class="bi bi-twitter text-dark fs-4"></i></a>
                <?php endif; ?>
                <?php if (!empty($atts['instagram'])): ?>
                    <a href="<?php echo esc_url($atts['instagram']); ?>" class="me-2"><i class="bi bi-instagram text-dark fs-4"></i></a>
                <?php endif; ?>
                <?php if (!empty($atts['linkedin'])): ?>
                    <a href="<?php echo esc_url($atts['linkedin']); ?>" class="me-2"><i class="bi bi-linkedin text-dark fs-4"></i></a>
                <?php endif; ?>
                <?php if (!empty($atts['youtube'])): ?>
                    <a href="<?php echo esc_url($atts['youtube']); ?>"><i class="bi bi-youtube text-dark fs-4"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <p class="text-large-normal mt-3 text-center text-md-start">
            <?php echo esc_html($atts['description']); ?>
        </p>
    </div>
</div>

    </div>
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('profile_card', 'profile_card_shortcode');


function companies_hiring_shortcode($atts) {
    // Set default values for the shortcode attributes
    $atts = shortcode_atts(
        array(
            'heading' => 'Companies Hiring',
            'description' => 'Description about companies hiring in this section. This could include industries or job roles.',
            'image1' => '',
            'image2' => '',
            'image3' => '',
            'image4' => '',
            'image5' => '',
            'image6' => ''
        ), $atts, 'companies_hiring');

    ob_start();
    ?>
    <div class="companies-hiring">
                <p class="text-large-normal"><em><?php echo esc_html($atts['description']); ?></em></p>
                <h2 class="h2"><?php echo esc_html($atts['heading']); ?></h2>
        
                
         
        
        <div class="row text-center align-items-center">
            <?php 
            // Loop to display up to 6 images from the shortcode attributes
            for ($i = 1; $i <= 6; $i++) {
                $image_url = $atts['image' . $i];
                if ($image_url) {
                    ?>
                    <div class="col-6 col-md-2 mb-3 d-flex justify-content-center align-items-center">
                        <img src="<?php echo esc_url($image_url); ?>" alt="Company Logo <?php echo $i; ?>" class="img-fluid tools-logo p-2"  style="max-width: 161px; height: auto; flex-shrink: 0;" />
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('companies_hiring', 'companies_hiring_shortcode');


// Create custom table on theme/plugin activation
function create_admission_table() {
    global $wpdb;
    
    // Define table name
    $table_name = $wpdb->prefix . 'course_admissions';
    
    // SQL to create table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        student_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(15) DEFAULT NULL,
        course VARCHAR(255) NOT NULL,
        address TEXT DEFAULT NULL,
        date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) CHARSET=utf8;";
    
    // Include the dbDelta function
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
    // Run the query
    dbDelta($sql);
}

// Hook the function to run on theme/plugin activation
register_activation_hook(__FILE__, 'create_admission_table');




function course_admission_form_shortcode($atts) {
    global $wpdb; // Access the WordPress database object

    // Set default values for the shortcode attributes
    $atts = shortcode_atts(
        array(
            'courses' => 'Course 1, Course 2, Course 3', // default courses
            'form_title' => 'Course Admission Form'
        ), $atts, 'course_admission_form');
    
    // Split courses into an array
    $courses = explode(',', $atts['courses']);
    ob_start();
    ?>
    <div class="container course-admission-form">
        <h3 class="h3 mb-4"><?php echo esc_html($atts['form_title']); ?></h3>
        <form method="post" action="" class="admission-form">
            <div class="form-group">
                <label for="student_name">Full Name:</label>
                <input type="text" name="student_name" id="student_name" class="form-control" required />
            </div>
            
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" class="form-control" required />
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" name="phone" id="phone" class="form-control" />
            </div>
            
            <div class="form-group">
                <label for="course">Select Course:</label>
                <select name="course" id="course" class="form-control" required disabled>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo esc_attr(trim($course)); ?>"><?php echo esc_html(trim($course)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>

            <div class="form-group text-center mt-2">
                <button type="submit" name="submit_admission_form" class="button primary">Submit</button>
            </div>
        </form>

        <?php 
        // Handle form submission
        if (isset($_POST['submit_admission_form'])) {
            // Sanitize form data
            $name = sanitize_text_field($_POST['student_name']);
            $email = sanitize_email($_POST['email']);
            $phone = sanitize_text_field($_POST['phone']);
            $course = sanitize_text_field($_POST['course']);
            $address = sanitize_textarea_field($_POST['address']);

            // Prepare the data to insert into the database
            $table_name = $wpdb->prefix . 'course_admissions'; // Table name

            $wpdb->insert(
                $table_name,
                array(
                    'student_name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'course' => $course,
                    'address' => $address
                )
            );
            
            // Check for successful insertion
            if ($wpdb->insert_id) {
                echo '<p class="mt-4 alert alert-success">Your form has been successfully submitted!</p>';
            } else {
                echo '<p class="mt-4 alert alert-danger">There was an error submitting your form. Please try again.</p>';
            }
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('course_admission_form', 'course_admission_form_shortcode');



// Hook to add custom admin menu
function add_admission_menu() {
    add_menu_page(
        'Course Admissions', // Page title
        'Course Admissions', // Menu title
        'manage_options',    // Capability required
        'course_admissions', // Menu slug
        'display_admissions_page', // Function to display the page
        'dashicons-clipboard', // Icon for the menu
        20 // Position of the menu
    );
}
add_action('admin_menu', 'add_admission_menu');

// Display the admissions data on the custom admin page
function display_admissions_page() {
    global $wpdb;
    
    // Display success or error messages
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'deleted') {
            echo '<div class="updated"><p>Submission deleted successfully.</p></div>';
        } elseif ($_GET['status'] == 'error') {
            echo '<div class="error"><p>There was an error processing your request.</p></div>';
        }
    }

    // Fetch all records from the course_admissions table
    $table_name = $wpdb->prefix . 'course_admissions';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_submitted DESC");

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Course Admissions</h1>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th class="manage-column">ID</th>
                    <th class="manage-column">Name</th>
                    <th class="manage-column">Email</th>
                    <th class="manage-column">Phone</th>
                    <th class="manage-column">Course</th>
                    <th class="manage-column">Address</th>
                    <th class="manage-column">Date Submitted</th>
                    <th class="manage-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results): ?>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo esc_html($row->id); ?></td>
                            <td><?php echo esc_html($row->student_name); ?></td>
                            <td><?php echo esc_html($row->email); ?></td>
                            <td><?php echo esc_html($row->phone); ?></td>
                            <td><?php echo esc_html($row->course); ?></td>
                            <td><?php echo esc_html($row->address); ?></td>
                            <td><?php echo esc_html($row->date_submitted); ?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=course_admissions&action=delete&id=' . $row->id); ?>" class="button-secondary" onclick="return confirm('Are you sure you want to delete this submission?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No submissions yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Handle actions like delete submission
function handle_admission_actions() {
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        global $wpdb;
        
        $id = intval($_GET['id']);
        $table_name = $wpdb->prefix . 'course_admissions';
        
        // Delete the record
        $result = $wpdb->delete($table_name, ['id' => $id]);
        
        // Check for success
        if ($result) {
            // Redirect with success status code
            wp_redirect(admin_url('admin.php?page=course_admissions&status=deleted'));
        } else {
            // Redirect with error status code
            wp_redirect(admin_url('admin.php?page=course_admissions&status=error'));
        }
        exit;
    }
}
add_action('admin_init', 'handle_admission_actions');



/**
 * Add a custom meta box for SEO metadata in the WordPress editor.
 */
function add_seo_meta_box() {
    add_meta_box(
        'seo_meta_data', // Unique ID for the meta box
        'SEO Metadata',  // Title of the meta box
        'render_seo_meta_box', // Callback function to render the meta box
        ['post', 'page'], // Post types (post and page)
        'normal',         // Context (normal, side, or advanced)
        'high'            // Priority (high or low)
    );
}
add_action('add_meta_boxes', 'add_seo_meta_box');

/**
 * Render the SEO metadata meta box.
 */
function render_seo_meta_box($post) {
    // Get existing values for the fields
    $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
    $custom_image = get_post_meta($post->ID, '_seo_custom_image', true);

    // Add a nonce field for security
    wp_nonce_field('save_seo_meta_box_data', 'seo_meta_box_nonce');

    // Render the input fields
    echo '<label for="seo_meta_description">Meta Description:</label>';
    echo '<textarea id="seo_meta_description" name="seo_meta_description" rows="4" style="width:100%;">' . esc_textarea($meta_description) . '</textarea>';
    echo '<br><br>';
    echo '<label for="seo_custom_image">Custom JSON-LD Image URL:</label>';
    echo '<input type="url" id="seo_custom_image" name="seo_custom_image" value="' . esc_url($custom_image) . '" style="width:100%;" />';
}

/**
 * Save the SEO metadata when the post is saved.
 */
function save_seo_meta_box_data($post_id) {
    // Check if the nonce is set and valid
    if (!isset($_POST['seo_meta_box_nonce']) || !wp_verify_nonce($_POST['seo_meta_box_nonce'], 'save_seo_meta_box_data')) {
        return;
    }

    // Check if the user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if this is an autosave and do nothing if it is
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save the meta description
    if (isset($_POST['seo_meta_description'])) {
        $meta_description = sanitize_text_field($_POST['seo_meta_description']);
        update_post_meta($post_id, '_seo_meta_description', $meta_description);
    }

    // Save the custom image URL
    if (isset($_POST['seo_custom_image'])) {
        $custom_image = esc_url_raw($_POST['seo_custom_image']);
        update_post_meta($post_id, '_seo_custom_image', $custom_image);
    }
}
add_action('save_post', 'save_seo_meta_box_data');

/**
 * Add the custom meta fields to the SEO meta tags and JSON-LD.
 */
function add_custom_seo_meta_tags_and_json_ld() {
    if (is_singular()) {
        global $post;
        // Get the custom meta fields
        $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
        $custom_image = get_post_meta($post->ID, '_seo_custom_image', true);

        // Fallback to default values if not set
        $description = $meta_description ?: wp_strip_all_tags(get_the_excerpt($post->ID));
        $featured_image = $custom_image ?: get_the_post_thumbnail_url($post->ID, 'full');
        $url = get_permalink($post->ID);
        $title = get_the_title($post->ID);
        $author = get_the_author_meta('display_name', $post->post_author);
        $datePublished = get_the_date('c', $post->ID);
        $dateModified = get_the_modified_date('c', $post->ID);

        // Output SEO meta tags
        echo "<meta name='description' content='" . esc_attr($description) . "' />\n";
        echo "<link rel='canonical' href='" . esc_url($url) . "' />\n";
        echo "<meta property='og:type' content='article' />\n";
        echo "<meta property='og:title' content='" . esc_attr($title) . "' />\n";
        echo "<meta property='og:description' content='" . esc_attr($description) . "' />\n";
        echo "<meta property='og:url' content='" . esc_url($url) . "' />\n";
        echo "<meta property='og:image' content='" . esc_url($featured_image) . "' />\n";

        // Output JSON-LD structured data
        $json_ld = [
            "@context" => "https://schema.org",
            "@type" => "Article",
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $url
            ],
            "headline" => $title,
            "description" => $description,
            "image" => $featured_image,
            "author" => [
                "@type" => "Person",
                "name" => $author
            ],
            "datePublished" => $datePublished,
            "dateModified" => $dateModified
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}
add_action('wp_head', 'add_custom_seo_meta_tags_and_json_ld');


function add_toc_meta_box() {
    add_meta_box(
        'enable_toc',
        'Enable Table of Contents',
        'render_toc_meta_box',
        'page',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_toc_meta_box');

function render_toc_meta_box($post) {
    $value = get_post_meta($post->ID, '_enable_toc', true);
    ?>
    <label for="enable_toc">
        <input type="checkbox" id="enable_toc" name="enable_toc" value="1" <?php checked($value, '1'); ?> />
        Enable Table of Contents
    </label>
    <?php
}

function save_toc_meta_box($post_id) {
    if (array_key_exists('enable_toc', $_POST)) {
        update_post_meta($post_id, '_enable_toc', '1');
    } else {
        delete_post_meta($post_id, '_enable_toc');
    }
}
add_action('save_post', 'save_toc_meta_box');

function fix_home_page_wp_title($title) {
    if (is_front_page() || is_home()) {
        return "Home | Analog Digital - The Digital People  ";
    }
    return $title;
}
add_filter('pre_get_document_title', 'fix_home_page_wp_title');


add_filter( 'git_updater_theme_repo', function( $repos ) {
    $repos['TheAnalogDigitalTheme'] = 'jarvismayur/TheAnalogDigitalTheme';
    return $repos;
});


function generate_sitemap() {
    $postsForSitemap = get_posts(array(
        'numberposts' => -1,
        'post_type'   => array('post', 'page'),
        'post_status' => 'publish'
    ));

    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($postsForSitemap as $post) {
        $postdate = get_the_date('c', $post->ID);
        echo '<url>';
        echo '<loc>' . get_permalink($post->ID) . '</loc>';
        echo '<lastmod>' . $postdate . '</lastmod>';
        echo '<changefreq>monthly</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }

    echo '</urlset>';
    exit;
}

// Hook the function to handle the sitemap URL
function add_sitemap_rewrite_rule() {
    add_rewrite_rule('^sitemap\.xml$', 'index.php?sitemap=1', 'top');
}
add_action('init', 'add_sitemap_rewrite_rule');

// Register the sitemap query var
function add_sitemap_query_var($vars) {
    $vars[] = 'sitemap';
    return $vars;
}
add_filter('query_vars', 'add_sitemap_query_var');

// Load the sitemap when the URL is accessed
function load_custom_sitemap() {
    if (get_query_var('sitemap')) {
        generate_sitemap();
    }
}
add_action('template_redirect', 'load_custom_sitemap');


function get_free_consulting_btn_shortcode($atts) {
    ob_start();
    ?>
    <!-- Button to trigger the modal -->
     <div class="mx-auto text-center " >
         <button type="button" class="button primary" onclick="showModal()" id="modalBtn" style="position:relative; z-index:0; ">
        Get Free Consulting 
    </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index:-1;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="h5 text-white" id="exampleModalLongTitle">Get Free Consulting </h5>
                    <button type="button" class="btn-close" style="filter: invert(1) brightness(200%);" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form id="consultingForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="occupation" class="form-label">Occupation</label>
                            <select class="form-control" id="occupation" name="occupation" required>
                                <option value="Student">Student</option>
                                <option value="Professional">Professional</option>
                                <option value="Entrepreneur">Entrepreneur</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label">Course Name</label>
                            <select class="form-control" id="course" name="course" required>
                                <option value="Digital Marketing ">Digital Marketing</option>
                                <option value="UI / UX Developer ">UI / UX Developer</option>
                                <option value="Full Stack Developer (MERN)">Full Stack Developer (MERN)</option>
                                <option value="Graphics Designing ">Graphics Designing </option>
                            </select>
                        </div>
                        <div class="mx-auto text-center">
                            <button type="submit" class="button primary">Submit</button>
                        </div>  
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        function showModal() {
            var modalElement = document.getElementById('exampleModalCenter');
            var backdropElement = document.createElement("div");
            var modalBtn = document.getElementById('modalBtn');


            var modal = new bootstrap.Modal(modalElement, {
                backdrop: true,
                keyboard: true
            });

            modal.show();

            setTimeout(() => {
                modalElement.style.display = "block";
                modalElement.style.opacity = "1";
                modalElement.style.visibility = "visible";
                modalElement.style.height = "auto"
                modalElement.style.zIndex  = "1052";
                modalBtn.style.zIndex  = "-1";

                backdropElement.className = "modal-backdrop fade show";
                backdropElement.style.opacity = "0.5";
                document.body.appendChild(backdropElement);

                document.body.style.overflow = "hidden";
            }, 100);

            modalElement.addEventListener("hidden.bs.modal", function () {
                modalElement.style.display = "none";
                modalElement.style.opacity = "0";
                modalElement.style.visibility = "hidden";
                modalBtn.style.zIndex  = "0";

                if (backdropElement) {
                    backdropElement.remove();
                }

                document.body.style.overflow = "auto";
            });
        }
        document.getElementById('consultingForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            var formData = new FormData(this);
            formData.append("action", "save_consulting_form");  // Append action properly

            fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Server Response:", data); // Debugging
                alert("Form submitted successfully!");
                document.getElementById('consultingForm').reset();
            })
            .catch(error => console.error("Error:", error));
        });

    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('get_free_consulting_btn', 'get_free_consulting_btn_shortcode');

function create_consulting_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "consulting_requests";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        occupation VARCHAR(100) NOT NULL,
        course VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_consulting_table');

function save_consulting_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . "consulting_requests";
    $wpdb->insert(
        $table_name,
        [
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
            'occupation' => sanitize_text_field($_POST['occupation']),
            'course' => sanitize_text_field($_POST['course'])
        ]
    );
    wp_die();
}
add_action('wp_ajax_save_consulting_form', 'save_consulting_form');
add_action('wp_ajax_nopriv_save_consulting_form', 'save_consulting_form');

function register_consulting_menu() {
    add_menu_page("Consulting Requests", "Consulting Requests", "manage_options", "consulting-requests", "display_consulting_requests");
}
add_action("admin_menu", "register_consulting_menu");

function display_consulting_requests() {
    global $wpdb;
    $table_name = $wpdb->prefix . "consulting_requests";
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    echo "<div class='wrap'><h2>Consulting Requests  </h2><table class='widefat'><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Occupation</th><th>Course</th><th>Date</th></tr></thead><tbody>";
    foreach ($results as $row) {
        echo "<tr><td>{$row->name}</td><td>{$row->email}</td><td>{$row->phone}</td><td>{$row->occupation}</td><td>{$row->course}</td><td>{$row->created_at}</td></tr>";
    }
    echo "</tbody></table></div>";
}


function get_download_brochure_btn_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'courses' => 'Course 1, Course 2, Course 3', // default courses
            'form_title' => 'Download Broucher Form'
        ), $atts, 'course_admission_form');
    
    // Split courses into an array
    $courses = explode(',', $atts['courses']);
    $form_title = $atts['form_title'];
    ob_start();
    ?>
    <!-- Button to trigger the modal -->
    <div class="mx-auto text-center">
        <button type="button" class="button primary" onclick="showBrochureModal()" id="brochureModalBtn" style="position:relative; z-index:0; ">
            Download Brochure
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="brochureModal" tabindex="-1" aria-labelledby="brochureModalTitle" aria-hidden="true" style="z-index:-1;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h5 text-white"><?php echo $form_title; ?></h5>
                    <button type="button" class="btn-close" style="filter: invert(1) brightness(200%);" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="brochureForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label">Select Course</label>
                            <select class="form-control" id="course" name="course" required disabled>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo esc_attr(trim($course)); ?>"><?php echo esc_html(trim($course)); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mx-auto text-center">
                            <button type="submit" class="button primary">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showBrochureModal() {
            var modalElement = document.getElementById('brochureModal');
            var backdropElement = document.createElement("div");
            var modalBtn = document.getElementById('brochureModalBtn');


            var modal = new bootstrap.Modal(modalElement, {
                backdrop: true,
                keyboard: true
            });

            modal.show();

            setTimeout(() => {
                modalElement.style.display = "block";
                modalElement.style.opacity = "1";
                modalElement.style.visibility = "visible";
                modalElement.style.height = "auto"
                modalElement.style.zIndex = "1051";
                modalBtn.style.zIndex  = "-1";

                backdropElement.className = "modal-backdrop fade show";
                backdropElement.style.opacity = "0.5";
                
                document.body.appendChild(backdropElement);

                document.body.style.overflow = "hidden";
            }, 100);

            modalElement.addEventListener("hidden.bs.modal", function () {
                modalElement.style.display = "none";
                modalElement.style.opacity = "0";
                modalElement.style.visibility = "hidden";
                modalBtn.style.zIndex  = "0";

                if (backdropElement) {
                    backdropElement.remove();
                }

                document.body.style.overflow = "auto";
            });
        }


        document.getElementById('brochureForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            var formData = new FormData(this);
            formData.append("action", "save_brochure_form");

            fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Server Response:", data);
                alert("Form submitted successfully! Your brochure will start downloading.");
                document.getElementById('brochureForm').reset();
                window.location.href = "<?php echo site_url('/wp-content/uploads/brochure.pdf'); ?>"; // Change to actual brochure URL
            })
            .catch(error => console.error("Error:", error));
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('get_download_brochure_btn', 'get_download_brochure_btn_shortcode');

function create_brochure_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "brochure_requests";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        course VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_brochure_table');

function save_brochure_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . "brochure_requests";
    $wpdb->insert(
        $table_name,
        [
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
            'course' => sanitize_text_field($_POST['course'])
        ]
    );
    wp_die();
}
add_action('wp_ajax_save_brochure_form', 'save_brochure_form');
add_action('wp_ajax_nopriv_save_brochure_form', 'save_brochure_form');

function register_brochure_menu() {
    add_menu_page("Brochure Requests", "Brochure Requests", "manage_options", "brochure-requests", "display_brochure_requests");
}
add_action("admin_menu", "register_brochure_menu");

function display_brochure_requests() {
    global $wpdb;
    $table_name = $wpdb->prefix . "brochure_requests";
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    echo "<div class='wrap'><h2>Brochure Requests</h2><table class='widefat'><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Date</th></tr></thead><tbody>";
    foreach ($results as $row) {
        echo "<tr><td>{$row->name}</td><td>{$row->email}</td><td>{$row->phone}</td><td>{$row->course}</td><td>{$row->created_at}</td></tr>";
    }
    echo "</tbody></table></div>";
}



function get_apply_for_course_btn_shortcode($atts) {
    // Set default values for the shortcode attributes
    $atts = shortcode_atts(
        array(
            'courses' => 'Course 1, Course 2, Course 3', // default courses
            'form_title' => 'Course Admission Form'
        ), $atts, 'course_admission_form');
    
    // Split courses into an array
    $courses = explode(',', $atts['courses']);
    $form_title = $atts['form_title'];
    ob_start();
    ?>
    <!-- Button to trigger the modal -->
    <div class="mx-auto text-center">
        <button type="button" class="button primary" onclick="showBrochureModalApply()" id="courseApplicationModalBtn" style="position:relative; z-index:0; ">
            Apply for the Course
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="courseApplicationModal" tabindex="-1" aria-labelledby="courseApplicationModalTitle" aria-hidden="true"style="z-index:-1;" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h5 text-white"><?php echo $form_title; ?></h5>
                    <button type="button" class="btn-close" style="filter: invert(1) brightness(200%);" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="courseApplicationForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label">Select Course</label>
                            <select class="form-control" id="course" name="course" required disabled>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo esc_attr(trim($course)); ?>"><?php echo esc_html(trim($course)); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mx-auto text-center">
                            <button type="submit" class="button primary">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showBrochureModalApply() {
            var modalElement = document.getElementById('courseApplicationModal');
            var backdropElement = document.createElement("div");
            var modalBtn = document.getElementById('courseApplicationModalBtn');


            var modal = new bootstrap.Modal(modalElement, {
                keyboard: true
            });

            modal.show();

            setTimeout(() => {
                modalElement.style.display = "block";
                modalElement.style.opacity = "1";
                modalElement.style.visibility = "visible";
                modalElement.style.height = "auto"
                modalElement.style.zIndex = "1053";
                modalBtn.style.zIndex  = "-1";

                backdropElement.className = "modal-backdrop fade show";
                backdropElement.style.opacity = "0.5";
                backdropElement.style.zIndex = "1";
                
                document.body.appendChild(backdropElement);

                document.body.style.overflow = "hidden";
            }, 100);

            modalElement.addEventListener("hidden.bs.modal", function () {
                modalElement.style.display = "none";
                modalElement.style.opacity = "0";
                modalElement.style.visibility = "hidden";
                modalBtn.style.zIndex  = "0";
                backdropElement.style.zIndex = "-1";

                if (backdropElement) {
                    backdropElement.remove();
                }

                document.body.style.overflow = "auto";
            });
        }

        document.getElementById('courseApplicationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            var formData = new FormData(this);
            formData.append("action", "save_course_application_form");

            fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Server Response:", data);
                alert("Form submitted successfully! Your course application has been received.");
            })
            .catch(error => console.error("Error:", error));
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('get_apply_for_course_btn', 'get_apply_for_course_btn_shortcode');

function create_course_application_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "course_application_requests";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        course VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_course_application_table');

function save_course_application_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . "course_application_requests";

    $wpdb->insert(
        $table_name,
        [
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
            'course' => sanitize_text_field($_POST['course'])
        ]
    );
    wp_die();
}
add_action('wp_ajax_save_course_application_form', 'save_course_application_form');
add_action('wp_ajax_nopriv_save_course_application_form', 'save_course_application_form');

function register_course_application_menu() {
    add_menu_page("Course Applications", "Course Applications", "manage_options", "course-application-requests", "display_course_application_requests");
}
add_action("admin_menu", "register_course_application_menu");

function display_course_application_requests() {
    global $wpdb;
    $table_name = $wpdb->prefix . "course_application_requests";
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    echo "<div class='wrap'><h2>Course Applications</h2><table class='widefat'><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Date</th></tr></thead><tbody>";
    foreach ($results as $row) {
        echo "<tr><td>{$row->name}</td><td>{$row->email}</td><td>{$row->phone}</td><td>{$row->course}</td><td>{$row->created_at}</td></tr>";
    }
    echo "</tbody></table></div>";
}



function custom_rewrite_rules() {
    add_rewrite_rule('^courses/([^/]*)/?', 'index.php?post_type=courses&name=$matches[1]', 'top');
    add_rewrite_rule('^blogs/([^/]*)/?', 'index.php?post_type=post&name=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_rules');

function custom_post_link($permalink, $post) {
    if ($post->post_type == 'courses') {
        return home_url('/courses/' . $post->post_name . '/');
    } elseif ($post->post_type == 'post') {
        return home_url('/blogs/' . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_type_link', 'custom_post_link', 10, 2);

function update_flush_rewrite_rules() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'update_flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'update_flush_rewrite_rules');


function custom_post_type_courses() {
    register_post_type('courses',
        array(
            'labels'      => array(
                'name'          => __('Courses'),
                'singular_name' => __('Course'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'courses'),
            'supports'    => array('title', 'editor', 'thumbnail'),
        )
    );
}
add_action('init', 'custom_post_type_courses');

