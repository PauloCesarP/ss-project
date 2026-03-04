<?php
/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
        </main>

        <?php do_action('tailpress_content_end'); ?>
    </div>

    <?php do_action('tailpress_content_after'); ?>

    <footer id="colophon" class="bg-[#f6f6f6]" role="contentinfo">
        <div class="content mx-auto lg:pt-[88px] lg:pb-[48px] py-8">
            <div class="flex flex-col gap-8 md:gap-14">
                <div class="flex flex-row sm:flex-col lg:flex-row justify-between gap-12 lg:gap-0">
                    <div class="flex flex-col gap-12 w-full lg:w-[320px]">
                        <div class="flex flex-col gap-8">
                            <div class="footer-logo-container max-w-[11.75rem] max-h-[3.125rem]">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                <?php 
                                if ( function_exists('get_field') ) :
                                    $footer_logo = get_field('footer_logo', 'option');
                                    if ($footer_logo): ?>
                                        <img src="<?php echo esc_url($footer_logo['url']); ?>" alt="<?php echo esc_attr($footer_logo['alt']); ?>" class="w-full h-full object-contain">
                                    <?php endif; ?>
                                <?php endif; ?>
                                </a>
                            </div>
                            <p class="font-inter text-[16px] leading-[1.5] tracking-[0.0313rem] text-[#666765] font-normal">
                                <?php
                                if ( function_exists('get_field') ) :
                                    $footer_description = get_field('footer_company_description', 'option');
                                    echo $footer_description ? esc_html($footer_description) : '';
                                endif;
                                ?>
                            </p>
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <p class="font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] text-[#0d0d0d] font-normal">
                                 <?php
                                 if ( function_exists('get_field') ) :
                                     $contact_title = get_field('footer_contact_title', 'option');
                                     echo $contact_title ? htmlspecialchars_decode($contact_title) : '';
                                 endif;
                                 ?>
                            </p>
                            <div class="flex flex-col gap-4 w-[257px]">
                                <?php display_footer_contact_info(); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hidden sm:flex sm:flex-row gap-4">
                            <?php if ( has_nav_menu( 'footer-1' ) ) : ?>
                        <div class="flex flex-col gap-4 w-full md:w-[208px]">
                            <?php 
                            $menu_locations = get_nav_menu_locations();
                            $menu_id = isset($menu_locations['footer-1']) ? $menu_locations['footer-1'] : 0;
                            $menu_object = wp_get_nav_menu_object( $menu_id );
                            $menu_name = $menu_object ? $menu_object->name : '';
                            ?>
                            <p class="font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] text-[#0d0d0d] font-normal">
                                <?php echo esc_html( $menu_name ); ?>
                            </p>
                            <div class="flex flex-col gap-4">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'footer-1',
                                        'menu_class'     => 'footer-menu-1 flex flex-col gap-4 font-inter text-[16px] leading-[1.5] tracking-[-0.176px] text-[#666765] font-normal hover:text-[#053169] transition-colors [&_a]:!no-underline',
                                        'container'      => false,
                                    )
                                );
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ( has_nav_menu( 'footer-2' ) ) : ?>
                        <div class="flex flex-col gap-4 w-full md:w-[208px]" aria-label="<?php esc_attr_e( 'Footer Menu 2', 'ss-theme' ); ?>">
                            
                            <?php 
                            $menu_locations = get_nav_menu_locations();
                            $menu_id = isset($menu_locations['footer-2']) ? $menu_locations['footer-2'] : 0;
                            $menu_object = wp_get_nav_menu_object( $menu_id );
                            $menu_name = $menu_object ? $menu_object->name : '';
                            ?>
                            
                            <p class="font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] text-[#0d0d0d] font-normal">
                                <?php echo esc_html( $menu_name ); ?>
                            </p>
                            <div class="flex flex-col gap-4">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'footer-2',
                                        'menu_class'     => 'footer-menu-2 flex flex-col gap-4 font-inter text-[16px] leading-[1.5] tracking-[-0.176px] text-[#666765] font-normal hover:text-[#053169] transition-colors [&_a]:!no-underline',
                                        'container'      => false,
                                    )
                                );
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex flex-col gap-10">
                    <div class="w-full h-[0.5px] bg-[#cccdcb]"></div>
                    
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-8 md:gap-4">
                        <p class="font-satoshi text-[14px] leading-[1.5] tracking-[-0.154px] text-[#666765] font-normal whitespace-nowrap">
                            <?php
                            if ( function_exists('get_field') ) :
                                $footer_copyright = get_field('footer_copyright', 'option');
                                if ($footer_copyright && $footer_copyright['copyright_text']) {
                                    echo esc_html($footer_copyright['copyright_text']);
                                }
                            endif;
                            ?>
                        </p>
                        
                        <div class="flex items-start md:items-center gap-4 justify-between w-full md:w-[544px]">
                            <div class="flex gap-8 items-center">
                                <?php
                                if ( function_exists('get_field') ) :
                                    $footer_copyright = get_field('footer_copyright', 'option');
                                    if ($footer_copyright && $footer_copyright['copyright_links']):
                                        foreach ($footer_copyright['copyright_links'] as $link_item):
                                            $link = $link_item['copyright_link'];
                                            if ($link && $link['url'] && $link['title']):
                                                $target = $link['target'] ? ' target="' . esc_attr($link['target']) . '"' : '';
                                    ?>
                                    <a href="<?php echo esc_url($link['url']); ?>"<?php echo $target; ?> class="font-satoshi text-[14px] leading-[1.5] tracking-[-0.4px] text-[#666765] font-normal whitespace-nowrap hover:text-[#053169] transition-colors !no-underline">
                                        <?php echo esc_html($link['title']); ?>
                                    </a>
                                    <?php endif;
                                        endforeach;
                                            endif;
                                                endif; ?>
                            </div>
                            
                            <div class="w-6 h-6 flex-shrink-0">
                                <?php display_footer_social_icons(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
