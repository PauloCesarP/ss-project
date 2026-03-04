<?php
$blocks = get_field('blocks');

if ($blocks):
    foreach ($blocks as $block):
        $layout = $block['acf_fc_layout'] ?? '';

        if ($layout === 'features_row'):
            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? '';
            $description = $fields['description'] ?? '';
            $features = $fields['features'] ?? [];

        endif;
    endforeach;
?>
<section id="features-row" class="relative bg-white py-16 md:py-[120px] overflow-hidden">
    <div class="content mx-auto px-4">
        <div class="max-w-[220px] sm:max-w-[470px] lg:max-w-[656px] mb-12 md:mb-14">
            <h2 class="font-normal text-[32px] md:text-[36px] lg:text-[40px] leading-[120%] tracking-[-0.44px] text-neutral-950 text-left">
                <?php echo htmlspecialchars_decode($headline); ?>
            </h2>
        </div>


        <?php if (!empty($features)): ?>
        <div class="grid auto-cols-auto sm:grid-cols-2 lg:grid-cols-4 gap-8 py-4 px-8 lg:py-0 justify-items-center">
            <?php foreach ($features as $index => $feature): ?>
                <?php
                    $icon = $feature['icon'] ?? [];
                    $icon_url = is_array($icon) ? ($icon['url'] ?? '') : $icon;
                    $icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
                    $feature_description = $feature['description'] ?? '';
                ?>
            <div class="flex flex-col items-center gap-8 text-center">
                <div class="w-[88px] h-[88px] rounded-full bg-blue-100 border-[0.5px] border-blue-50 flex items-center justify-center">
                    <?php if (!empty($icon_url)): ?>
                        <img src="<?php echo esc_url($icon_url); ?>" 
                            alt="<?php echo esc_attr($icon_alt ?: $feature_description); ?>" 
                            class="w-6 h-6 object-contain">
                    <?php endif; ?>
                </div>
                
                <p class="font-normal text-lg leading-[140%] tracking-[-0.0124rem] text-neutral-600 text-center">
                    <?php echo esc_html($feature_description); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>