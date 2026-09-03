<?php

// Inicia a sessão somente se ela ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conecta ao banco (agora só existe $pdo — nada de $conn/mysqli)
require 'conexao.php';

// Verifica se os dados vieram pelo formulário
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/index_cadastro.php');
    exit;
}

// Recebe os dados do formulário
$email = trim($_POST['Email'] ?? '');
$senha = $_POST['Senha'] ?? '';

// Verifica se os campos estão preenchidos
if (empty($email) || empty($senha)) {
    $_SESSION['msg'] = 'Preencha o email e a senha!';
    $_SESSION['status'] = 'erro';

    header('Location: ../pages/index_cadastro.php');
    exit;
}

try {
    // Busca o funcionário pelo email
    $stmt = $pdo->prepare('SELECT id, nome, senha_hash, ativo FROM funcionarios WHERE email = ?');
    $stmt->execute([$email]);
    $funcionario = $stmt->fetch();

    // password_verify compara a senha digitada com o hash salvo no cadastro
    if ($funcionario && $funcionario['ativo'] && password_verify($senha, $funcionario['senha_hash'])) {

        // Regenera o ID de sessão por segurança (evita fixação de sessão)
        session_regenerate_id(true);

        $_SESSION['funcionario_id'] = $funcionario['id'];
        $_SESSION['funcionario_nome'] = $funcionario['nome'];
        $_SESSION['msg'] = 'Login realizado com sucesso!';
        $_SESSION['status'] = 'ok';

        header('Location: ../pages/index_sistema.php');
        exit;

    } else {

        $_SESSION['msg'] = 'Email ou senha incorretos!';
        $_SESSION['status'] = 'erro';

        header('Location: ../pages/index_cadastro.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['msg'] = 'Erro ao consultar o banco de dados.';
    $_SESSION['status'] = 'erro';

    header('Location: ../pages/index_cadastro.php');
    exit;
}
