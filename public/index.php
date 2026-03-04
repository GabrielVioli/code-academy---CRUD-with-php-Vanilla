<?php
require_once 'functions.php';

$acao = $_GET['acao'] ?? 'listar';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($acao === 'cadastrar') {
        cadastrar_produto($_POST['nome'], $_POST['preco'], $_POST['quantidade'], isset($_POST['ativo']));
        $mensagem = "Produto cadastrado com sucesso";
        $acao = 'listar';

    } elseif ($acao === 'editar') {
        editar_produto($_POST['id'], $_POST['nome'], $_POST['preco'], $_POST['quantidade'], isset($_POST['ativo']));
        $mensagem = "Produto editado com sucesso";
        $acao = 'listar';
    }

} elseif ($acao === 'remover' && isset($_GET['id'])) {
    remover_produto($_GET['id']);
    $mensagem = "Produto removido com sucesso";
    $acao = 'listar';
}

$produtos = listar_produtos();
$estatisticas = calcular_estatisticas();
$resultadosBusca = [];

if ($acao === 'buscar' && isset($_GET['termo'])) {
    $resultadosBusca = buscar_produto($_GET['termo']);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Gerenciador de Produtos</h1>

<div class="menu">
    <a href="?acao=listar">Listar Todos</a>
    <a href="?acao=cadastrar">Cadastrar Novo</a>
    <a href="?acao=buscar">Buscar</a>
    <a href="?acao=estatisticas">Estatísticas</a>
</div>

<?php
if ($mensagem): ?>
    <p class="msg"><?= $mensagem ?></p>
<?php endif;
?>

<?php if ($acao === 'listar'): ?>
    <h2>Lista de Produtos</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>

        <?php if (empty($produtos)): ?>
            <tr><td colspan="5">Nenhum produto cadastrado.</td></tr>
        <?php else: ?>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                    <td><?= $produto['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td>
                        <a href="?acao=editar_form&id=<?= $produto['id'] ?>">Editar</a> |
                        <a href="?acao=remover&id=<?= $produto['id'] ?>" onclick="return confirm('Tem certeza que deseja remover?')">Remover</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

<?php elseif ($acao === 'cadastrar'): ?>
    <h2>Cadastrar Produto</h2>
    <form method="POST" action="?acao=cadastrar">
        <p>Nome: <input type="text" name="nome" required></p>
        <p>Preço: <input type="number" step="0.01" name="preco" required></p>
        <p>Quantidade: <input type="number" name="quantidade" required></p>
        <p>Ativo: <input type="checkbox" name="ativo" checked></p>
        <button type="submit">Salvar Produto</button>
    </form>

<?php elseif ($acao === 'editar_form'):
    $produtoEditar = null;
    foreach ($produtos as $p) {
        if ($p['id'] === $_GET['id']) $produtoEditar = $p;
    }
    if ($produtoEditar):
        ?>
        <h2>Editar Produto</h2>
        <form method="POST" action="?acao=editar">
            <input type="hidden" name="id" value="<?= $produtoEditar['id'] ?>">
            <p>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($produtoEditar['nome']) ?>"></p>
            <p>Preço: <input type="number" step="0.01" name="preco" value="<?= $produtoEditar['preco'] ?>"></p>
            <p>Quantidade: <input type="number" name="quantidade" value="<?= $produtoEditar['quantidade'] ?>"></p>
            <p>Ativo: <input type="checkbox" name="ativo" <?= $produtoEditar['ativo'] ? 'checked' : '' ?>></p>
            <button type="submit">Atualizar Produto</button>
        </form>
    <?php else: echo "<p>Produto não encontrado.</p>"; endif; ?>


<?php elseif ($acao === 'estatisticas'): ?>
    <h2>Estatísticas</h2>
    <ul>
        <li><strong>Total de Produtos:</strong> <?= $estatisticas['total'] ?></li>
        <li><strong>Unidades Totais em Estoque:</strong> <?= $estatisticas['estoque_total'] ?></li>
        <li><strong>Média de Preço:</strong> R$ <?= number_format($estatisticas['media_preco'], 2, ',', '.') ?></li>
    </ul>
<?php endif; ?>

</body>
</html>