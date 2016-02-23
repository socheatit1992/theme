<div id="toeAllProductsPage">  
    <div class="nine columns nopadding">    
        <hr class="wave-line" />
        <div class="sort-line">
        <?php if(have_posts()) :?>
            <div class="items-view">
                <?php lang::_e('Show'); ?>: 
                <a href="#" class="change-to-grid-view <?php if($_COOKIE['catalogView'] == 'grid' || $_COOKIE['catalogView'] == null) echo 'current-catalog-view' ?>"><?php lang::_e('Grid View'); ?></a>
                <a href="#" class="change-to-list-view <?php if($_COOKIE['catalogView'] == 'list') echo 'current-catalog-view' ?>"><?php lang::_e('List View'); ?></a>
            </div>
            <?php 
            if(class_exists('frame') && frame::_()->getModule('pagination')) {
                frame::_()->getModule('pagination')->getView()->display(array('nav_id' => 'pagination', 'show' => array('navigation', 'perPage', 'ordering')));
            }?>
        <?php endif; ?>
        </div>
        <div class="clear"></div>
        
        <div class="items row">
            <?php foreach($this->productsContentParts as $pHtml) {
                echo $pHtml;
            }?>
        </div>
        <div class="clear"></div>
        
        <div class="sort-line">
            <div class="items-view">
                <?php lang::_e('Show'); ?>: 
                <a href="#" class="change-to-grid-view <?php if($_COOKIE['catalogView'] == 'grid' || $_COOKIE['catalogView'] == null) echo 'current-catalog-view' ?>"><?php lang::_e('Grid View'); ?></a>
                <a href="#" class="change-to-list-view <?php if($_COOKIE['catalogView'] == 'list') echo 'current-catalog-view' ?>"><?php lang::_e('List View'); ?></a>
            </div>
            <?php 
            if(class_exists('frame') && frame::_()->getModule('pagination')) {
                frame::_()->getModule('pagination')->getView()->display(array('nav_id' => 'pagination', 'show' => array('navigation', 'perPage', 'ordering')));
            }?>
        </div>
        <div class="clear"></div>
    </div>
    
    <div id="sidebar" class="three columns">
        <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'sidebarproducts' ) ) : ?>
            <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'sidebarproducts' ); ?>
        <?php endif; ?>
    </div>    
    <div class="clear"></div>
</div>  