<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
$total_reg = "10"; // número de registros por página

if($post){

	$init_value = $_POST['init_value'];
	$final_value = $_POST['final_value'];
	$mensagem = '';
	$consulta = '';
	$result = '';
	$error = '';

	//conecta com o BD
    $inst = Database::getInstance();
    $con = $inst->getConnection();
    
    
     $pagina = $_POST['pagina'];
        if(!$pagina){
			//$resultado = pg_query("SELECT COUNT(*) AS total FROM reduzido, natureza WHERE reduzido.codigonatureza = natureza.codigo and natureza.descricao LIKE '%$natureza%'");
            //$conta = pg_fetch_assoc($resultado);
            $pc = 0; //primeira página a ser exibida
        }else{
            $pc = $pagina;
        }
     $pag = $_POST['pa'];
     	if(!$pag){
     		$pa = 0;
     	}else{
     		$pa = $pag;
     	}
        
        
    
	if($con){
			if($pc == 0){
				//query de busca no banco
            	$consulta = "begin; SELECT gasto ($init_value, $final_value, 'res'); FETCH FORWARD 10 IN \"res\";";
            	//execucao da query
       			$result = pg_query($con, $consulta) or die($error = pg_last_error());
       			pg_query($con,"CLOSE res;");
            	$pc++;
            	$pa = 1;
			}else{
				if($pc == 1){
				$avanco = ($pa-1)*10;
            	$consulta = "begin; SELECT gasto ($init_value, $final_value, 'res'); MOVE FORWARD $avanco IN \"res\"; FETCH FORWARD 10 in \"res\"";
            	$result = pg_query($con, $consulta) or die($error = pg_last_error());
       			pg_query($con,"CLOSE res;");
				}
				if($pc == -1 && $pa>=1){
					$avanco = ($pa-1)*10;
            		$consulta = "begin; SELECT gasto ($init_value, $final_value, 'res'); MOVE FORWARD $avanco IN \"res\"; FETCH FORWARD 10 in \"res\"";
            		$result = pg_query($con, $consulta) or die($error = pg_last_error());
       				pg_query($con,"CLOSE res;");				}
			}
            if (pg_num_fields($result) > 0) {
                $conteudo .= '<table id="tabela">';
                $conteudo .= '<tr>';
                $conteudo .= '<th>Descricao interna:</th>';
                $conteudo .= '<th>Descricao:</th>';
                $conteudo .= '<th>Valor Total:</th>';
                $conteudo .= '</tr>';
                while($row = pg_fetch_assoc($result)) {
                    $conteudo .= '<tr>';
                    $conteudo .= '<td>' . $row['descricaointernamunicipio'] . '</td> ';
                    $conteudo .= '<td>' . $row['descricao'] . '</td> ';
                    $conteudo .= '<td>' . $row['valortotal'] . '</td> ';
                    $conteudo .= '</tr>';
                }
                $conteudo .= '</table>';
                
            }else{
                $error.='Nenhum resultado foi encontrado<br/>';
            }
			
            //Encerra a conexão com o banco
            //pg_close($link);
			
	}else{
            $error.='não foi possível conectar com o banco' .pg_last_error();
        }

	if(!$error){
            echo json_encode(array($conteudo,$pc,$pa));
            
	}else{
            echo json_encode(array($error));
        }
}
?>