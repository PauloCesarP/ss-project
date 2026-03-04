<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'hero_split') :

            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? '';
            $content = $fields['content'] ?? '';
            $cta_link = $fields['cta_link'] ?? '';
            
            $image = $block['image'] ?? [];
            $image_url = is_array($image) ? ($image['url'] ?? '') : '';
            $image_alt = is_array($image) ? ($image['alt'] ?? '') : '';
        endif;
    endforeach;
?>

<section id="hero-split" class="relative overflow-hidden py-0 lg:py-30 max-h-126.5">
    <div class="hidden lg:block max-w-[952px] absolute inset-y-0 right-0 bg-blue-800 rounded-bl-none lg:rounded-bl-[24px] overflow-hidden">
        <img src="<?php echo esc_url($image_url); ?>" 
            alt="<?php echo esc_attr($image_alt); ?>"
            class="w-full h-full max-w-[clamp(0px,calc(952/1920*100vw),952px)] object-cover" />

    </div>
    
    <div class="flex flex-col lg:flex-row lg:items-center mx-auto w-full max-w-[1920px]">
        <div class="flex lg:hidden rounded-bl-none lg:rounded-bl-[24px] min-h-[216px] bg-blue-800 mb-8 lg:mb-0">
            <img src="<?php echo esc_url($image_url); ?>" 
            alt="<?php echo esc_attr($image_alt); ?>"
            class="w-full h-full object-cover min-h-54" />
        </div>

        <div class="content">
            <!-- Text Container -->
            <div class="flex flex-col gap-8 max-w-none lg:max-w-[550px] xl:max-w-[608px] pr-0 lg:pr-12">
                <div class="flex flex-col gap-4">
                    <?php if ($headline) : ?>
                        <h1 class="font-normal text-[clamp(46px,calc(64/1920*100vw),64px)] leading-[110%] tracking-[-0.92px] text-blue-950">
                            <?php echo htmlspecialchars_decode($headline); ?>
                        </h1>
                    <?php endif; ?>
                    
                    <?php if ($content) : ?>
                        <div class="font-normal text-[clamp(18px,calc(18/1920*100vw),18px)] leading-[140%] tracking-[-0.132px] lg:tracking-[1.1%] text-neutral-600">
                            <?php echo wp_kses_post($content); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- CTA Button -->
                <?php if ($cta_link) : ?>
                    <a href="<?php echo esc_url($cta_link['url']); ?>" 
                    class="inline-flex items-center justify-center bg-blue-900 hover:bg-blue-800 transition-colors px-6 py-3 rounded-[64px] w-full lg:w-fit">
                        <span class="font-medium text-[12px] lg:text-[16px] leading-[1.5] tracking-[-0.132px] lg:tracking-[-0.176px] text-neutral-50">
                            <?php echo htmlspecialchars_decode($cta_link['title']); ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

            
        </div>
    </div>
</section>

<?php endif; ?>