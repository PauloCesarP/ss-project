<?php
/**
 * Template for Projects Grid Block
 * 
 * Displays a grid of case studies with optional filtering and pagination
 *
 * @package SS_Project
 */

// Get ACF fields
$fields = get_sub_field('fields') ?? [];

// Parse block settings
$settings = ss_parse_projects_grid_settings($fields);

// Build and execute query
$projects_query = ss_get_projects_query($settings);

// Determine grid layout class
$grid_class = ss_get_grid_columns_class($settings['columns']);
?>

<!-- Case Study Cards Block -->
    <section class="w-full 
                   py-12
                   sm:py-12
                   md:py-12
                   lg:py-[60px]
                   xl:py-[60px]">
        
        <!-- Categories Filter -->
        <div class="content mb-8">
            <?php if (ss_should_show_category_tabs($settings)) : 
                // Get terms based on source mode
                if ($settings['source'] === 'automatic' || $settings['source'] === 'filtered') {
                    // Automatic or Filtered mode: show ALL categories
                    $terms = ss_get_filtered_terms([]);
                } else {
                    // Manual mode: show only selected categories
                    $terms = ss_get_filtered_terms($settings['which_taxonomy_to_use']);
                }
            ?>
                <!-- Tabs -->
                <div class="flex flex-wrap gap-4 mb-2" id="category-tabs"
                     data-source="<?php echo esc_attr($settings['source']); ?>"
                     data-manual-posts="<?php echo esc_attr(json_encode(!empty($settings['manual_projects']) && is_array($settings['manual_projects']) ? array_map(function($post) { return is_object($post) ? $post->ID : absint($post); }, $settings['manual_projects']) : [])); ?>"
                     data-taxonomy-ids="<?php echo esc_attr(json_encode(!empty($settings['which_taxonomy_to_use']) && is_array($settings['which_taxonomy_to_use']) ? array_map(function($term) { return is_object($term) && isset($term->term_id) ? $term->term_id : absint($term); }, $settings['which_taxonomy_to_use']) : [])); ?>">
                    <?php if ($settings['show_all_tab']) : ?>
                        <a href="#" 
                           class="category-tab px-4 pb-2 font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] transition-all font-bold text-blue-950"
                           data-term-slug="all"
                           data-posts-per-page="<?php echo esc_attr($settings['auto_count']); ?>">
                            <?php echo esc_html($settings['all_tab_label']); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php 
                    foreach ($terms as $term) {
                        $is_active = !$settings['show_all_tab'];
                        $classes = 'category-tab px-4 pb-2 font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] transition-all';
                        $classes .= $is_active ? ' font-bold text-blue-950' : ' font-normal text-neutral-600 hover:text-blue-950';
                        $is_active = false; // Only first one active
                        ?>
                        <a href="#" 
                           class="<?php echo esc_attr($classes); ?>"
                           data-term-slug="<?php echo esc_attr($term->slug); ?>"
                           data-term-id="<?php echo esc_attr($term->term_id); ?>"
                           data-posts-per-page="<?php echo esc_attr($settings['auto_count']); ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full h-[2px] bg-neutral-300 rounded-full relative overflow-visible">
                    <div id="progress-bar" class="absolute h-[5px] bg-blue-900 rounded-full top-1/2 -translate-y-1/2 transition-all duration-300"
                         style="width: 0; left: 0;">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Posts Grid -->
        <?php if ($projects_query->have_posts()) : ?>
            <div class="content grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($grid_class); ?> gap-4" id="case-studies-grid">
                
                <?php while ($projects_query->have_posts()) : $projects_query->the_post(); 
                    $post_id = get_the_ID();
                    // Get all categories for this post
                    $categories = wp_get_post_terms($post_id, 'service_category', ['orderby' => 'term_id', 'order' => 'ASC']) ?? [];
                    $excerpt = get_the_excerpt($post_id);
                ?>
                    <article class="flex flex-col gap-2 items-start justify-end overflow-hidden p-4 relative rounded-[24px] h-144 group">
                        
                        <!-- Background Layer -->
                        <div aria-hidden="true" class="absolute inset-0 pointer-events-none rounded-[24px]">
                            <div class="absolute bg-gradient-to-b from-[#f4f4f4] to-[#8e8e8e] inset-0 rounded-[24px]"></div>
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', ['class' => 'absolute max-w-none object-cover rounded-[24px] w-full h-full']); ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Category Badges -->
                        <?php if (!empty($categories)) : ?>
                            <div class="absolute flex flex-wrap items-center gap-2 left-4 top-4 z-10">
                                <?php foreach ($categories as $category) : ?>
                                    <span class="inline-flex items-center justify-center px-4 py-1 bg-[#d6e9ff] border-[0.5px] border-solid border-[#b8d9ff] rounded-[40px]
                                                font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] text-[#0a5bb3] whitespace-nowrap">
                                        <?php echo esc_html($category->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Card Content -->
                        <div class="relative z-10 bg-white rounded-[24px] px-6 py-4 flex flex-col gap-4 w-full">
                            
                            <!-- Card Text -->
                            <div class="flex flex-col gap-2 w-full">
                                <h2 class="font-inter font-normal text-[#0d0d0d] text-[20px] leading-[1.3] tracking-[-0.22px] line-clamp-2 md:line-clamp-1">
                                    <?php the_title(); ?>
                                </h2>
                                <p class="font-inter font-normal text-[#666765] text-[16px] leading-[1.5] tracking-[-0.176px] line-clamp-2">
                                    <?php echo wp_trim_words($excerpt, 15, '...'); ?>
                                </p>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="flex flex-col items-end w-full">
                                <a href="<?php the_permalink(); ?>" 
                                   class="flex items-center justify-center gap-3 group-hover:gap-4 transition-all">
                                    <span class="font-inter font-bold text-[#313131] text-[16px] text-center leading-[1.5] tracking-[-0.176px] whitespace-nowrap">
                                        <?php echo __('Read', 'ss-project'); ?>
                                    </span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                        <path d="M16.01 11H4V13H16.01V16L20 12L16.01 8V11Z" fill="#313131"/>
                                    </svg>
                                </a>
                            </div>
                            
                        </div>
                        
                    </article>
                <?php endwhile; 
                wp_reset_postdata(); // Reset post data after custom query 
                ?>
                
            </div>
            
            <!-- Load More Button -->
            <?php if (ss_should_show_load_more($settings, $projects_query)) : ?>
                <div class="content mt-8 text-center">
                    <button id="load-more-btn" 
                            class="inline-flex items-center gap-3 bg-blue-950 hover:bg-blue-900 transition-colors px-6 py-3 rounded-full cursor-pointer"
                            data-page="1"
                            data-max-pages="<?php echo esc_attr($projects_query->max_num_pages); ?>"
                            data-posts-per-page="<?php echo esc_attr($settings['auto_count']); ?>">
                        <span class="font-medium text-neutral-50 text-[16px] leading-[1.5] tracking-[-0.176px]">
                            <?php echo __('Load More', 'ss-project'); ?>
                        </span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0 animate-spin hidden" id="load-more-spinner">
                            <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83" stroke="#f6f6f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
            
            <!-- WordPress Pagination -->
            <div class="content mt-8" id="pagination-container">
                <?php if (ss_should_show_pagination($settings, $projects_query)) : ?>
                    <nav class="flex justify-center items-center gap-2" aria-label="<?php esc_attr_e('Pagination Navigation', 'ss-project'); ?>">
                        <?php
                        $big = 999999999;
                        $current_page = max(1, get_query_var('paged'));
                        $pagination_links = paginate_links([
                            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format'    => '?paged=%#%',
                            'current'   => $current_page,
                            'total'     => $projects_query->max_num_pages,
                            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                            'next_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                            'type'      => 'array',
                        ]);
                        
                        if ($pagination_links) :
                            echo '<div class="flex items-center gap-2">';
                            foreach ($pagination_links as $link) {
                                $base_classes = 'inline-flex items-center justify-center min-w-[40px] h-[40px] px-3 rounded-lg border border-neutral-300 hover:border-blue-950 hover:bg-blue-950 hover:text-white transition-colors font-satoshi text-[14px] leading-[1.5]';
                                
                                // Check if it's the current page
                                if (strpos($link, 'current') !== false) {
                                    $link = str_replace('class="', 'class="' . $base_classes . ' bg-blue-950 text-white border-blue-950 ', $link);
                                    $link = str_replace('<span', '<span', $link);
                                } else {
                                    $link = str_replace('class="', 'class="' . $base_classes . ' ', $link);
                                }
                                
                                echo $link;
                            }
                            echo '</div>';
                        endif;
                        ?>
                    </nav>
                <?php endif; ?>
            </div>
            
        <?php else : ?>
            
            <!-- No Posts Found -->
            <div class="text-center py-12">
                <p class="text-neutral-600 text-[18px] leading-[1.5]">
                    <?php echo __('No case studies found.', 'ss-project'); ?>
                </p>
            </div>
            
        <?php endif; ?>
        
    </section>
<!-- End Case Study Cards Block -->