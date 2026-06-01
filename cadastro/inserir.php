<?php
// Inclui o arquivo de conexão que está na raiz
require '../conexao.php';

// Recebe os dados enviados pelo formulário via método POST
$nome  = trim($_POST['txtnome'] ?? '');
$email = trim($_POST['txtemail'] ?? '');
$senha = trim($_POST['txtsenha'] ?? '');
$sexo  = $_POST['txtsexo'] ?? '';
$dtna  = $_POST['txtdata'] ?? null;

// Validação básica: nome e e-mail são obrigatórios
if ($nome === '' || $email === '') {
    die('Erro: Nome e E-mail são campos obrigatórios para o cadastro.');
}

// Prepara a instrução SQL para inserção de dados de forma segura
$sql = 'INSERT INTO Usuario (Nome, Email, Senha, Sexo, DataNascimento) 
        VALUES (:nome, :email, :senha, :sexo, :dtna)';

// Prepara a query no banco de dados
$stmt = $cmd->prepare($sql);

// Executa a query passando os valores reais
$stmt->execute([
    ':nome'  => $nome,
    ':email' => $email,
    ':senha' => $senha,
    ':sexo'  => $sexo,
    ':dtna'  => $dtna,
]);

// Redireciona para a listagem
header('Location: ../registros/listar.php');
exit;
?>
