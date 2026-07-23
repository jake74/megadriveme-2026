<?php
	$image_or_video = get_field( 'image_or_video' );

    if ($image_or_video == 'image') {
        $hero_image = get_field( 'hero_image' );
    }

    if ($image_or_video == 'video') {
        $hero_video = get_field( 'hero_video' );
    }

    if ($image_or_video == 'slideshow') {

    }

?>

<?php if ( ($image_or_video == 'image') && ($hero_image != '') ) : ?>
	<div class="header-banner">
		<img src="<?php echo $hero_image['sizes']['hero-xl']; ?>" class="hero-image" alt="<?php echo $hero_image['alt']; ?>">
	</div>
<?php elseif ( ($image_or_video == 'image') && ($hero_video != '') ) : ?>
	<div class="header-banner">
        <video playsinline autoplay muted loop class="hero-video">
            <source src="<?php echo $hero_video; ?>" type="video/mp4">
        </video>
	</div>
<?php endif; ?>