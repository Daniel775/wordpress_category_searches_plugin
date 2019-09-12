<?php
function behaviorChooser($arg)
{
	if ($arg == 'fixo'){
		wp_enqueue_script('comportamento', plugins_url('widgets/js/comportamento.js', __FILE__));
	}
}
function removeElements($originalList, $unwantedValues)
{
 #função responsavel por remover as 'grandchildren categories' de 'cidades'
	$num = count($originalList);
	
	for ($i = 0; $i < $num; $i++) :
		foreach ($unwantedValues as $values) {
			if (array_search($values, $originalList) != null) :
				unset($originalList[array_search($values, $originalList)]);
			endif;
		}
	endfor;

	return $originalList;
}

function getStates()
{
	$statesName = array();
	$statesId = array();

	$args = array('parent' => 0, 'exclude' => 1);
	$statesCategories = get_categories($args);
		
	foreach ($statesCategories as $category) { #retorna o nome de todos os estado e os seus ids
		if($category->cat_name != 'notícias'){
			$statesName[] = $category->cat_name;
			$statesId[] = get_cat_id($category->cat_name);
		}
	}
	return array('name' => $statesName, 'id' => $statesId);
}

function getCities()
{
	$citiesName = array();
	$citiesWithIds = array();
	$states = getStates();

	foreach ($states['id'] as $values) { #trata o id de cada esdado por vez
		$args = array('exclude' => 1, 'child_of' => $values);
		$cityCategories = get_categories($args);
			
		foreach ($cityCategories as $category) {
			$citiesName[] = $category->cat_name;
			$citiesWithIds[$category->cat_name] = get_cat_name($values);
		}
	}
	$regionOnly = getRegionsOnly();
	$getCities = removeElements($citiesName, $regionOnly);
	return array('citiesName' => $getCities, 'citiesWithIds' => $citiesWithIds);
}

function getCitiesId()
{
	$citiesIds = array();
	$states = getstates();

	foreach ($states['id'] as $values) { #trata o id de cada estado por vez
		$args = array('exclude' => 1, 'child_of' => $values);
		$cityCategories = get_categories($args);
			
		foreach ($cityCategories as $category) {
			$citiesIds[] = get_cat_id($category->name);
		}
	}
	return $citiesIds;
}

function getRegions()
{
	$regionName = array();
	$getCities = getCitiesId();
	
	foreach ($getCities as $values) { #usa o id de cada cidade em um loop proprio
		$args = array('exclude' => 1, 'child_of' => $values);
		$regionCategories = get_categories($args);
			
		foreach ($regionCategories as $category) {
			$regionName[] = $category->cat_name . ',' . get_cat_name($values); # regiao + cidade ;-;
		}
	}
	return $regionName;
}

function getRegionsOnly()
{
	$regionName = array();

	$getCities = getCitiesId();
	
	foreach ($getCities as $values) { #usa o id de cada cidade em um loop proprio
		$args = array('exclude' => 1, 'child_of' => $values);
		$regionCategories = get_categories($args);
			
		foreach ($regionCategories as $category) {
			$regionOnly[] = $category->cat_name;
		}
	}
	return $regionOnly;
}
