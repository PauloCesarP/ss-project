<!-- Gradient Blue CTA Banner -->
<!-- CTA Container -->
 <?php 
    $headline = $args['headline'] ?? '';
    $description = $args['description'] ?? '';
    $cta_link = $args['cta_link'] ?? '';
    $image_url = $args['image_url'] ?? '';
    $image_alt = $args['image_alt'] ?? '';
    $style = $args['style'] ?? 'gradient_blue';
    $size = $args['size'] ?? 'full';
    $image_position = $args['image_position'] ?? 'left';
 ?>
<div class="relative <?php echo ($style === 'dark_blue' ? 'bg-blue-950' : 'bg-blue-50'); ?> rounded-3xl overflow-hidden px-6 py-6 lg:py-12 md:py-[clamp(48px,calc(48/1920*100vw),48px)]
            <?php echo $image_position === 'left' ? 'md:pl-[clamp(320px,calc(448/1920*100vw),448px)] md:pr-[clamp(32px,calc(48/1920*100vw),48px)]' : 'md:pr-[clamp(320px,calc(448/1920*100vw),448px)] md:pl-[clamp(32px,calc(48/1920*100vw),48px)]'; ?>">
    
    <!-- 3D Image -->
    <?php if ($image_url) : ?>
        <div class="absolute -top-[26px] w-[374.16px] h-[374.16px] md:top-[clamp(-21px,calc(-56.5/1920*100vw),-56.5px)] md:w-[clamp(374.16px,calc(683/1920*100vw),683px)] md:h-[clamp(374.16px,calc(683/1920*100vw),683px)] pointer-events-none z-10
                    <?php echo $image_position === 'left' ? '-left-[75px] md:left-[-92px] xl:left-[-186px]' : '-right-[75px] md:right-[-92px] xl:right-[-186px]'; ?>">
            <img src="<?php echo esc_url($image_url); ?>" 
                    alt="<?php echo esc_attr($image_alt); ?>"
                    class="w-full h-full object-contain object-center">
        </div>
    <?php endif; ?>
    
    <!-- Content Area -->
    <div class="relative z-20 flex flex-col gap-[clamp(24px,calc(32/1920*100vw),32px)] md:max-w-[608px] mt-72 md:mt-0">
        
        <!-- Text Content -->
        <div class="flex flex-col gap-4">
            <?php if ($headline) : ?>
                <h2 class="font-inter font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[1.2] tracking-[-0.352px] text-neutral-950">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>
            <?php endif; ?>
            
            <?php if ($description) : ?>
                <p class="font-inter font-normal text-[clamp(18px,calc(18/1920*100vw),18px)] leading-[1.4] tracking-[-0.198px] text-neutral-600">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>
        </div>
        
        <!-- CTA Button -->
        <?php if ($cta_link) : ?>
            <a href="<?php echo esc_url($cta_link['url'] ?? '#'); ?>" 
                class="lg:self-start inline-flex items-center justify-center gap-3 bg-blue-950 hover:bg-blue-900 transition-colors px-6 py-3 rounded-[64px]"
                <?php if (!empty($cta_link['target'])) : ?>target="<?php echo esc_attr($cta_link['target']); ?>"<?php endif; ?>>
                <span class="font-inter font-medium text-[16px] leading-[1.5] tracking-[-0.176px] text-neutral-50">
                    <?php echo esc_html($cta_link['title'] ?? 'Contact Us'); ?>
                </span>
                <svg class="w-[7.4px] h-3" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.5 1L6.5 6L1.5 11" stroke="#F6F6F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        <?php endif; ?>
        
    </div>
    
</div>