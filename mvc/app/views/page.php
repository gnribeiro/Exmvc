Page

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <article>
        <h5>Page</h5>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
    </article>
<?php endwhile; ?>