<?php get_template_part('templates/header'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1>Search Results for: <?php echo get_search_query(); ?></h1>

            <?php
            // Start the loop to display search results
            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <header>
                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </header>
                        <div class="content">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile;
            else :
                echo '<p>No results found.</p>';
            endif;
            ?>
        </div>

        <div class="col-md-4">
            <?php get_sidebar(); // Include sidebar ?>
        </div>
    </div>
</div>

<?php get_template_part('templates/footer'); ?>
