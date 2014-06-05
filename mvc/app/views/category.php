<?php if ( have_posts() ): ?>
<h2>Category Archive: <?php echo single_cat_title( '', false ); ?></h2>
<ol>
<?php while ( have_posts() ) : the_post(); ?>
    <li>
        <article>
            <h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php the_content(); ?>
        </article>
    </li>
<?php endwhile; ?>
</ol>
<?php else: ?>
<h2>No posts to display in <?php echo single_cat_title( '', false ); ?></h2>
<?php endif; ?>