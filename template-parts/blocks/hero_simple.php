<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'hero_simple') :

            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? '';
            $description = $fields['description'] ?? '';
            $cta_link = $fields['cta_link'] ?? '';
            
            $image = $block['background_image'] ?? [];
            $image_url = is_array($image) ? ($image['url'] ?? '') : '';
            $image_alt = is_array($image) ? ($image['alt'] ?? '') : '';
        endif;
    endforeach;
?>

<section id="hero-simple" class="relative bg-white">
    <div class="w-full h-full flex flex-col lg:flex-row gap-4">
        <div class="flex-1 bg-[#d6e9ff] rounded-br-3xl">
            <div class="h-54 sm:h-120 max-w-full xl:max-w-238 xl:float-end">
            <?php if ($image_url) : ?>
                <img src="<?php echo esc_url($image_url); ?>" 
                    alt="<?php echo esc_attr($image_alt); ?>"
                    class="block w-full h-full object-cover rounded-br-3xl" />
            <?php endif; ?>
            </div>
        </div>
        <div class="flex-1 bg-white">
            <div class="h-full flex flex-col justify-center items-start gap-8 px-6 lg:px-12 py-12 lg:py-24 max-w-480 xl:max-w-238">
                <?php if ($headline) : ?>
                    <h1 class="font-normal text-[46px] lg:text-[64px] leading-[1.1] tracking-[-0.92px] lg:tracking-[-1.28px] text-blue-950">
                        <?php echo htmlspecialchars_decode($headline); ?>
                    </h1>
                <?php endif; ?>
                
                <?php if ($description) : ?>
                    <div class="font-normal text-[18px] leading-[1.4] tracking-[-0.198px] text-neutral-600">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($cta_link) : ?>
                    <a href="<?php echo esc_url($cta_link['url']); ?>" 
                    class="inline-flex items-center justify-center bg-[#074b99] hover:bg-blue-800 transition-colors px-6 py-3 rounded-[64px] w-full xl:w-fit">
                        <span class="font-medium text-[12px] lg:text-[16px] leading-normal tracking-[-0.132px] lg:tracking-[-0.176px] text-neutral-50">
                            <?php echo htmlspecialchars_decode($cta_link['title']); ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>    
</section>

<?php endif; ?>