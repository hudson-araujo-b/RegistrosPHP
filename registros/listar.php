<?php
// Inclui o arquivo de conexão que está na raiz (um nível acima)
require '../conexao.php';

// Recebe o termo de busca enviado via formulário pelo método GET (url)
$busca = trim($_GET['txtbusca'] ?? '');

// Verifica se foi digitado algum termo para a pesquisa
if ($busca !== '') {
    // Caso haja busca: prepara a consulta SQL buscando nomes que comecem com o termo
    $sql = 'SELECT * FROM Usuario WHERE Nome LIKE :busca ORDER BY Nome';
    $stmt = $cmd->prepare($sql);
    $stmt->execute([':busca' => $busca . '%']);
    $registros = $stmt->fetchAll();
} else {
    // Caso não haja busca: exibe todos os registros
    $sql = 'SELECT * FROM Usuario ORDER BY Id ASC';
    $stmt = $cmd->query($sql);
    $registros = $stmt->fetchAll();
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesquisar Registros</title>
    <!-- CSS na pasta css que está na raiz (nível acima) -->
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <h1>Pesquisar Registros</h1>
    <hr />

    <!-- Formulário de pesquisa (envia os dados para este mesmo arquivo listar.php) -->
    <form method="get" action="listar.php">
        <label for="txtbusca">Pesquisar por Nome (começa com):</label>
        <div style="display: flex; gap: 10px; margin-top: 5px;">
            <input type="text" name="txtbusca" id="txtbusca" value="<?= htmlspecialchars($busca) ?>" placeholder="Digite o nome..." style="flex: 1;" autofocus />
            <input type="submit" value="Buscar" style="margin-top: 0;" />
        </div>
    </form>

    <!-- Exibição dos resultados -->
    <?php if (empty($registros)): ?>
        <?php if ($busca !== ''): ?>
            <p class="empty">Nenhum registro encontrado para "<?= htmlspecialchars($busca) ?>".</p>
        <?php else: ?>
            <p class="empty">Não existem registros para exibir.</p>
        <?php endif; ?>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Senha</th>
                    <th>Sexo</th>
                    <th>Nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $linha): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['Id']) ?></td>
                        <td><?= htmlspecialchars($linha['Nome']) ?></td>
                        <td><?= htmlspecialchars($linha['Email']) ?></td>
                        <td><?= htmlspecialchars($linha['Senha']) ?></td>
                        <td><?= htmlspecialchars($linha['Sexo']) ?></td>
                        <td><?= htmlspecialchars($linha['DataNascimento']) ?></td>
                        <td>
                            <a class="button" href="../cadastro/editar.php?id=<?php echo urlencode($linha['Id']); ?>">Editar</a>
                            <a class="button" href="../cadastro/deletar.php?id=<?php echo urlencode($linha['Id']); ?>" style="background-color: #d32f2f;" onclick="return confirm('Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>

    <!-- Seção de botões de navegação -->
    <div class="actions">
        <!-- Retorna para a raiz onde está o index.html -->
        <a class="button" href="../index.html">Menu</a>
        <!-- Abre o cadastrar.html que está na pasta cadastro (sobe um nível, entra na pasta cadastro) -->
        <a class="button" href="../cadastro/cadastrar.html">Novo cadastro</a>
    </div>
</body>
</html>
