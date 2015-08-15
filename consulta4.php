<?php
require_once 'Database.php';    
session_start();
error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;
$total_reg = "10"; // número de registros por página

if($post){

	$natureza = $_POST['natureza'];
	
	$mensagem = '';
	$consulta = '';
	$result = '';
	$error = '';

	//conecta com o BD
    $inst = Database::getInstance();
    $con = $inst->getConnection();
    
     $pagina = $_POST['pagina'];
        if(!$pagina){
			$resultado = pg_query("SELECT COUNT(*) AS total FROM reduzido, programa WHERE reduzido.codigoprograma = programa.codigo AND programa.descricaointernamunicipio LIKE '%$natureza%'");
            $conta = pg_fetch_assoc($resultado);
            $tr = $conta['total'];
            $pc = 1; //primeira página a ser exibida
        }else{
            $pc = $pagina;
            $tr = $_POST['tr'];
        }
        
        $inicio = ($pc -1)* $total_reg;
    
	if($con){
            //query de busca no banco
            $consulta = "SELECT programa.descricaointernamunicipio AS descr, reduzido.datames, reduzido.dataano, reduzido.valor FROM reduzido, programa WHERE reduzido.codigoprograma = programa.codigo AND programa.descricaointernamunicipio LIKE '%$natureza%' ORDER BY reduzido.dataano, reduzido.datames LIMIT $total_reg OFFSET $inicio;";
            //execucao da query
            $result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
            if (pg_num_fields($result) > 0) {
                $tp = $tr/$total_reg;
                $conteudo .= '<table id="tabela">';
                $conteudo .= '<tr>';
                $conteudo .= '<th>Decrição:</th>';
                $conteudo .= '<th>Valor:</th>';
                $conteudo .= '<th>Mês:</th>';
                $conteudo .= '<th>Ano:</th>';
                $conteudo .= '</tr>';
                while($row = pg_fetch_assoc($result)) {
                    $conteudo .= '<tr>';
                    $conteudo .= '<td>' . $row['descr'] . '</td> ';
                    $conteudo .= '<td>' . number_format ( floatval($row['valor']) , 2 , "," , "." ) . '</td> ';
                    $conteudo .= '<td>'. $row['datames'].'</td>';
                    $conteudo .= '<td>'. $row['dataano'].'</td>';
                    $conteudo .= '</tr>';
                }
                $conteudo .= '</table>';
                
            }else{
                $error.='Nenhum resultado foi encontrado<br/>';
            }
			
            //Encerra a conexão com o banco
            pg_close($link);
			
	}else{
            $error.='não foi possível conectar com o banco' .pg_last_error();
        }

	if(!$error){
            echo json_encode(array($conteudo,$pc,$tp,$tr));
	}else{
            echo $error;
        }
}
?>