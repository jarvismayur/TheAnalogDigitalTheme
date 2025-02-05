<?php get_template_part('templates/header'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="archive-title"><?php the_archive_title(); ?></h1>
            <div class="archive-description"><?php the_archive_description(); ?></div>

            <?php
            // Start the loop to display archived posts
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
                echo '<p>No posts found.</p>';
            endif;
            ?>
        </div>

        <div class="col-md-4">
            <?php get_sidebar(); // Include sidebar ?>
        </div>
    </div>
</div>

<?php get_template_part('templates/footer'); ?>

