<?php
/**
 * Case studies single template file.
 */
get_header();

// Get ACF fields for the case study.
$case_study_fields = get_fields();
?>



<div id="case-study-single" class="content py-8 md:py-22 mx-auto">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs flex flex-col items-start mb-8">
        <a href="<?php echo esc_url( get_permalink( get_page_by_title( 'Projects' ) ) ); ?>" class="flex gap-3 items-center justify-center group">
            <div class="flex items-center justify-center">
                <svg width="7.4" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="rotate-180">
                    <path d="M2 2L6 6L2 10" stroke="#053169" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span class="font-medium text-[12px] md:text-[16px] leading-normal text-[#053169] text-center whitespace-nowrap tracking-[-0.132px] md:tracking-[-0.176px] group-hover:opacity-80">
                <?php echo esc_html__('Back to Case Studies', 'ss-project'); ?>
            </span>
        </a>
    </div>
    <?php if ( $case_study_fields !== false ) : ?>
    <!-- Case Study Content -->
    <div class="case-study-content flex flex-col gap-8 lg:flex-row lg:gap-[88px]">
        <!-- Project Details Left Side -->
        <div class="lg:block w-full lg:w-[432px]">
            <div class="flex flex-col gap-4 md:gap-8 bg-blue-50 rounded-[28px] py-8 px-8">
                <h2 class="font-normal text-blue-950 text-[24px] leading-[1.4] tracking-[-0.264px] md:text-[30px] md:tracking-[-0.33px] lg:text-[32px] lg:tracking-[-0.352px]">
                    <?php echo esc_html__('Project Details', 'ss-project'); ?>
                </h2>
                <div class="flex flex-col gap-4">
                    <!-- Project Details -->
                    <?php if ( ! empty( $case_study_fields['sidebar_details'] ) ) : 
                        $sidebar_details = $case_study_fields['sidebar_details'];
                    ?>
                        <div class="flex flex-col gap-4">
                            <?php if ( ! empty( $sidebar_details['category'] ) ) : ?>
                                <p class="text-[14px] lg:text-[18px] leading-normal lg:leading-[1.4] tracking-[-0.154px] lg:tracking-[-0.198px] text-[#4c4d4c]">
                                    <span><?php echo esc_html__('Category:', 'ss-project'); ?></span>
                                    <span class="font-bold"><?php echo esc_html( $sidebar_details['category'] ); ?></span>
                                </p>
                            <?php endif; ?>
    
                            <?php if ( ! empty( $sidebar_details['service_area'] ) ) : ?>
                                <p class="text-[14px] lg:text-[18px] leading-normal lg:leading-[1.4] tracking-[-0.154px] lg:tracking-[-0.198px] text-[#4c4d4c]">
                                    <span><?php echo esc_html__('Service Area:', 'ss-project'); ?></span>
                                    <span class="font-bold"><?php echo esc_html( $sidebar_details['service_area'] ); ?></span>
                                </p>
                            <?php endif; ?>
    
                            <?php if ( ! empty( $sidebar_details['technologies'] ) ) : ?>
                                <p class="text-[14px] lg:text-[18px] leading-normal lg:leading-[1.4] tracking-[-0.154px] lg:tracking-[-0.198px] text-[#4c4d4c]">
                                    <span><?php echo esc_html__('Technologies Used:', 'ss-project'); ?></span>
                                    <span class="font-bold"><?php echo esc_html( $sidebar_details['technologies'] ); ?></span>
                                </p>
                            <?php endif; ?>
    
                            <?php if ( ! empty( $sidebar_details['duration'] ) ) : ?>
                                <p class="text-[14px] lg:text-[18px] leading-normal lg:leading-[1.4] tracking-[-0.154px] lg:tracking-[-0.198px] text-[#4c4d4c]">
                                    <span><?php echo esc_html__('Duration:', 'ss-project'); ?></span>
                                    <span class="font-bold"><?php echo esc_html( $sidebar_details['duration'] ); ?></span>
                                </p>
                            <?php endif; ?>
    
                            <?php if ( ! empty( $sidebar_details['location'] ) ) : ?>
                                <p class="text-[14px] lg:text-[18px] leading-normal lg:leading-[1.4] tracking-[-0.154px] lg:tracking-[-0.198px] text-[#4c4d4c]">
                                    <span><?php echo esc_html__('Location:', 'ss-project'); ?></span>
                                    <span class="font-bold"><?php echo esc_html( $sidebar_details['location'] ); ?></span>
                                </p>
                            <?php endif; ?>

                            <!-- Custom Content -->
                            <?php if ( ! empty( $sidebar_details['custom_content'] ) ) : ?>
                                <div class="flex flex-col gap-4">
                                    <?php foreach ( $sidebar_details['custom_content'] as $custom_block ) : ?>
                                        <div class="flex flex-col gap-2">
                                            <?php if ( ! empty( $custom_block['label'] ) && ! empty( $custom_block['content'] ) ) : ?>
                                                <p class="text-[14px] lg:text-[18px] leading-normal lg:leading-[1.4] tracking-[-0.154px] lg:tracking-[-0.198px] text-[#4c4d4c]">
                                                    <span><?php echo esc_html( $custom_block['label'] . ':' ); ?></span>
                                                    <span class="font-bold"><?php echo esc_html( $custom_block['content'] ); ?></span>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex-1 pb-8 lg:pb-0">
            <div class="flex flex-col gap-8 lg:gap-14">
                <!-- Top Section (Header) -->
                <div class="flex flex-col gap-[24px]">
                    <!-- get taxonomies from single post and show them -->
                     <ul class="flex gap-[8px] flex-wrap mb-4">
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'service_category' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                            foreach ( $terms as $term ) : ?>
                                <li class="inline-flex items-center justify-center px-[16px] py-[4px] bg-[#d6e9ff] border-[0.5px] border-[#b8d9ff] rounded-[40px] w-fit">
                                    <p class="text-[14px] leading-[1.5] tracking-[-0.154px] text-[#0a5bb3] whitespace-nowrap">
                                        <?php echo esc_html( $term->name ); ?>
                                    </p>
                                </li>
                            <?php endforeach;
                        endif;
                        ?>
                    </ul>

                    <div class="flex flex-col gap-[16px] mb-6">
                        <h1 class="font-normal text-[32px] leading-[1.2] lg:text-[40px] tracking-[-0.352px] lg:tracking-[-0.44px] text-[#053169]">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                    
                    <p class="font-normal text-[18px] leading-[1.4] tracking-[-0.198px] text-[#313131]">
                        <?php echo esc_html( get_the_content() ); ?>
                    </p>
                    
                </div>

                <!-- Main Content Section -->
                <div class="flex flex-col gap-8">
                    <!-- The Client -->
                    <?php if ( ! empty( $case_study_fields['the_client'] ) ) : ?>
                        <div class="flex flex-col gap-4">
                            <h2 class="font-normal text-base lg:text-[20px] leading-[1.3] tracking-[-0.176px] lg:tracking-[-0.22px] text-blue-950">
                                <?php echo esc_html__( 'The Client', 'ss-project' ); ?>
                            </h2>
                            <div class="text-[16px] leading-normal tracking-[-0.176px] text-neutral-600">
                                <?php echo wp_kses_post( $case_study_fields['the_client'] ); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- The Challenge -->
                    <?php if ( ! empty( $case_study_fields['the_challenge'] ) ) : ?>
                        <div class="flex flex-col gap-4">
                            <h2 class="font-normal text-base lg:text-[20px] leading-[1.3] tracking-[-0.176px] lg:tracking-[-0.22px] text-blue-950">
                                <?php echo esc_html__( 'The Challenge', 'ss-project' ); ?>
                            </h2>
                            <div class="text-[16px] leading-normal tracking-[-0.176px] text-neutral-600">
                                <?php echo wp_kses_post( $case_study_fields['the_challenge'] ); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Content Image -->
                    <?php if ( ! empty( $case_study_fields['content_image'] ) ) : ?>
                        <div class="flex flex-col gap-2">
                            <div class="w-full h-98 rounded-3xl overflow-hidden">
                                <img 
                                    src="<?php echo esc_url( $case_study_fields['content_image']['url'] ); ?>" 
                                    alt="<?php echo esc_attr( $case_study_fields['content_image']['alt'] ); ?>" 
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <?php 
                            $image_text = ! empty($case_study_fields['content_image']['caption']) ? $case_study_fields['content_image']['caption'] : $case_study_fields['content_image']['alt']; ?>
                            <p class="text-[12px] lg:text-[14px] leading-normal tracking-[-0.154px] text-neutral-500">
                                <?php echo 'Image: ' . $image_text; ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- The Solution -->
                    <?php if ( ! empty( $case_study_fields['the_solution'] ) ) : ?>
                        <div class="flex flex-col gap-4">
                            <h2 class="font-normal text-base lg:text-[20px] leading-[1.3] tracking-[-0.176px] lg:tracking-[-0.22px] text-blue-950">
                                <?php echo esc_html__( 'The Solution', 'ss-project' ); ?>
                            </h2>
                            <div class="text-[16px] leading-normal tracking-[-0.176px] text-neutral-600 solution-content">
                                <?php echo wp_kses_post( $case_study_fields['the_solution'] ); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- The Outcome -->
                    <?php if ( ! empty( $case_study_fields['the_outcome'] ) ) : ?>
                        <div class="flex flex-col gap-4">
                            <h2 class="font-normal text-base lg:text-[20px] leading-[1.3] tracking-[-0.176px] lg:tracking-[-0.22px] text-blue-950">
                                <?php echo esc_html__( 'The Outcome', 'ss-project' ); ?>
                            </h2>
                            <div class="text-[16px] leading-normal tracking-[-0.176px] text-neutral-600 outcome-content">
                                <?php echo wp_kses_post( $case_study_fields['the_outcome'] ); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Custom Content -->
                    <?php if ( ! empty( $case_study_fields['custom_content'] ) ) : ?>
                        <div class="flex flex-col gap-8">
                            <?php foreach ( $case_study_fields['custom_content'] as $custom_block ) : ?>
                                <div class="flex flex-col gap-4">
                                    <?php if ( ! empty( $custom_block['label'] ) ) : ?>
                                        <h2 class="font-normal text-base lg:text-[20px] leading-[1.3] tracking-[-0.176px] lg:tracking-[-0.22px] text-blue-950">
                                            <?php echo esc_html( $custom_block['label'] ); ?>
                                        </h2>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $custom_block['content'] ) ) : ?>
                                        <div class="text-[16px] leading-normal tracking-[-0.176px] text-neutral-600">
                                            <?php echo wp_kses_post( $custom_block['content'] ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <!-- Additional Blocks Section -->
     <?php 
        if (function_exists('acf_add_local_field_group')) :
            if (have_rows('blocks')) :
                while (have_rows('blocks')) : the_row();
                    get_template_part('template-parts/blocks/' . get_row_layout(), null, ['page_id' => get_the_ID()]);
                endwhile;
            endif;
        endif;
    ?>
</div>


<?php get_footer(); ?>