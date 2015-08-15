$(document).ready(function(){ 
        
	$("#ajax-contact-form").submit(function(){
		var str = $(this).serialize(); 
		$.ajax( { type: "POST", url: "consulta2.php", data: str, success: function(msg){ 
				result = $.parseJSON(msg);
                                pc = result[1];
                                tp = result[2];
                                tr = result[3];
				$("#conteudo_inicial").hide();
				$("#conteudo_busca").html(result[0]);
                                if(pc>1){
                                    document.getElementById("anterior").style.visibility="visible";
                                }else{
                                    document.getElementById("anterior").style.visibility="hidden";
                                }
                                if(pc<tp){
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
                pc--;
                var dados = str + "&pagina="+pc+"&tr="+tr+"";
		$.ajax( { type: "POST", url: "consulta2.php", data: dados, success: function(msg){ 
				result = $.parseJSON(msg);
                                pc = result[1];
                                tp = result[2];
                                tr = result[3];
				$("#conteudo_inicial").hide();
				$("#conteudo_busca").html(result[0]);
                                if(pc>1){
                                    document.getElementById("anterior").style.visibility="visible";
                                }else{
                                    document.getElementById("anterior").style.visibility="hidden";
                                }
                                if(pc<tp){
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
                pc++;
                var dados = str + "&pagina="+pc+"&tr="+tr+"";
		$.ajax( { type: "POST", url: "consulta2.php", data: dados, success: function(msg){ 
				result = $.parseJSON(msg);
                                pc = result[1];
                                tp = result[2];
                                tr = result[3];
				$("#conteudo_inicial").hide();
				$("#conteudo_busca").html(result[0]);
                                if(pc>1){
                                    document.getElementById("anterior").style.visibility="visible";
                                }else{
                                    document.getElementById("anterior").style.visibility="hidden";
                                }
                                if(pc<tp){
                                    document.getElementById("proximo").style.visibility="visible";
                                }else{
                                    document.getElementById("proximo").style.visibility="hidden";
                                }
			} 
		}); 
		return false;
	}); 
        
});