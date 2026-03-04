<?php
$fields = get_sub_field('fields') ?? [];
$icon = $fields['icon'] ?? [];
$label = $fields['label'] ?? '';
$headline = $fields['headline'] ?? '';
$description = $fields['description'] ?? '';
$cta_link = $fields['cta_link'] ?? [];
$image = $fields['image'] ?? [];
$image_position = $fields['image_left_image_right'] ?? 'image_right'; // 'image_left' or 'image_right'
$background_style = $fields['options_white_light_gray_blue_gradient'] ?? 'white';

$icon_url = is_array($icon) ? ($icon['url'] ?? '') : '';
$icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
$image_url = is_array($image) ? ($image['url'] ?? '') : '';
$image_alt = is_array($image) ? ($image['alt'] ?? '') : '';

// Background color based on option
$bg_class = '';
switch ($background_style) {
    case 'light_gray':
        $bg_class = 'bg-neutral-50';
        break;
    case 'blue_gradient':
        $bg_class = 'bg-blue-50';
        break;
    default:
        $bg_class = 'bg-white';
}
?>

<!-- Service Detail Block -->
<section class="w-full py-[clamp(32px,calc(120/1920*100vw),120px)] <?php echo esc_attr($bg_class); ?>">
    
    <div class="content">
        <div class="flex flex-col <?php echo $image_position === 'image_left' ? 'lg:flex-row-reverse' : 'md:flex-row'; ?> gap-4 items-center">
        
            <!-- Content Column -->
            <div class=" order-last md:order-first w-full lg:flex-1 lg:basis-0 flex flex-col gap-16 items-start lg:min-w-0 lg:min-h-0">
                
                <!-- Text Content -->
                <div class="flex flex-col gap-8 items-start w-full">
                    
                    <!-- Header with Icon & Label -->
                    <div class="flex flex-col gap-4 items-start w-full">
                        
                        <!-- Icon + Label -->
                        <?php if (!empty($icon_url) || !empty($label)): ?>
                            <div class="flex gap-4 items-center">
                                <?php if (!empty($icon_url)): ?>
                                    <div class="w-[20.412px] h-full shrink-0">
                                        <img src="<?php echo esc_url($icon_url); ?>" 
                                            alt="<?php echo esc_attr($icon_alt ?: $label); ?>"
                                            class="w-full h-full object-contain" />
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($label)): ?>
                                    <p class="font-medium text-[clamp(12px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.132px] md:tracking-[-0.176px] text-blue-500 whitespace-nowrap">
                                        <?php echo esc_html($label); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Headline -->
                        <?php if (!empty($headline)): ?>
                            <h2 class="font-normal text-[clamp(20px,calc(28/1920*100vw),28px)] leading-[1.4] tracking-[-0.22px] md:tracking-[-0.308px] text-neutral-950 w-full">
                                <?php echo htmlspecialchars_decode($headline); ?>
                            </h2>
                        <?php endif; ?>
                        
                    </div>
                    
                    <!-- Description List -->
                    <?php if (!empty($description)): ?>
                        <div class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.154px] md:tracking-[-0.176px] text-neutral-600 w-full [&_ul]:list-disc [&_ul]:pl-4.5 [&_li]:mb-2 [&_li:last-child]:mb-0">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- CTA Button -->
                <?php if (!empty($cta_link)): ?>
                    <a href="<?php echo esc_url($cta_link['url'] ?? '#'); ?>"
                    <?php if (!empty($cta_link['target'])): ?>target="<?php echo esc_attr($cta_link['target']); ?>"<?php endif; ?>
                    class="inline-flex gap-3 items-center justify-center group hover:gap-4 transition-all duration-200">
                        <span class="font-medium text-[clamp(12px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.132px] md:tracking-[-0.176px] text-neutral-900 whitespace-nowrap">
                            <?php echo esc_html($cta_link['title'] ?? 'Learn More'); ?>
                        </span>
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-[7.4px] h-3 flex-shrink-0">
                            <path d="M1.5 1L6.5 6L1.5 11" stroke="#191A19" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>
                
            </div>
            
            <!-- Image Column -->
            <?php if (!empty($image_url)): ?>
                <div class="order-first md:order-last w-full lg:flex-1 lg:basis-0 flex flex-col lg:min-w-0 lg:min-h-0 <?php echo $image_position === 'image_left' ? 'lg:pr-0' : 'lg:pl-12'; ?>">
                    <div class="h-[clamp(240px,calc(384/1920*100vw),384px)] w-full rounded-3xl">
                        <img src="<?php echo esc_url($image_url); ?>" 
                            alt="<?php echo esc_attr($image_alt ?: $headline); ?>"
                            class="w-full h-full md:max-w-152 object-cover object-center rounded-3xl" />
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    
</section>