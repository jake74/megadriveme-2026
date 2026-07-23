<?php if( have_rows('social_links', 'option') ):
    echo '<ul class="social-links">';

    while( have_rows('social_links', 'option') ): the_row();
        $service = get_sub_field('service');
        $icon = get_sub_field('icon');
        $url = get_sub_field('link');

        if ($icon != '') :
            echo '<li class="platform"><a href="' . $url . '">';
            echo '<img src="' . $icon['url'] . '" alt="' . $service . '" loading="lazy"><span>' . $service . '</span>';
            echo '</a></li>';
        endif;

    endwhile;
    echo '</ul>';
endif; ?>
