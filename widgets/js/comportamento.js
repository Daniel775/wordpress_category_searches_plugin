const larguraInicial = document.getElementById("topo-menu").style.width;

window.addEventListener("scroll",() =>{
	const menu = document.getElementById("topo-menu");
	if (window.scrollY > 30){
		menu.style.position = "fixed";
		menu.style.width = "100%";
		menu.style.right = "0px";
		menu.style.top = "0px";
	}
	else{
		if(window.innerWidth > 767){
			menu.style.position = "relative";
			menu.style.width = larguraInicial;
			menu.style.right = "";
			menu.style.top = "";
		} else{
			menu.style.position = "fixed";
			menu.style.width = "100%";
			menu.style.right = "";
			menu.style.top = "";
		}
	}
});