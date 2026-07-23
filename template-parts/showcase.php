<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Swiper === 'undefined') {
    return;
  }

  new Swiper('.showcase-content', {
    direction: 'horizontal',
    loop: true,
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    effect: 'fade',
    fadeEffect: {
      crossFade: true,
    },
  });
});
</script>

<div class="showcase">
  <div class="showcase-content">
    <div class="swiper-wrapper">
      <?php 
        $showcase = get_field( 'mega_drive_showcase', 'options');
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

            $alt = $image['alt'];

            if ($alt == '') {
              $alt = $image['title'];
            }
        ?>
        <div class="swiper-slide">
          <?php if($link) : ?><a href="<?php echo $link; ?>"><?php endif; ?>
            <?php echo wp_get_attachment_image( $image['ID'], 'large', false, array( 'alt' => $alt ) ); ?>
          <?php if($link) : ?></a><?php endif; ?>
        </div>
        <?php 
          endforeach;?>
      <?php endif; ?>
    </div>
  </div>
</div>