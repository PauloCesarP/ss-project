<?php
$blocks = get_field('blocks');

if ($blocks) : 
    foreach ($blocks as $block) :
        $layout = $block['acf_fc_layout'] ?? '';
        
        if ($layout === 'team_highlight') :
            $fields = $block['fields'] ?? [];
            $label = $fields['label'] ?? '';
            $headline = $fields['headline'] ?? '';
            $content = $fields['content'] ?? '';
            $cta_link = $fields['cta_link'] ?? '';
            // $members = $fields['members'] ?? []; // repeater field: photo, name, role, link_url

            // Fetch members from Relationship field
            $members = [];
            if (!empty($fields['members'])) {
                foreach ($fields['members'] as $member_post) {
                    $member_id = $member_post->ID;
                    $members[] = [
                        'photo' => get_field('photo', $member_id),
                        'name' => $member_post->post_title,
                        'role' => get_field('role', $member_id),
                        'link_url' => get_field('link_url', $member_id),
                    ];
                }
            }
            
        endif;
    endforeach;

?>

<section id="team-highlight" class="relative bg-white py-8 lg:py-[136px] overflow-hidden">
    <div class="content mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-[clamp(32px,calc(72/1920*100vw),72px)] items-start">
            
            <!-- Left Column: Content -->
            <div class="w-full lg:flex-1 flex flex-col gap-[clamp(40px,calc(64/1920*100vw),64px)]">
                <div class="flex flex-col gap-[clamp(24px,calc(32/1920*100vw),32px)]">
                    <div class="flex flex-col gap-8">
                        <?php if ($headline) : ?>
                            <h2 class="font-normal text-[clamp(32px,calc(40/1920*100vw),40px)] leading-[120%] tracking-[-0.352px] md:tracking-[-0.44px] text-neutral-950">
                                <?php echo htmlspecialchars_decode($headline); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ($label) : ?>
                            <p class="order-first font-medium text-[clamp(12px,calc(16/1920*100vw),16px)] leading-[150%] tracking-[-0.132px] md:tracking-[-0.176px] text-blue-500">
                                <?php echo htmlspecialchars_decode($label); ?>
                            </p>
                        <?php endif; ?>
                        
                    </div>
                    
                    <?php if ($content) : ?>
                        <p class="font-normal text-[clamp(14px,calc(16/1920*100vw),16px)] leading-[150%] tracking-[-0.176px] text-[#313131]">
                            <?php echo htmlspecialchars_decode($content); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <?php if ($cta_link) : ?>
                    <a href="<?php echo esc_url($cta_link['url'] ?? 'javascript:void(0)'); ?>" 
                       class="chevron_right lg:self-start inline-flex items-center justify-center gap-3 bg-blue-950 hover:bg-blue-900 transition-colors px-6 py-4 rounded-[64px]"
                       <?php if (!empty($cta_link['target'])) : ?>target="<?php echo esc_attr($cta_link['target']); ?>"<?php endif; ?>>
                        <span class="font-normal text-[16px] leading-normal text-neutral-50">
                            <?php echo htmlspecialchars_decode($cta_link['title'] ?? 'About Us'); ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Right Column: Team Members -->
            <div class="w-full lg:flex-1 flex flex-col gap-6">
                <?php 
                if (!empty($members)) : 
                    $bg_colors = ['bg-blue-50', 'bg-blue-100', 'bg-blue-200']; // Cycle through blue shades
                    foreach ($members as $index => $member) :
                        $photo = $member['photo'] ?? null;
                        $name = $member['name'] ?? '';
                        $role = $member['role'] ?? '';
                        $link_url = $member['link_url'] ?? '';
                        $bg_class = $bg_colors[$index % 3];
                        
                        $card_classes = "relative w-full aspect-square lg:aspect-[516/400] rounded-[24px] overflow-hidden flex flex-col items-start justify-end p-4 pt-[216px]";
                        if ($index === 1) {
                            $card_classes .= " shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)]";
                        }
                ?>
                    <div class="<?php echo $card_classes; ?> group hover:shadow-[0px_8px_17px_0px_rgba(0,0,0,0.1)] transition-shadow duration-300">
                        <!-- Background with Image -->
                        <div class="absolute inset-0 <?php echo $bg_class; ?> rounded-[24px] min-h-[321px]">
                            <?php if ($photo) : ?>
                                <img src="<?php echo esc_url($photo['url']); ?>" 
                                     alt="<?php echo esc_attr($photo['alt'] ?? $name); ?>"
                                     class="w-full h-full object-cover object-center rounded-[24px] px-4 pt-5 pb-0">
                            <?php endif; ?>
                        </div>
                        
                        <!-- Info Card -->
                        <div class="relative bg-white rounded-2xl px-8 py-[23px] w-full flex items-start justify-between z-10">
                            <div class="flex flex-col gap-1">
                                <p class="font-normal text-[clamp(18px,calc(20/1920*100vw),20px)] leading-[1.3] tracking-[-0.22px] text-neutral-950 whitespace-nowrap">
                                    <?php echo htmlspecialchars_decode($name); ?>
                                </p>
                                <p class="font-satoshi-variable text-[clamp(12px,calc(14/1920*100vw),14px)] leading-[1.5] tracking-[-0.154px] text-neutral-600 whitespace-nowrap">
                                    <?php echo htmlspecialchars_decode($role); ?>
                                </p>
                            </div>
                            
                            <?php if ($link_url) : ?>
                                <a href="<?php echo esc_url($link_url); ?>" 
                                   target="_blank"
                                   class="flex-shrink-0 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-300"
                                   aria-label="View <?php echo esc_attr($name); ?> profile">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M1.66153 15.4285L0 13.7669L11.3933 2.37361H1.18681V0H15.4285V14.2417H13.0549V4.03514L1.66153 15.4285Z" fill="#313131"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
            
        </div>
    </div>
</section>

<?php endif; ?>