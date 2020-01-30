//Esta funcion genera el objeto para para petición
function crearHttpRequest(){
	var http = null;
	//Para versiones previas de IExplorer
	if(window.ActiveXObject){
		http = new ActiveXObject("Microsoft.XMLHTTP");
	//Para el resto de navegadores
	}else if(window.XMLHttpRequest){
		http = new XMLHttpRequest();
	}
	return http;
}


function buscar(){
	var url = 'servidor.php';
	//Los parámetros para el post
	var params = 'val1='+a+'&val2='+b;

	//LLamamos a la función para generar el objeto de la petición
	http = crearHttpRequest();
	//La POST a la url
	http.open('POST',url,true);
	//Cabecera necesaria para que los parámetros se envíen correctamente
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	
	//Es un listener para que cuando el documento alcance el estado 4(completo) se ejecute el código que muestra el resultado
	http.onreadystatechange = 
	function(){
		if(http.readyState == 4 && http.status == 200){
			//Introducimos el resultado en el inner del div 'resultado' del formulario
			document.getElementById('resultado').innerHTML = "aaaaaadssssssssssssssssssssssss";
		}
	}

	//Los parámetros para la llamada
	http.send(params);
}

