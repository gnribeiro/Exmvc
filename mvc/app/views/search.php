<?php if ( have_posts() ): ?>
<h2>Search Results for '<?php echo get_search_query(); ?>'</h2> 
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
<h2>No results found for '<?php echo get_search_query(); ?>'</h2>
<?php endif; ?>