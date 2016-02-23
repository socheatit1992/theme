<?php if($this->canEdit) {?>
<script type="text/javascript">
// <!--
var toeQtyPrev = '';
jQuery(document).ready(function(){
    jQuery('.prod_qty').keyup(function(){
        var val = jQuery(this).val();
        if(val == '')
            val = 0;
        if(!isNumber(toeQtyPrev)) {
            var intMatches = /\d+/.exec(toeQtyPrev);
            if(intMatches)
                toeQtyPrev = intMatches[0];
        }
        if(!isNumber(val)) 
            val = toeQtyPrev;
        jQuery(this).val(val);
    });
    jQuery('.prod_qty').keydown(function(){
        if(jQuery(this).val() == '0')
            jQuery(this).val('');
        toeQtyPrev = jQuery(this).val();
    });
    jQuery('.cartQtyUpdate').submit(function(){
        jQuery(this).sendForm({
            msgElID: 'qty_update_msg_'+ jQuery(this).find('input[type=hidden][name=inCartId]').val(),
            onSuccess: function(res) {
                if(res.data)
                    updateCart( [res.data.cart], res.data.totalHtml, res.data.newCartData );
            }
        });
        return false;
    });
    jQuery('.remove_from_cart').click(function(){
        var inCartId = jQuery(this).parents('tr:first').find('input[type=hidden][name=inCartId]').val();
        inCartId = parseInt(inCartId);
        if(isNumber(inCartId)) {
            jQuery(this).sendForm({
                msgElID: 'qty_update_msg_'+ inCartId,
                data: {inCartId: inCartId, reqType: 'ajax', action: 'updateCart', mod: 'user', qty: 0},
                onSuccess: function(res) {
                    if(res.data)
                        updateCart( [res.data.cart], res.data.totalHtml, res.data.newCartData );
                }
            });
        }
        return false;
    });  
});
// -->
</script>
<?php }?>
<div id="shopping-cart">
    <div class="clear"></div>
    <?php if (frame::_()->getModule('pages')->isCart()): ?>
    <h2><?php echo lang::_e('Shopping cart'); ?></h2>
    <hr class="wave-line" />
    <div class="clear"></div>
    <?php endif; ?>

    <table cellspacing="0" cellpadding="0" class="shopping_cart twelve">
        <thead>
            <tr style="height:22px;">
                <?php foreach($this->columns as $cKey => $cInfo) { ?>
                    <?php if($cInfo['disable']) continue;?>
                    <?php if($cKey == 'action' && !$this->canEdit) continue;?>
                    <td class="shopping_cart_<?php echo $cKey?>"><?php lang::_e($cInfo['title'])?></td>
                <?php }?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->cart as $inCartId => $c) { 
                $product = get_post($c['pid']);
            ?>
            <tr class="cart_row_<?php echo $inCartId?>">
                <?php foreach($this->columns as $cKey => $cInfo) {
                    if($cInfo['disable']) continue;
                    switch($cKey) {
                        case 'id' :?>
                            <td class="shopping_cart_<?php echo $cKey?>"><?php echo $c['pid'];?></td>
                        <?php break;
                        case'img':?>
                            <td class="shopping_cart_<?php echo $cKey?>">
                                <?php
                                    $imgsrc = frame::_()->getModule('products')->getView()->getProductImage($product);
                                ?>
                                <a href="<?php echo get_permalink($c['pid']); ?>" target="_blank">
                                    <img src="<?php get_image($imgsrc['big'][0], 138, 84, 'height'); ?>" alt="<?php echo get_the_title();?>" />
                                </a>
                            </td>
                        <?php break;
                        case 'name': ?>
                            <td class="shopping_cart_<?php echo $cKey?>">
                                <a href="<?php echo get_permalink($c['pid']); ?>"><?php echo $c['name']?></a><!--<span class="toeProdOutOfStock">***</span>-->
                                <?php if(!empty($c['options'])) { ?>
                                    <div>
                                    <?php foreach($c['options'] as $optKey => $opt) { ?>
                                        <b><?php lang::_e($opt['label'])?></b>: 
                                        <?php 
                                            if(is_array($opt['displayValue']))
                                                echo implode(', ', $opt['displayValue']);
                                            else
                                                echo $opt['displayValue']
                                        ?><br />
                                    <?php } ?>
                                    </div>
                                <?php }?>
                            </td>
                        <?php break;
                        case 'qty':?>
                            <td class="shopping_cart_<?php echo $cKey?>">
                                <?php if($this->canEdit && !$c['gift']) {?>
									<?php echo html::formStart('qty_cart', array('action' => '', 'attrs' => 'class="cartQtyUpdate"'))?>
                                        <?php echo html::textIncDec('qty', array('value' => $c['qty'], 'attrs' => 'class="prod_qty"', 'id' => 'qty_'. $inCartId. ''))?>
                                        <?php echo html::hidden('reqType', array('value' => 'ajax'))?>
                                        <?php echo html::hidden('action', array('value' => 'updateCart'))?>
                                        <?php echo html::hidden('mod', array('value' => 'user'))?>
                                        <?php /** @deprecated @see inCartId key, but DO NOT delete this*/?>
                                        <?php echo html::hidden('pid', array('value' => $c['pid']))?>
                                        <?php /*****/?>
                                        <?php echo html::hidden('inCartId', array('value' => $inCartId))?>
                                        <?php echo html::submit('update', array('value' => lang::_('Update'), 'attrs' => 'class="update_qty"'))?>
                                    <?php echo html::formEnd()?>
                                    <div id="qty_update_msg_<?php echo $inCartId?>" class="toeItemQtypdateMessage"></div>
                                <?php } else {
									if($this->canEdit && $c['gift']) {	//Show this for gifts
										echo html::formStart('qty_cart', array('action' => '', 'attrs' => 'class="cartQtyUpdate"'));
										echo html::hidden('inCartId', array('value' => $inCartId));
										echo html::formEnd();
									}
                                    echo $c['qty'];
                                }?>
                                <div class="clear"></div>
                                
                            </td>
                        <?php break;
                        case 'price': ?>
                            <td class="shopping_cart_<?php echo $cKey?>">
                                <?php if($c['gift']) {
                                    lang::_e('It\'s a gift');
                                } else {
									echo frame::_()->getModule('currency')->displayTotal($c['price'], 1 /*Price for one product*/, $c['pid'], array('options' => $c['options']));
                                    //echo frame::_()->getModule('currency')->display($c['price']);
                                }?>
                            </td>
                        <?php break;
                        case 'total': ?>
                            <td class="total_<?php echo $inCartId?>">
                                <?php if($c['gift']) {
                                    lang::_e('It\'s a gift');
                                } else {
                                    echo frame::_()->getModule('currency')->displayTotal($c['price'], $c['qty'], $c['pid'], array('options' => $c['options']));
                                }?>
                            </td>
                        <?php break;
                        case 'action': ?>
                            <?php if($this->canEdit) {?>
                            <td class="shopping_cart_<?php echo $cKey?>">
								<?php if(!isset($this->columns['qty']) || $this->columns['qty']['disable']) { ?>
									<div id="qty_update_msg_<?php echo $inCartId?>"></div>
								<?php }?>
								<?php echo html::hidden('inCartId', array('value' => $inCartId)); ?>
								<a href="#" class="remove remove_from_cart"></a>
							</td>
                            <?php }?>
                        <?php break;
                    }
                }?>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <?php 
        if($this->canEdit) {
            echo $this->totalBox;
        }
    ?>
    <div class="clear"></div>
    
    <?php if($this->canEdit) {?>
    <div class="shopping-cart-footer twelve">
        <div class="button-to-right">
            <?php echo $this->checkoutLink; ?>
            <input type="button" class="clear_link" style="width:auto; float:right;" value="<?php lang::_e('Clear Cart'); ?>" onclick="toeClearCart({reload: true}); return false;" />
            <div class="clear"></div>
        </div> 
        <div class="button-to-left">
            <a href="<?php bloginfo('url'); ?>" class="button-blue"><?php lang::_e('Continue Shopping'); ?></a>
            <div class="clear"></div>
        </div>
    </div>
    <?php }?>

<div class="clear"></div>