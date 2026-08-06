<?php
$post_type = get_post_type();
// echo $post_type;

$post_type_labels = get_post_type_object(get_post_type())->labels->menu_name;
?>

<?php if ($post_type === 'mega-drive') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-md game-cover" data-post-type="<?php echo $post_type_labels; ?>">
    <?php the_post_thumbnail( 'showcase', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php
      the_title( '<p class="entry-title">', '</p>' ); ?>
    </div>
  </a>
<?php elseif ($post_type === 'mega-cd') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-mega-cd game-cover" data-post-type="<?php echo $post_type_labels; ?>">
    <?php the_post_thumbnail( 'showcase_cd', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php the_title( '<p class="entry-title">', '</p>' );?>
    </div>
  </a>
<?php elseif ($post_type === '32x') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-32x game-cover" data-post-type="<?php echo $post_type_labels; ?>">
    <?php the_post_thumbnail( 'showcase', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php the_title( '<p class="entry-title">', '</p>' );?>
    </div>
  </a>
<?php elseif ($post_type === 'hardware') : ?>
  <a href="<?php the_permalink(); ?>" class="cover-hardware game-cover" data-post-type="<?php echo $post_type; ?>">
    <?php the_post_thumbnail( 'showcase', array( 'alt' => the_title_attribute( array( 'echo' => false, ) ), ) ); ?>
    <div class="entry-header">
      <?php the_title( '<p class="entry-title">', '</p>' );?>
    </div>
  </a>
<?php endif; ?>
      