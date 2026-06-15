<?php
require '../conexao.php';

$id = trim($_GET['id'] ?? '');

if ($id === '' || !ctype_digit($id)) {
    die('Erro: ID inválido para edição.');
}

$stmt = $cmd->prepare('SELECT * FROM Usuario WHERE Id = :id');
$stmt->execute([':id' => $id]);
$registro = $stmt->fetch();

if (!$registro) {
    die('Erro: Registro não encontrado.');
}

$nome  = $registro['Nome'];
$email = $registro['Email'];
$senha = $registro['Senha'];
$sexo  = $registro['Sexo'];
$dtna  = $registro['DataNascimento'];
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Registro</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <h1>Editar Registro</h1>
    <hr />

    <form method="post" action="atualizar.php">
        <input type="hidden" name="txtid" value="<?= htmlspecialchars($id) ?>" />

        <label for="txtnome">Nome:</label>
        <input type="text" name="txtnome" id="txtnome" maxlength="40" required value="<?= htmlspecialchars($nome) ?>" />

        <label for="txtemail">E-mail:</label>
        <input type="email" name="txtemail" id="txtemail" maxlength="40" required value="<?= htmlspecialchars($email) ?>" />

        <label for="txtsenha">Senha:</label>
        <input type="password" name="txtsenha" id="txtsenha" maxlength="150" value="<?= htmlspecialchars($senha) ?>" />

        <label>Sexo:</label>
        <label><input type="radio" value="F" name="txtsexo" id="txtsexof" <?= $sexo === 'F' ? 'checked' : '' ?> /> F</label>
        <label><input type="radio" value="M" name="txtsexo" id="txtsexom" <?= $sexo === 'M' ? 'checked' : '' ?> /> M</label>
        <label><input type="radio" value="T" name="txtsexo" id="txtsexot" <?= $sexo === 'T' ? 'checked' : '' ?> /> T</label>

        <label for="txtdata">Data de Nascimento:</label>
        <input type="date" name="txtdata" id="txtdata" value="<?= htmlspecialchars($dtna) ?>" />

        <div class="actions">
            <input type="submit" value="Atualizar" />
            <a class="button" href="../registros/listar.php">Voltar</a>
        </div>
    </form>
</body>
</html>
