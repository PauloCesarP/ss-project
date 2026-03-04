<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'case_studies_carousel') :
            $fields = $block['fields'] ?? [];
            $label = $fields['label'] ?? 'Case Studies';
            $headline = $fields['headline'] ?? '';
            $description = $fields['description'] ?? '';
            $source = $fields['source'] ?? 'manual';
            
            // Get case studies based on source
            $case_studies = [];
            
            if ($source === 'manual') {
                // Use manually selected projects
                $manual_projects = $fields['manual_projects'] ?? [];
                if (!empty($manual_projects)) {
                    $case_studies = $manual_projects;
                }
            } else {
                // Automatic: query posts
                $auto_count = $fields['auto_count'] ?? 6;
                
                $args = [
                    'post_type' => 'case_studies',
                    'posts_per_page' => !empty($auto_count) ? (int)$auto_count : -1,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'no_found_rows' => true,
                    'ignore_sticky_posts' => true
                ];
                
                $query = new WP_Query($args);
                
                if ($query->have_posts()) {
                    $case_studies = $query->posts;
                }
                wp_reset_postdata();
            }
        endif;
    endforeach;
?>

<section id="case-studies-carousel" class="relative bg-[#f6f6f6] py-[56px] md:py-[120px] md:px-0 overflow-hidden">
    
    <!-- Container with max-width -->
    <div class="content mx-auto px-4">
        
        <!-- Header Section -->
        <div class="flex flex-col gap-8 md:gap-[56px] w-full">
            
            <!-- Title & Description Container -->
            <div class="flex flex-col gap-4 md:gap-8 w-full md:max-w-[656px]">
                
                <!-- Label & Headline -->
                <div class="flex flex-col gap-4">
                    
                    <?php if (!empty($headline)): ?>
                        <h2 class="font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[120%] tracking-[-0.44px] text-blue-950 text-left">
                            <?php echo htmlspecialchars_decode($headline); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($label)): ?>
                        <p class="order-first font-medium text-[12px] md:text-[16px] leading-[150%] tracking-[-0.132px] md:tracking-[-0.176px] text-blue-500 text-left">
                            <?php echo esc_html($label); ?>
                        </p>
                    <?php endif; ?>

                </div>
                
                <!-- Description -->
                <?php if (!empty($description)): ?>
                    <p class="font-normal text-[14px] md:text-[16px] leading-[150%] tracking-[-0.154px] md:tracking-[-0.176px] text-[#313131] text-left">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Cards Section - Full Width on Desktop -->
    <div class="mx-auto px-4 flex flex-col gap-8 mt-8 md:mt-[56px]">
        
        <!-- Carousel Container -->
        <div class="relative overflow-x-auto scrollbar-hide md:pl-[calc((100vw-1360px)/2)] -mx-4 px-4 md:mx-0 md:pr-0" id="case-studies-scroll">
            <div class="flex gap-4 md:gap-4 pb-4 snap-x snap-mandatory">
                
                <?php if (!empty($case_studies) && is_array($case_studies)): ?>
                    <?php foreach ($case_studies as $index => $post): 
                                setup_postdata($post);
                                $post_id = $post->ID;
                                $image = get_the_post_thumbnail_url($post_id, 'full');
                                $image_alt = get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
                                $categories = wp_get_post_terms($post_id, 'service_category', ['fields' => 'names']);
                                $title = get_the_title($post_id);
                                $excerpt = get_the_excerpt($post_id);
                                $link_url = get_permalink($post_id);
                            ?>
                            
                            <!-- Case Study Card -->
                            <div class="flex-shrink-0 w-[calc(100vw-32px)] md:w-[656px] snap-start">
                                <div class="relative h-[544px] rounded-[24px] border-[0.25px] border-[#cccdcb] md:border-[#e5e6e5] overflow-hidden group hover:shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)] transition-shadow duration-300">
                                    
                                    <!-- Background Image -->
                                    <?php if (!empty($image)): ?>
                                        <img 
                                            src="<?php echo esc_url($image); ?>"
                                            alt="<?php echo esc_attr($image_alt ?: $title); ?>"
                                            class="absolute inset-0 w-full h-full object-cover rounded-[24px]"
                                        >
                                    <?php endif; ?>
                                    
                                    <!-- Content Container (positioned at bottom) -->
                                    <div class="absolute inset-0 flex flex-col justify-between p-4">
                                        
                                        <!-- Category Tags (top) -->
                                        <?php if (!empty($categories) && is_array($categories)): ?>
                                            <div class="flex gap-2 flex-wrap">
                                                <?php foreach ($categories as $category): ?>
                                                    <div class="bg-blue-100 backdrop-blur-sm rounded-[72px] px-3 py-1">
                                                        <span class="font-satoshi font-normal text-[12px] md:text-[14px] leading-[150%] tracking-[-0.154px] text-blue-950">
                                                            <?php echo esc_html($category); ?>
                                                        </span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Card Content (bottom) -->
                                        <div class="bg-[rgba(240,247,255,0.90)] backdrop-blur-[2px] border-[0.5px] border-blue-100 rounded-[16px] p-6 md:p-8 flex flex-col gap-4">
                                            
                                            <!-- Title & Excerpt -->
                                            <div class="flex flex-col gap-4">
                                                <?php if (!empty($title)): ?>
                                                    <h3 class="font-normal text-[16px] md:text-[20px] leading-[130%] tracking-[-0.176px] md:tracking-[-0.22px] text-neutral-950 line-clamp-2 md:line-clamp-1">
                                                        <?php echo htmlspecialchars_decode($title); ?>
                                                    </h3>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($excerpt)): ?>
                                                    <p class="font-normal text-[14px] md:text-[16px] leading-[150%] tracking-[-0.154px] md:tracking-[-0.176px] text-neutral-600 line-clamp-2">
                                                        <?php echo esc_html($excerpt); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Read Button -->
                                            <div class="flex justify-end">
                                                <a href="<?php echo esc_url($link_url); ?>" 
                                                   class="flex items-center gap-3 group/btn hover:gap-4 transition-all">
                                                    <span class="font-medium text-[12px] md:text-[16px] leading-[150%] tracking-[-0.132px] md:tracking-[-0.176px] text-neutral-950">
                                                        Read
                                                    </span>
                                                    <svg width="7.4" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                                        <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" fill="#0d0d0d"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                    <?php endforeach; wp_reset_postdata(); ?>
                <?php endif; ?>
                
            </div>
        </div>
        
        <!-- Progress Bar & Navigation -->
        <div class="content mx-auto px-4 w-full">
            <div class="flex items-center gap-6 h-[40px] w-full">
                
                <!-- Progress Bar -->
                <div class="flex-1 flex items-center relative">
                    <div class="absolute inset-0 h-1 bg-[#cccdcb] rounded-[48px]"></div>
                    <div class="h-[8px] bg-[#053169] rounded-[48px] absolute transition-all duration-300 w-[72.483px] md:w-[208px] left-0 top-[-2.2px]" id="progress-bar"></div>
                </div>
                
                <!-- Navigation Arrows -->
                <div class="flex gap-2">
                    <button 
                        id="prev-btn" 
                        aria-label="Previous slide"
                        class="w-10 h-10 cursor-pointer flex items-center justify-center rounded-full bg-[#D6E9FF] text-[#053169] border-[#D6E9FF] border hover:border-[#053169] hover:bg-[#053169] hover:text-white transition-colors group disabled:opacity-30 disabled:cursor-not-allowed">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="rotate-180">
                            <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" class="fill-[#053169] group-hover:fill-white"/>
                        </svg>
                    </button>
                    <button 
                        id="next-btn" 
                        aria-label="Next slide"
                        class="w-10 h-10 cursor-pointer flex items-center justify-center rounded-full bg-[#D6E9FF] text-[#053169] border border-[#D6E9FF] hover:border-[#053169] hover:bg-[#053169] hover:text-white transition-colors group disabled:opacity-30 disabled:cursor-not-allowed">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" class="fill-[#053169] group-hover:fill-white"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    
</section>

<?php endif; ?>