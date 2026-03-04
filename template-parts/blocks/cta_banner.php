<?php
$fields = get_sub_field('fields') ?? [];
$headline = $fields['headline'] ?? '';
$description = $fields['description'] ?? '';
$cta_link = $fields['cta_link'] ?? '';
$image = $fields['image'] ?? []; // 3D Image
$image_url = is_array($image) ? ($image['url'] ?? '') : '';
$image_alt = is_array($image) ? ($image['alt'] ?? '') : '';
$image_position = $fields['image_position'] ?? 'left'; // options: right, left
$style = $fields['style'] ?? 'gradient_blue'; // options: gradient_blue, dark_blue
$size = $fields['size'] ?? 'full'; // options: full, compact

$section_bg = $style === 'dark_blue' ? 'bg-blue-950' : 'bg-white py-22';
$section_width = $size === 'compact' ? 'max-w-[1136px]' : 'w-full';
$banner_type = $style === 'dark_blue' ? 'cta_dark_blue_banner' : 'cta_gradient_blue_banner';
?>

<section id="cta-banner" class="<?php echo $section_bg; ?> relative flex flex-col lg:flex-row lg:items-center overflow-hidden lg:max-h-[640px]">
    <div class="content <?php echo $section_width; ?> <?php echo ($style === 'dark_blue') ? 'pt-8 pb-0 lg:py-22.5 xl:py-[180px]' : ''; ?>">    
        <!-- Banner type -->
        <?php get_template_part('template-parts/blocks/' . $banner_type, null, ['headline' => $headline, 'description' => $description, 'cta_link' => $cta_link, 'image_url' => $image_url, 'image_alt' => $image_alt, 'image_position' => $image_position, 'style' => $style, 'size' => $size]); ?>
    </div>
</section>