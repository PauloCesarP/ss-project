<?php 
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'accreditations_bar') :

            $fields = $block['fields'] ?? [];
            $section_title = $fields['headline'] ?? '';
            $optional_description = $fields['description'] ?? '';
            $custom_logos = $fields['custom_logos'] ?? [];
        endif;
    endforeach;
?>

<section id="accreditations-block" class="relative bg-white py-8 lg:py-22 overflow-hidden">
    <div class="content">
        <div class="flex flex-col lg:flex-row gap-4 mb-8 lg:mb-[3.8125rem]">
            <div class="flex-1">
                <h2 class="text-[1.5rem] lg:text-[2rem] leading-[140%] text-neutral-950 tracking-[-0.0165rem] font-normal lg:tracking-[-0.022rem]"><?php echo esc_html($section_title); ?></h2>
            </div>
            <div class="flex-1">
                <p class="text-[18px] leading-[140%] text-neutral-600 tracking-[-0.0165rem] font-normal">
                    <?php echo esc_html($optional_description); ?>
                </p>
            </div>
        </div>
        <div class="grid auto-cols-auto min-[1100px]:grid-cols-5 gap-4"> <!-- grid-cols-1 xl:grid-cols-5 -->
            <?php if (!empty($custom_logos)): ?>
                <?php foreach ($custom_logos as $logo): ?>
                    <?php if (!empty($logo['logo'])): ?>
                        <?php $image = $logo['logo']; ?>
                        <div class="bg-neutral-50 rounded-2xl w-full xl:max-h-24 xl:max-w-[252.8px] flex items-center justify-center py-[36.25px] px-[106px]">
                            <img src="<?php echo esc_url($image['url']); ?>" 
                                alt="<?php echo esc_attr($image['name'] ?? 'Accreditation Logo'); ?>" 
                                class="max-h-[24px] max-w-[132px] object-contain">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>