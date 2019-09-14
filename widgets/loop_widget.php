<?php
	class DmLoopWidget extends WP_Widget
	{
		public function __construct()
		{
			$widget_options = array( 'classname' => 'dm-posts-loop', 'description' => 'Resultados de busca de blogs por catergorias.' );
			parent::__construct('dm-posts-loop', 'Resultados de Busca', $widget_options);
		}

		public function widget($args, $instance)
		{
			wp_enqueue_style('menu', plugins_url('css/results.css', __FILE__));

			$dicionario = array();
			$args = array('exclude' => 1, 'hide_empty' => 0);
			$categories = get_categories($args);
			
			foreach ($categories as $category) {
				$nome = $category->cat_name;
				$dictionary[preg_replace('/[ -]+/', '-', $nome)] = get_cat_id($category->cat_name);
			}?>

			<div id="dm-posts">
				<?php
					$region =  isset($_POST["Region"]) ? $_POST["Region"] : null;
					$state = $_POST["State"];
					$city = $_POST["City"];

					$location = (is_null($region) || $region == 'Todos') ? $city : $region;
					$args = array('posts_per_page'=>'30', 'cat'=>$dictionary[$location]);
					$query = new WP_Query($args);

					if ($query->have_posts()) {
						while ($query->have_posts()):
							$query->the_post();
							$postCategories = get_the_category();

							foreach ($postCategories as $value) {
								if (preg_replace('/[ -]+/', '-', $value->name) != preg_replace('/[ -]+/', '-', $state) && $value->name != $city){
									$currentRegion = $value->name;
								}
							}
				?>

				<div class="dm-results">
					<a href="<?= the_permalink();?>">
						<div class="dm-thumb">
							<?= the_post_thumbnail("medium"); ?>
						</div>
						<div class="dm-text-description">
							<p class="dm-titulo"><?= $currentRegion;?></p>
							<p class="dm-subtitulo">
								<?php
									$cityName = explode("-", $city);
									for ($i = 0; $i < count($cityName); $i++){
										echo " ".mb_strtoupper($cityName[$i], 'UTF-8');
									}
									echo '-'.mb_strtoupper($state, 'UTF-8');
								?>
							</p>
							<p class="dm-notas"><?= the_title();?></p>
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
					} else {
						echo "Nenhum Resultado Encontrado para a Busca";
					}
					wp_reset_postdata();
				
			echo '</div>';
		}
	}
?>