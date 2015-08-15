$(document).ready(function(){ 
	$("#ajax-contact-form").submit(function(){
		var str = $(this).serialize(); 
		$.ajax( { type: "POST", url: "consulta_elab2.php", data: str, success: function(msg){ 
				result = $.parseJSON(msg);
				pc = result[1];
				pa = result[2];
				$("#conteudo_inicial").hide();
				$("#conteudo_busca").html(result[0]);
								if(pa>1){
                                    document.getElementById("anterior").style.visibility="visible";
                                }else{
                                    document.getElementById("anterior").style.visibility="hidden";
                                }
                                if(pa>=1){
                                    document.getElementById("proximo").style.visibility="visible";
                                }else{
                                    document.getElementById("proximo").style.visibility="hidden";
                                }
			} 
		}); 
		return false;
	}); 

$("#anterior").click(function(){
		var str = $("#ajax-contact-form").serialize();
                pc=-1;
                pa--;
                var dados = str + "&pagina="+pc+"&pa="+pa+"";
		$.ajax( { type: "POST", url: "consulta_elab2.php", data: dados, success: function(msg){ 
				result = $.parseJSON(msg);
                                pc = result[1];
                                pa = result[2];
				$("#conteudo_inicial").hide();
				$("#conteudo_busca").html(result[0]);
                                if(pa>1){
                                    document.getElementById("anterior").style.visibility="visible";
                                }else{
                                    document.getElementById("anterior").style.visibility="hidden";
                                }
                                if(pa>=1){
                                    document.getElementById("proximo").style.visibility="visible";
                                }else{
                                    document.getElementById("proximo").style.visibility="hidden";
                                }
			} 
		}); 
		return false;
	}); 

$("#proximo").click(function(){
		var str = $("#ajax-contact-form").serialize();
                pc=1;
                pa++;
                var dados = str + "&pagina="+pc+"&pa="+pa+"";
		$.ajax( { type: "POST", url: "consulta_elab2.php", data: dados, success: function(msg){ 
				result = $.parseJSON(msg);
                                pc = result[1];
                                pa = result[2];
				$("#conteudo_inicial").hide();
				$("#conteudo_busca").html(result[0]);
                                if(pa>1){
                                    document.getElementById("anterior").style.visibility="visible";
                                }else{
                                    document.getElementById("anterior").style.visibility="hidden";
                                }
                                if(pa>=1){
                                    document.getElementById("proximo").style.visibility="visible";
                                }else{
                                    document.getElementById("proximo").style.visibility="hidden";
                                }
			} 
		}); 
		return false;
	}); 

});
				
function freset(){ 	
	$("#note").html('');
	document.getElementById('ajax-contact-form').reset();
	$("#fields").show();
};