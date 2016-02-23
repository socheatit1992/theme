<?php
if($this->wp_query->max_num_pages > 1) {    //If this is not first page?>
    <?php //Navigation?>
        <?php if($this->paged == 0) $this->paged = 1; //bug fix ?>
        <div class="<?php echo $this->nav_id; ?>">
            <?php if($this->paged != 1) {?>
                <div class="nav-first"><a href="<?php echo get_pagenum_link(1)?>"></a></div>
                <div class="nav-previous"><?php previous_posts_link(''); ?></div>
            <?php }?>
    <?php for($i = 1; $i <= $this->wp_query->max_num_pages; $i++) { ?>
            <?php if($this->paged != $i) {?>
            <a href="<?php echo get_pagenum_link($i)?>">
            <?php } else {echo '<span>';}?>
            <?php echo $i?>
            <?php if($this->paged != $i) {?>
            </a>
            <?php } else {echo '</span>';}?>
    <?php }?>
            <?php if($this->paged != $this->wp_query->max_num_pages) {  //If this is not last page?>
            <div class="nav-next"><?php next_posts_link(''); ?></div>
            <div class="nav-last"><a href="<?php echo get_pagenum_link($this->wp_query->max_num_pages)?>"><?php lang::_e('')?></a></div>
            <?php }?>
		</div><!-- #nav-above -->


<?php }