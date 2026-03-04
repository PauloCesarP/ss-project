<?php 
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';

        if ($layout === 'expertise_grid') :
            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? '';
            $description = $fields['description'] ?? '';
            $items = $fields['items'] ?? [];

            endif;
    endforeach;
?>
<section id="expertise-grid" class="relative bg-blue-50 py-8 lg:py-[120px] overflow-hidden">
    <div class="content mx-auto px-4">
        <!-- Header Section -->
        <div class="flex flex-col gap-4 mb-14 max-w-[656px]">
            <h2 class="font-normal text-[32px] lg:text-[40px] leading-[120%] tracking-[-0.0275rem] text-blue-950">
                <?php echo htmlspecialchars_decode($headline); ?>
            </h2>
            <p class="font-normal text-sm lg:text-base leading-[150%] tracking-[-0.011rem] text-[#666765]">
                <?php echo esc_html($description); ?>
            </p>
        </div>

        <!-- Grid Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:pl-[224px] gap-2 md:gap-4">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $index => $item): ?>
                    <?php
                        $icon = $item['icon'] ?? [];
                        $icon_url = is_array($icon) ? ($icon['url'] ?? '') : $icon;
                        $icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
                        $title = $item['title'] ?? '';
                        $item_description = $item['description'] ?? '';
                        $link = $item['link'] ?? null;
                        $link_url = $link['url'] ?? 'javascript:void(0);';
                        $link_target = $link['target'] ?? '_self';
                    ?>
                    <a href="<?php echo esc_url($link_url); ?>" 
                    target="<?php echo esc_attr($link_target); ?>" 
                    class="bg-white border-[0.25px] border-neutral-100 rounded-[24px] p-8 flex flex-col gap-6 md:gap-12 transition-shadow duration-300 !no-underline hover:shadow-[0px_8px_17px_0px_rgba(0,0,0,0.10)]">
                        
                        <!-- Arrow Icon - Top Right -->
                        <div class="flex items-center justify-end w-full">
                            <svg width="15.428px" height="15.428px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-[15.428px] h-[15.428px]">
                                <path d="M4 12L12 4M12 4H4M12 4V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        
                        <!-- Center Icon Container -->
                        <div class="flex items-center justify-center w-full">
                            <div class="w-[72px] h-[72px] rounded-[88px] border-[1px] border-blue-800 flex items-center justify-center p-4">
                                <?php if (!empty($icon_url)): ?>
                                    <img src="<?php echo esc_url($icon_url); ?>" 
                                        alt="<?php echo esc_attr($icon_alt ?: $title); ?>" 
                                        class="w-8 h-8 object-contain">
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Text Content -->
                        <div class="flex flex-col gap-2 w-full">
                            <h3 class="font-normal text-[18px] md:text-2xl leading-[120%] tracking-[-0.198px] md:tracking-[-0.264px] text-neutral-950">
                                <?php echo htmlspecialchars_decode($title); ?>
                            </h3>
                            <p class="font-normal text-[14px] md:text-base leading-[150%] tracking-[-0.154px] md:tracking-[-0.176px] text-neutral-600">
                                <?php echo esc_html($item_description); ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>