<div class="toeSingleProductShell">
	<div id="single_product" class="main-content single-page">
		<div class="product_wrap row">
			<form action="" method="post" class="toeAddToCartForm" id="toeAddToCartForm<?php echo $this->post->ID?>" onsubmit="toeAddToCart(this, 'Product added!', false); return false;">
				<?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'breadcrumbs' ) ) : ?>
					<?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'breadcrumbs' ); ?>
				<?php endif; ?>
				<div class="clear"></div>

				<div id="single-gallery" class="product_main six columns">
					<div id="imgslider" class="product_full_image row">
						<div id="big-image-wrapper">
							<a href="#" rel="lightbox[product]">
								<?php if (!empty($this->images)) {$bigImage = $this->images[0]['big'][0];} ?>
								<img src="<?php echo $bigImage; ?>" alt="" class="back-img" />
								<span class="zoom"></span>
							</a>
						</div>
					</div>
					<?php if (!empty($this->images)):?>
					<div class="product_slider">
						<ul class="row">
						<?php $img_count = count($this->images); 
							  $i = 1;
						?>
						<?php foreach($this->images as $image) :?>
						   <li class="four columns">
								<?php
									$imgsrc = $image['big'][0];
								?>
								 <a href="<?php get_image($imgsrc, 460, 263, 'height'); ?>" alt="<?php echo $imgsrc_big = $image['big'][0]; ?>">
									<img src="<?php echo $image['thumb'][0]; ?>" 
										 width="<?php echo $image['thumb'][1]; ?>"
										 height="<?php echo $image['thumb'][2]; ?>"
										 alt="<?php echo get_the_title();?>" />
								</a>
							</li>
							<?php 
								if ($i % 3 == 0) {echo '</ul><ul style="clear:left;">';}
								$i++; 
							?>
						<?php endforeach; ?>
						</ul>
					</div>
					<div id="all-prod-images">
						<?php foreach($this->images as $image) :?>
							<?php
								$imgsrc = $image['big'][0];
							?>
							<a href="<?php echo $imgsrc; ?>" rel="lightbox[product]"></a>
						<?php endforeach; ?>
					</div>
					<?php endif;?>
				</div>

				<div class="content product_info six columns">
					<div id="product_main_info">
						<div class="product_block_wrapper">
							<?php if ($this->viewOptions['title']) :?>
								<!--toetitle-->
									<h2><?php echo get_the_title(); ?></h2>
								<!--/toetitle-->
							<?php endif;?>
							<?php if(isset($this->variationsSelect) && !empty($this->variationsSelect)) 
								echo $this->variationsSelect;?>
							<table class="product-info-table">
								<tr>
									<?php if ($this->viewOptions['sku']) :?>
									<!--toesku-->
									<td class="text-left"><?php echo lang::_e('Product ID:'); ?></td>
									<td>
										<div id="product_sku">
											<span><?php echo $this->pData['sku']->value;?></span>
										</div>
									</td>
									<!--/toesku-->
									<?php endif;?>
									<?php if ($this->viewOptions['price']) :?>
									<!--toeprice-->
									<td id="price-rating">
										<div id="product_price" class="item-list-price <?php if(frame::_()->getModule('products')->markAsSale($this->post->ID) == true) {echo 'hot-price'; } ?>">
											<span><?php echo $this->priceHtml?></span>
										</div>
										<div class="clear"></div>
									</td>
									<!--/toeprice-->
									<?php endif; ?>
								</tr>
								<?php if ($this->viewOptions['quantity']) :?>
								<!--toequantity-->
								<tr>
									<td class="text-left"><?php echo lang::_e('Availability:'); ?></td>
									<td style="width:120px">
										<div id="product_quantity">
											<span>
												<?php 
													$qnt = $this->pData['quantity']->value;
													if ($qnt > 0) {echo 'in stock ('.$qnt.')';} else {echo 'out of stock';}
												?>
											</span>
										</div>
									</td>
								</tr>
								<!--/toequantity-->
								<?php endif; ?>
								<tr>
									<td class="text-left"><?php echo lang::_e('Brand:'); ?></td>
									<td><?php the_terms( $this->pData['sku']->value, 'products_brands' ); ?></td>
									<td><div class="item-rating"><?php echo $this->ratingBox; ?></div></td>
								</tr>
								<tr>
									<td colspan="3" class="label-text-left">
										<?php if(!empty($this->specials) && is_single()) { ?>
										<span class="special_labels">
										<?php 
											if(!empty($this->saleTpl)) { ?>
												<span><?php echo $this->saleTpl?></span>
										<?php }
											foreach($this->specials as $s) {
												lang::_e($s['label']). '<br />';
											}
										?>
										</span>
										<?php }?>
									</td>
								</tr>
							</table>
							<?php if(!empty($this->extraFields)) {?>
							<div class="extra-params">
								<table>
									<?php foreach($this->extraFields as $d) { ?>
									<tr>
										<td><?php lang::_e($d->label)?>&nbsp;&nbsp;</td>
										<td><?php $d->display()?></td>
									</tr>
									<?php }?>
								</table>
							</div>
							<?php }?>
						</div>
					</div>
					<?php if ($this->viewOptions['full_descr']) :?>
						<!--toefull_description-->
							<div id="product_description">
								<div class="product_block_wrapper product-text">
									<p><?php echo $this->fullDescr; ?></p>
								</div>  
							</div>
						<!--/toefull_description-->
					<?php endif; ?>

					<div class="single-links-control"></div>
					<?php if ($this->viewOptions['add_to_cart']) :?>
						<!--toeadd_to_cart-->
							<div class="product_to_cart buy-option">
								  <?php echo $this->actionButtons?>
							</div>
						<!--/toeadd_to_cart-->
					<?php endif; ?>
				</div>
			</form> 
			<div style="clear:both"></div>
			<div id="comment-block" class="row">
				<hr class="wave-line" />
				<?php comments_template(); ?>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>

	<?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'newproducts' ) ) : ?>
	<div id="new-products" class="row">
		<?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'newproducts' ); ?>
	</div>
	<?php endif; ?>

	<div class="clear"></div>
</div>