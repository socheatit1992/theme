<script type="text/javascript">
// <!--
function toeApplyCoupon() {
    jQuery(this).sendForm({
        msgElID: 'toeCouponsCheckoutMsg',
        data: {coupon: jQuery('#toeCoupon').val(), mod: 'coupons', action: 'applyCoupon', reqType: 'ajax'},
        onSuccess: function(res) {
            if(res.data.totalHtml) {
                updateCart(new Array(), res.data.totalHtml);
            }
            if(!res.error) {
                jQuery('#toeCoupon').val('');
            }
        }
    });
}
function toeShouCouponsDescription(link) {
    var linkPos = jQuery(link).position();
    subScreen.show(<?php echo $this->couponsDescription?>, linkPos.left, linkPos.top, null, "This is a coupon description");
}
// -->
</script>
<?php lang::_e('<div class="coupon-text">Enter your coupon code (<a href="#" onclick="toeShouCouponsDescription(this); return false;">where to get one?</a>):</div>')?>
<?php echo html::text('coupon', array('attrs' => 'id="toeCoupon" placeholder="0000-0000-0000-0000"'))?>
<?php echo html::button(array('value' => lang::_('Apply'), 'attrs' => 'onclick="toeApplyCoupon();" class="btn" id="ApplyCoupon"'))?>
<div id="toeCouponsCheckoutMsg"></div>
<div class="clear"></div>