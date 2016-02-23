        <div id="footer" class="row">
            <div id="copyright" class="footer-widget three column">
                <p><?php echo get_option('scom_footer'); ?></p>
                <div id="buttons">
                    <?php 
                        $path = get_bloginfo('template_directory').'/img/pay/';
                        $ext = '.png';
                        $paymentImg = array(
                            'payondelivery' => 'payondelivery',
                            'paypal' => 'paypal',
                            'paypalpro' => 'paypalpro',
                            'pm2checkout' => '2checkout',
                            'deposit_account' => 'deposit',
                            'authorizenet_aim' => 'deposit',
                            'authorizenet_sim' => 'authorize',
                            'authorizenet_sim' => 'authorize',
                            'sagepay' => 'sagepay',
                            'soeasypay' => 'soeasypay',
                            'eprocessingnetwork' => 'eprocessingnetwork',
                            'e4_payments' => 'e4_payments',
                            'moneybookers' => 'moneybookers'                              
                        );
                        foreach(frame::_()->getModules(array('type' => 'payment')) as $code => $pay) {
                            if(isset($paymentImg[$code])) {
                                echo '<img src="'.$path.$paymentImg[$code].$ext.'" alt="'.$paymentImg[$code].'" />';
                            }
                        }
                    ?>
                </div>
            </div>
            
            <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'footercontact' ) ) : ?>
            <div id="contact-us" class="footer-widget two column">
                <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'footercontact' ); ?>
            </div>
            <?php endif; ?>
            
            <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'footertwitter' ) ) : ?>
            <div id="latest-tweets" class="footer-widget five column">
                <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'footertwitter' ); ?>
            </div>
            <?php endif; ?>
            
            <div id="links" class="footer-widget two column">
                <h3><?php echo lang::_e('Help'); ?></h3>
                <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container'=>'', 'menu_id' => '', 'fallback_cb' => 'wp_page_menu', 'depth' => 1) ); ?>
                <div class="social">
                    <?php if (get_option('scom_twitter') <> '') : ?>
                    <a href="http://twitter.com/<?php echo get_option('scom_twitter'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory').'/img/social/twitter.png'; ?>" alt="" /></a>
                    <?php endif; ?>
                    <?php if (get_option('scom_facebook') <> '') : ?>
                    <a href="<?php echo get_option('scom_facebook'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory').'/img/social/facebook.png'; ?>" alt="" /></a>
                    <?php endif; ?>
                    <?php if (get_option('scom_gplus') <> '') : ?>
                    <a href="<?php echo get_option('scom_gplus'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory').'/img/social/google.png'; ?>" alt="" /></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clear"></div>
        </div><!-- End Footer -->
        <?php wp_footer(); ?>
    </div>
 </body>
</html>