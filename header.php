<?php
/**
 * Theme header template.
 *
 * @package TailPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-neutral-600 antialiased'); ?>>
<?php do_action('tailpress_site_before'); ?>

<div id="page" class="flex flex-col">
    <?php do_action('tailpress_header'); ?>

    <header class="flex w-full py-5 px-4 2xl:px-14 border-b-[0.0313rem] max-h-[88px] border-solid border-b-neutral-600 bg-white">
        <div class="container px-0 mx-auto max-w-[1952px]">
            <div class="md:flex md:justify-between md:items-center">
            <div class="flex justify-between items-center">
                <div class="logo-container max-w-[7.875rem] max-h-[2.125rem]">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <div class="flex items-center gap-2">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="!no-underline lowercase font-medium text-lg">
                                <?php bloginfo('name'); ?>
                            </a>
                            <?php if ($description = get_bloginfo('description')): ?>
                                <span class="text-sm font-light text-dark/80">|</span>
                                <span class="text-sm font-light text-dark/80"><?php echo esc_html($description); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (has_nav_menu('primary')): ?>
                    <div class="md:hidden">
                        <button type="button" aria-label="Toggle navigation" id="primary-menu-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <div id="primary-navigation" class="hidden md:flex md:bg-transparent gap-6 items-center border border-light md:border-none rounded-xl p-4 md:p-0">
                <nav>
                    <?php if (current_user_can('administrator') && !has_nav_menu('primary')): ?>
                        <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>" class="text-sm text-neutral-600"><?php esc_html_e('Edit Menus', 'tailpress'); ?></a>
                    <?php else: ?>
                        <?php
                        wp_nav_menu([
                            'container_id'    => 'primary-menu',
                            'container_class' => '',
                            'menu_class'      => 'md:flex items-center lg:gap-16 sm:gap-8 mx-0 [&_a]:!no-underline [&_li:last-child]:mx-0 [&_li:last-child_a]:bg-[#074B99] [&_li:last-child_a]:text-white [&_li:last-child_a]:px-6 [&_li:last-child_a]:py-3 [&_li:last-child_a]:rounded-full [&_li:last-child_a]:hover:bg-[#063B7A] [&_li:last-child_a]:transition-colors [&_li:last-child_a]:duration-200 [&_li:last-child_a]:flex [&_li:last-child_a]:items-center [&_li:last-child_a]:font-medium [&_li:last-child_a]:gap-3 [&_li:last-child_a]:font-medium [&_li:last-child_a]:tracking-[1.1%] [&_li:nth-child(3)]:tracking-[-0.02em]',
                            'theme_location'  => 'primary',
                            'li_class'        => 'md:mx-0 tracking-[0.045px]',
                            'fallback_cb'     => false,
                        ]);
                        ?>
                    <?php endif; ?>
                </nav>
            </div>

            <div id="mobile-menu-overlay" class="fixed inset-0 bg-white z-50 md:hidden transform translate-x-full transition-transform duration-300 ease-in-out">
                <div class="flex flex-col h-full">
                    <div class="flex justify-between items-center py-5 px-[1rem] md:px-14 border-b-[0.5px] border-neutral-600">
                        <div class="logo-container max-w-[7.875rem] max-h-[2.125rem]">
                            <?php if (has_custom_logo()): ?>
                                <?php the_custom_logo(); ?>
                            <?php else: ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="!no-underline lowercase font-medium text-lg">
                                    <?php bloginfo('name'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <button type="button" aria-label="Close navigation" id="mobile-menu-close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-start px-4 md:px-14">
                        <nav>
                            <?php if (current_user_can('administrator') && !has_nav_menu('primary')): ?>
                                <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>" class="text-lg text-neutral-600"><?php esc_html_e('Edit Menus', 'tailpress'); ?></a>
                            <?php else: ?>
                                <?php
                                wp_nav_menu([
                                    'container_id'    => 'mobile-menu',
                                    'container_class' => '',
                                    'menu_class'      => 'flex flex-col pt-8 gap-8 [&_a]:!no-underline [&_a]:text-2xl [&_a]:font-medium [&_a]:text-neutral-800 [&_a]:py-2 [&_a]:transition-colors [&_a]:duration-200 hover:[&_a]:text-[#074B99] [&_li:last-child_a]:bg-[#074B99] [&_li:last-child_a]:text-white [&_li:last-child_a]:px-8 [&_li:last-child_a]:py-4 [&_li:last-child_a]:rounded-full [&_li:last-child_a]:text-center [&_li:last-child_a]:mt-4 [&_li:last-child_a]:inline-flex [&_li:last-child_a]:items-center [&_li:last-child_a]:justify-center [&_li:last-child_a]:gap-3 [&_li:last-child_a]:hover:bg-[#063B7A]',
                                    'theme_location'  => 'primary',
                                    'li_class'        => '',
                                    'fallback_cb'     => false,
                                ]);
                                ?>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('primary-menu-toggle');
        const menuClose = document.getElementById('mobile-menu-close');
        const mobileOverlay = document.getElementById('mobile-menu-overlay');
        const body = document.body;

        if (menuToggle && mobileOverlay) {
            menuToggle.addEventListener('click', function() {
                mobileOverlay.classList.remove('translate-x-full');
                mobileOverlay.classList.add('translate-x-0');
                body.classList.add('overflow-hidden'); // Prevent body scroll
            });
        }

        if (menuClose && mobileOverlay) {
            menuClose.addEventListener('click', function() {
                mobileOverlay.classList.remove('translate-x-0');
                mobileOverlay.classList.add('translate-x-full');
                body.classList.remove('overflow-hidden'); // Restore body scroll
            });
        }

        // Close menu when clicking on menu links
        const mobileMenuLinks = document.querySelectorAll('#mobile-menu a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileOverlay.classList.remove('translate-x-0');
                mobileOverlay.classList.add('translate-x-full');
                body.classList.remove('overflow-hidden');
            });
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !mobileOverlay.classList.contains('translate-x-full')) {
                mobileOverlay.classList.remove('translate-x-0');
                mobileOverlay.classList.add('translate-x-full');
                body.classList.remove('overflow-hidden');
            }
        });
    });
    </script>

    <div id="content" class="site-content grow">
        <?php do_action('tailpress_content_start'); ?>
        <main>
