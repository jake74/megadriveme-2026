<?php
$post_type = get_post_type();

if ($post_type === 'mega-drive') {
  $showcase_photos = 'mega_drive_showcase';
} elseif ($post_type === 'mega-cd') {
  $showcase_photos = 'mega_cd_showcase';
} elseif ($post_type === '32x') {
  $showcase_photos = '32x_showcase';
} else {
  $showcase_photos = 'showcase_all';
}

$image_size = 'showcase';

if ($post_type === 'mega-cd') {
  $image_size = 'showcase_cd';
}

?>

<div class="showcase aside <?php echo $post_type; ?>">
  <div class="showcase-content">
    
    <div class="swiper-wrapper">
      <?php 
        $showcase = get_field( $showcase_photos, 'options');
        if($showcase) :
          //randomise the showcase
          shuffle( $showcase );

          foreach($showcase as $row) :
            $image = $row['image'];
            $game_link = $row['game_link'];
            $link = '';

            if ($game_link != '') {
              $link = $game_link['url'];
            }

            // $alt = $image['alt'];

            // if ($alt == '') {
            //   $alt = $image['title'];
            // }

            // print_r($image);
            // echo $image['id'];
        ?>
        <div class="swiper-slide">
          <?php if($link) : ?><a href="<?php echo $link; ?>"><?php endif; ?>
            <?php echo wp_get_attachment_image( $image['ID'], $image_size, false, array( 'loading' => 'lazy' ) ); ?>
          <?php if($link) : ?></a><?php endif; ?>
        </div>
        <?php 
          endforeach;?>
      <?php endif; ?>
    </div>
  </div>
</div>