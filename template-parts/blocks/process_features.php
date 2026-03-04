<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'process_features') :
            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? '';
            $description = $fields['description'] ?? '';
            $features = $fields['features'] ?? [];
        endif;
    endforeach;
?>

<section id="process-features" class="relative bg-white pb-[clamp(64px,calc(120/1920*100vw),120px)] pt-0">
    
    <!-- Top Border Line -->
    <div class="content max-w-[1328px] mx-auto px-4 h-[1px] bg-neutral-200"></div>
    
    <!-- Content Container -->
    <div class="content mx-auto px-4 mt-[clamp(64px,calc(120/1920*100vw),120px)]">
        
        <!-- Main Grid -->
        <div class="flex flex-col md:flex-row gap-4 items-start">
            
            <!-- Left Column: Header + First Feature -->
            <div class="flex flex-col gap-8 md:gap-[40px] flex-1">
                
                <!-- Header -->
                <div class="flex flex-col gap-4 md:gap-[16px]">
                    <?php if ($headline) : ?>
                        <h2 class="font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[1.2] tracking-[-0.44px] text-neutral-950">
                            <?php echo htmlspecialchars_decode($headline); ?>
                        </h2>
                    <?php endif; ?>
                    
                    <?php if ($description) : ?>
                        <p class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-600">
                            <?php echo esc_html($description); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <!-- First Feature Card -->
                <?php if (!empty($features[0])) : 
                    $feature = $features[0];
                    $icon = $feature['icon'] ?? null;
                    $title = $feature['title'] ?? '';
                    $feat_description = $feature['description'] ?? '';
                ?>
                    <div class="bg-neutral-50 border-[0.5px] border-blue-100 rounded-[24px] p-8 md:p-[32px] flex flex-col justify-between h-auto md:h-[264px] hover:shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)] transition-shadow">
                        
                        <!-- Icon -->
                        <?php if ($icon) : ?>
                            <div class="w-6 h-6 shrink-0">
                                <img src="<?php echo esc_url($icon['url']); ?>" 
                                     alt="<?php echo esc_attr($icon['alt'] ?? $title); ?>"
                                     class="w-full h-full object-contain">
                            </div>
                        <?php endif; ?>
                        
                        <!-- Text Content -->
                        <div class="flex flex-col gap-2 mt-[74px] md:mt-0">
                            <?php if ($title) : ?>
                                <h3 class="font-normal text-[clamp(20px,calc(24/1920*100vw),24px)] leading-[1.2] tracking-[-0.264px] text-neutral-950">
                                    <?php echo htmlspecialchars_decode($title); ?>
                                </h3>
                            <?php endif; ?>
                            
                            <?php if ($feat_description) : ?>
                                <p class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-[#9E9E9E]">
                                    <?php echo esc_html($feat_description); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                <?php endif; ?>
                
            </div>
            
            <!-- Middle Column: Second Feature (with top offset) -->
            <?php if (!empty($features[1])) : 
                $feature = $features[1];
                $icon = $feature['icon'] ?? null;
                $title = $feature['title'] ?? '';
                $feat_description = $feature['description'] ?? '';
            ?>
                <div class="flex flex-col flex-1 md:pt-[80px]">
                    <div class="bg-neutral-50 border-[0.5px] border-blue-100 rounded-[24px] p-8 md:p-[32px] flex flex-col justify-between h-auto md:h-[264px] shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)] hover:shadow-[0px_12px_24px_0px_rgba(0,0,0,0.15)] transition-shadow">
                        
                        <!-- Icon -->
                        <?php if ($icon) : ?>
                            <div class="w-6 h-6 shrink-0">
                                <img src="<?php echo esc_url($icon['url']); ?>" 
                                     alt="<?php echo esc_attr($icon['alt'] ?? $title); ?>"
                                     class="w-full h-full object-contain">
                            </div>
                        <?php endif; ?>
                        
                        <!-- Text Content -->
                        <div class="flex flex-col gap-2 mt-[74px] md:mt-0">
                            <?php if ($title) : ?>
                                <h3 class="font-normal text-[clamp(20px,calc(24/1920*100vw),24px)] leading-[1.2] tracking-[-0.264px] text-neutral-950">
                                    <?php echo htmlspecialchars_decode($title); ?>
                                </h3>
                            <?php endif; ?>
                            
                            <?php if ($feat_description) : ?>
                                <p class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-600">
                                    <?php echo esc_html($feat_description); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Right Column: Third Feature -->
            <?php if (!empty($features[2])) : 
                $feature = $features[2];
                $icon = $feature['icon'] ?? null;
                $title = $feature['title'] ?? '';
                $feat_description = $feature['description'] ?? '';
            ?>
                <div class="bg-neutral-50 border-[0.5px] border-blue-100 rounded-[24px] p-8 md:p-[32px] flex flex-col justify-between h-auto md:h-[264px] flex-1 hover:shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)] transition-shadow">
                    
                    <!-- Icon -->
                    <?php if ($icon) : ?>
                        <div class="w-6 h-6 shrink-0">
                            <img src="<?php echo esc_url($icon['url']); ?>" 
                                 alt="<?php echo esc_attr($icon['alt'] ?? $title); ?>"
                                 class="w-full h-full object-contain">
                        </div>
                    <?php endif; ?>
                    
                    <!-- Text Content -->
                    <div class="flex flex-col gap-2 mt-[74px] md:mt-0">
                        <?php if ($title) : ?>
                            <h3 class="font-normal text-[clamp(20px,calc(24/1920*100vw),24px)] leading-[1.2] tracking-[-0.264px] text-neutral-950">
                                <?php echo htmlspecialchars_decode($title); ?>
                            </h3>
                        <?php endif; ?>
                        
                        <?php if ($feat_description) : ?>
                            <p class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-600">
                                <?php echo esc_html($feat_description); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                </div>
            <?php endif; ?>
            
        </div>
        
    </div>
</section>

<?php endif; ?>