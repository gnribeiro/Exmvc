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

            <?php if(isset($childrens) && count($intro)) : foreach($childrens as $key => $value) :?>
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

    <?php if ( isset($list_posts) && count($list_posts)): ?>
    <section class="container">
        <ul class="list-group">
             <?php foreach ($list_posts as $key => $value) :?>
            
            <li class="list-group-item">
                <article>
                    <h2><a href="<?php echo  get_permalink( $value->ID); ?>" rel="bookmark"><?php echo $value->post_title ?></a></h2>
                        <?php echo $value->post_content ?>
                </article>
            </li>
            <?php endforeach;  ?>
        </ul>

    </section>
    <?php endif?>
     <?php if(isset($pagination)) echo $pagination ?>
