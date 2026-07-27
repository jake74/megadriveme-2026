<?php if (get_post_type() === 'mega-drive') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-md game-cover">
    <?php the_post_thumbnail( 'md_cover', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php
      the_title( '<p class="entry-title">', '</p>' ); ?>
    </div>
  </a>
<?php elseif (get_post_type() === 'mega-cd') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-mega-cd game-cover">
    <?php the_post_thumbnail( 'mcd_cover', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php the_title( '<p class="entry-title">', '</p>' );?>
    </div>
  </a>
<?php elseif (get_post_type() === '32x') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-32x game-cover">
    <?php the_post_thumbnail( 'md_cover', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php the_title( '<p class="entry-title">', '</p>' );?>
    </div>
  </a>
<?php elseif (get_post_type() === 'hardware') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-hardware game-cover">
    <?php the_post_thumbnail( 'md_cover', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php the_title( '<p class="entry-title">', '</p>' );?>
    </div>
  </a>
<?php endif; ?>
      