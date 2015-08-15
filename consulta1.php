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
            $resultado = pg_query("SELECT COUNT(*) AS total FROM reduzido r, natureza n WHERE r.codigonatureza = n.codigo AND r.valor BETWEEN $init_value AND $final_value");
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
            $consulta = "SELECT n.descricao FROM reduzido r, natureza n WHERE r.codigonatureza = n.codigo AND r.valor BETWEEN $init_value AND $final_value LIMIT $total_reg OFFSET $inicio;";
            //execucao da query
            $result = pg_query($con, $consulta) or die("Cannot execute query: $consulta\n"); 
            if (pg_num_fields($result) > 0) {
                $tp = $tr/$total_reg;
                $conteudo .= '<table id="tabela">';
                $conteudo .= '<tr>';
                $conteudo .= '<th>Programa:</th>';
                $conteudo .= '</tr>';
                while($row = pg_fetch_assoc($result)) {
                    $conteudo .= '<tr>';
                    $conteudo .= '<td>' . $row['descricao'] . '</td> ';
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