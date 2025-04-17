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

// Receber dados do formulário
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id']) || !is_numeric($data['id'])) {
    echo json_encode(['erro' => 'ID inválido ou dados ausentes']);
    exit;
}

$conn->begin_transaction();

try {
    // Atualizar formulário
    $sql = "UPDATE formularios SET nome = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }
    
    $stmt->bind_param('si', $data['nome'], $data['id']);
    if (!$stmt->execute()) {
        throw new Exception("Erro ao atualizar formulário: " . $stmt->error);
    }

    // Atualizar público alvo
    $sql = "UPDATE publico SET publico_alvo = ? WHERE formulario_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }
    
    $stmt->bind_param('si', $data['publico_alvo'], $data['id']);
    if (!$stmt->execute()) {
        throw new Exception("Erro ao atualizar público alvo: " . $stmt->error);
    }

    // Atualizar datas
    $sql = "UPDATE data_formularios SET data_envio = ?, data_limite = ? WHERE formulario_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }
    
    $stmt->bind_param('ssi', $data['data_criacao'], $data['data_limite'], $data['id']);
    if (!$stmt->execute()) {
        throw new Exception("Erro ao atualizar datas: " . $stmt->error);
    }

    // Atualizar perguntas
    foreach ($data['perguntas'] as $pergunta) {
        if (isset($pergunta['id'])) {
            // Atualizar pergunta existente
            $sql = "UPDATE perguntas SET pergunta = ?, tipo_pergunta = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }
            
            $stmt->bind_param('ssi', $pergunta['texto'], $pergunta['tipo'], $pergunta['id']);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao atualizar pergunta: " . $stmt->error);
            }

            if ($pergunta['tipo'] === 'objetiva' && isset($pergunta['opcoes'])) {
                // Limpar opções antigas
                $sql = "DELETE FROM respostas WHERE pergunta_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $pergunta['id']);
                $stmt->execute();

                // Inserir novas opções
                $sql = "INSERT INTO respostas (pergunta_id, texto_opcao, ordem) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                foreach ($pergunta['opcoes'] as $ordem => $texto) {
                    $stmt->bind_param('isi', $pergunta['id'], $texto, $ordem);
                    if (!$stmt->execute()) {
                        throw new Exception("Erro ao inserir opção: " . $stmt->error);
                    }
                }
            }

            if ($pergunta['tipo'] === 'classificacao') {
                $sql = "UPDATE perguntas SET min_classificacao = ?, max_classificacao = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('iii', $pergunta['min'], $pergunta['max'], $pergunta['id']);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao atualizar classificação: " . $stmt->error);
                }
            }
        } else {
            // Inserir nova pergunta
            $sql = "INSERT INTO perguntas (formulario_id, pergunta, tipo_pergunta) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iss', $data['id'], $pergunta['texto'], $pergunta['tipo']);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir pergunta: " . $stmt->error);
            }

            $pergunta_id = $stmt->insert_id;

            if ($pergunta['tipo'] === 'objetiva' && isset($pergunta['opcoes'])) {
                $sql = "INSERT INTO respostas (pergunta_id, texto_opcao, ordem) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                foreach ($pergunta['opcoes'] as $ordem => $texto) {
                    $stmt->bind_param('isi', $pergunta_id, $texto, $ordem);
                    if (!$stmt->execute()) {
                        throw new Exception("Erro ao inserir opção: " . $stmt->error);
                    }
                }
            }

            if ($pergunta['tipo'] === 'classificacao') {
                $sql = "UPDATE perguntas SET min_classificacao = ?, max_classificacao = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('iii', $pergunta['min'], $pergunta['max'], $pergunta_id);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao inserir classificação: " . $stmt->error);
                }
            }
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}
?>
