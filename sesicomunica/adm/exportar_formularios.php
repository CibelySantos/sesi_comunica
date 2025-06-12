<?php
require __DIR__ . '/../../vendor/autoload.php';
include_once '../../conexao.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Recebe o ID do formulário via GET
$formularioId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se um ID válido foi fornecido
if ($formularioId <= 0) {
    die('ID de formulário inválido.');
}

// Cria a planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Cabeçalhos
$headers = [
    'ID Formulário',
    'Nome',
    'Público Alvo',
    'Data Limite',
    'ID Pergunta',
    'Pergunta',
    'ID Resposta',
    'Resposta',
    'Texto da Opção'
];
$sheet->fromArray($headers, null, 'A1');

// Query SQL com filtro pelo ID
$sql = "SELECT 
            f.id AS formulario_id,
            f.nome,
            pub.publico_alvo,
            d.data_envio,
            d.data_limite,
            p.id AS pergunta_id,
            p.pergunta,
            r.id AS resposta_id,
            r.resposta,
            r.texto_opcao
        FROM formularios f
        LEFT JOIN publico pub ON f.id = pub.formulario_id
        LEFT JOIN data_formularios d ON f.id = d.formulario_id
        LEFT JOIN perguntas p ON f.id = p.formulario_id
        LEFT JOIN respostas r ON p.id = r.pergunta_id
        WHERE f.id = ?
        ORDER BY p.id ASC, r.id ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $formularioId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $rowIndex = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->fromArray([
            $row['formulario_id'],
            $row['nome'],
            $row['publico_alvo'],
            $row['data_limite'],
            $row['pergunta_id'],
            $row['pergunta'],
            $row['resposta_id'],
            $row['resposta'],
            $row['texto_opcao']
        ], null, 'A' . $rowIndex);
        $rowIndex++;
    }
} else {
    // Nenhum dado encontrado
    $sheet->setCellValue('A2', 'Nenhum dado encontrado para este formulário.');
}

// Exporta para o navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="formulario_' . $formularioId . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
