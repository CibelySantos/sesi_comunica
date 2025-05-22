<?php
// Ensure no output before headers
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');
include_once '../../conexao.php';

if (!$conn) {
    echo json_encode(['erro' => 'Erro de conexão com o banco de dados']);
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo json_encode(['erro' => 'ID inválido']);
    exit;
}

// Buscar dados principais do formulário - Removed f.inativo from the query
$sql = "SELECT f.id, f.nome, pub.publico_alvo, d.data_envio, d.data_limite
        FROM formularios f
        LEFT JOIN publico pub ON f.id = pub.formulario_id
        LEFT JOIN data_formularios d ON f.id = d.formulario_id
        WHERE f.id = ?";

try {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }
    
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $formulario = $result->fetch_assoc();
    
    if (!$formulario) {
        echo json_encode(['erro' => 'Formulário não encontrado']);
        exit;
    }

    // Buscar perguntas
    $sql_perguntas = "SELECT id, pergunta, tipo_pergunta FROM perguntas WHERE formulario_id = ?";
    $stmt_perg = $conn->prepare($sql_perguntas);
    if (!$stmt_perg) {
        throw new Exception("Erro na preparação da consulta de perguntas: " . $conn->error);
    }
    
    $stmt_perg->bind_param('i', $id);
    $stmt_perg->execute();
    $res_perg = $stmt_perg->get_result();
    $perguntas = [];
    
    while ($perg = $res_perg->fetch_assoc()) {
        $pergunta = [
            'id' => $perg['id'],
            'texto' => $perg['pergunta'],
            'tipo' => $perg['tipo_pergunta']
        ];
        
        if ($perg['tipo_pergunta'] === 'objetiva') {
            $sql_op = "SELECT texto_opcao FROM respostas WHERE pergunta_id = ? ORDER BY ordem ASC";
            $stmt_op = $conn->prepare($sql_op);
            if (!$stmt_op) {
                throw new Exception("Erro na preparação da consulta de opções: " . $conn->error);
            }
            
            $stmt_op->bind_param('i', $perg['id']);
            $stmt_op->execute();
            $res_op = $stmt_op->get_result();
            $opcoes = [];
            
            while ($op = $res_op->fetch_assoc()) {
                $opcoes[] = $op['texto_opcao'];
            }
            $pergunta['opcoes'] = $opcoes;
        }
        
        if ($perg['tipo_pergunta'] === 'classificacao') {
            $sql_cl = "SELECT min_classificacao, max_classificacao FROM perguntas WHERE id = ?";
            $stmt_cl = $conn->prepare($sql_cl);
            if (!$stmt_cl) {
                throw new Exception("Erro na preparação da consulta de classificação: " . $conn->error);
            }
            
            $stmt_cl->bind_param('i', $perg['id']);
            $stmt_cl->execute();
            $res_cl = $stmt_cl->get_result();
            $cl = $res_cl->fetch_assoc();
            $pergunta['min'] = $cl ? intval($cl['min_classificacao']) : 1;
            $pergunta['max'] = $cl ? intval($cl['max_classificacao']) : 5;
        }
        
        $perguntas[] = $pergunta;
    }

    $formulario['perguntas'] = $perguntas;
    // Set default value for inativo since the column doesn't exist
    $formulario['inativo'] = false;
    $formulario['data_criacao'] = $formulario['data_envio'];
    unset($formulario['data_envio']);

    echo json_encode($formulario, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro interno do servidor: ' . $e->getMessage()]);
}
?>