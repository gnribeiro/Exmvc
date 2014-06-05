<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<h5>FrontPage</h5>
<article>
    <h2><?php the_title(); ?></h2>
    <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
    <?php the_content(); ?>         
</article>
<?php endwhile; ?>