<?php
$blocks = get_field('blocks');

if ($blocks) :
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'testimonial_card') :
            $fields = $block['fields'] ?? [];
            $quote = $fields['quote'] ?? '';
            $author_photo = $fields['author_photo'] ?? [];
            $author_name = $fields['author_name'] ?? '';
            $author_role = $fields['author_role'] ?? '';
        endif;
    endforeach;
?>

<section id="testimonial-card" class="relative py-[clamp(64px,calc(120/1920*100vw),120px)]">
    <div class="content mx-auto px-4 max-w-[1104px]">
        
        <!-- Testimonial Card -->
        <div class="bg-blue-50 border-[0.5px] border-blue-100 rounded-[24px] p-8 md:p-[48px] flex flex-col md:flex-row items-start justify-between overflow-hidden relative">
            
            <!-- Left: Quote and Author -->
            <div class="flex flex-col gap-14 flex-1">

                <!-- Quote -->
                <?php if ($quote) : ?>
                    <blockquote class="font-inter font-normal text-[clamp(24px,calc(40/1920*100vw),40px)] leading-[1.2] tracking-[-0.264px] md:tracking-[-0.44px] text-blue-950 max-w-[530px] xl:max-w-[792px]">
                        "<?php echo htmlspecialchars_decode($quote); ?>"
                    </blockquote>
                <?php endif; ?>
                
                <!-- Author Info -->
                <div class="flex gap-4 md:gap-[16px] items-center">
                    
                    <!-- Author Photo -->
                    <?php if (!empty($author_photo)) : ?>
                        <div class="w-16 h-16 md:w-[64px] md:h-[64px] rounded-full overflow-hidden shrink-0 bg-white">
                            <img src="<?php echo esc_url($author_photo['url']); ?>" 
                                 alt="<?php echo esc_attr($author_photo['alt'] ?? $author_name); ?>"
                                 class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>
                    
                    <!-- Author Details -->
                    <div class="flex flex-col gap-1">
                        <?php if ($author_name) : ?>
                            <p class="font-inter font-normal text-[clamp(16px,calc(20/1920*100vw),20px)] leading-[1.3] tracking-[-0.176px] md:tracking-[-0.22px] text-neutral-950">
                                <?php echo htmlspecialchars_decode($author_name); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($author_role) : ?>
                            <p class="font-satoshi font-normal text-[clamp(12px,calc(14/1920*100vw),14px)] leading-[1.5] tracking-[-0.132px] md:tracking-[-0.154px] text-neutral-600">
                                <?php echo htmlspecialchars_decode($author_role); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                </div>
                
            </div>
            
            <!-- Right: Quote Icon -->
            <div class="order-first md:order-last md:flex flex-col items-end justify-end self-stretch w-[68.703px] md:w-[136.179px] h-14 md:h-[111px] shrink-0 mb-8 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 137 111" fill="none">
                    <path d="M76.9553 111V85.1118C88.7764 83.6933 96.4601 79.9105 100.006 73.7636C103.789 67.6166 105.681 59.4601 105.681 49.2939L126.604 53.5495H77.6646V0H136.179V39.7188C136.179 57.4505 131.332 72.9361 121.639 86.1757C112.182 99.4153 97.2875 107.69 76.9553 111ZM0 111V85.1118C11.8211 83.6933 19.5048 79.9105 23.0511 73.7636C26.8339 67.6166 28.7253 59.4601 28.7253 49.2939L49.6486 53.5495H0.709281V0H59.2236V39.7188C59.2236 57.4505 54.377 72.9361 44.6837 86.1757C35.2268 99.4153 20.3323 107.69 0 111Z" fill="#053169"/>
                </svg>
            </div>
            
        </div>
        
    </div>
</section>
<?php endif; ?>
