<div class="cart-mini">
    <div class="cart-ico">
        <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getShoppingCart'))?>" class="cart-link">
            <img src="<?php echo bloginfo('template_directory').'/img/cart-ico.png'; ?>"  alt="<?php lang::_e('Shopping cart'); ?>"/>
        </a>
    </div>
    <div class="cart-mini-state"><a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getShoppingCart'))?>" class="cart-link"><?php lang::_e('Cart')?></a> | <?php lang::_e('Your cart is empty')?></div>
</div>