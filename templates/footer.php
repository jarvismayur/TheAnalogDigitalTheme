<footer class="site-footer bg-white text-dark py-4 bg-white py-3 shadow-medium" >
    <div class="section-container">
    <div class="row">
        <!-- Large Column -->
        <div class="col-lg-4 col-md-6 mb-4 footer-col footer-col-large">
            <div class="footer-large-widget">
                <!-- Display Logo -->
                <div class="footer-logo">
                    <?php 
                    // Get the logo from the Customizer (ID)
                    $logo_url = get_theme_mod( 'footer_logo' );
                    if ( $logo_url ) : 
                    ?>
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="Logo" class="img-thumbnail border-0">
                    <?php else : ?>
                        <p>Logo image not available. Please upload it in the Customizer.</p>
                    <?php endif; ?>
                </div>

                <!-- Display Description -->
                <div class="footer-description">
                    <?php
                    // Get footer description from the Customizer
                    $footer_description = get_theme_mod( 'footer_description' );
                    if ( $footer_description ) :
                        echo '<p class="text-large-normal">' . esc_html( $footer_description ) . '</p>';
                    else :
                        echo '<p>Provide a description via the Customizer.</p>';
                    endif;
                    ?>
                </div>
                 <ul class="list-inline mx-auto text-center social-links">
                    <?php
                    // Define social media platforms
                    $social_links = array(
                        'facebook'  => 'Facebook',
                        'twitter'   => 'Twitter',
                        'instagram' => 'Instagram',
                        'linkedin'  => 'LinkedIn',
                        'youtube'   => 'YouTube'
                    );

                    // Loop through each platform and check if the URL is set in the Customizer
                    foreach ( $social_links as $slug => $name ) :
                        $url = get_theme_mod( "social_{$slug}_url" );
                        if ( ! empty( $url ) ) :
                    ?>
                        <li class="list-inline-item">
                            <a href="<?php echo esc_url( $url ); ?>" target="_blank" aria-label="Visit our <?php echo esc_html( $name ); ?> page">
                                <i class="bi bi-<?php echo esc_attr( $slug ); ?> text-dark"></i> 
                                <span class="sr-only"></span>
                            </a>
                        </li>
                    <?php endif; endforeach; ?>
                </ul>

            </div>
        </div>

        <div class="col-lg-8 col-md-6 mb-4">
            <div class="row">
                <?php
                $footer_menus = array(
                    'footer-menu-1' => 'footer-menu-1',
                    'footer-menu-2' => 'footer-menu-2',
                    'footer-menu-3' => 'footer-menu-3',
                    'footer-menu-4' => 'footer-menu-4',
                );

                foreach ( $footer_menus as $menu_location => $menu_id ) :
                    // Fetch the menu assigned to this location
                    $menu = wp_get_nav_menu_object( get_nav_menu_locations()[ $menu_location ] );

                    if ( $menu ) :
                        $menu_name = $menu->name;  // Get the name of the assigned menu
                ?>
                        <div class="col-lg-3 col-md-6  col-sm-6 mb-4 footer-col">
                            <span class="text-large-bold"><?php echo esc_html( $menu_name ); ?></span>
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => $menu_location,
                                'menu_id'        => $menu_location,
                                'menu_class'     => 'menu list-unstyled text-regular-normal',
                                'fallback_cb'    => false,
                            ) );
                            ?>
                        </div>
                <?php
                    else :
                ?>
                        <div class="col-lg-3 col-md-6 mb-4 footer-col">
                            <h4><?php esc_html_e( 'No menu assigned. Please assign a menu in Appearance > Menus.', 'textdomain' ); ?></h4>
                        </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>

    </div>

        <div class="site-info text-center">
            <div class="container">
                <!-- Display Copyright Text from Customizer -->
                <p>
                    <?php 
                    $copyright_text = get_theme_mod( 'footer_copyright_text', '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All Rights Reserved.' );
                    echo wp_kses_post( $copyright_text );
                    ?> |

                    <!-- Display Terms and Conditions Link from Customizer -->
                    <?php
                    $terms_page_id = get_theme_mod( 'footer_terms_page' );
                    if ( $terms_page_id ) :
                        $terms_url = get_permalink( $terms_page_id );
                    ?>
                        <a href="<?php echo esc_url( $terms_url ); ?>">
                            <?php esc_html_e( 'Terms and Conditions', 'textdomain' ); ?>
                        </a> | 
                    <?php endif; ?>

                    <!-- Display Privacy Policy Link from Customizer -->
                    <?php
                    $privacy_page_id = get_theme_mod( 'footer_privacy_page' );
                    if ( $privacy_page_id ) :
                        $privacy_url = get_permalink( $privacy_page_id );
                    ?>
                        <a href="<?php echo esc_url( $privacy_url ); ?>">
                            <?php esc_html_e( 'Privacy Policy', 'textdomain' ); ?>
                        </a>
                    <?php endif; ?>
                </p>
            </div>
        </div>

            </div>
</footer>

<!-- Bootstrap JavaScript and dependencies -->
<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/bootstrap/js/jquery-3.7.1.min.js' ); ?>"></script>
<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.bundle.min.js' ); ?>"></script>
<script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/main.js' ); ?>"></script>


<!-- Updated Bootstrap 5 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
<script src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/highlight.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="/docs/4.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#courseslist .owl-carousel').owlCarousel({
            center: true,                // Center the active item
            loop: true,                  // Enable infinite looping
            margin: 30,                  // Space between items
            items: 1,                    // Number of items to show
            dots: true,                  // Enable pagination dots
            autoplay: true,              // Auto-play the carousel
            autoplayTimeout: 5000,       // Delay between auto-play slides
            responsiveClass: true,
            responsive: {                // Responsive settings
                0: {
                    items: 1             // Show 1 item on small screens
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        center: true,                // Center the active item
        loop: true,                  // Enable infinite looping
        margin: 30,                  // Space between items
        items: 3,                    // Number of items to show
        dots: true,                  // Enable pagination dots
        autoplay: true,              // Auto-play the carousel
        autoplayTimeout: 3000,       // Delay between auto-play slides
		responsiveClass: true,
        responsive: {                // Responsive settings
            0: {
                items: 1             // Show 1 item on small screens
            },
            600: {
                items: 2             // Show 2 items on medium screens
            },
            1000: {
                items: 3             // Show 3 items on large screens
            }
        }
    });
});
	
	
$(document).ready(function(){

	// responsive nav
	var responsiveNav = $('#toggle-nav');
	var navBar = $('.nav-bar');

	responsiveNav.on('click',function(e){
		e.preventDefault();
		console.log(navBar);
		navBar.toggleClass('active')
	});

	// pseudo active
	if($('#docs').length){
		var sidenav = $('ul.side-nav').find('a');
		var url = window.location.pathname.split( '/' );
		var url = url[url.length-1];
		
		sidenav.each(function(i,e){
			var active = $(e).attr('href');

			if(active === url){
				$(e).parent('li').addClass('active');
				return false;
			}
		});
	}

});

hljs.configure({tabReplace: '  '});
hljs.initHighlightingOnLoad();


</script>

<script>
    document.querySelectorAll('.accordion-link').forEach(link => {
  link.addEventListener('click', function() {
    const accordionItem = this.closest('.accordion-item');
    
    // Toggle active state
    accordionItem.classList.toggle('active');

    // Close other items
    document.querySelectorAll('.accordion-item').forEach(item => {
      if (item !== accordionItem) {
        item.classList.remove('active');
      }
    });
  });
});

</script>









</body>
</html>
