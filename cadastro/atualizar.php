<?php
require '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido para atualização. Use o formulário de edição.');
}

$id  = trim($_POST['txtid'] ?? '');
$nome  = trim($_POST['txtnome'] ?? '');
$email = trim($_POST['txtemail'] ?? '');
$senha = trim($_POST['txtsenha'] ?? '');
$sexo  = $_POST['txtsexo'] ?? '';
$dtna  = $_POST['txtdata'] ?? null;

if ($id === '' || !ctype_digit($id)) {
    die('Erro: ID inválido para atualização.');
}

if ($nome === '' || $email === '') {
    die('Erro: Nome e E-mail são campos obrigatórios para atualizar o registro.');
}

$sql = 'UPDATE Usuario
        SET Nome = :nome,
            Email = :email,
            Senha = :senha,
            Sexo = :sexo,
            DataNascimento = :dtna
        WHERE Id = :id';

$stmt = $cmd->prepare($sql);
$stmt->execute([
    ':id'    => $id,
    ':nome'  => $nome,
    ':email' => $email,
    ':senha' => $senha,
    ':sexo'  => $sexo,
    ':dtna'  => $dtna,
]);

header('Location: ../registros/listar.php');
exit;

