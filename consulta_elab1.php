<?php
require_once 'Database.php';
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
$total_reg = "10"; // número de registros por página

if($post){
	$natureza = $_POST['natureza'];
	$descricao = $_POST['descricao'];
	$mensagem = '';
	$consulta = '';
	$result = '';
	$error = '';

	//conecta com o BD
	$db = Database::getInstance();
    $con = $db->getConnection();
    
    
     $pagina = $_POST['pagina'];
        if(!$pagina){
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
            	$consulta = "BEGIN; SELECT desempenho ((SELECT codigo FROM natureza WHERE natureza.descricao LIKE '%$natureza%'),(SELECT codigo FROM orgao WHERE descricaointernamunicipio LIKE '%$descricao%'),'media_cur'); FETCH FORWARD 10 IN \"media_cur\" ";
            	//execucao da query
            	$result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
                pg_query($con,"CLOSE res;");
            	$pc++;
                $pa = 1;
			}else{
				if($pc == 1){
                    $avanco = ($pa-1)*10;
					$consulta = "BEGIN; SELECT desempenho ((SELECT codigo FROM natureza WHERE natureza.descricao LIKE '%$natureza%'),(SELECT codigo FROM orgao WHERE descricaointernamunicipio LIKE '%$descricao%'),'media_cur'); MOVE FORWARD $avanco IN \"media_cur\"; FETCH FORWARD 10 IN \"media_cur\"";
                    //execucao da query
                    $result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
                    pg_query($con,"CLOSE media_cur;");
				}
				if($pc == -1 && $pa>=1){
                    $avanco = ($pa-1)*10;
					$consulta = "BEGIN; SELECT desempenho ((SELECT codigo FROM natureza WHERE natureza.descricao LIKE '%$natureza%'),(SELECT codigo FROM orgao WHERE descricaointernamunicipio LIKE '%$descricao%'),'media_cur'); MOVE FORWARD $avanco IN \"media_cur\"; FETCH FORWARD 10 IN \"media_cur\" ";
                    //execucao da query
                    $result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
                    pg_query($con,"CLOSE media_cur;");
				}
			}
            
            if (pg_num_fields($result) > 0) {
                $tp = $tr/$total_reg;
                $conteudo .= '<table id="tabela">';
                $conteudo .= '<tr>';
                $conteudo .= '<th>Orgao:</th>';
                $conteudo .= '<th>Natureza:</th>';
                $conteudo .= '<th>Mes:</th>';
                $conteudo .= '<th>Ano:</th>';
                $conteudo .= '<th>Media:</th>';
                $conteudo .= '</tr>';
                while($row = pg_fetch_assoc($result)) {
                    $conteudo .= '<tr>';
                    $conteudo .= '<td>' . $row['orgao'] . '</td> ';
                    $conteudo .= '<td>' . $row['natureza'] . '</td> ';
                    $conteudo .= '<td>' . $row['mes'] . '</td> ';
                    $conteudo .= '<td>' . $row['ano'] . '</td> ';
                    $conteudo .= '<td>' . round($row['media'],2) . '</td> ';
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