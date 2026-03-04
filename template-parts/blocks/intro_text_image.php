<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';

        if ($layout === 'intro_text_image') :

            $fields = $block['fields'] ?? [];
            $label = $fields['label'] ?? '';
            $headline = $fields['headline'] ?? '';
            $content = $fields['content'] ?? '';
            $image = $fields['image'] ?? [];
            $mobile_image = $fields['mobile_image'] ?? [];
            $cta = [
                'text' => $fields['cta_text']['title'] ?? '',
                'url' => $fields['cta_text']['url'] ?? '#',
                'target' => $fields['cta_text']['target'] ?? '_self',
            ];
        endif;
    endforeach;
?>
<section id="intro-block" class="flex flex-col-reverse lg:flex-col gap-8 lg:gap-0 relative bg-[#f0f7ff] pt-0 md:pt-28 lg:pt-[120px] pb-0 overflow-hidden">
    <div class="content mx-auto">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-4 pb-14 lg:pb-[56px]">
            <div class="flex-1 flex flex-col gap-4">
                <h2 class="font-normal text-[32px] lg:text-[40px] leading-[1.2] tracking-[-0.011em] text-[#0d0d0d]">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>
                <p class="order-first font-medium text-[0.75rem] leading-[1.5] tracking-[-0.0083rem] text-[#313131]">
                    <?php echo esc_html($label); ?>
                </p>
            </div>
            
            <div class="flex-1 flex flex-col gap-8 lg:gap-8">
                <p class="font-normal text-[0.875rem] lg:text-base leading-[1.5] tracking-[-0.011em] text-[#4c4d4c] opacity-70">
                    <?php echo esc_html($content); ?>
                </p>
                <a href="<?php echo esc_url($cta['url']); ?>" 
                target="<?php echo esc_attr($cta['target']); ?>" 
                class="chevron_right lg:self-start gap-3 bg-[#053169] text-[#f6f6f6] px-6 py-4 rounded-[64px] inline-flex items-center justify-center font-normal text-[0.875rem] lg:text-base leading-[normal] whitespace-nowrap !no-underline hover:bg-[#053169]/90 transition-colors">
                    <?php echo htmlspecialchars_decode($cta['text']); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="relative h-[216px] md:h-[400px] w-full lg:hidden ml-4 lg:ml-0">
        <div class="absolute inset-0 bg-[#d6e9ff] rounded-bl-[24px] overflow-hidden">
            <?php if (!empty($mobile_image['url'])): ?>
                <img src="<?php echo esc_url($mobile_image['url']); ?>" 
                    alt="<?php echo esc_attr($mobile_image['alt'] ?? ''); ?>" 
                    class="w-[95%] object-cover object-center">
            <?php elseif (!empty($image['url'])): ?>
                <img src="<?php echo esc_url($image['url']); ?>" 
                    alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" 
                    class="w-[95%] object-cover object-center">
            <?php endif; ?>
        </div>
    </div>
    <div class="hidden lg:block relative">
        <div class="absolute top-0 right-0 h-[392px] bg-[#d6e9ff] rounded-tl-[24px] overflow-hidden" 
            style="width: calc(100vw - max((100vw - 1328px) / 2, 0px)); left: max((100vw - 1328px) / 2, 0px);">
            <div class="relative w-full h-full overflow-visible">
                <?php if (!empty($image['url'])): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" 
                        alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" 
                        class="absolute bottom-0 left-0 w-full h-auto min-h-[120%] object-cover object-bottom">
                <?php endif; ?>
            </div>
        </div>
        <div class="h-[392px]"></div>
    </div>
</section>
<?php endif; ?>