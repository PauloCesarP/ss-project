<?php
$blocks = get_field('blocks');

if ($blocks) : 
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'team_grid') :
            $fields = $block['fields'] ?? [];
            $label = $fields['label'] ?? '';
            $headline = $fields['headline'] ?? '';
            $members = [];
            if (!empty($fields['members'])) {
                foreach ($fields['members'] as $member_post) {
                    $member_id = $member_post->ID;
                    $members[] = [
                        'photo' => get_field('photo', $member_id),
                        'name' => $member_post->post_title,
                        'role' => get_field('role', $member_id),
                        'bio' => get_field('bio', $member_id),
                        'linkedin_url' => get_field('link_url', $member_id),
                    ];
                }
            }
            $show_carousel = $fields['show_carousel'] ?? false;
        endif;
    endforeach;
?>

<section id="team-grid" class="relative bg-blue-50 py-[clamp(64px,calc(120/1920*100vw),120px)]">
    
    <!-- Header -->
    <div class="content mx-auto px-4">
        <div class="flex flex-col gap-4 md:gap-[16px] mb-[clamp(40px,calc(56/1920*100vw),56px)] max-w-[656px]">
            <?php if ($label) : ?>
                <p class="font-inter font-medium text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-blue-500">
                    <?php echo htmlspecialchars_decode($label); ?>
                </p>
            <?php endif; ?>
            
            <?php if ($headline) : ?>
                <h2 class="font-inter font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[1.2] tracking-[-0.44px] text-neutral-950">
                    <?php echo htmlspecialchars_decode($headline); ?>
                </h2>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Team Grid -->
    <?php if (!empty($members)) : ?>
        <div class="mx-auto px-4 flex flex-col gap-8 md:gap-[56px]">
            
            <!-- Team Members Container  
             
            class="flex relative overflow-x-auto gap-4 md:gap-[16px] snap-x snap-mandatory scrollbar-hide px-4 md:pl-[calc((100vw-1360px)/2)] md:pr-0 <?php // echo $show_carousel ? '' : 'md:grid md:grid-cols-2 lg:grid-cols-3 md:overflow-visible md:px-6 content md:mx-auto'; ?>"-->
            <div id="team-grid-scroll" class="relative overflow-x-auto scrollbar-hide md:pl-[calc((100vw-1360px)/2)] -mx-4 px-4 md:mx-0 md:pr-0">
                    <div class="flex gap-4 md:gap-4 pb-4 snap-x snap-mandatory">
                    <?php foreach ($members as $index => $member) : 
                        $photo = $member['photo'] ?? null;
                        $name = $member['name'] ?? '';
                        $role = $member['role'] ?? '';
                        $bio = $member['bio'] ?? '';
                        $linkedin_url = $member['linkedin_url'] ?? '';
                    ?>
                    
                    <!-- Team Member Card -->
                    <div class="bg-white border-[0.2px] border-blue-100 rounded-[24px] p-8 md:p-[48px] flex flex-col gap-8 md:gap-[32px] min-w-[calc(100vw-32px)] md:min-w-0 md:w-[544px] snap-start shrink-0">
                        
                        <!-- Member Details -->
                        <div class="flex flex-col gap-8 md:gap-[32px]">
                            
                            <!-- Photo -->
                            <?php if ($photo) : ?>
                                <div class="w-[95px] h-[95px] rounded-full overflow-hidden bg-blue-100">
                                    <img src="<?php echo esc_url($photo['url']); ?>" 
                                         alt="<?php echo esc_attr($photo['alt'] ?? $name); ?>"
                                         class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>
                            
                            <!-- Text Content -->
                            <div class="flex flex-col gap-4 md:gap-[16px]">
                                
                                <!-- Name and Role -->
                                <div class="flex flex-col">
                                    <h3 class="font-inter font-normal text-[clamp(20px,calc(24/1920*100vw),24px)] leading-[1.2] tracking-[-0.264px] text-neutral-950">
                                        <?php echo htmlspecialchars_decode($name); ?>
                                    </h3>
                                    <p class="font-inter font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-600">
                                        <?php echo htmlspecialchars_decode($role); ?>
                                    </p>
                                </div>
                                
                                <!-- Bio -->
                                <?php if ($bio) : ?>
                                    <div class="font-inter font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[1.5] tracking-[-0.176px] text-neutral-600 [&>p:not(:last-child)]:mb-[8px]">
                                        <?php echo wp_kses_post(wpautop($bio)); ?>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                            
                        </div>
                        
                        <!-- LinkedIn Link -->
                        <?php if ($linkedin_url) : ?>
                            <div class="pt-8 md:pt-[32px] border-t border-transparent">
                                <a href="<?php echo esc_url($linkedin_url); ?>" 
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-3 md:gap-[12px] group">
                                    <span class="font-inter font-medium text-[16px] leading-[1.5] tracking-[-0.176px] text-neutral-900 group-hover:text-blue-900 transition-colors">
                                        Linkedin
                                    </span>
                                    <svg class="w-[11px] h-[11px] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 10L10 1M10 1V10M10 1H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    
                    <?php endforeach; ?>
                    
            
                </div>
            </div>
            
            <!-- Carousel Controls -->
            <?php if ($show_carousel && count($members) > 1) : ?>
                <div class="content mx-auto px-4">
                    <div class="flex items-center gap-6 md:gap-[24px]">
                        
                        <!-- Progress Bar Container -->
                        <div class="flex-1 flex items-center relative">
                            <div class="absolute inset-0 h-1 bg-neutral-200 rounded-[48px]"></div>
                            <div id="team-progress-bar" class="h-2 bg-blue-950 rounded-[48px] absolute transition-all duration-300 w-[72.483px] md:w-[208px] left-0 top-[-2px]"></div>
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="flex items-center gap-2">
                            <button id="team-prev-btn" 
                                    class="w-10 h-10 cursor-pointer rounded-full bg-white border border-blue-100 flex items-center justify-center hover:bg-blue-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    aria-label="Previous team member">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 16L6 10L12 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button id="team-next-btn" 
                                    class="w-10 h-10 cursor-pointer rounded-full bg-white border border-blue-100 flex items-center justify-center hover:bg-blue-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    aria-label="Next team member">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 4L14 10L8 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>    
                    </div>
                </div>

            <?php endif; ?>
            
        </div>
    <?php endif; ?>
    
</section>
<?php endif; ?>