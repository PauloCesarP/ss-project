<?php
// Hero Minimal Block - Let's Talk Section
// Os campos estão dentro de um grupo chamado 'fields'
$fields = get_sub_field('fields') ?? [];
$headline = $fields['headline'] ?? '';
$description = $fields['description'] ?? '';
$image = $fields['background_image'] ?? [];
$image_url = is_array($image) ? ($image['url'] ?? '') : '';
$image_alt = is_array($image) ? ($image['alt'] ?? '') : '';
?>

<!-- Hero Minimal - Let's Talk -->
<section class="relative bg-blue-50 overflow-hidden 
               py-8
               md:py-20
               lg:py-24
               xl:py-[120px]">
    
    <!-- Content Container -->
    <div class="content w-full relative z-10 flex flex-col gap-4 
                md:flex-row md:gap-6
                lg:gap-4
                xl:flex-row">
        
        <!-- Headline -->
        <?php if (!empty($headline)): ?>
            <div class="flex-1 w-full md:w-1/2">
                <h1 class="font-normal text-blue-950
                          text-[46px] leading-[1.1] tracking-[-0.92px]
                          lg:text-[64px]
                          md:tracking-[-0.96px]
                          lg:tracking-[-1.12px]
                          xl:tracking-[-1.28px]">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h1>
            </div>
        <?php endif; ?>
        
        <!-- Description -->
        <?php if (!empty($description)): ?>
            <div class="@container flex-1 w-full md:w-1/2">
                <p class="font-normal text-neutral-600
                         text-[18px] leading-[1.4] tracking-[-0.198px]
                         lg:text-[18px] lg:tracking-[-0.198px]
                         2xl:pr-29 [@media(min-width:1760px)]:pr-0">
                    <?php echo htmlspecialchars_decode($description); ?>
                </p>
            </div>
        <?php endif; ?>
        
    </div>
    
    <!-- 3D Image - Hidden on mobile, visible on larger screens -->
    <?php if (!empty($image_url)): ?>
        <div class="hidden 2xl:block absolute pointer-events-none
                   w-[600px] h-[600px]
                   lg:w-[700px] lg:h-[700px]
                   xl:w-[891.916px] xl:h-[891.916px]
                   max-w-[891.916px]
                   top-1/2 -translate-y-1/2
                   right-[-558.516px]
                   
                   ">
            <img src="<?php echo esc_url($image_url); ?>" 
                 alt="<?php echo esc_attr($image_alt ?: $headline); ?>" 
                 class="w-full h-full object-cover object-center" />
        </div>
    <?php endif; ?>
    
</section>
