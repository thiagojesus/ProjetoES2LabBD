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
			//$resultado = pg_query("SELECT COUNT(*) AS total FROM reduzido, natureza WHERE reduzido.codigonatureza = natureza.codigo and natureza.descricao LIKE '%$natureza%'");
            //$conta = pg_fetch_assoc($resultado);
            $tr = 1;
            $pc = 1; //primeira página a ser exibida
        }else{
            $pc = $pagina;
            $tr = $_POST['tr'];
        }
        
        $inicio = ($pc -1)* $total_reg;
    
	if($con){
            //query de busca no banco
            $consulta = "SELECT SUM( valor ) AS soma FROM reduzido, natureza WHERE reduzido.codigonatureza = natureza.codigo and natureza.descricao LIKE '%$natureza%' LIMIT $total_reg OFFSET $inicio;";
            //execucao da query
            $result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
            if (pg_num_fields($result) > 0) {
                $tp = $tr/$total_reg;
                $conteudo .= '<table id="tabela">';
                $conteudo .= '<tr>';
                $conteudo .= '<th>Valor Total:</th>';
                $conteudo .= '</tr>';
                while($row = pg_fetch_assoc($result)) {
                    $conteudo .= '<tr>';
                    $conteudo .= '<td>' . number_format ( floatval($row['soma']) , 2 , "," , "." ) . '</td> ';
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
            echo json_encode(array($error));
        }
}
?>