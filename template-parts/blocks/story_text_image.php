<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'story_text_image') :
            $fields = $block['fields'] ?? [];
            $label = $fields['label'] ?? '';
            $headline = $fields['headline'] ?? '';
            $content = $fields['content'] ?? '';
            $cta_link = $fields['cta_link'] ?? '';
            $image = $fields['image'] ?? [];
        endif;
    endforeach;
?>

<section id="story-text-image" class="relative py-[clamp(64px,calc(120/1920*100vw),120px)]">
    
    <div class="flex items-center justify-center px-4 md:pl-[max(16px,calc((100vw-1328px)/2))] md:pr-0">
        
        <!-- Container -->
        <div class="flex flex-col md:flex-row gap-8 md:gap-[16px] flex-1">
            
            <!-- Left: Content -->
            <div class="flex flex-col gap-8 md:gap-[64px] w-full md:w-[432px] shrink-0">
                
                <!-- Text Content -->
                <div class="flex flex-col gap-8 md:gap-[32px]">
                    
                    <!-- Header -->
                    <div class="flex flex-col gap-4 md:gap-[16px]">
                        <?php if ($headline) : ?>
                            <h2 class="font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[1.2] tracking-[-0.352px] md:tracking-[-0.44px] text-neutral-950">
                                <?php echo htmlspecialchars_decode($headline); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ($label) : ?>
                            <p class="order-first font-medium text-[clamp(12px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.154px] md:tracking-[-0.176px] text-blue-500">
                                <?php echo htmlspecialchars_decode($label); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Body Content -->
                    <?php if ($content) : ?>
                        <div class="font-normal text-[clamp(12px,calc(12/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-600 [&>p:not(:last-child)]:mb-[8px]">
                            <?php echo wp_kses_post($content); ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- CTA Button -->
                <?php if ($cta_link) : ?>
                    <a href="<?php echo esc_url($cta_link['url']); ?>" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 hover:bg-blue-950 text-neutral-50 font-medium text-[clamp(12px,calc(16/1920*100vw),16px)] mt-8 md:mt-0 tracking-[-0.132px] leading-[1.5] md:tracking-[-0.176px] rounded-[64px] transition-colors shrink-0 w-fit">
                        <?php echo esc_html($cta_link['title']); ?>
                    </a>
                <?php endif; ?>
                
            </div>
            
            <!-- Right: Image -->
            <div class="flex flex-col flex-1 pl-0 md:pl-[48px]">
                <div class="relative w-full min-h-[300px] md:min-h-[400px] bg-blue-100 rounded-l-[24px] overflow-hidden">
                    <?php if (!empty($image)) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" 
                             alt="<?php echo esc_attr($image['alt'] ?? $headline); ?>"
                             class="absolute w-full h-full left-0 top-[0] max-w-[1128px] object-cover">
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
        
    </div>
</section>
<?php endif; ?>