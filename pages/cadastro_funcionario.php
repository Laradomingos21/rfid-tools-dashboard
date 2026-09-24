<?php
session_start();
require_once __DIR__ . '/../config/conexao.php'; // ajuste o caminho

function voltar($msg, $status)
{
    $_SESSION['msg_func'] = $msg;
    $_SESSION['status_func'] = $status;
    header('Location: ../view/cadastro_funcionario.php'); // ajuste o nome da view
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    voltar('Requisição inválida.', 'erro');
}

$nome         = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
$email        = trim(isset($_POST['email']) ? $_POST['email'] : '');
$matricula    = trim(isset($_POST['matricula']) ? $_POST['matricula'] : '');
$departamento = trim(isset($_POST['departamento']) ? $_POST['departamento'] : '');
$tag_rfid     = trim(isset($_POST['tag_rfid']) ? $_POST['tag_rfid'] : '');
$senha        = isset($_POST['senha']) ? $_POST['senha'] : '';

if ($nome === '' || $email === '' || $matricula === '' || $departamento === '' || $tag_rfid === '' || $senha === '') {
    voltar('Preencha todos os campos.', 'erro');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    voltar('Email inválido.', 'erro');
}

if (strlen($senha) < 6) {
    voltar('A senha deve ter no mínimo 6 caracteres.', 'erro');
}

try {
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO funcionarios (nome, email, matricula, departamento, tag_rfid, senha)
            VALUES (:nome, :email, :matricula, :departamento, :tag_rfid, :senha)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':nome'         => $nome,
        ':email'        => $email,
        ':matricula'    => $matricula,
        ':departamento' => $departamento,
        ':tag_rfid'     => $tag_rfid,
        ':senha'        => $hash,
    ));

    voltar('Funcionário cadastrado com sucesso!', 'sucesso');

} catch (PDOException $e) {
    if ($e->getCode() == '23000') {
        voltar('Email, matrícula ou tag RFID já cadastrados.', 'erro');
    }
    voltar('Erro ao cadastrar. Tente novamente.', 'erro');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Funcionário · RFID Tools</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Alata&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style_sistema.css">
</head>

<body>

    <main class="tela">

        <h1 class="titulo">RFID TOOLS</h1>

        <p class="subtitulo">
            Sistema de Monitoramento
        </p>

        <section class="container">

            <h2>Cadastrar Funcionário</h2>

            <p class="descricao">
                Crie um acesso para um novo funcionário usar o sistema.
            </p>

            <?php if ($msg): ?>

                <div
                    id="mensagem"
                    class="mensagem <?= htmlspecialchars($status) ?>"
                    role="alert"
                >
                    <?= htmlspecialchars($msg) ?>
                </div>

            <?php endif; ?>


            <form
                id="formulario_cadastro_funcionario"
                action="../controller/cadastrar_funcionario.php"
                method="POST"
            >

                <label for="nome">
                    Nome completo
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Nome do funcionário"
                    autocomplete="name"
                    required
                >


                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nome@empresa.com"
                    autocomplete="username"
                    required
                >


                <label for="matricula">
                    Matrícula
                </label>

                <input
                    type="text"
                    id="matricula"
                    name="matricula"
                    placeholder="Ex: F001"
                    required
                >


                <label for="departamento">
                    Departamento
                </label>

                <input
                    type="text"
                    id="departamento"
                    name="departamento"
                    placeholder="Ex: Manutenção"
                    required
                >


                <label for="tag_rfid">
                    Tag RFID
                </label>

                <input
                    type="text"
                    id="tag_rfid"
                    name="tag_rfid"
                    placeholder="Código do crachá/tag"
                    autocomplete="off"
                    required
                >


                <label for="senha">
                    Senha
                </label>

                <div class="campo-senha">

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="Mínimo 6 caracteres"
                        autocomplete="new-password"
                        minlength="6"
                        required
                    >

                    <button
                        type="button"
                        class="botao-olho"
                        id="toggleSenhaCadastro"
                        aria-label="Mostrar senha"
                        title="Mostrar senha"
                    >
                        👁
                    </button>

                </div>


                <button
                    type="submit"
                    class="botao-primario"
                >
                    Cadastrar funcionário
                </button>

            </form>


            <a
                href="index_cadastro.php"
                class="botao-secundario"
            >
                Voltar para o login
            </a>

        </section>

    </main>


    <script src="main.js"></script>

    <script>
        const botaoOlhoCadastro =
            document.getElementById('toggleSenhaCadastro');

        const campoSenhaCadastro =
            document.getElementById('senha');

        if (botaoOlhoCadastro && campoSenhaCadastro) {

            botaoOlhoCadastro.addEventListener('click', () => {

                const senhaVisivel =
                    campoSenhaCadastro.type === 'text';

                campoSenhaCadastro.type =
                    senhaVisivel ? 'password' : 'text';

                botaoOlhoCadastro.setAttribute(
                    'aria-label',
                    senhaVisivel
                        ? 'Mostrar senha'
                        : 'Ocultar senha'
                );

                botaoOlhoCadastro.setAttribute(
                    'title',
                    senhaVisivel
                        ? 'Mostrar senha'
                        : 'Ocultar senha'
                );
            });
        }
    </script>

</body>

</html>
