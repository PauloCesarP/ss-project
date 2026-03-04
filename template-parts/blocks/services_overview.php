<?php 
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';

        if ($layout === 'services_overview') :
            $fields = $block['fields'] ?? [];
            $headline = $fields['headline'] ?? 'Explore Our Core Services';
            $description = $fields['description'] ?? 'We focus on the critical layers of enterprise IT — the systems and infrastructure that keep your organisation running.';
            $services = $fields['services'] ?? [];
        endif;
    endforeach;
?>

<section id="services-overview" class="relative bg-white py-8 lg:py-30">
    <div class="content mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-4 lg:gap-4">
            <!-- Left Column: Header -->
            <div class="flex flex-col gap-4 w-full lg:w-[320px] lg:pr-12 shrink-0">
                <h2 class="font-normal text-center lg:text-left text-[32px] lg:text-[40px] leading-[120%] tracking-[-0.352px] md:tracking-[-0.44px] text-neutral-950">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>
                <p class="font-normal text-[18px] text-center lg:text-left leading-[140%] tracking-[-0.198px] text-neutral-600">
                    <?php echo esc_html($description); ?>
                </p>
            </div>

            <!-- Right Column: Services Grid -->
            <div class="flex flex-col gap-8 lg:gap-12 flex-1">
                <?php if (!empty($services)): ?>
                    <?php 
                    $rows = array_chunk($services, 2);
                    foreach ($rows as $row): 
                    ?>
                        <div class="flex flex-col lg:flex-row gap-8 lg:gap-4">
                            <?php foreach ($row as $service): ?>
                                <?php
                                    $icon = $service['icon'] ?? [];
                                    $icon_url = is_array($icon) ? ($icon['url'] ?? '') : $icon;
                                    $icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
                                    $title = $service['title'] ?? '';
                                    $service_description = $service['description'] ?? '';
                                ?>
                                <div class="flex gap-4 flex-1 flex-col md:flex-row items-center md:items-start">
                                    <!-- Icon -->
                                    <div class="shrink-0">
                                        <div class="w-18 h-18 rounded-[88px] border-[0.5px] border-blue-800 flex items-center justify-center p-4">
                                            <?php if (!empty($icon_url)): ?>
                                                <img src="<?php echo esc_url($icon_url); ?>" 
                                                    alt="<?php echo esc_attr($icon_alt ?: $title); ?>" 
                                                    class="w-8 h-8 object-contain">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex flex-col gap-2 flex-1 text-center md:text-left">
                                        <h3 class="font-normal text-[18px] lg:text-[24px] leading-[120%] tracking-[-0.198px] md:tracking-[-0.264px] text-neutral-950">
                                            <?php echo htmlspecialchars_decode($title); ?>
                                        </h3>
                                        <p class="font-normal text-sm lg:text-base leading-[150%] tracking-[-0.176px] text-neutral-600">
                                            <?php echo esc_html($service_description); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>