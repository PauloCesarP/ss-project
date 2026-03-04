<?php 
    $headline = $args['headline'] ?? '';
    $description = $args['description'] ?? '';
    $cta_link = $args['cta_link'] ?? '';
    $image_url = $args['image_url'] ?? '';
    $image_alt = $args['image_alt'] ?? '';
    $style = $args['style'] ?? 'dark_blue';
    $size = $args['size'] ?? 'full';
    $image_position = $args['image_position'] ?? 'right';
 ?>

<div class="relative bg-[#053169] overflow-x-visible flex flex-col-reverse gap-0 lg:gap-8 w-full z-10 px-0">
    <?php if (!empty($image_url)): ?>
        <div class="lg:block lg:absolute pointer-events-none max-w-[600px] 2xl:max-w-[748.65px] bottom-[clamp(-110px,calc(-110/1920*100vw),-110px)] 
                    <?php echo $image_position === 'left' ? 'self-start -ml-25 pl-10 left-[clamp(-50px,calc(-50/1920*100vw),-50px)] 2xl:-left-12' : 'self-end -mr-25 pr-10 right-[clamp(-50px,calc(-50/1920*100vw),-50px)] 2xl:-right-12'; ?>">
            <img src="<?php echo esc_url($image_url); ?>" 
                 alt="<?php echo esc_attr($image_alt ?: $headline); ?>" 
                 class="w-full h-full object-cover object-center -mb-17.5" />
        </div>
    <?php endif; ?>
    
    <div class="@container">
        <div class="relative z-10 flex flex-col gap-8 max-w-full @sm:@max-[1024px]:max-w-[520px] @min-[1025px]:max-w-[656px]">
            <?php if (!empty($headline)): ?>
                <h2 class="text-[32px] lg:text-[36px] xl:text-[40px] 
                          font-normal leading-[1.2] tracking-[-0.352px] lg:tracking-[-0.44px] 
                          text-[#b8d9ff]">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>
            <?php endif; ?>
            
            <?php if (!empty($description)): ?>
                <p class="text-[14px] lg:text-[16px] font-normal leading-normal tracking-[-0.154px] lg:tracking-[-0.176px] 
                         text-white">
                    <?php echo htmlspecialchars_decode($description); ?>
                </p>
            <?php endif; ?>
            
            <?php if (!empty($cta_link)): ?>
                <a href="<?php echo esc_url($cta_link['url']); ?>"
                   <?php if (!empty($cta_link['target'])): ?>target="<?php echo esc_attr($cta_link['target']); ?>"<?php endif; ?>
                   class="inline-flex items-center justify-center gap-3 
                          px-6 py-3 bg-[#f0f7ff] rounded-full w-fit
                          hover:bg-white transition-colors duration-200 no-underline!">
                    <span class="text-[12px] lg:text-[14px] font-medium leading-normal tracking-[-0.132px] lg:tracking-[-0.176px] 
                                text-[#053169] whitespace-nowrap">
                        <?php echo htmlspecialchars_decode($cta_link['title'] ?? 'Contact Us'); ?>
                    </span>
                    
                    <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                        <path d="M1.5 1L6.5 6L1.5 11" stroke="#053169" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            <?php endif; ?>
            
        </div>
        
    </div>
    
</div>