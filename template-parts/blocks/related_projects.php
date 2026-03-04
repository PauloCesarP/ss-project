<?php
$fields = get_sub_field('fields') ?? [];
$headline = $fields['headline'] ?? 'Related Projects';
$source = $fields['options'] ?? 'automatic';
$manual_projects = $fields['manual_projects'] ?? [];
$count = $fields['count'] ?? 2;

$current_post_id = get_the_ID();
$related_projects = [];

if ($source === 'manual' && !empty($manual_projects)) {
    $related_projects = $manual_projects;
} elseif ($source === 'same_category') {
    $categories = wp_get_post_terms($current_post_id, 'service_category', ['fields' => 'ids']);
    if (!empty($categories)) {
        $query_args = [
            'post_type' => 'case_studies',
            'posts_per_page' => $count,
            'post__not_in' => [$current_post_id],
            'tax_query' => [
                [
                    'taxonomy' => 'service_category',
                    'field' => 'term_id',
                    'terms' => $categories,
                ],
            ],
        ];
        $related_projects = get_posts($query_args);
    }
} else { // automatic
    $query_args = [
        'post_type' => 'case_studies',
        'posts_per_page' => $count,
        'post__not_in' => [$current_post_id],
        'orderby' => 'rand',
    ];
    $related_projects = get_posts($query_args);
}
?>

<?php if (!empty($related_projects)) : ?>
    <section class="related-projects-section py-8 md:py-12 lg:py-[120px] bg-white">
        <div class="mx-auto">
            <div class="flex flex-col gap-[48px] items-center justify-center">
                <!-- Headline -->
                <h2 class="font-normal text-[40px] leading-[1.2] tracking-[-0.44px] text-[#053169] w-full">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>

                <!-- Cards Grid -->
                <div class="flex flex-col lg:flex-row gap-8 w-full <?php echo count($related_projects) === 1 ? 'justify-start' : ''; ?>">
                    <?php foreach ($related_projects as $project) : 
                        $project_fields = get_fields($project->ID);
                        $service_area = wp_get_post_terms($project->ID, 'service_category', ['fields' => 'names']) ?? [];
                        $thumbnail_id = get_post_thumbnail_id($project->ID);
                        $thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'large') : '';
                        $excerpt = get_the_excerpt($project->ID) ?? wp_trim_words(strip_tags($project->post_content), 20, '...');
                    ?>
                        <div class="w-full lg:flex-1 min-w-0 bg-gradient-to-b from-[#f4f4f4] to-[#8e8e8e] h-[544px] lg:h-[576px] rounded-[24px] overflow-hidden p-[16px] flex flex-col gap-[8px] items-start justify-end relative">
                            <!-- Featured Image Background -->
                            <?php if ($thumbnail_url) : ?>
                                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"></div>
                            <?php endif; ?>

                            <!-- Categories Badges -->
                             <?php foreach ($service_area as $category_name) : ?>
                                <div class="absolute top-[16px] left-[16px] border-[0.5px] border-[#b8d9ff] bg-blue-100 bg-opacity-90 rounded-full px-[16px] py-[8px] inline-flex items-center justify-center">
                                    <span class="font-satoshi font-medium text-[14px] leading-[1.5] tracking-[-0.154px] text-[#0a5bb3] whitespace-nowrap">
                                        <?php echo esc_html($category_name); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>                            

                            <!-- Card Content (positioned at bottom) -->
                            <div class="bg-white rounded-[24px] px-[24px] py-[16px] w-full flex flex-col gap-[16px] relative z-10">
                                <!-- Card Text -->
                                <div class="flex flex-col gap-[8px]">
                                    <h3 class="font-normal text-[20px] leading-[1.3] tracking-[-0.22px] text-[#0d0d0d] line-clamp-2 md:line-clamp-1">
                                        <?php echo esc_html(get_the_title($project->ID)); ?>
                                    </h3>
                                    <p class="text-[16px] leading-[1.5] tracking-[-0.176px] text-[#666765] line-clamp-2">
                                        <?php echo esc_html($excerpt); ?>
                                    </p>
                                </div>

                                <!-- Card Footer -->
                                <div class="flex justify-end">
                                    <a href="<?php echo esc_url(get_permalink($project->ID)); ?>" class="flex gap-[12px] items-center justify-center group">
                                        <span class="font-medium text-[16px] leading-[1.5] tracking-[-0.176px] text-[#191a19] whitespace-nowrap">
                                            Read
                                        </span>
                                        <div class="w-[7.4px] h-[12px]">
                                            <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2 2L6 6L2 10" stroke="#191a19" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Back Button -->
                <div class="w-full">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_title('Projects'))); ?>" class="inline-flex gap-[12px] items-center justify-center px-[24px] py-[12px] bg-[#074b99] rounded-[64px]">
                        <div class="flex items-center justify-center rotate-180">
                            <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 2L6 6L2 10" stroke="#f6f6f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="font-medium text-[16px] leading-[1.5] tracking-[-0.176px] text-[#f6f6f6] whitespace-nowrap">
                            <?php esc_html_e('Back to Case Studies', 'ss-project'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
  