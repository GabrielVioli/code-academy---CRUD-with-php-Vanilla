<?php
session_start();

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [];
}

function cadastrar_produto($nome, $preco, $quantidade, $ativo) {
    $_SESSION['produtos'][] = [
        'id' => uniqid(),
        'nome' => trim($nome),
        'preco' => (float)$preco,
        'quantidade' => (int)$quantidade,
        'ativo' => (bool)$ativo
    ];
}

function listar_produtos() {
    $dados = $_SESSION['produtos'];
    return $dados;
}

function buscar_produto($termo) {
    $resultados = [];
    foreach ($_SESSION['produtos'] as $item) {
        if (stripos($item['nome'], $termo) !== false) {
            $resultados[] = $item;
        }
    }
    return $resultados;
}

function editar_produto($id, $nome, $preco, $quantidade, $ativo) {
    foreach ($_SESSION['produtos'] as &$item) {
        if ($item['id'] === $id) {
            $item['nome'] = $nome !== '' ? trim($nome) : $item['nome'];
            $item['preco'] = $preco !== '' ? (float)$preco : $item['preco'];
            $item['quantidade'] = $quantidade !== '' ? (int)$quantidade : $item['quantidade'];
            $item['ativo'] = $ativo !== '' ? (bool)$ativo : $item['ativo'];
            return true;
        }
    }
    return false;
}

function remover_produto($id) {
    foreach ($_SESSION['produtos'] as $key => $item) {
        if ($item['id'] === $id) {
            unset($_SESSION['produtos'][$key]);
            $_SESSION['produtos'] = array_values($_SESSION['produtos']);
            return true;
        }
    }
    return false;
}

function calcular_estatisticas() {
    $dados = $_SESSION['produtos'];
    $total = count($dados);

    if ($total === 0) {
        return ['total' => 0, 'estoque_total' => 0, 'media_preco' => 0];
    }

    $estoqueTotal = 0;
    $somaPreco = 0;

    foreach ($dados as $item) {
        $estoqueTotal += $item['quantidade'];
        $somaPreco += $item['preco'];
    }

    return [
        'total' => $total,
        'estoque_total' => $estoqueTotal,
        'media_preco' => round($somaPreco / $total, 2)
    ];
}