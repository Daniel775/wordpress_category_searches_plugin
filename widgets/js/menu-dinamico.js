function SelecionadoEstado(){
	const estado = document.getElementById("estado");
	let estadoSelecionado = estado.options[estado.selectedIndex].value;
	let categoria = document.getElementsByClassName(estadoSelecionado);
	let geral = document.getElementsByClassName("categorias-city");
	let geralRegiao = document.getElementsByClassName("categorias-region");
		
	for(i = 0; i < geral.length; i++){
		geral[i].style.display = "none";
	}
	
	for(i = 0; i < geralRegiao.length; i++){
		geralRegiao[i].style.display = "none";
	}
	
	document.getElementsByClassName("todos")[0].style.display = 'none';
	
	document.getElementById("titulo-cidade").selected = "selected";
	document.getElementById("titulo-regiao").selected = "selected";
	
	for(i = 0; i < categoria.length; i++){
		categoria[i].style.display = "block";
	}
}
function selectCity(){
	const cidade = document.getElementById("cidade");
	let cidadeSelecionada = cidade.options[cidade.selectedIndex].value;
	let categoria = document.getElementsByClassName(cidadeSelecionada);
	let geral = document.getElementsByClassName("categorias-region");
	
	for(i = 0; i < geral.length; i++){
		geral[i].style.display = "none";
	}
	
	document.getElementById("titulo-regiao").selected = "selected";
	
	for(i = 0; i < categoria.length; i++){
		categoria[i].style.display = "block";
	}
	
	if(categoria[0] != null){
		document.getElementsByClassName("todos")[0].style.display = 'block';
	}
}

function Tg_submit(){
	const estado = document.getElementById("estado");
	const cidade = document.getElementById("cidade");
	const regiao = document.getElementById("regiao");
	let estadoSelecionada = estado.options[estado.selectedIndex].value;
	let cidadeSelecionada = cidade.options[cidade.selectedIndex].value;
	let regiaoSelecionada = regiao.options[regiao.selectedIndex].value;
	
	let link_result = estadoSelecionada + '/' + cidadeSelecionada + '/' + regiaoSelecionada;
	window.open(link_result.toLowerCase());
}