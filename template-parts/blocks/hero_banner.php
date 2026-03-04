<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'hero_banner') :

            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? '';
            $subheadline = $fields['subheadline'] ?? '';
            $primary_cta_link = $fields['primary_cta_link'] ?? '';
            $secondary_cta_link = $fields['secondary_cta_link'] ?? '';
            
            $hero_image = $block['hero_image'] ?? [];
            $hero_image_url = is_array($hero_image) ? ($hero_image['url'] ?? '') : '';
            $hero_image_alt = is_array($hero_image) ? ($hero_image['alt'] ?? '') : '';
        endif;
    endforeach;
?>
<section id="hero-banner" class="relative bg-white flex flex-col lg:flex-row lg:items-center overflow-hidden lg:max-h-[585px]">
    <!-- MOBILE & TABLET 3D IMAGE -->
    <div class="h-[16rem] sm:h-[27.236rem] md:h-[32.6832rem] w-full relative overflow-hidden lg:hidden">
        <div class="relative w-full h-full">
            <?php if (!empty($hero_image)): ?>
                <img
                    src="<?php echo esc_url($hero_image['url']); ?>"
                    alt="<?php echo esc_attr($hero_image['alt'] ?: $headline); ?>"
                    class="absolute top-[-57.5%] right-[-34px] xs:sm:right-[-34px] md:right-[-74px] max-h-[376px] sm:max-h-[640px] md:max-h-[768px] w-auto object-cover"
                >
            <?php endif; ?>
        </div>
    </div>

    <!-- LEFT CONTENT -->
    <div class="flex flex-col gap-8 w-full pb-8 lg:content lg:py-0 lg:md:pt-44 lg:md:pb-[120px] relative z-10">

        <div class="flex flex-col gap-4 items-start justify-center w-full lg:max-w-[51.2%] px-4 lg:px-0">

            <!-- HEADLINE FLUID -->
            <h1
                    class="text-[clamp(46px,calc(64/1920*100vw),64px)]
                   leading-[clamp(110%,calc(1.1/1920*100vw),110%)]
                   tracking-[clamp(-1.28px,calc(-1.28/1920*100vw),-0.92px)]
                   text-[#053169]
                   text-left w-full"
            >
                <?php echo htmlspecialchars_decode($headline ?? ''); ?>
            </h1>

            <!-- SUBHEADLINE FLUID -->
            <p
                    class="text-[clamp(18px,calc(18/1920*100vw),18px)]
                   leading-[clamp(140%,calc(140%/1920*100vw),140%)]
                   tracking-[clamp(-0.198px,calc(-0.198px/1920*100vw),-0.198px)]
                   text-[#666765]
                   text-left w-full max-w-[650px]"
            >
                <?php echo htmlspecialchars_decode($subheadline ?? ''); ?>
            </p>
        </div>

        <!-- CTAs -->
        <div class="flex flex-col gap-4 items-center justify-start w-full px-4 lg:px-0 lg:flex-row lg:gap-8">

            <?php if (!empty($primary_cta_link)): ?>
                <a href="<?php echo esc_url($primary_cta_link['url']); ?>"
                   target="<?php esc_attr($primary_cta_link['target']); ?>"
                   class="chevron_right bg-[#053169] rounded-[64px] px-6 py-4
                       flex items-center justify-center gap-3 text-[#f6f6f6]
                       text-[14px] md:text-xs-16-150 leading-normal text-left
                       whitespace-nowrap !no-underline hover:bg-[#053169]/90
                       transition-colors w-full lg:w-auto">
                    <?php echo htmlspecialchars_decode($primary_cta_link['title']); ?>
                </a>
            <?php endif; ?>

            <?php if (!empty($secondary_cta_link)): ?>
                <a href="<?php echo esc_url($secondary_cta_link['url']); ?>"
                   target="<?php esc_attr($secondary_cta_link['target']); ?>"
                   class="flex items-center justify-center gap-3 text-[#191a19]
                      font-medium text-[12px] text-left md:text-xs-16-150 leading-[150%]
                      tracking-[-0.0083rem] whitespace-nowrap !no-underline
                      hover:text-[#053169] transition-colors w-full lg:w-auto">
                    <?php echo htmlspecialchars_decode($secondary_cta_link['title']); ?>
                    <svg width="7.4" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                        <path d="M4.6 6L0 1.4L1.4 0L7.4 6L1.4 12L0 10.6L4.6 6Z" fill="currentColor"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- DESKTOP 3D IMAGE | FLUID POSITIONING -->
    <div
            class="hidden lg:block absolute pointer-events-none
           w-[clamp(300px,calc(972.359/1920*100vw),972.359px)]
           h-[clamp(300px,calc(972.359/1920*100vw),972.359px)]
           top-[clamp(3px,calc(3/1920*100vw),3px)]
           right-[clamp(0px,calc(0/1920*100vw),0px)]"
    >
        <?php if (!empty($hero_image)): ?>
            <img
                    src="<?php echo esc_url($hero_image['url']); ?>"
                    alt="<?php echo esc_attr($hero_image['alt'] ?: $headline); ?>"
                    class="w-full h-full object-cover object-center"
            >
        <?php endif; ?>
    </div>

</section>
<?php endif; ?>
