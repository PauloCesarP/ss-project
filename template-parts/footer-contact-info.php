<div class="flex gap-4 items-center">
    <div class="w-4 h-4 flex-shrink-0">
        <?php if ($icon_path && file_exists($icon_path)): ?>
            <?php echo file_get_contents($icon_path); ?>
        <?php endif; ?>
    </div>
    <?php if ($label): ?>
        <p class="font-inter text-[16px] leading-[1.5] tracking-[-0.176px] text-[#666765] font-normal whitespace-nowrap">
            <?php echo esc_html($label); ?>
        </p>
    <?php endif; ?>
</div>