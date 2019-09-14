<?php

/*
Plugin Name: Buscas por Categorias
Description: Conjunto de widgets responsáveis pela busca de posts por categiria em um site.
Version: 1.43
Author: Daniel Bomfim
*/


include(plugin_dir_path(__FILE__) . 'widgets/menu_widget.php');
include(plugin_dir_path(__FILE__) . 'widgets/loop_widget.php');
include(plugin_dir_path(__FILE__) . 'widgets/similares_widget.php');

function dm_register_menu_widget() #menu de categorias
{
	register_widget('DmMenuWidget');
}
add_action('widgets_init', 'dm_register_menu_widget');

function dm_register_loop_widget() #resultados das buscas com o menu
{
	register_widget('DmLoopWidget');
}
add_action('widgets_init', 'dm_register_loop_widget');

function dm_register_dm_similares_widget() #retorna posts com as mesmas categorias do atual
{
	register_widget('DmSimilaresWidget');
}
add_action('widgets_init', 'dm_register_dm_similares_widget');
?>
