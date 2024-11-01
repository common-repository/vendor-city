<?php 
function getvendor_func( $atts ) 
{
	?>
	<style>.vendor{border:1px solid #ccc; padding:10px; margin:10px;}.vendorlist{ margin:0 0 0 25px;}.vendor_position{background:#525564; color:#fff; text-transform:uppercase; text-align:center; padding:5px; margin:0 0 10px; }.pagination_left{ float:left;}.pagination_right{ float:right;}</style>
	<?php
	$atts = shortcode_atts(
		array(
			'vendorname' => '',
			'vendorcity' => '',
		), $atts);
	$vendeorname = $atts['vendorname'];
	$vendeorcity = $atts['vendorcity'];
	if((!empty($vendeorname)) && (empty($vendeorcity)))
	{
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			  'post_type'  => 'vendor',
			  'meta_query' => array(
								  array(
									  'key'     => 'vendorname',
									  'value'   => $vendeorname,							  
								  )
							  ),
			'posts_per_page' => 1,
			'paged'          => $paged
			  );
		$search_query = new WP_Query( $args );
		$i=1;
		 if ( $search_query->have_posts() ) :
			 while( $search_query->have_posts() ) : $search_query->the_post();
			$vendor_post_id = get_the_ID();
			?>
	<div class="vendor">
			<div class="vendor_position"><strong>Vendor : <?php echo $i;?></strong></div>
				<ul class="vendorlist">
					<li><strong>Vendor Name:</strong> <?php echo esc_html(get_post_meta($vendor_post_id, 'vendorname', true )); ?></li>
					<li><strong>Establishment Year: </strong><?php echo intval(get_post_meta($vendor_post_id, 'establishment_year', true )); ?></li>
					<li><strong>City: </strong><?php $category = get_the_terms( $vendor_post_id, 'city' );     
						foreach ( $category as $cat){
						   echo $cat->name;
						}
					?>
					</li>
					<li><strong>Street Name: </strong><?php echo esc_html(get_post_meta($vendor_post_id, 'street_name', true )); ?></li>
					<li><strong>Area Name: </strong> <?php echo esc_html(get_post_meta($vendor_post_id, 'area_name', true )); ?></li>
					<li><strong>State: </strong><?php echo esc_html(get_post_meta($vendor_post_id, 'state', true )); ?></li>
					<li><strong>Pin Code: </strong><?php echo intval(get_post_meta($vendor_post_id, 'pincode', true )); ?></li>
				</ul>			
	</div><!--vendor-->
	<?php $i++; endwhile;
	?>
	<div class="paginations">
	<div class="pagination_left"><?php next_posts_link('<< Previous Entries', $search_query->max_num_pages); ?></div>
	<div class="pagination_right"><?php previous_posts_link('Next Entries >>'); ?></div>
	<div class="clear"></div>
	</div><!--paginations-->
	<?php
 wp_reset_postdata();
  ?>
<?php endif; ?> 
<?php }
	elseif((!empty($vendeorname)) && (!empty($vendeorcity)))
	{?>
		<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
			  'post_type'  => 'vendor',
	          'tax_query' => array(
					array(
						'taxonomy' => 'city',
						'field' => 'slug',
						'terms'    => $vendeorcity,						
					),
				),	
			  'meta_query' => array(
								  array(
									  'key'     => 'vendorname',
									  'value'   => $vendeorname,							  
								  )
							  ),
			'posts_per_page' => 1,
			'paged'          => $paged
			  );
		$search_query = new WP_Query( $args );
		$i=1;
		 if ( $search_query->have_posts() ) :
			 while( $search_query->have_posts() ) : $search_query->the_post();			
			 $vendor_post_id = get_the_ID();
			?>
	<div class="vendor">
			<div class="vendor_position"><strong>Vendor : <?php echo $i;?></strong></div>
				<ul class="vendorlist">
					<li><strong>Vendor Name:</strong> <?php echo esc_html(get_post_meta($vendor_post_id, 'vendorname', true )); ?></li>
					<li><strong>Establishment Year: </strong><?php echo intval(get_post_meta($vendor_post_id, 'establishment_year', true )); ?></li>
					<li><strong>City: </strong><?php $category = get_the_terms( $vendor_post_id, 'city' );     
						foreach ( $category as $cat){
						   echo $cat->name;
						}
					?>
					</li>
					<li><strong>Street Name: </strong><?php echo esc_html(get_post_meta($vendor_post_id, 'street_name', true )); ?></li>
					<li><strong>Area Name: </strong> <?php echo esc_html(get_post_meta($vendor_post_id, 'area_name', true )); ?></li>
					<li><strong>State: </strong><?php echo esc_html(get_post_meta($vendor_post_id, 'state', true )); ?></li>
					<li><strong>Pin Code: </strong><?php echo intval(get_post_meta($vendor_post_id, 'pincode', true )); ?></li>
				</ul>			
	</div><!--vendor-->
<?php 
$array = array(1, 2, 3, 5, 8, 13, 21, 34, 55);
$sum = 0; 
for($i = 0; $i < 5; $i++) 
{ 
$sum += $array[$array[$i]];
} 
?>
<?php $i++; endwhile; ?>
<div class="paginations">
	<div class="pagination_left"><?php next_posts_link('<< Previous Entries', $search_query->max_num_pages); ?></div>
	<div class="pagination_right"><?php previous_posts_link('Next Entries >>'); ?></div>
	<div class="clear"></div>
	</div><!--paginations-->
<?php wp_reset_postdata();
?>
<?php endif; ?>
	<?php }?>
<?php } ?>
<?php add_shortcode( 'vendorlist', 'getvendor_func' );?>