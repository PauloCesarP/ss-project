<?php
$fields = get_sub_field('fields') ?? [];
$headline = $fields['headline'] ?? '';
$description = $fields['description'] ?? '';
$steps = $fields['steps'] ?? [];
?>

<!-- Process Steps Block -->
<section class="content py-[clamp(32px,calc(120/1920*100vw),120px)]">
    
    <!-- Header -->
    <?php if (!empty($headline) || !empty($description)): ?>
        <div class="flex flex-col gap-4 items-center text-center max-w-[656px] mx-auto mb-[clamp(40px,calc(56/1920*100vw),56px)]">
            <?php if (!empty($headline)): ?>
                <h2 class="font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[1.2] tracking-[-0.352px] lg:tracking-[-0.44px] text-neutral-950 w-full">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>
            <?php endif; ?>
            
            <?php if (!empty($description)): ?>
                <p class="font-normal text-[18px] leading-[1.4] tracking-[-0.198px] text-neutral-600 w-full">
                    <?php echo htmlspecialchars_decode($description); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <!-- Steps Grid -->
    <?php if (!empty($steps)): ?>
        <div class="flex flex-col lg:flex-row gap-4 items-start w-full">
            <?php 
            $step_count = count($steps);
            foreach ($steps as $index => $step): 
                $icon = $step['icon'] ?? [];
                $icon_url = is_array($icon) ? ($icon['url'] ?? '') : '';
                $icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
                $title = $step['title'] ?? '';
                $step_description = $step['description'] ?? '';
                $is_last = ($index === $step_count - 1);
            ?>
                <!-- Step Card -->
                <div class="w-full lg:flex-1 lg:basis-0 flex flex-col gap-8 items-center p-8 lg:min-w-0 lg:min-h-0 lg:self-stretch">
                    
                    <!-- Icon Container with Background Circle -->
                    <?php if (!empty($icon_url)): ?>
                        <div class="relative w-[88px] h-[88px] flex-shrink-0">
                            <!-- Outer Light Blue Circle -->
                            <div class="absolute inset-0 rounded-full bg-[#d6e9ff] flex items-center justify-center">
                                <!-- Inner Circle (Icon Background) -->
                                <div class="w-[48px] h-[48px] rounded-full flex items-center justify-center">
                                    <img src="<?php echo esc_url($icon_url); ?>" 
                                         alt="<?php echo esc_attr($icon_alt ?: $title); ?>"
                                         class="w-6 h-6 object-contain" />
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Text Content -->
                    <div class="flex flex-col gap-4 items-start text-center w-full">
                        <?php if (!empty($title)): ?>
                            <h3 class="font-normal text-[clamp(16px,calc(20/1920*100vw),20px)] leading-[1.3] tracking-[-0.176px] md:tracking-[-0.22px] text-blue-950 w-full">
                                <?php echo htmlspecialchars_decode($title); ?>
                            </h3>
                        <?php endif; ?>
                        
                        <?php if (!empty($step_description)): ?>
                            <p class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.154pxzz] md:tracking-[-0.176px] text-neutral-600 w-full">
                                <?php echo htmlspecialchars_decode($step_description); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                </div>
                
                <!-- Arrow Separator (not shown after last item) -->
                <?php if (!$is_last): ?>
                    <!-- Mobile/Tablet: Vertical Arrow -->
                    <div class="flex lg:hidden w-full items-center justify-center">
                        <svg width="12" height="52" viewBox="0 0 12 52" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                            <path d="M6.53033 51.5303C6.23744 51.8232 5.76256 51.8232 5.46967 51.5303L0.696699 46.7574C0.403806 46.4645 0.403806 45.9896 0.696699 45.6967C0.989593 45.4038 1.46447 45.4038 1.75736 45.6967L6 49.9393L10.2426 45.6967C10.5355 45.4038 11.0104 45.4038 11.3033 45.6967C11.5962 45.9896 11.5962 46.4645 11.3033 46.7574L6.53033 51.5303ZM6.75 0L6.75 51H5.25L5.25 0L6.75 0Z" fill="#2563EB"/>
                        </svg>
                    </div>
                    
                    <!-- Desktop: Horizontal Arrow -->
                    <div class="hidden lg:flex w-[51.343px] flex-shrink-0 items-start justify-center pt-[152px]">
                        <svg width="52" height="12" viewBox="0 0 52 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                            <path d="M51.5303 6.53033C51.8232 6.23744 51.8232 5.76256 51.5303 5.46967L46.7574 0.696699C46.4645 0.403806 45.9896 0.403806 45.6967 0.696699C45.4038 0.989593 45.4038 1.46447 45.6967 1.75736L49.9393 6L45.6967 10.2426C45.4038 10.5355 45.4038 11.0104 45.6967 11.3033C45.9896 11.5962 46.4645 11.5962 46.7574 11.3033L51.5303 6.53033ZM0 6.75H51V5.25H0V6.75Z" fill="#2563EB"/>
                        </svg>
                    </div>
                <?php endif; ?>
                
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
</section>
