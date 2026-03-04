<?php

get_header(); ?>

<div class="mainContent">
    <?php
    // Display Blocks using ACF Flexible Content
    if (function_exists('acf_add_local_field_group')) :
        if (have_rows('blocks')) :
            while (have_rows('blocks')) : the_row();
                get_template_part('template-parts/blocks/' . get_row_layout(), null, ['page_id' => get_the_ID()]);
            endwhile;
        endif;
    
        // Display Page Content
        while (have_posts()) : the_post();
            if (get_the_content()) : ?>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            <?php endif;
        endwhile;
    endif;
    ?>
</div>


<?php get_footer(); ?>