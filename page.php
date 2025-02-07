<?php get_template_part('templates/header'); ?>
<?php
    // Check if the TOC is enabled for this page
    $enable_toc = get_post_meta(get_the_ID(), '_enable_toc', true); ?>
<?php if ($enable_toc) : ?>
    <div class="container mt-5 ">
<?php endif;?>
<article <?php post_class(); ?>>
    <?php if ($enable_toc) : ?>
    <header class="mb-5 ">
        <h1 class="h1 text-center"><?php the_title(); ?></h1>
    </header>
    <?php endif;?>

    

    <?php if ($enable_toc) : ?>
        <div class="row  ">
            <div class="col-lg-3">
                <div class="table-of-contents my-4 p-3 border rounded d-none d-lg-block" id="toc-list">
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
            <div class="col-lg-9 col-12">
                <div class="content" id="post-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

    <?php else : ?>
        <div class="content text-large-normal" id="post-content">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>

</article>
<?php if ($enable_toc) : ?>
</div>
<?php endif; ?>

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
