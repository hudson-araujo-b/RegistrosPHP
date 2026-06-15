<?php
require '../conexao.php';

$id = trim($_GET['id'] ?? $_POST['txtid'] ?? '');

if ($id === '' || !ctype_digit($id)) {
    die('Erro: ID inválido para exclusão.');
}

$sql = 'DELETE FROM Usuario WHERE Id = :id';

$stmt = $cmd->prepare($sql);
$stmt->execute([':id' => $id]);

header('Location: ../registros/listar.php');
exit;
