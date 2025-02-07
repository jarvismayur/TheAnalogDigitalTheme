<?php get_template_part('templates/header'); ?>

<div class="container mt-5">
    <?php
    // Start the loop to display the post content
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <article <?php post_class(); ?>>
                <header class="mb-5">
                    <!-- Breadcrumb Navigation -->
                    <nav aria-label="breadcrumb" class="mt-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo home_url(); ?>">Home</a>
                            </li>
                            <?php if (is_home() && !is_front_page()) : ?>
                                <li class="breadcrumb-item active" aria-current="page">Blog</li>
                            <?php elseif (is_archive()) : ?>
                                <li class="breadcrumb-item active" aria-current="page"><?php single_cat_title(); ?></li>
                            <?php elseif (is_single()) : ?>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Blog</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                            <?php elseif (is_search()) : ?>
                                <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                            <?php else : ?>
                                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium', [
                            'class' => 'card-img-top img-fluid',
                            'alt'   => get_the_title(),
                            'loading' => 'lazy',
                        ]); ?>
                    </a>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/placeholder.png'); ?>" 
                        alt="Placeholder Image" 
                        class="card-img-top img-fluid" 
                        loading="lazy">
                <?php endif; ?>

                <div class="row align-items-center">
    <!-- Column 1: Author Information -->
    <div class="col-md-2">
        <p class="mb-0"><strong>Written By</strong></p>
        <p class="mb-0"><?php the_author(); ?></p>
    </div>

    <!-- Column 2: Published Date -->
    <div class="col-md-2">
        <p class="mb-0"><strong>Published On</strong></p>
        <p class="mb-0"><?php echo get_the_date(); ?></p>
    </div>

    <!-- Column 3: Social Media Sharing Links -->
    <div class="col-md-8 text-md-end">
        
        <div class="d-flex justify-content-md-end gap-2">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="" title="Share on Facebook">
                <i class="bi bi-facebook text-dark"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="" title="Share on Twitter">
                <i class="bi bi-twitter text-dark"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" class="" title="Share on LinkedIn">
                <i class="bi bi-linkedin text-dark"></i>
            </a>
        </div>
    </div>
</div>


                <div class="row mt-5 ">
                    <div class="col-3">
                        <div class="table-of-contents my-4 p-3  border rounded  " id="toc-list">
                                <h2 class="h2">Table of Contents</h2>
                                <?php
                                $content = get_the_content();
                                preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER);

                                if (!empty($matches)) {
                                    echo '<ul class="list-unstyled ms-3">';
                                    $heading_ids = []; // Array to track unique IDs for headings

                                    foreach ($matches as $match) {
                                        $heading_text = strip_tags($match[2]); // Extract the heading text
                                        $base_id = sanitize_title($heading_text); // Generate a base ID
                                        $unique_id = $base_id;

                                        // Ensure ID uniqueness by appending a number if needed
                                        $counter = 1;
                                        while (in_array($unique_id, $heading_ids)) {
                                            $unique_id = $base_id . '-' . $counter;
                                            $counter++;
                                        }
                                        $heading_ids[] = $unique_id;

                                        // Replace the heading in the content with the new ID
                                        $heading_with_id = "<h{$match[1]} id='{$unique_id}'>{$match[2]}</h{$match[1]}>";
                                        $content = str_replace($match[0], $heading_with_id, $content);

                                        // Generate the TOC entry
                                        echo "<li class='mb-2'><a href='#{$unique_id}' class='text-dark text-decoration-none'>{$heading_text}</a></li>";
                                    }
                                    echo '</ul>';
                                } else {
                                    echo '<p>No headings found in the content.</p>';
                                }

                                // Output the modified content using a filter
                                add_filter('the_content', function($original_content) use ($content) {
                                    return $content;
                                });
                                ?>
                            </div>
                    </div>
                    <div class="col-9">
                                <!-- Post Content -->
                <div class="content" id="post-content" >
                    <?php the_content(); ?>
                </div>
                        </div>
                </div>
                
                                


                

                <!--<footer>
                    <div class="post-categories">
                        <?php  // the_category(', '); ?>
                    </div>
                </footer>-->
            </article>
        <?php endwhile;
    else :
        echo '<p>No content found</p>';
    endif;
    ?>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const headerHeight = document.querySelector("header").offsetHeight || 0; // Get header height
        const links = document.querySelectorAll("a[href^='#']");

        links.forEach(link => {
            link.addEventListener("click", function (event) {
                const targetId = this.getAttribute("href").substring(1); // Get the target ID
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    event.preventDefault(); // Prevent default anchor behavior

                    // Smoothly scroll to the target
                    window.scrollTo({
                        top: targetElement.offsetTop - headerHeight - 10, // Adjust for header height
                        behavior: "smooth"
                    });
                }
            });
        });
    });
</script>





<?php get_template_part('templates/footer'); ?>

