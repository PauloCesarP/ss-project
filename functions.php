<?php

if (is_file(__DIR__.'/vendor/autoload_packages.php')) {
    require_once __DIR__.'/vendor/autoload_packages.php';
}

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
                ->ssl(verify: false)
            )
            ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager->add(
            'primary', __( 'Primary Menu', 'tailpress' ),
            'footer-1', __( 'Footer Menu 1', 'tailpress' ),
            'footer-2', __( 'Footer Menu 2', 'tailpress' )
        ))
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

tailpress();

/**
 * Localize script for AJAX
 */
function ss_localize_scripts() {
    wp_localize_script('tailpress-app', 'ssAjax', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'filterNonce' => wp_create_nonce('case_studies_filter_nonce'),
        'loadMoreNonce' => wp_create_nonce('case_studies_load_more_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'ss_localize_scripts', 20);

/**
 * Include helper functions
 */
require_once get_template_directory() . '/inc/projects-grid-helpers.php';

/**
 * ACF Local JSON
 * Automatically save & load ACF fields from local JSON file
 */
add_filter('acf/settings/save_json', function() {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    // Remove original path
    unset($paths[0]);

    // Add our custom path
    $paths[] = get_template_directory() . '/acf-json';

    return $paths;
});

/**
 * Register navigation menus (fallback registration)
 */
function register_nav_menus_fallback() {
    register_nav_menus(array(
        'primary'  => __('Primary Menu', 'tailpress'),
        'footer-1' => __('Footer Menu 1', 'tailpress'),
        'footer-2' => __('Footer Menu 2', 'tailpress'),
    ));
}
add_action('after_setup_theme', 'register_nav_menus_fallback');

/**
 * Enable SVG uploads
 */
function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

/**
 * Fix SVG MIME type detection
 */
function fix_svg_mime_type($data, $file, $filename, $mimes) {
    $ext = isset($data['ext']) ? $data['ext'] : '';
    if (strlen($ext) < 1) {
        $exploded = explode('.', $filename);
        $ext = strtolower(end($exploded));
    }
    if ($ext === 'svg') {
        $data['type'] = 'image/svg+xml';
        $data['ext'] = 'svg';
    }
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 4);

/**
 * Add SVG support to media library
 */
function display_svg_in_media_library($response) {
    if ($response['mime'] === 'image/svg+xml') {
        $response['image'] = [
            'src' => $response['url'],
            'width' => 150,
            'height' => 150,
        ];
        $response['thumb'] = [
            'src' => $response['url'],
            'width' => 150,
            'height' => 150,
        ];
        $response['sizes']['thumbnail'] = [
            'height' => 150,
            'width' => 150,
            'url' => $response['url'],
            'orientation' => 'landscape',
        ];
    }
    return $response;
}
add_filter('wp_prepare_attachment_for_js', 'display_svg_in_media_library');

/**
 * Sanitize SVG uploads for security
 */
function sanitize_svg_upload($file) {
    if ($file['type'] === 'image/svg+xml') {
        if (!current_user_can('upload_files')) {
            $file['error'] = __('Sorry, you are not allowed to upload SVG files.');
            return $file;
        }
        
        $svg_content = file_get_contents($file['tmp_name']);
        
        // Basic security check - remove script tags and event handlers
        $svg_content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $svg_content);
        $svg_content = preg_replace('/on\w+="[^"]*"/i', '', $svg_content);
        $svg_content = preg_replace("/on\w+='[^']*'/i", '', $svg_content);
        
        file_put_contents($file['tmp_name'], $svg_content);
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'sanitize_svg_upload');

/**
 * Register Custom Post Types
 */
function register_custom_post_types() {
    
    // Case Studies Post Type
    register_post_type('case_studies', [
        'labels' => [
            'name' => __('Case Studies', 'ss-project'),
            'singular_name' => __('Case Study', 'ss-project'),
            'menu_name' => __('Case Studies', 'ss-project'),
            'add_new' => __('Add New', 'ss-project'),
            'add_new_item' => __('Add New Case Study', 'ss-project'),
            'edit_item' => __('Edit Case Study', 'ss-project'),
            'new_item' => __('New Case Study', 'ss-project'),
            'view_item' => __('View Case Study', 'ss-project'),
            'view_items' => __('View Case Studies', 'ss-project'),
            'search_items' => __('Search Case Studies', 'ss-project'),
            'not_found' => __('No case studies found', 'ss-project'),
            'not_found_in_trash' => __('No case studies found in trash', 'ss-project'),
            'all_items' => __('All Case Studies', 'ss-project'),
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'case-studies'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'],
    ]);

    // Services Post Type
    register_post_type('services', [
        'labels' => [
            'name' => __('Services', 'ss-project'),
            'singular_name' => __('Service', 'ss-project'),
            'menu_name' => __('Services', 'ss-project'),
            'add_new' => __('Add New', 'ss-project'),
            'add_new_item' => __('Add New Service', 'ss-project'),
            'edit_item' => __('Edit Service', 'ss-project'),
            'new_item' => __('New Service', 'ss-project'),
            'view_item' => __('View Service', 'ss-project'),
            'view_items' => __('View Services', 'ss-project'),
            'search_items' => __('Search Services', 'ss-project'),
            'not_found' => __('No services found', 'ss-project'),
            'not_found_in_trash' => __('No services found in trash', 'ss-project'),
            'all_items' => __('All Services', 'ss-project'),
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'services'],
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'],
    ]);

    // Team Post Type
    register_post_type('team', [
        'labels' => [
            'name' => __('Team', 'ss-project'),
            'singular_name' => __('Team Member', 'ss-project'),
            'menu_name' => __('Team', 'ss-project'),
            'add_new' => __('Add New', 'ss-project'),
            'add_new_item' => __('Add New Team Member', 'ss-project'),
            'edit_item' => __('Edit Team Member', 'ss-project'),
            'new_item' => __('New Team Member', 'ss-project'),
            'view_item' => __('View Team Member', 'ss-project'),
            'view_items' => __('View Team', 'ss-project'),
            'search_items' => __('Search Team', 'ss-project'),
            'not_found' => __('No team members found', 'ss-project'),
            'not_found_in_trash' => __('No team members found in trash', 'ss-project'),
            'all_items' => __('All Team Members', 'ss-project'),
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'team'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 22,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'excerpt', 'custom-fields', 'revisions'],
    ]);
}
add_action('init', 'register_custom_post_types');

/**
 * Flush rewrite rules on theme activation
 */
function flush_rewrite_rules_on_activation() {
    register_custom_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rewrite_rules_on_activation');


/**
 * Redirect single 'services' posts and archive to the services page
 */
add_action( 'template_redirect', function() {
    // Redirect archive page to Services page
    if ( is_post_type_archive( 'services' ) ) {
        wp_redirect( home_url( '/services' ), 301 );
        exit;
    }
    
    // Redirect single services posts to Services page
    if ( is_singular( 'services' ) ) {
        wp_redirect( home_url( '/services' ), 301 );
        exit;
    }
} );

/**
 * Display Footer Social Icons
 */
function display_footer_social_icons() {
    if ( function_exists('have_rows') && have_rows('social_links', 'option') ):
        if( have_rows('social_links', 'option') ):
            echo '<ul class="flex gap-4">';
                while ( have_rows('social_links', 'option') ) : the_row();
                    $network = get_sub_field('select_the_social_network');
                    $link = get_sub_field('social_network_link');
                    if( $link ):
                        $url = $link['url'];
                        $target = $link['target'] ? $link['target'] : '_self';
                        echo '<li>';
                        echo '<a href="' . esc_url($url) . '" target="' . esc_attr($target) . '" class="hover:opacity-75 transition-opacity duration-200">';
                        // Display SVG icon based on selected network
                        switch( $network ) {
                            case 'linkedin':
                                echo file_get_contents(get_template_directory() . '/resources/images/icons/linkedin.svg');
                                break;
                        }
                        echo '</a>';
                        echo '</li>';
                    endif;
                endwhile;
            echo '</ul>';
        endif;
    endif;
}

/**
 * Display Sidebar Contact Info 
 */
function display_sidebar_contact_info($page_id = null) {
    if (!function_exists('get_field')) {
        return [];
    }

    $page_id = $page_id ?: get_the_ID();
    $result = [];
    
    $blocks = get_field('blocks', $page_id);
    if ($blocks) {
        foreach ($blocks as $block) {
            if (($block['acf_fc_layout'] ?? '') === 'contact_form_split') {
                $fields = $block['fields'] ?? [];
                $contact_list = $fields['sidebar_contact_info'] ?? [];
                
                if ($contact_list) {
                    foreach ($contact_list as $contact_item) {
                        $type = $contact_item['type'] ?? '';
                        $label = $contact_item['label'] ?? '';
                        
                        if ($type && $label) {
                            // Determine icon path based on type
                            $icon_filename = '';
                            switch ($type) {
                                case 'phone':
                                    $icon_filename = 'icon-phone.svg';
                                    break;
                                case 'email':
                                    $icon_filename = 'icon-email.svg';
                                    break;
                                case 'address':
                                    $icon_filename = 'icon-location.svg';
                                    break;
                            }
                            
                            if ($icon_filename) {
                                $result[] = [
                                    'type' => $type,
                                    'label' => $label,
                                    'icon_path' =>  get_template_directory_uri() . '/resources/images/icons/' . $icon_filename
                                ];
                            }
                        }
                    }
                }
                break; // Found the contact_form_split block, exit loop
            }
        }
    }
    
    return $result;
}

/**
 * Display Footer Contact Info 
 * 
 */
function display_footer_contact_info() {
    if ( function_exists('get_field') ) :
        $contact_list = get_field('footer_contact_info', 'option');
        if ($contact_list):
            foreach ($contact_list as $contact_item):
                $type = $contact_item['type'];
                $label = $contact_item['label'];
                if ($type && $label):
                    // Determine icon based on type
                    $icon_path = '';
                    switch ($type) {
                        case 'phone':
                            $icon_path = get_template_directory() . '/resources/images/icons/icon-phone.svg';
                            break;
                        case 'email':
                            $icon_path = get_template_directory() . '/resources/images/icons/icon-email.svg';
                            break;
                        case 'address':
                            $icon_path = get_template_directory() . '/resources/images/icons/icon-location.svg';
                            break;
                    }

                    // Include template file footer-contact-item.php
                    set_query_var('icon_path', $icon_path);
                    set_query_var('label', $label);
                    get_template_part('template-parts/footer-contact-info');
                endif;
            endforeach;
        endif;
    endif;
    
    
}

// Disable Gutenberg Editor for all post types
add_filter('use_block_editor_for_post', '__return_false');

/**
 * AJAX Handler - Filter Case Studies by Category
 *
 * @since 1.0.0
 */
function ajax_filter_case_studies() {
    check_ajax_referer('case_studies_filter_nonce', 'nonce');
    
    $term_slug      = isset($_POST['term_slug']) ? sanitize_text_field($_POST['term_slug']) : '';
    $paged          = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? absint($_POST['posts_per_page']) : 6;
    $source         = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'automatic';
    $manual_posts   = isset($_POST['manual_posts']) ? json_decode(stripslashes($_POST['manual_posts']), true) : [];
    $taxonomy_ids   = isset($_POST['taxonomy_ids']) ? json_decode(stripslashes($_POST['taxonomy_ids']), true) : [];
    
    $query = ss_build_filtered_query($term_slug, $posts_per_page, $paged, $source, $manual_posts, $taxonomy_ids);
    
    $html = ss_generate_projects_html($query);
    $pagination = ss_generate_pagination_html($query, $paged);
    
    wp_send_json_success([
        'html'        => $html,
        'pagination'  => $pagination,
        'found_posts' => $query->found_posts,
        'max_pages'   => $query->max_num_pages,
    ]);
}
add_action('wp_ajax_filter_case_studies', 'ajax_filter_case_studies');
add_action('wp_ajax_nopriv_filter_case_studies', 'ajax_filter_case_studies');

/**
 * AJAX Handler - Load More Case Studies
 *
 * @since 1.0.0
 */
function ajax_load_more_case_studies() {
    check_ajax_referer('case_studies_load_more_nonce', 'nonce');
    
    $term_slug      = isset($_POST['term_slug']) ? sanitize_text_field($_POST['term_slug']) : '';
    $page           = isset($_POST['page']) ? absint($_POST['page']) : 2;
    $posts_per_page = isset($_POST['posts_per_page']) ? absint($_POST['posts_per_page']) : 6;
    $source         = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'automatic';
    $manual_posts   = isset($_POST['manual_posts']) ? json_decode(stripslashes($_POST['manual_posts']), true) : [];
    $taxonomy_ids   = isset($_POST['taxonomy_ids']) ? json_decode(stripslashes($_POST['taxonomy_ids']), true) : [];
    
    $query = ss_build_filtered_query($term_slug, $posts_per_page, $page, $source, $manual_posts, $taxonomy_ids);
    
    $html = ss_generate_projects_html($query);
    
    wp_send_json_success([
        'html'        => $html,
        'found_posts' => $query->found_posts,
        'max_pages'   => $query->max_num_pages,
    ]);
}
add_action('wp_ajax_load_more_case_studies', 'ajax_load_more_case_studies');
add_action('wp_ajax_nopriv_load_more_case_studies', 'ajax_load_more_case_studies');

/**
 * Build filtered WP_Query for case studies
 *
 * @param string $term_slug    Taxonomy term slug ('all' or specific slug)
 * @param int    $per_page     Posts per page
 * @param int    $paged        Current page number
 * @param string $source       Source mode: 'manual', 'filtered', 'automatic'
 * @param array  $manual_posts Array of post IDs (for manual mode)
 * @param array  $taxonomy_ids Array of taxonomy term IDs (for manual mode filtering)
 * @return WP_Query
 */
function ss_build_filtered_query($term_slug, $per_page, $paged, $source = 'automatic', $manual_posts = [], $taxonomy_ids = []) {
    $args = [
        'post_type'      => 'case_studies',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    
    // Handle manual mode
    if ($source === 'manual') {
        if (!empty($manual_posts)) {
            // Manual posts selected
            $args['post__in'] = array_map('absint', $manual_posts);
            $args['orderby']  = 'post__in';
        }
        
        // Apply taxonomy filter for manual mode
        if ($term_slug === 'all' && !empty($taxonomy_ids)) {
            // Filter by all selected taxonomies
            $args['tax_query'] = [[
                'taxonomy' => 'service_category',
                'field'    => 'term_id',
                'terms'    => array_map('absint', $taxonomy_ids),
                'operator' => 'IN',
            ]];
        } elseif ($term_slug !== 'all') {
            // Filter by specific category slug
            $args['tax_query'] = [[
                'taxonomy' => 'service_category',
                'field'    => 'slug',
                'terms'    => $term_slug,
            ]];
        }
    } elseif ($source === 'filtered') {
        // Filtered mode: Use manual_posts if provided, otherwise use taxonomy filters
        if (!empty($manual_posts)) {
            // Manual posts selected in filtered mode
            $args['post__in'] = array_map('absint', $manual_posts);
            $args['orderby']  = 'post__in';
            
            // Apply taxonomy filter on top of manual posts
            if ($term_slug !== 'all') {
                $args['tax_query'] = [[
                    'taxonomy' => 'service_category',
                    'field'    => 'slug',
                    'terms'    => $term_slug,
                ]];
            }
        } else {
            // No manual posts, use taxonomy filtering
            if ($term_slug === 'all' && !empty($taxonomy_ids)) {
                // Show all posts from selected taxonomies
                $args['tax_query'] = [[
                    'taxonomy' => 'service_category',
                    'field'    => 'term_id',
                    'terms'    => array_map('absint', $taxonomy_ids),
                    'operator' => 'IN',
                ]];
            } elseif ($term_slug !== 'all') {
                // Filter by specific category slug
                $args['tax_query'] = [[
                    'taxonomy' => 'service_category',
                    'field'    => 'slug',
                    'terms'    => $term_slug,
                ]];
            }
        }
    } else {
        // Automatic mode: Show all posts, or filter by clicked tab
        if (!empty($term_slug) && $term_slug !== 'all') {
            $args['tax_query'] = [[
                'taxonomy' => 'service_category',
                'field'    => 'slug',
                'terms'    => $term_slug,
            ]];
        }
    }
    
    return new WP_Query($args);
}

/**
 * Generate HTML for projects grid
 *
 * @param WP_Query $query Query object
 * @return string HTML output
 */
function ss_generate_projects_html($query) {
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ss_render_project_card(get_the_ID());
        }
    } else {
        ?>
        <div class="col-span-full text-center py-12">
            <p class="text-neutral-600 text-[18px] leading-[1.5]">
                <?php esc_html_e('No case studies found.', 'ss-project'); ?>
            </p>
        </div>
        <?php
    }
    
    wp_reset_postdata();
    
    return ob_get_clean();
}

/**
 * Generate pagination HTML for AJAX responses.
 *
 * @param WP_Query $query       The query object.
 * @param int      $current_page Current page number.
 * @return string Pagination HTML.
 */
function ss_generate_pagination_html($query, $current_page = 1) {
    if ($query->max_num_pages <= 1) {
        return '';
    }
    
    ob_start();
    
    $big = 999999999;
    $pagination_links = paginate_links([
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => $current_page,
        'total'     => $query->max_num_pages,
        'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'next_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'type'      => 'array',
    ]);
    
    if ($pagination_links) {
        echo '<div class="flex items-center gap-2">';
        foreach ($pagination_links as $link) {
            $base_classes = 'inline-flex items-center justify-center min-w-[40px] h-[40px] px-3 rounded-lg border border-neutral-300 hover:border-blue-950 hover:bg-blue-950 hover:text-white transition-colors font-satoshi text-[14px] leading-[1.5]';
            
            // Check if it's the current page (check for 'current' class or if it's a span with the current page number)
            $is_current = strpos($link, 'current') !== false;
            
            // Additional check: if it's a span (not a link) and contains the current page number, it's the current page
            if (!$is_current && strpos($link, '<span') !== false) {
                // Extract the text content and check if it matches current page
                preg_match('/>(\d+)</', $link, $matches);
                if (isset($matches[1]) && intval($matches[1]) === $current_page) {
                    $is_current = true;
                }
            }
            
            if ($is_current) {
                $link = str_replace('class="', 'class="' . $base_classes . ' bg-blue-950 text-white border-blue-950 ', $link);
            } else {
                $link = str_replace('class="', 'class="' . $base_classes . ' ', $link);
            }
            
            echo $link;
        }
        echo '</div>';
    }
    
    return ob_get_clean();
}

/**
 * Add class to last menu link in primary menu
 */
function add_class_to_last_menu_link( $atts, $item, $args ) {

    if ( $args->theme_location !== 'primary' ) return $atts;

    // pega itens do menu atual
    static $menu_ids = [];

    if ( empty( $menu_ids ) ) {
        $locations = get_nav_menu_locations();
        $menu      = wp_get_nav_menu_items( $locations['primary'] );
        $menu_ids  = wp_list_pluck( $menu, 'ID' );
    }

    $last_id = end( $menu_ids );

    if ( $item->ID == $last_id ) {
        $atts['class'] = ( $atts['class'] ?? '' ) . ' chevron_right';
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_class_to_last_menu_link', 10, 3 );
