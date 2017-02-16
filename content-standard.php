<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="post-inner">

    <figure class="post-thumbnail">
      <?php if ( has_post_thumbnail() ): ?>
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-standard'); ?></a>
      <?php else: ?>
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/thumb-standard.png" alt="<?php the_title(); ?>"></a>
      <?php endif; ?>
    </figure>

    <div class="post-content flex-column">

      <div class="post-header">

        <h2 class="post-title">
          <a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </h2>

        <p class="post-meta">
          <span class="post-date"><?php echo get_the_date(); ?></span>
          <span class="post-category"><?php the_category(' / ') ?></span>
          <?php if ( comments_open() && cd_is_post_single_comment() ) { ?><span class="post-comment"><?php comments_popup_link('0', '1', '%'); ?></span><?php } ?>
        </p>

        <?php if ( get_the_excerpt() != '' ): ?>
          <div class="post-excerpt"><?php the_excerpt(); ?></div>
        <?php endif; ?>

      </div>

      <p class="more"><a href="<?php the_permalink(); ?>"><?php _e( 'READ MORE', 'coldbox' ) ?></a></p>

    </div>

  </div><!--/.post-inner-->
</article>
