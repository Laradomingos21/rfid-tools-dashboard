<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/conexao.php';

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {

    $_SESSION['msg_login'] = 'Preencha o email e a senha.';
    $_SESSION['status_login'] = 'erro';

    header('Location: ../view/index_cadastro.php');
    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $_SESSION['msg_login'] = 'Informe um email válido.';
    $_SESSION['status_login'] = 'erro';

    header('Location: ../view/index_cadastro.php');
    exit;
}


try {

    // =====================================================
    // BUSCAR FUNCIONÁRIO
    // =====================================================

    $sql = "
        SELECT
            id,
            nome,
            matricula,
            setor,
            email,
            ativo,
            criado_em,
            Senha
        FROM funcionarios
        WHERE email = :email
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':email' => $email
    ]);

    $funcionario = $stmt->fetch();


    // =====================================================
    // VERIFICAR SE O FUNCIONÁRIO EXISTE
    // =====================================================

    if (!$funcionario) {

        $_SESSION['msg_login'] = 'Email ou senha incorretos.';
        $_SESSION['status_login'] = 'erro';

        header('Location: ../view/index_cadastro.php');
        exit;
    }


    // =====================================================
    // VERIFICAR SE O USUÁRIO ESTÁ ATIVO
    // =====================================================

    if ((int) $funcionario['ativo'] !== 1) {

        $_SESSION['msg_login'] =
            'Este funcionário está com o acesso desativado.';

        $_SESSION['status_login'] = 'erro';

        header('Location: ../view/index_cadastro.php');
        exit;
    }


    // =====================================================
    // VERIFICAR SENHA
    // =====================================================

    if (!password_verify($senha, $funcionario['Senha'])) {

        $_SESSION['msg_login'] = 'Email ou senha incorretos.';
        $_SESSION['status_login'] = 'erro';

        header('Location: ../view/index_cadastro.php');
        exit;
    }


    // =====================================================
    // LOGIN AUTENTICADO
    // =====================================================

    session_regenerate_id(true);


    $_SESSION['logado'] = true;

    $_SESSION['funcionario_id'] = $funcionario['id'];
    $_SESSION['funcionario_nome'] = $funcionario['nome'];
    $_SESSION['funcionario_matricula'] = $funcionario['matricula'];
    $_SESSION['funcionario_setor'] = $funcionario['setor'];
    $_SESSION['funcionario_email'] = $funcionario['email'];


    // =====================================================
    // REDIRECIONAR PARA O SISTEMA
    // =====================================================

    header('Location: ../view/sistema.php');
    exit;


} catch (PDOException $e) {

    // Registrar o erro no log do servidor.
    error_log(
        'Erro no login RFID Tools: ' . $e->getMessage()
    );


    $_SESSION['msg_login'] =
        'Não foi possível realizar o login. Tente novamente.';

    $_SESSION['status_login'] = 'erro';


    header('Location: ../view/index_cadastro.php');
    exit;
}
