<?php get_template_part('templates/header'); ?>

<div class="container mt-5">

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


    <!-- Blog Section -->
    <section class="blog-posts mt-4">
        <?php if (have_posts()) : ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                <!-- Loop Through Posts -->
                <?php while (have_posts()) : the_post(); ?>

                    <div class="col">
                        <div id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?>>
                            
                            <!-- Post Thumbnail -->
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


                            <div class="card-body">
                                <!-- Post Title -->
                                <h5 class="card-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark" class="text-dark text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>

                                <!-- Post Meta -->
                                <p class="card-text small text-muted">
                                    <i class="fas fa-calendar-alt"></i> <?php echo esc_html(get_the_date()); ?> |
                                    <i class="fas fa-user"></i> <?php the_author_posts_link(); ?>
                                    
                                </p>

                                <!-- Post Excerpt -->
                                <p class="card-text">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            </div>

                            <!-- Read More -->
                            
                                <a href="<?php the_permalink(); ?>" class="button primary flex-grow-1 mx-2">
                                    <?php _e('Continue Reading &raquo;', 'textdomain'); ?>
                                </a>
                           

                        </div>
                    </div>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <div class="pagination mt-5">
                <?php custom_bootstrap_pagination(); ?>
            </div>

        <?php else : ?>
            <!-- No Posts Found -->
            <section class="no-results not-found">
                <header class="page-header">
                    <h2><?php esc_html_e('Nothing Found', 'textdomain'); ?></h2>
                </header>
                <div class="page-content">
                    <p><?php esc_html_e('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'textdomain'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>

        <?php endif; ?>
    </section>

        </div>

<?php get_template_part('templates/footer'); ?>
