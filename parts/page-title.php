<?php if ( is_category() ): ?>
  <h1><span class="title-description"><?php _e('Category:','coldbox');?>&#32;</span><?php echo single_cat_title(); ?></h1>
  <?php if ( term_description() != '' ): ?>
    <div class="taxonomy-description">
      <?php echo term_description(); ?>
    </div>
  <?php endif; ?>


<?php elseif ( is_tag() ): ?>
  <h1><span class="title-description"><?php _e('Tag:','coldbox');?>&#32;</span><?php echo single_tag_title(); ?></h1>
  <?php if ( term_description() != '' ): ?>
    <div class="taxonomy-description">
      <?php echo term_description(); ?>
    </div>
  <?php endif; ?>


<?php elseif ( is_search() ): ?>
  <h1><span class="title-description"><?php _e('Search Results for:','coldbox');?>&#32;</span><?php the_search_query(); ?></h1>
    <div class="taxonomy-description">
      <?php get_search_form(); ?>
    </div>


  <?php elseif ( is_day() ): ?>
    <h1><span class="title-description"><?php _e('Daily Archive:','coldbox');?>&#32;</span><?php echo get_the_time('j F, Y'); ?></h1>


  <?php elseif ( is_month() ): ?>
    <h1><span class="title-description"><?php _e('Monthly Archive:','coldbox');?>&#32;</span><?php echo get_the_time('F, Y'); ?></h1>


  <?php elseif ( is_year() ): ?>
    <h1><span class="title-description"><?php _e('Yearly Archive:','coldbox');?>&#32;</span><?php echo get_the_time('Y') ?></h1>


  <?php elseif ( is_author() ): ?>
    <h1><span class="title-description"><?php _e('Author:','coldbox');?>&#32;</span><?php echo $author = get_the_author(); ?></h1>


  <?php elseif ( is_404() ): ?>
    <h1><span class="title-description"><?php _e('ERROR 404.','coldbox');?>&#32;</span><?php _e('Sorry, Page Not Found.','coldbox')?></h1>

  <?php endif; ?>
