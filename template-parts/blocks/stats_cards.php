<?php
$blocks = get_field('blocks') ?: [];

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'stats_cards') :
            $fields = $block['fields'] ?? [];
            $cards = $fields['cards'] ?? [];
        endif;
    endforeach;
?>

<section id="stats-cards" class="relative bg-white py-[clamp(64px,calc(120/1920*100vw),120px)]">
    <div class="content mx-auto px-4">
        
        <div class="flex flex-col lg:flex-row gap-4 lg:h-[312px]">
            
            <?php if (!empty($cards)) : 
                foreach ($cards as $index => $card) :
                    $title = $card['title'] ?? '';
                    $content = $card['content'] ?? '';
                    $stats = $card['stats'] ?? [];
                    $has_stats = !empty($stats);
            ?>
            
            <!-- Card <?php echo $index + 1; ?> -->
            <div class="flex-1 bg-blue-50 border-[0.25px] border-blue-100 rounded-[24px] p-[clamp(32px,calc(48/1920*100vw),48px)] flex flex-col gap-4 overflow-hidden transition-shadow duration-300 !no-underline hover:shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)] <?php echo $has_stats ? 'justify-between' : ''; ?>">
                
                <!-- Card Content -->
                <div class="flex flex-col gap-4">
                    <?php if ($title) : ?>
                        <h3 class="font-inter font-normal text-[clamp(22px,calc(28/1920*100vw),28px)] leading-[1.4] tracking-[-0.308px] text-blue-950">
                            <?php echo htmlspecialchars_decode($title); ?>
                        </h3>
                    <?php endif; ?>
                    
                    <?php if ($content) : ?>
                        <div class="font-inter font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-500 [&>p:not(:last-child)]:mb-2">
                            <?php echo wp_kses_post(wpautop($content)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Stats Details -->
                <?php if ($has_stats) : ?>
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <?php foreach ($stats as $stat) : 
                            $label = $stat['label'] ?? '';
                            $value = $stat['value'] ?? '';
                        ?>
                            <div class="flex flex-col gap-0 whitespace-nowrap">
                                <span class="font-satoshi-variable text-[clamp(12px,calc(14/1920*100vw),14px)] leading-[1.5] tracking-[-0.154px] text-neutral-400">
                                    <?php echo esc_html($label); ?>
                                </span>
                                <span class="font-inter font-normal text-[clamp(20px,calc(24/1920*100vw),24px)] leading-[1.2] tracking-[-0.264px] text-[#313131]">
                                    <?php echo esc_html($value); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
            </div>
            
            <?php 
                endforeach;
            endif; 
            ?>
            
        </div>
        
    </div>
</section>

<?php endif; ?>