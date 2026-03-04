<?php
$fields = get_sub_field('fields') ?? [];
$sidebar_title = $fields['sidebar_title'] ?? '';
$page_id = get_the_ID();
$sidebar_contact_info = display_sidebar_contact_info($page_id);
$business_hours = $fields['subtitle'] ?? '';
$content = $fields['content'] ?? '';
$form_shortcode = $fields['form_shortcode'] ?? '';

?>
<style>
    #contact-form-split {}
    #contact-form-split .gform_heading {
        display: none;
    }
    #contact-form-split .gfield_label.gform-field-label {
        color: #053169;
        font-size: 12px;
        font-style: normal;
        font-weight: 500;
        line-height: 150%;
        letter-spacing: -0.132px;
    }
    #contact-form-split .gfield_required.gfield_required_asterisk {
        color: #DA5533;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: 120%; /* 21.6px */
        letter-spacing: -0.5px;
    }
    #contact-form-split .gform_wrapper .gfield input[type="text"],
    #contact-form-split .gform_wrapper .gfield input[type="email"],
    #contact-form-split .gform_wrapper .gfield input[type="tel"],
    #contact-form-split .gform_wrapper .gfield textarea,
    #contact-form-split .gform_wrapper .gfield select {
        border: 1px solid #7F817E;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 400;
        height: 45px;
        line-height: 110%;
        letter-spacing: -0.176px;
        color: #999A98;
    }
    #contact-form-split .gform_wrapper .gfield input[type="text"]:focus,
    #contact-form-split .gform_wrapper .gfield input[type="email"]:focus,
    #contact-form-split .gform_wrapper .gfield input[type="tel"]:focus,
    #contact-form-split .gform_wrapper .gfield textarea:focus,
    #contact-form-split .gform_wrapper .gfield select:focus {
        border-color: #053169;
        outline: none;
    }
    #contact-form-split .gform_wrapper .gfield select {
        display: flex;
        align-items: center;
    }
    #contact-form-split .gform_wrapper .gfield input[type="checkbox"] {
        width: 24px;
        height: 24px;
        border: 1px solid #999A98;
        border-radius: 4px;
    }
    #contact-form-split .gform-theme--framework .gfield--type-choice .gchoice {
        align-items: center;
    }
    #contact-form-split .gform-theme--framework .gfield--type-choice .gchoice .gform-field-label--type-inline {
        margin-left: 8px;
    }
    #contact-form-split .gform_wrapper .gfield input[type="text"]::placeholder,
    #contact-form-split .gform_wrapper .gfield input[type="email"]::placeholder,
    #contact-form-split .gform_wrapper .gfield input[type="tel"]::placeholder,
    #contact-form-split .gform_wrapper .gfield textarea::placeholder {
        color: #999A98;
        font-size: 14px;
        font-weight: 400;
        line-height: 150%; /* 21px */
        letter-spacing: -0.154px;
    }
    #contact-form-split .gform_wrapper .gform_footer .gform_button {
        width: 100%;
    }
    #contact-form-split .gform_wrapper .gform_footer .gform_button {
        background-color: #053169;
        color: #f6f6f6;
        border-radius: 9999px;
        padding: 12px 24px;
        font-size: 12px;
        font-weight: 500;
    }
    #contact-form-split .gform-body.gform_body .gform_fields {
        gap: 16px;
    }
    @media (min-width: 768px) {
        #contact-form-split .gform_wrapper .gform_footer .gform_button {
            width: auto;
        }
        #contact-form-split .gform_wrapper .gfield input[type="text"],
        #contact-form-split .gform_wrapper .gfield input[type="email"],
        #contact-form-split .gform_wrapper .gfield input[type="tel"],
        #contact-form-split .gform_wrapper .gfield textarea,
        #contact-form-split .gform_wrapper .gfield select {
            height: 48px;
        }
    }
</style>
<!-- Contact Form Split -->
<section id="contact-form-split" class="relative bg-white 
               py-8
               xl:py-[112px]">
    
    <div class="content flex flex-col gap-8 lg:flex-row lg:gap-4">
        
        <!-- Direct Contact Block - Left Side -->
        <div class="order-last lg:order-first lg:block w-full lg:w-[432px]">
            
            <div class="flex flex-col gap-8 bg-blue-50 rounded-[28px] py-8 px-8">
                
                <!-- Title -->
                <h2 class="font-normal text-blue-950
                          text-[24px] leading-[1.4] tracking-[-0.264px]
                          sm:text-[28px] sm:tracking-[-0.308px]
                          md:text-[30px] md:tracking-[-0.33px]
                          lg:text-[32px] lg:tracking-[-0.352px]">
                    <?php echo htmlspecialchars_decode($sidebar_title); ?>
                </h2>
                
                <!-- Contact Details -->
                <div class="flex flex-col gap-4">
                    
                    <?php foreach ($sidebar_contact_info as $info_item) : ?>
                        <div class="flex gap-4 items-center">
                            <img src="<?php echo $info_item['icon_path']; ?>" alt="<?php echo esc_attr($info_item['label']); ?>" class="w-[12.40px] h-[12.40px] object-contain object-center shrink-0">
                            <p class="font-normal text-neutral-700 text-[18px] leading-[1.4] tracking-[-0.198px]">
                                <?php echo esc_html($info_item['label']); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Business Hours -->
                <?php if (!empty($business_hours) || !empty($content)): ?>
                    <div class="flex flex-col gap-2">
                        <?php if (!empty($business_hours)): ?>
                            <p class="text-neutral-700 text-[16px] leading-normal tracking-[-0.176px]">
                                <span class="font-bold"><?php echo nl2br(esc_html($business_hours)); ?></span>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (!empty($content)): ?>
                            <p class="font-normal text-neutral-700 text-[14px] lg:text-[16px] leading-normal tracking-[-0.176px] gap-2">
                                <?php echo htmlspecialchars_decode($content); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            </div>
            
        </div>
        
        <!-- Form Section - Right Side -->
        <div class="flex-1 lg:pl-12 pb-8 lg:pb-0">
            <?php if (!empty($form_shortcode)): ?>
                <?php echo do_shortcode($form_shortcode); ?>
            <?php endif; ?>
        </div>
        
    </div>
    
</section>