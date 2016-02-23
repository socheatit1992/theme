<div class="toeWidget row">
    <?php if(!empty($this->title)) { ?>
        <h2 class="toeWidgetTitle"><?php lang::_e($this->title)?></h2>
    <?php }?>
    
    <?php if (!empty($this->data)):?>
    <div id="brands">
        <div class="brands-slider row">  
            <ul class="slides">
            <?php foreach ($this->data as $category) :?>
                <li class="brand-item">
                    <div class="brand-img-wrapper">
                        <a href="<?php echo $category->href; ?>" title="<?php echo $category->name; ?>">
                            <?php $term_icon = $category->image; ?>
                            <img width="120" src="<?php echo $term_icon; ?>" alt="<?php echo $category->name; ?>" />
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif;?>
</div>
