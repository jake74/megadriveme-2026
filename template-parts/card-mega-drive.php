<div class="md-cover game-cover">

  <?php the_post_thumbnail( 'md_cover', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>

  <header class="entry-header">
    <?php
    the_title( '<p class="entry-title">', '</p>' );

    if ( 'post' === get_post_type() ) :
      ?>
      <div class="entry-meta">
        <?php
        megadriveme2020_posted_on();
        megadriveme2020_posted_by();
        ?>
      </div>
    <?php endif; ?>
  </header>
</div>