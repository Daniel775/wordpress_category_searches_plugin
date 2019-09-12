<?php
	class DmMenuWidget extends WP_Widget
	{
		public function __construct()
		{
			$widget_options = array( 'classname' => 'dm-menu', 'description' => 'Menu de buscas por categorias' );
			parent::__construct('dm-menu', 'Buscas por Categorias', $widget_options);
		}

		public function widget($args, $instance)
		{
			wp_enqueue_style('menu', plugins_url('css/painel.css', __FILE__));
			wp_enqueue_script('menu-dinamico', plugins_url('js/menu-dinamico.js', __FILE__));

			include(plugin_dir_path(__FILE__) . '../functions.php');

			$states = getStates();

			if(isset($instance['title']) == false or $instance['title'] == ''){
				$instance['title'] = 'Titulo';
			}
			if(isset($instance['subtitle']) == false or $instance['subtitle'] == ''){
				$instance['subtitle'] = 'subtítulo';
			}
			if(isset($instance['font_color']) == false or $instance['font_color'] == ''){
				$instance['font_color'] = '#FFF';
			}
			if(isset($instance['interface_color']) == false or $instance['interface_color'] == ''){
				$instance['interface_color'] = '#3E5368E6';
			}
			if(isset($instance['details_color']) == false or $instance['details_color'] == ''){
				$instance['details_color'] = '#E39104';
			}
			if(isset($instance['text_button_color']) == false or $instance['text_button_color'] == ''){
				$instance['text_button_color'] = '#FFF';
			}
			if(isset($instance['barBehavior']) == false or $instance['barBehavior'] == ''){
				$instance['barBehavior'] = 'fixo';
			}
			if(isset($instance['barWidth']) == false or $instance['barWidth'] == ''){
				$instance['barWidth'] = '80';
			}
			if(isset($instance['results_url']) == false or $instance['results_url'] == ''){
				$instance['results_url'] = 'resultados';
			}

			behaviorChooser($instance['barBehavior']);
?>

	<div id="menu" >
		<div id="topo-menu" style="width: <?= $instance['barWidth']; ?>%; background-color: <?= $instance['interface_color']; ?>;">
			<div id="texto" style="color: <?= $instance['font_color'] ?>">
				<h3><?= $instance['title']; ?></h3>
				<strong><?= $instance['subtitle']; ?></strong>
			</div>
			<div style="width: 50px;">
				<div id="seta" style="border-bottom: <?= $instance['details_color'];?> 3px solid; border-right: <?= $instance['details_color'];?> 3px solid;"></div>
			</div>
				<form id="formulario" method="post" action="<?= $instance['results_url']; ?>">
					<select onchange="SelecionadoEstado();" class="opcao" name="State" id="estado" required="required" onclick="SelecionadoEstado();">
						<option value="" disabled selected>Estado</option>

						<?php
							foreach ($states['name'] as $name) {
								echo "<option value='".preg_replace('/[ -]+/', '-', $name)."'>".$name."</option>";
							}
						?>

					</select>
					<select class="opcao" name="City" id="cidade" required="required" onclick="selectCity();">
						<option value="" disabled selected id="titulo-cidade">Cidade</option>

							<?php
								$cities = getCities();
								$citiesIds = $cities['citiesWithIds'];
								foreach ($cities['citiesName'] as $name) {
										echo "<option value='".preg_replace('/[ -]+/', '-', $name)."' class='".preg_replace('/[ -]+/', '-', $citiesIds[$name])." categorias-city'>".$name."</option>";
								} #taygra 
							?>

					</select>
					<select class="opcao" name="Region" id="regiao">
						<option value="" disabled selected id="titulo-regiao">Região</option>
						<option value="Todos" class="categorias-region todos">Todos</option>

						<?php
							$regionName = getRegions();
							foreach ($regionName as $name) {
								$trueName = explode(',', $name);
							echo "<option value='".preg_replace('/[ -]+/', '-', $trueName[0])."' class='".preg_replace('/[ -]+/', '-', $trueName[1])." categorias-region'>".$trueName[0]."</option>";
							}
						?>

					</select>
					<input type="submit" id="tg-submit" value="Buscar" style="color: <?= $instance['text_button_color']; ?>; background-color: <?= $instance['details_color']; ?>;">
				</form>
			</div>
		</div>
	</div>

<?php
		}

		public function form($instance){
			if (isset($instance['title'])){
				$title = $instance['title'];
			}
			else {
				$title = __('Título', 'default_title');
			}
			if (isset($instance['subtitle'])){
				$subtitle = $instance['subtitle'];
			}
			else {
				$subtitle = __('Subtítulo', 'default_subtitle');
			}
			if (isset($instance['interface_color'])){
				$interface_color = $instance['interface_color'];
			}
			else {
				$interface_color = __('#3E5368E6', 'default_interface_color');
			}
			if (isset($instance['font_color'])){
				$font_color = $instance['font_color'];
			}
			else {
				$font_color = __('#FFFFFF', 'default_font_color');
			}
			if (isset($instance['details_color'])){
				$details_color = $instance['details_color'];
			}
			else {
				$details_color = __('#E39104', 'default_details_color');
			}
			if (isset($instance['text_button_color'])){
				$text_button_color = $instance['text_button_color'];
			}
			else {
				$text_button_color = __('#FFF', 'default_text_button_color');
			}
			if (isset($instance['barBehavior'])){
				$barBehavior = $instance['barBehavior'];
			}
			else {
				$instance['barBehavior'] = 'fixed';
				$barBehavior = $instance['barBehavior'];
			}
			if (isset($instance['barWidth'])){
				$barWidth = $instance['barWidth'];
			}
			else {
				$barWidth = __('80%', 'default_barWidth');
			}
			if (isset($instance['results_url'])){
				$results_url = $instance['results_url'];
			}
			else {
				$results_url = __('resultados', 'default_results_url');
			}?>

			<p>
				<label for="<?= $this->get_field_id('title'); ?>"><?php _e('Título:'); ?></label> 
				<input class="widefat" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name('title'); ?>" type="text" value="<?= esc_attr($title); ?>"/>
			</p>
			<p>
				<label for="<?= $this->get_field_id('subtitle'); ?>"><?php _e('Subtítulo:'); ?></label>
				<input class="widefat" id="<?= $this->get_field_id('subtitle'); ?>" name="<?= $this->get_field_name('subtitle'); ?>" type="text" value="<?= esc_attr($subtitle); ?>"/>
			</p>
			<p>
				<label for="<?= $this->get_field_id('interface_color'); ?>"><?php _e('Cor da Interface:'); ?></label> 
				<input class="widefat" id="<?= $this->get_field_id('interface_color'); ?>" name="<?= $this->get_field_name('interface_color'); ?>" type="text" value="<?= esc_attr($interface_color); ?>"/>
			</p>
			<p>
				<label for="<?= $this->get_field_id('font_color'); ?>"><?php _e('Cor do Texto:'); ?></label> 
				<input class="widefat" id="<?= $this->get_field_id('font_color'); ?>" name="<?= $this->get_field_name('font_color'); ?>" type="text" value="<?= esc_attr($font_color); ?>"/>
			</p>
			<p>
				<label for="<?= $this->get_field_id('details_color'); ?>"><?php _e('Cor dos Detalhes:'); ?></label> 
				<input class="widefat" id="<?= $this->get_field_id('details_color'); ?>" name="<?= $this->get_field_name('details_color'); ?>" type="text" value="<?= esc_attr($details_color); ?>"/>
			</p>
			<p>
				<label for="<?= $this->get_field_id('text_button_color'); ?>"><?php _e('Cor do Texto do Botão:'); ?></label> 
				<input class="widefat" id="<?= $this->get_field_id('text_button_color'); ?>" name="<?= $this->get_field_name('text_button_color'); ?>" type="text" value="<?= esc_attr($text_button_color); ?>"/>
			</p>
			<p>
				<label for="<?= $this->get_field_id('barWidth'); ?>"><?php _e('Largura do Menu:'); ?></label> 
				<input type="range" min="60" max="100" class="widefat" id="<?= $this->get_field_id('barWidth'); ?>" name="<?= $this->get_field_name('barWidth'); ?>" value="<?= esc_attr($barWidth); ?>">
			</p>
			<p>
				<label for="<?= $this->get_field_id('barBehavior'); ?>"><?php _e('Comportamento do menu:'); ?></label> 
					<select class='widefat' id="<?= $this->get_field_id('barBehavior'); ?>" name="<?= $this->get_field_name('barBehavior'); ?>" type="text">
						<option value='normal'<?= ($instance['barBehavior']=='normal')?'selected':''; ?>>Normal</option>
						<option value='fixo'<?= ($instance['barBehavior']=='fixo')?'selected':''; ?>>Fixo</option>
					</select>
			</p>
			<p>
				<label for="<?= $this->get_field_id('results_url'); ?>"><?php _e('Link da pagina de resultados:'); ?></label>
				<input class="widefat" id="<?= $this->get_field_id('results_url'); ?>" name="<?= $this->get_field_name('results_url'); ?>" type="text" value="<?= esc_attr($results_url); ?>"/>
			</p>
			<?php 
		}

		public function update($new_instance, $old_instance) {
			$instance = array();
			$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
			$instance['subtitle'] = (!empty($new_instance['subtitle'])) ? strip_tags($new_instance['subtitle'])  : '';
			$instance['interface_color'] = (!empty($new_instance['interface_color'])) ? strip_tags($new_instance['interface_color']) : '';
			$instance['font_color'] = (!empty($new_instance['font_color'])) ? strip_tags($new_instance['font_color']) : '';
			$instance['details_color'] = (!empty($new_instance['details_color'])) ? strip_tags($new_instance['details_color']) : '';
			$instance['text_button_color'] = (!empty($new_instance['text_button_color'])) ? strip_tags($new_instance['text_button_color']) : '';
			$instance['barBehavior'] = (!empty($new_instance['barBehavior'])) ? strip_tags($new_instance['barBehavior']) : '';
			$instance['barWidth'] = (!empty($new_instance['barWidth'])) ? strip_tags($new_instance['barWidth']) : '';
			$instance['results_url'] = (!empty($new_instance['results_url'])) ? strip_tags($new_instance['results_url']) : '';
			return $instance;
		}
	}
?>