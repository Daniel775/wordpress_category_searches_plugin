<?php

	class DmSimilaresWidget extends WP_Widget
	{
		public function __construct()
		{
			$widget_options = array( 'classname' => 'dm-similar-loop', 'description' => 'loop de categorias similares' );
			parent::__construct('dm-similar-loop', 'Posts de mesma Categoria', $widget_options);
		}

		public function widget($args, $instance)
		{
			wp_enqueue_style('menu', plugins_url('css/similar.css', __FILE__));
			
			global $post;
			$categories = get_the_category($post->ID);
			$currentPageID = $post->ID;

			foreach ($categories as $value) {
				if(!empty($state)){
					break;
				}
				$state = $value->category_parent > 0 ? null : $value;
			}

			foreach ($categories as $value) {
				if(!empty($city)){
					break;
				}
				$city = $value->category_parent == $state->cat_ID ? $value : null;
			}

			foreach ($categories as $value) {
				if(!empty($region)){
					break;
				}
				$region = $value->category_parent == $city->cat_ID ? $value : null;
			}

			$args = array('posts_per_page'=>'5', 'cat'=>$region->cat_ID);
			$query = new WP_Query($args);

			echo '<div id="similar-container">';

			if ($query->have_posts()) {
				$index = 0;
				while ($query->have_posts()):
					$index++;
					$query->the_post();
					$postID = get_the_ID();
					if($currentPageID == $postID) {
						continue;
					}
					if($index > 3){
						break;
					}
?>
					<div style="margin-right: 10px;" class="dm-results">
						<a href="<?= the_permalink();?>">
							<div class="dm-thumb">
								<?= the_post_thumbnail("medium");?>
							</div>
							<div class="dm-text-description">
								<p class="dm-title">
									<?= $region->name;?>
								</p>
								<p class="dm-subtitle">
									<?= $city->name.'-'.$state->name?>
								</p>
								<p class="dm-notes">
									<?= the_title();?>
								</p>
								<div class="dm-tags">
								<?php
									$postTags = get_the_tags();

									if(!empty($postTags)){
										foreach ($postTags as $tag) {
											echo '<p style="background-color: #FB595C">'.$tag->name.'</p>';
										}
									}
								?>
								</div>
							</div>
						</a>
					</div>
<?php
				endwhile;
			}
			else{
				echo "Desculpe, ainda não possuimos outros items dessa categoria.";
			}
			wp_reset_postdata();
			echo "</div>";
	 }
}
?>