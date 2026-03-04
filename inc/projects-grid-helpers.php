<?php
/**
 * Helper Functions for Projects Grid Block
 *
 * @package SS_Project
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Parse and validate projects grid settings from ACF fields
 *
 * @param array $fields ACF fields array
 * @return array Parsed settings with defaults
 */
function ss_parse_projects_grid_settings($fields) {
    return [
        'show_all_tab'          => $fields['show_all_tab'] ?? false,
        'all_tab_label'         => $fields['all_tab_label'] ?? __('All', 'ss-project'),
        'which_taxonomy_to_use' => $fields['which_taxonomy_to_use'] ?? [],
        'source'                => $fields['source'] ?? 'automatic',
        'manual_projects'       => $fields['manual_projects'] ?? [],
        'auto_count'            => absint($fields['auto_count'] ?? 6),
        'columns'               => $fields['columns'] ?? '3',
        'show_pagination'       => $fields['show_pagination'] ?? false,
    ];
}

/**
 * Build WP_Query arguments for projects grid
 *
 * @param array $settings Grid settings
 * @return WP_Query Query object
 */
function ss_get_projects_query($settings) {
    $query_args = [
        'post_type'      => 'case_studies',
        'post_status'    => 'publish',
        'no_found_rows'  => false,
    ];

    switch ($settings['source']) {
        case 'manual':
            // Manual: Display posts based on manual selection or taxonomies
            if (!empty($settings['manual_projects'])) {
                // If manual posts are selected, use them
                $post_ids = array_map(function($post) {
                    return is_object($post) ? $post->ID : absint($post);
                }, $settings['manual_projects']);
                
                // If taxonomies are selected, filter manual posts by those taxonomies first
                if (!empty($settings['which_taxonomy_to_use'])) {
                    $term_ids = array_map(function($term) {
                        return is_object($term) && isset($term->term_id) ? $term->term_id : absint($term);
                    }, $settings['which_taxonomy_to_use']);
                    
                    // Pre-filter posts by taxonomy before applying post__in
                    $filtered_query = new WP_Query([
                        'post_type'      => 'case_studies',
                        'post_status'    => 'publish',
                        'post__in'       => $post_ids,
                        'fields'         => 'ids',
                        'posts_per_page' => -1,
                        'tax_query'      => [[
                            'taxonomy' => 'service_category',
                            'field'    => 'term_id',
                            'terms'    => $term_ids,
                            'operator' => 'IN',
                        ]],
                    ]);
                    
                    $post_ids = $filtered_query->posts;
                }
                
                // Paginate the post IDs array manually
                $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
                $per_page = $settings['auto_count'];
                $offset = ($paged - 1) * $per_page;
                $paginated_ids = array_slice($post_ids, $offset, $per_page);
                
                // Store total for later calculation
                $total_posts = count($post_ids);
                
                $query_args['post__in']       = !empty($paginated_ids) ? $paginated_ids : [0];
                $query_args['orderby']        = 'post__in';
                $query_args['posts_per_page'] = $per_page;
                $query_args['paged']          = $paged;
                
                // Force found_posts for pagination calculation
                add_filter('found_posts', function($found_posts, $query) use ($total_posts) {
                    if ($query->get('post_type') === 'case_studies' && $query->get('orderby') === 'post__in') {
                        return $total_posts;
                    }
                    return $found_posts;
                }, 10, 2);
            } elseif (!empty($settings['which_taxonomy_to_use'])) {
                // If no manual posts but taxonomies are selected, show all posts from those taxonomies
                $query_args['posts_per_page'] = $settings['auto_count'];
                $query_args['orderby']        = 'date';
                $query_args['order']          = 'DESC';
                
                $term_ids = array_map(function($term) {
                    return is_object($term) && isset($term->term_id) ? $term->term_id : absint($term);
                }, $settings['which_taxonomy_to_use']);
                
                $query_args['tax_query'] = [[
                    'taxonomy' => 'service_category',
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                    'operator' => 'IN',
                ]];
            }
            break;

        case 'filtered':
            // Filtered: Display manually selected posts with filtering
            $query_args['posts_per_page'] = $settings['auto_count'];
            $query_args['orderby']        = 'date';
            $query_args['order']          = 'DESC';
            
            // If manual posts are selected in filtered mode, use them
            if (!empty($settings['manual_projects'])) {
                $post_ids = array_map(function($post) {
                    return is_object($post) ? $post->ID : absint($post);
                }, $settings['manual_projects']);
                
                $query_args['post__in'] = $post_ids;
                $query_args['orderby']  = 'post__in';
            } elseif (!empty($settings['which_taxonomy_to_use'])) {
                // If no manual posts, use taxonomy filter
                $term_ids = array_map(function($term) {
                    return is_object($term) && isset($term->term_id) ? $term->term_id : absint($term);
                }, $settings['which_taxonomy_to_use']);
                
                $query_args['tax_query'] = [[
                    'taxonomy' => 'service_category',
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                    'operator' => 'IN',
                ]];
            }
            break;

        case 'automatic':
        default:
            // Automatic: Display all posts from all taxonomy terms
            $query_args['posts_per_page'] = $settings['auto_count'];
            $query_args['orderby']        = 'date';
            $query_args['order']          = 'DESC';
            break;
    }

    return new WP_Query($query_args);
}

/**
 * Get grid columns CSS class based on columns setting
 *
 * @param string $columns Number of columns ('2' or '3')
 * @return string Tailwind CSS class
 */
function ss_get_grid_columns_class($columns) {
    return $columns === '2' ? 'lg:grid-cols-2' : 'lg:grid-cols-3';
}

/**
 * Check if category tabs should be displayed
 *
 * @param array $settings Grid settings
 * @return bool
 */
function ss_should_show_category_tabs($settings) {
    // Show tabs if show_all_tab is true OR which_taxonomy_to_use has items
    // Works for all modes including manual (for filtering within manual selection)
    return $settings['show_all_tab'] || !empty($settings['which_taxonomy_to_use']);
}

/**
 * Get filtered taxonomy terms
 *
 * @param array $term_ids Optional array of term IDs or term objects to filter by
 * @return array|WP_Error Array of term objects
 */
function ss_get_filtered_terms($term_ids = []) {
    $args = [
        'taxonomy'   => 'service_category',
        'hide_empty' => false,
    ];
    
    if (!empty($term_ids) && is_array($term_ids)) {
        // Convert term objects to IDs if needed
        $ids = array_map(function($term) {
            return is_object($term) && isset($term->term_id) ? $term->term_id : absint($term);
        }, $term_ids);
        $args['include'] = $ids;
    }
    
    return get_terms($args);
}

/**
 * Render category filter tabs
 *
 * @param array $terms Array of term objects
 * @param bool $show_all_tab Whether "All" tab is shown
 * @param int $posts_per_page Posts per page for AJAX
 * @return string HTML output
 */
function ss_render_category_tabs($terms, $show_all_tab, $posts_per_page = 6) {
    if (empty($terms) || is_wp_error($terms)) {
        return '';
    }
    
    ob_start();
    
    $first_term = true;
    foreach ($terms as $term) {
        $is_active = !$show_all_tab && $first_term;
        $first_term = false;
        
        $classes = 'category-tab px-4 pb-2 font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] transition-all';
        $classes .= $is_active ? ' font-bold text-blue-950' : ' font-normal text-neutral-600 hover:text-blue-950';
        ?>
        <a href="#" 
           class="<?php echo esc_attr($classes); ?>"
           data-term-slug="<?php echo esc_attr($term->slug); ?>"
           data-term-id="<?php echo esc_attr($term->term_id); ?>"
           data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>">
            <?php echo esc_html($term->name); ?>
        </a>
        <?php
    }
    
    return ob_get_clean();
}

/**
 * Check if Load More button should be displayed
 *
 * @param array $settings Grid settings
 * @param WP_Query $query Query object
 * @return bool
 */
function ss_should_show_load_more($settings, $query) {
    // Show Load More for all modes when pagination is disabled
    return !$settings['show_pagination'] 
           && in_array($settings['source'], ['manual', 'filtered', 'automatic'])
           && $query->max_num_pages > 1;
}

/**
 * Check if WordPress pagination should be displayed
 *
 * @param array $settings Grid settings
 * @param WP_Query $query Query object
 * @return bool
 */
function ss_should_show_pagination($settings, $query) {
    // Show pagination for all modes when enabled
    return $settings['show_pagination'] 
           && in_array($settings['source'], ['manual', 'filtered', 'automatic'])
           && $query->max_num_pages > 1;
}

/**
 * Render a single project card
 *
 * @param int $post_id Post ID
 */
function ss_render_project_card($post_id) {
    $categories = wp_get_post_terms($post_id, 'service_category', [
        'orderby' => 'term_id',
        'order'   => 'ASC',
    ]);
    $categories = is_array($categories) ? $categories : [];
    $excerpt = get_the_excerpt($post_id);
    ?>
    <article class="flex flex-col gap-2 items-start justify-end overflow-hidden p-4 relative rounded-[24px] h-144 group">
        
        <!-- Background Layer (Gradient + Image) -->
        <div aria-hidden="true" class="absolute inset-0 pointer-events-none rounded-[24px]">
            <div class="absolute bg-gradient-to-b from-[#f4f4f4] to-[#8e8e8e] inset-0 rounded-[24px]"></div>
            <?php if (has_post_thumbnail($post_id)) : ?>
                <?php echo get_the_post_thumbnail($post_id, 'large', [
                    'class' => 'absolute max-w-none object-cover rounded-[24px] w-full h-full'
                ]); ?>
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
                    <?php echo esc_html(get_the_title($post_id)); ?>
                </h2>
                <p class="font-inter font-normal text-[#666765] text-[16px] leading-[1.5] tracking-[-0.176px] line-clamp-2">
                    <?php echo esc_html(wp_trim_words($excerpt, 15, '...')); ?>
                </p>
            </div>
            
            <!-- Card Footer -->
            <div class="flex flex-col items-end w-full">
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" 
                   class="flex items-center justify-center gap-3 group-hover:gap-4 transition-all"
                   aria-label="<?php echo esc_attr(sprintf(__('Read %s', 'ss-project'), get_the_title($post_id))); ?>">
                    <span class="font-inter font-bold text-[#313131] text-[16px] text-center leading-[1.5] tracking-[-0.176px] whitespace-nowrap">
                        <?php esc_html_e('Read', 'ss-project'); ?>
                    </span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0" aria-hidden="true">
                        <path d="M16.01 11H4V13H16.01V16L20 12L16.01 8V11Z" fill="#313131"/>
                    </svg>
                </a>
            </div>
            
        </div>
        
    </article>
    <?php
}

/**
 * Render project card for AJAX responses
 * Used by both filter and load more handlers
 *
 * @param int $post_id Post ID
 * @return string HTML output
 */
function ss_render_project_card_ajax($post_id) {
    ob_start();
    ss_render_project_card($post_id);
    return ob_get_clean();
}
