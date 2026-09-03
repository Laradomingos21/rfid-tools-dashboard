<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Tools · Sistema de Monitoramento & Estilização CSS</title>
    
    <!-- Google Fonts: Alata e JetBrains Mono para códigos/tags -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ==========================================================================
           RFID TOOLS - STYLE_SISTEMA.CSS (Estilo Global, Dashboard & Formulários)
           ========================================================================== */

        /* ----- Variáveis Globais de Design (Design Tokens) ----- */
        :root {
            /* Cores de Destaque Cyberpunk / Neon */
            --cor-primaria: #1de3d8;
            --cor-primaria-hover: #19c4bb;
            --cor-primaria-glow: rgba(29, 227, 216, 0.35);
            --cor-primaria-subtle: rgba(29, 227, 216, 0.08);

            /* Cores de Status */
            --cor-sucesso: #3ee08a;
            --cor-sucesso-glow: rgba(62, 224, 138, 0.25);
            --cor-alerta: #f2b84b;
            --cor-alerta-glow: rgba(242, 184, 75, 0.25);
            --cor-erro: #e24b4a;
            --cor-erro-glow: rgba(226, 75, 74, 0.25);

            /* Fundos Escuros e Vidro (Glassmorphism) */
            --bg-body: radial-gradient(circle at 50% 0%, #101817 0%, #05070a 60%, #000000 100%);
            --bg-card: rgba(255, 255, 255, 0.03);
            --bg-card-hover: rgba(255, 255, 255, 0.05);
            --bg-input: rgba(0, 0, 0, 0.45);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-highlight: rgba(29, 227, 216, 0.3);

            /* Textos e Tipografia */
            --texto-principal: #e8f5f3;
            --texto-secundario: #9aa5a3;
            --texto-desativado: #5f6b69;
            --fonte-principal: 'Alata', sans-serif;
            --fonte-mono: 'JetBrains Mono', monospace;

            /* Transições e Sombras */
            --transicao-suave: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --sombra-neon: 0 0 20px rgba(29, 227, 216, 0.15);
            --sombra-card: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* ----- Reset & Estrutura Base ----- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--fonte-principal);
        }

        html, body {
            min-height: 100%;
            background: #05070a;
            color: var(--texto-principal);
            overflow-x: hidden;
            background-image: var(--bg-body);
            background-attachment: fixed;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(29, 227, 216, 0.3);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--cor-primaria);
        }

        /* ----- Barra Superior (Topbar) ----- */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            border-bottom: 1px solid var(--border-subtle);
            background: rgba(5, 7, 10, 0.7);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar .marca {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar .marca i {
            font-size: 20px;
            color: var(--cor-primaria);
            filter: drop-shadow(0 0 8px var(--cor-primaria-glow));
        }

        .topbar .marca h1 {
            font-size: 18px;
            letter-spacing: 3px;
            color: var(--cor-primaria);
            text-shadow: 0 0 12px var(--cor-primaria-glow);
            font-weight: normal;
        }

        .topbar .marca span {
            font-size: 11px;
            color: var(--texto-secundario);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 1px solid var(--border-subtle);
            padding-left: 10px;
        }

        .topbar .usuario {
            display: flex;
            align-items: center;
            gap: 18px;
            font-size: 13px;
            color: var(--texto-secundario);
        }

        .topbar .usuario strong {
            color: var(--texto-principal);
            font-weight: 600;
        }

        .botao-sair {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid rgba(226, 75, 74, 0.35);
            background: rgba(226, 75, 74, 0.08);
            color: #f4a3a3;
            font-size: 12px;
            transition: var(--transicao-suave);
            cursor: pointer;
        }

        .botao-sair:hover {
            background: rgba(226, 75, 74, 0.2);
            border-color: rgba(226, 75, 74, 0.6);
            color: #ffffff;
            box-shadow: 0 0 12px var(--cor-erro-glow);
        }

        /* ----- Barra Demostração / Switcher de Telas ----- */
        .demo-bar {
            background: rgba(0, 0, 0, 0.8);
            border-bottom: 1px solid var(--border-highlight);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            font-size: 13px;
        }

        .demo-controls {
            display: flex;
            gap: 10px;
        }

        .btn-demo {
            padding: 6px 14px;
            border-radius: 6px;
            border: 1px solid var(--border-highlight);
            background: rgba(29, 227, 216, 0.08);
            color: var(--cor-primaria);
            font-size: 12px;
            cursor: pointer;
            transition: var(--transicao-suave);
        }

        .btn-demo.ativo, .btn-demo:hover {
            background: var(--cor-primaria);
            color: #000000;
            font-weight: bold;
            box-shadow: 0 0 10px var(--cor-primaria-glow);
        }

        /* ===== Container Principal (Painel Dashboard) ===== */
        .painel {
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 32px 60px;
        }

        /* ===== Barra de leitura RFID (Leitor Principal) ===== */
        .scan-bar {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px 28px;
            border-radius: 14px;
            background: rgba(29, 227, 216, 0.04);
            border: 1px solid var(--border-highlight);
            box-shadow: var(--sombra-neon), inset 0 0 20px rgba(29, 227, 216, 0.02);
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
        }

        .scan-bar .scan-label {
            display: flex;
            flex-direction: column;
            min-width: 210px;
        }

        .scan-bar .scan-label strong {
            font-size: 15px;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .scan-bar .scan-label small {
            font-size: 11px;
            color: var(--cor-primaria);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 4px;
        }

        #form-scan {
            flex: 1;
            display: flex;
            gap: 12px;
        }

        #form-scan input {
            flex: 1;
            padding: 12px 18px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: var(--bg-input);
            color: #ffffff;
            font-size: 15px;
            letter-spacing: 1px;
            font-family: var(--fonte-mono);
            outline: none;
            transition: var(--transicao-suave);
        }

        #form-scan input:focus {
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 3px var(--cor-primaria-glow);
            background: rgba(0, 0, 0, 0.65);
        }

        #form-scan button {
            padding: 12px 24px;
            border-radius: 8px;
            border: 1px solid var(--cor-primaria);
            background: rgba(29, 227, 216, 0.15);
            color: var(--cor-primaria);
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transicao-suave);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #form-scan button:hover {
            background: var(--cor-primaria);
            color: #05070a;
            box-shadow: 0 0 15px var(--cor-primaria-glow);
        }

        /* Feedback de Leitura RFID */
        #scan-feedback {
            min-height: 24px;
            font-size: 13px;
            margin-bottom: 22px;
            padding: 8px 14px;
            border-radius: 6px;
            display: none;
        }

        #scan-feedback.sucesso {
            display: block;
            background: rgba(62, 224, 138, 0.1);
            color: var(--cor-sucesso);
            border: 1px solid rgba(62, 224, 138, 0.3);
        }

        #scan-feedback.erro {
            display: block;
            background: rgba(226, 75, 74, 0.1);
            color: #f4a3a3;
            border: 1px solid rgba(226, 75, 74, 0.3);
        }

        /* ===== Cards de Estatística ===== */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            padding: 18px 20px;
            border-radius: 12px;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-left: 4px solid var(--cor-stat, var(--cor-primaria));
            transition: var(--transicao-suave);
            backdrop-filter: blur(5px);
        }

        .stat-card:hover {
            background: var(--bg-card-hover);
            transform: translateY(-2px);
            box-shadow: var(--sombra-card);
        }

        .stat-card .valor {
            font-size: 28px;
            font-weight: bold;
            color: #ffffff;
            font-family: var(--fonte-mono);
        }

        .stat-card .rotulo {
            font-size: 12px;
            color: var(--texto-secundario);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card.total       { --cor-stat: var(--cor-primaria); }
        .stat-card.disponivel  { --cor-stat: var(--cor-sucesso); }
        .stat-card.emprestada  { --cor-stat: var(--cor-alerta); }
        .stat-card.manutencao  { --cor-stat: var(--cor-erro); }

        /* ===== Layout de Duas Colunas do Dashboard ===== */
        .conteudo {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .painel-secao {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 22px;
            backdrop-filter: blur(8px);
        }

        .painel-secao h2 {
            font-size: 15px;
            letter-spacing: 0.5px;
            color: #ffffff;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .painel-secao .subinfo {
            font-size: 12px;
            color: var(--texto-secundario);
            margin-bottom: 18px;
        }

        /* Tabela de Ferramentas */
        table.ferramentas {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        table.ferramentas th {
            text-align: left;
            padding: 10px 12px;
            color: var(--texto-secundario);
            font-weight: normal;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        table.ferramentas td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transicao-suave);
        }

        table.ferramentas tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        table.ferramentas tr:last-child td {
            border-bottom: none;
        }

        table.ferramentas td.tag {
            color: var(--texto-secundario);
            font-size: 12px;
            font-family: var(--fonte-mono);
        }

        /* Badges de Status */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            letter-spacing: 0.3px;
            font-weight: 500;
        }

        .status-badge.disponivel {
            background: rgba(62, 224, 138, 0.12);
            color: var(--cor-sucesso);
            border: 1px solid rgba(62, 224, 138, 0.35);
        }

        .status-badge.emprestada {
            background: rgba(242, 184, 75, 0.12);
            color: var(--cor-alerta);
            border: 1px solid rgba(242, 184, 75, 0.35);
        }

        .status-badge.manutencao {
            background: rgba(226, 75, 74, 0.12);
            color: #f4a3a3;
            border: 1px solid rgba(226, 75, 74, 0.35);
        }

        /* Feed de Movimentações */
        .feed-movimentacoes {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 460px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .feed-movimentacoes li {
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 13px;
        }

        .feed-movimentacoes li:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .feed-movimentacoes .linha-topo {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .feed-movimentacoes .tipo-emprestimo { color: var(--cor-alerta); }
        .feed-movimentacoes .tipo-devolucao  { color: var(--cor-sucesso); }

        .feed-movimentacoes .detalhe {
            color: var(--texto-secundario);
            font-size: 12px;
        }

        .vazio {
            color: var(--texto-desativado);
            font-size: 13px;
            padding: 10px 0;
            text-align: center;
        }

        /* ==========================================================================
           TELA DE CADASTRO / FORMULÁRIO (cadastrar_funcionario.php)
           ========================================================================== */

        .tela {
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .titulo {
            font-size: 26px;
            letter-spacing: 4px;
            color: var(--cor-primaria);
            text-shadow: 0 0 15px var(--cor-primaria-glow);
            text-align: center;
            font-weight: normal;
        }

        .subtitulo {
            font-size: 12px;
            color: var(--texto-secundario);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 4px;
            margin-bottom: 28px;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 32px 28px;
            backdrop-filter: blur(12px);
            box-shadow: var(--sombra-card), 0 0 30px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--cor-primaria), transparent);
        }

        .container h2 {
            font-size: 18px;
            color: #ffffff;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .container .descricao {
            font-size: 13px;
            color: var(--texto-secundario);
            margin-bottom: 24px;
            line-height: 1.4;
        }

        /* Mensagens PHP / Feedback */
        .mensagem {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.3s ease;
        }

        .mensagem.sucesso {
            background: rgba(62, 224, 138, 0.12);
            border: 1px solid rgba(62, 224, 138, 0.4);
            color: var(--cor-sucesso);
        }

        .mensagem.erro {
            background: rgba(226, 75, 74, 0.12);
            border: 1px solid rgba(226, 75, 74, 0.4);
            color: #f4a3a3;
        }

        /* Formulário & Campos */
        form label {
            display: block;
            font-size: 12px;
            color: var(--texto-secundario);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
            margin-top: 14px;
        }

        form label:first-of-type {
            margin-top: 0;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: var(--bg-input);
            color: #ffffff;
            font-size: 14px;
            outline: none;
            transition: var(--transicao-suave);
        }

        form input:focus {
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 3px var(--cor-primaria-glow);
            background: rgba(0, 0, 0, 0.6);
        }

        /* Campo Especial de Senha com Ícone de Olho */
        .campo-senha {
            position: relative;
            display: flex;
            align-items: center;
        }

        .campo-senha input {
            padding-right: 44px;
        }

        .botao-olho {
            position: absolute;
            right: 8px;
            background: transparent;
            border: none;
            color: var(--texto-secundario);
            padding: 8px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 6px;
            transition: var(--transicao-suave);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .botao-olho:hover {
            color: var(--cor-primaria);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Botoes Primários e Secundários */
        .botao-primario {
            width: 100%;
            padding: 13px;
            margin-top: 22px;
            border-radius: 8px;
            border: 1px solid var(--cor-primaria);
            background: rgba(29, 227, 216, 0.15);
            color: var(--cor-primaria);
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            transition: var(--transicao-suave);
            text-transform: uppercase;
            text-align: center;
            display: block;
        }

        .botao-primario:hover {
            background: var(--cor-primaria);
            color: #05070a;
            box-shadow: 0 0 20px var(--cor-primaria-glow);
            transform: translateY(-1px);
        }

        .botao-secundario {
            display: block;
            width: 100%;
            text-align: center;
            padding: 11px;
            margin-top: 12px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.02);
            color: var(--texto-secundario);
            font-size: 13px;
            transition: var(--transicao-suave);
        }

        .botao-secundario:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* ===== Animações ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== Responsividade Aprimorada ===== */
        @media (max-width: 900px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
            .conteudo { grid-template-columns: 1fr; }
            .scan-bar { flex-direction: column; align-items: stretch; }
            #form-scan { flex-direction: column; }
            .scan-bar .scan-label { min-width: 100%; }
        }

        @media (max-width: 560px) {
            .topbar { padding: 14px 18px; flex-direction: column; gap: 12px; align-items: flex-start; }
            .topbar .usuario { width: 100%; justify-content: space-between; }
            .painel { padding: 20px 16px 40px; }
            .stats { grid-template-columns: 1fr; }
            .container { padding: 24px 18px; }
            .demo-bar { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>
</head>
<body>

    <!-- Control Bar (Demonstrador do Sistema) -->
    <div class="demo-bar">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-code" style="color: var(--cor-primaria)"></i>
            <strong>Modo de Exibição Interativo:</strong>
        </div>
        <div class="demo-controls">
            <button class="btn-demo ativo" onclick="alternarTela('dashboard')">
                <i class="fa-solid fa-chart-line"></i> Dashboard / Painel
            </button>
            <button class="btn-demo" onclick="alternarTela('cadastro')">
                <i class="fa-solid fa-user-plus"></i> Cadastro de Funcionário
            </button>
        </div>
    </div>

    <!-- Topbar Padrão do Sistema -->
    <header class="topbar">
        <div class="marca">
            <i class="fa-solid fa-microchip"></i>
            <h1>RFID TOOLS</h1>
            <span>Sistema de Monitoramento</span>
        </div>
        <div class="usuario">
            <span>Operador: <strong>Carlos Eduardo</strong></span>
            <a href="#" class="botao-sair" title="Encerrar Sessão">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </a>
        </div>
    </header>

    <!-- ===================================================================
         TELA 1: DASHBOARD / PAINEL PRINCIPAL
         =================================================================== -->
    <main id="view-dashboard" class="painel">
        
        <!-- Leitor de RFID Principais -->
        <section class="scan-bar">
            <div class="scan-label">
                <strong><i class="fa-solid fa-wifi" style="color: var(--cor-primaria)"></i> Leitor RFID Ativo</strong>
                <small>Aproxime a tag ou digite</small>
            </div>
            <form id="form-scan" onsubmit="simularScan(event)">
                <input type="text" id="input-tag" placeholder="Aguardando leitura de tag..." autocomplete="off">
                <button type="submit">
                    <i class="fa-solid fa-bolt"></i> Processar Tag
                </button>
            </form>
        </section>

        <!-- Mensagem Feedback do Scan -->
        <div id="scan-feedback" class="sucesso"></div>

        <!-- Estatísticas Gerais -->
        <section class="stats">
            <div class="stat-card total">
                <div class="valor">142</div>
                <div class="rotulo">Total de Ferramentas</div>
            </div>
            <div class="stat-card disponivel">
                <div class="valor">98</div>
                <div class="rotulo">Disponíveis</div>
            </div>
            <div class="stat-card emprestada">
                <div class="valor">36</div>
                <div class="rotulo">Emprestadas</div>
            </div>
            <div class="stat-card manutencao">
                <div class="valor">8</div>
                <div class="rotulo">Em Manutenção</div>
            </div>
        </section>

        <!-- Grade de Conteúdo do Dashboard -->
        <div class="conteudo">
            
            <!-- Lista de Ferramentas Cadastradas -->
            <section class="painel-secao">
                <h2><i class="fa-solid fa-wrench" style="color: var(--cor-primaria)"></i> Inventário de Ferramentas</h2>
                <p class="subinfo">Status atual e tags RFID cadastradas no inventário</p>

                <table class="ferramentas">
                    <thead>
                        <tr>
                            <th>Ferramenta</th>
                            <th>Tag RFID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Furadeira de Impacto 750W</td>
                            <td class="tag">E200-001A-8842</td>
                            <td><span class="status-badge disponivel"><i class="fa-solid fa-circle-check"></i> Disponível</span></td>
                        </tr>
                        <tr>
                            <td>Multímetro Digital Pro</td>
                            <td class="tag">E200-001A-9912</td>
                            <td><span class="status-badge emprestada"><i class="fa-solid fa-clock"></i> Emprestada</span></td>
                        </tr>
                        <tr>
                            <td>Osciloscópio Portátil</td>
                            <td class="tag">E200-002F-1020</td>
                            <td><span class="status-badge manutencao"><i class="fa-solid fa-triangle-exclamation"></i> Manutenção</span></td>
                        </tr>
                        <tr>
                            <td>Kit Chaves de Precisão</td>
                            <td class="tag">E200-003B-4410</td>
                            <td><span class="status-badge disponivel"><i class="fa-solid fa-circle-check"></i> Disponível</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Histórico de Movimentações -->
            <section class="painel-secao">
                <h2><i class="fa-solid fa-list-check" style="color: var(--cor-primaria)"></i> Movimentações Recentes</h2>
                <p class="subinfo">Atividades de empréstimo e devolução</p>

                <ul class="feed-movimentacoes">
                    <li>
                        <div class="linha-topo">
                            <span>Multímetro Digital</span>
                            <span class="tipo-emprestimo">Empréstimo</span>
                        </div>
                        <div class="detalhe">
                            Retirado por <strong>João Silva</strong> &bull; Há 15 min
                        </div>
                    </li>
                    <li>
                        <div class="linha-topo">
                            <span>Alicate Amperímetro</span>
                            <span class="tipo-devolucao">Devolução</span>
                        </div>
                        <div class="detalhe">
                            Devolvido por <strong>Ana Paula</strong> &bull; Há 1 hora
                        </div>
                    </li>
                    <li>
                        <div class="linha-topo">
                            <span>Parafusadeira Bateria</span>
                            <span class="tipo-emprestimo">Empréstimo</span>
                        </div>
                        <div class="detalhe">
                            Retirado por <strong>Marcos Souza</strong> &bull; Há 3 horas
                        </div>
                    </li>
                </ul>
            </section>

        </div>
    </main>

    <!-- ===================================================================
         TELA 2: FORMULÁRIO DE CADASTRO DE FUNCIONÁRIO (cadastrar_funcionario.php)
         =================================================================== -->
    <div id="view-cadastro" class="tela" style="display: none;">

        <h1 class="titulo">RFID TOOLS</h1>
        <p class="subtitulo">Sistema de Monitoramento</p>

        <div class="container">
            <h2>Cadastrar Funcionário</h2>
            <p class="descricao">Crie um acesso para um novo funcionário usar o sistema</p>

            <!-- Exemplo de Mensagem Flash PHP -->
            <div id="mensagem-cadastro" class="mensagem sucesso">
                <i class="fa-solid fa-circle-check"></i> Pronta para cadastrar novos funcionários.
            </div>

            <form id="formulario_cadastro_funcionario" onsubmit="simularCadastro(event)">

                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Nome do funcionário" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="nome@empresa.com" autocomplete="username" required>

                <label for="matricula">Matrícula</label>
                <input type="text" id="matricula" name="matricula" placeholder="Ex: F001" required>

                <label for="departamento">Departamento</label>
                <input type="text" id="departamento" name="departamento" placeholder="Ex: Manutenção" required>

                <label for="tag_rfid">Tag RFID</label>
                <input type="text" id="tag_rfid" name="tag_rfid" placeholder="Código do crachá/tag" required>

                <label for="senha">Senha</label>
                <div class="campo-senha">
                    <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres" autocomplete="new-password" required minlength="6">
                    <button type="button" class="botao-olho" id="toggleSenhaCadastro" aria-label="Mostrar senha">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="botao-primario">Cadastrar funcionário</button>
            </form><br>

            <a href="#" onclick="alternarTela('dashboard')" class="botao-secundario">Voltar para o Painel</a>
        </div>
    </div>

    <!-- Scripts Funcionais para Interação da Tela -->
    <script>
        // Alternar visualização entre Dashboard e Cadastro de Funcionário
        function alternarTela(tela) {
            const dash = document.getElementById('view-dashboard');
            const cad = document.getElementById('view-cadastro');
            const btns = document.querySelectorAll('.btn-demo');

            if (tela === 'dashboard') {
                dash.style.display = 'block';
                cad.style.display = 'none';
                btns[0].classList.add('ativo');
                btns[1].classList.remove('ativo');
            } else {
                dash.style.display = 'flex';
                cad.style.display = 'none';
                btns[0].classList.remove('ativo');
                btns[1].classList.add('ativo');
            }
        }

        // Mostrar / Ocultar Senha
        const botaoOlhoCadastro = document.getElementById('toggleSenhaCadastro');
        const campoSenhaCadastro = document.getElementById('senha');
        
        if (botaoOlhoCadastro && campoSenhaCadastro) {
            botaoOlhoCadastro.addEventListener('click', () => {
                const visivel = campoSenhaCadastro.type === 'text';
                campoSenhaCadastro.type = visivel ? 'password' : 'text';
                
                // Atualizar ícone
                const icone = botaoOlhoCadastro.querySelector('i');
                if (icone) {
                    icone.className = visivel ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
                }
                
                botaoOlhoCadastro.setAttribute('aria-label', visivel ? 'Mostrar senha' : 'Ocultar senha');
            });
        }

        // Simulação de Scan RFID no Dashboard
        function simularScan(e) {
            e.preventDefault();
            const input = document.getElementById('input-tag');
            const feedback = document.getElementById('scan-feedback');
            
            if (input.value.trim() === '') {
                feedback.className = 'erro';
                feedback.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Erro: Por favor insira um código de Tag RFID válido.';
                return;
            }

            feedback.className = 'sucesso';
            feedback.innerHTML = `<i class="fa-solid fa-circle-check"></i> Tag <strong>${input.value}</strong> lida com sucesso! Registro processado.`;
            input.value = '';
        }

        // Simulação de Envio do Formulário de Cadastro
        function simularCadastro(e) {
            e.preventDefault();
            const msg = document.getElementById('mensagem-cadastro');
            msg.className = 'mensagem sucesso';
            msg.innerHTML = '<i class="fa-solid fa-circle-check"></i> Funcionário cadastrado com sucesso!';
            document.getElementById('formulario_cadastro_funcionario').reset();
        }
    </script>
</body>
</html>