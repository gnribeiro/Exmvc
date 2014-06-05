    <?php if(isset($intro) && count($intro)):?>
    <section  class="jumbotron">
        <?php foreach ($intro as $key => $value) :?>
        <div class="container">
            <h3><?php echo $value->post_title ?></h3>
            <p><?php echo $value->post_content ?></p>
         </div>
           <? endforeach?>
    </section>
    <?php endif?>
    <section class="container">
        <div class="row">

            <?php if(isset($childrens) && count($childrens)) : foreach($childrens as $key => $value) :?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                      <img data-src="holder.js/300x200" alt="...">
                      <div class="caption">
                        <h3><?php echo $value['name'] ?></h3>
                        <p><?php echo $value['post_content']  ?></p>
                        <p><a href="<?php echo $value['slug'] ?>" class="btn btn-primary" role="button">Button</a></p>
                      </div>
                    </div>
                </div>
            <? endforeach; endif?>
        </div>
    </section>

  <?php if ( have_posts() && $lists): ?>
    <section class="container">
        <ul class="list-group">
            <?php global $post;  while ( have_posts() ) : the_post(); if(!has_category( 'intro', $post->ID )):?>
            
            <li class="list-group-item">
                <article>
                    <h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <?php the_content(); ?>
                </article>
            </li>
            <?php endif; endwhile;  ?>
        </ul>

    </section>
    <?php endif?>
  <?php if(isset($pagination)) echo $pagination ?>