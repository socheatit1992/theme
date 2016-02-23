<script type="text/javascript">
// <!--
    if(typeof(toeNavigationItems) == 'undefined') {
        var toeNavigationItems = new Array();
    }
    toeNavigationItems = <?php echo utils::jsonEncode($this->steps)?>;
    jQuery(document).ready(function(){
        var itemWasSelected = false;
        for(id in toeNavigationItems) {
            if(toeNavigationItems[id]['selected']) {
                toeSetNavigationSelected(id, 0);
                itemWasSelected = true;
            }
            if(!itemWasSelected)
                toeSetNavigationPassed(id);
        }
        
        // Checkout nav text color fixes
        jQuery('.toeCheckoutNavigationPassed').parent().find('.toeCheckoutNavigationItemText').addClass('passed-text');
        jQuery('.toeCheckoutNavigationCurrent').parent().find('.toeCheckoutNavigationItemText').addClass('current-text');
    });
// -->
</script>
<div id="checkNav" class="nine columns centered">
    <div id="checkoutConteiner" class="row">
        <?php foreach($this->steps as $key => $s) { ?>
        <div class="toeCheckoutNavigationItem three columns">
            <div class="toeCheckoutNavigationItemPoint <?php echo $key?>">&nbsp;</div>
            <div class="toeCheckoutNavigationItemText"><?php echo $s['label']?></div>
        </div>
        <?php }?>
    </div>
    <div class="toeCheckoutNavigationSelected" style="display: none;">&nbsp;</div>
</div>