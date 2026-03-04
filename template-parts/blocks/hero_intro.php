<?php
$fields = get_sub_field('fields') ?? [];
$headline = $fields['headline'] ?? '';
$description = $fields['description'] ?? '';
?>

<!-- Intro Block -->
    <section class="w-full 
                   px-4 py-12
                   sm:py-16
                   md:py-20
                   lg:py-24
                   xl:py-[120px]">
        <div class="content flex flex-col gap-4 
                   md:flex-row md:gap-4
                   lg:gap-4">
            <div class="flex-1 max-w-[656px]">
                <?php if (!empty($headline)): ?>
                <h1 class="font-normal text-blue-950
                          text-[32px] leading-[1.1] tracking-[-0.64px]
                          lg:text-[64px] xl:tracking-[-1.28px]">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h1>
                <?php endif; ?>
            </div>
            <div class="flex-1 max-w-[656px]">
                <?php if (!empty($description)): ?>
                <p class="font-normal text-neutral-600
                         text-[16px] leading-[1.4] tracking-[-0.176px]
                         md:text-[17px]
                         lg:text-[18px] lg:tracking-[-0.198px]">
                    <?php echo htmlspecialchars_decode($description); ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<!-- End Intro Block -->