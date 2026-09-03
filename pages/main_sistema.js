document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-scan');
    const input = document.getElementById('input-tag');
    const feedback = document.getElementById('scan-feedback');

    if (!form) return;

    // Mantém o foco no campo de leitura — pensado para leitor RFID físico,
    // que "digita" o código da tag e manda Enter sozinho.
    input.focus();
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#form-scan') && document.activeElement !== input) {
            input.focus();
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const tag = input.value.trim();
        if (!tag) return;

        feedback.textContent = 'Registrando...';
        feedback.className = '';

        try {
            const resposta = await fetch('../controller/registrar_movimentacao.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'tag_rfid=' + encodeURIComponent(tag),
            });

            const dados = await resposta.json();

            feedback.textContent = dados.mensagem;
            feedback.className = dados.ok ? 'sucesso' : 'erro';

            if (dados.ok) {
                atualizarLinhaFerramenta(dados.ferramenta_id, dados.novo_status);
                atualizarContadores();
                adicionarNaLista(dados);
            }
        } catch (erro) {
            feedback.textContent = 'Não foi possível conectar ao servidor.';
            feedback.className = 'erro';
        }

        input.value = '';
        input.focus();
    });

    function atualizarLinhaFerramenta(ferramentaId, novoStatus) {
        const linha = document.querySelector(`tr[data-ferramenta-id="${ferramentaId}"]`);
        if (!linha) return;

        const badge = linha.querySelector('.status-badge');
        badge.className = 'status-badge ' + novoStatus;
        badge.textContent = rotuloStatus(novoStatus);
    }

    function rotuloStatus(status) {
        return { disponivel: 'Disponível', emprestada: 'Emprestada', manutencao: 'Manutenção' }[status] || status;
    }

    function atualizarContadores() {
        const linhas = document.querySelectorAll('tr[data-ferramenta-id]');
        let disponivel = 0, emprestada = 0, manutencao = 0;

        linhas.forEach((linha) => {
            const status = linha.querySelector('.status-badge').classList[1];
            if (status === 'disponivel') disponivel++;
            if (status === 'emprestada') emprestada++;
            if (status === 'manutencao') manutencao++;
        });

        setValor('.stat-card.disponivel .valor', disponivel);
        setValor('.stat-card.emprestada .valor', emprestada);
        setValor('.stat-card.manutencao .valor', manutencao);
    }

    function setValor(seletor, valor) {
        const el = document.querySelector(seletor);
        if (el) el.textContent = valor;
    }

    function adicionarNaLista(dados) {
        const lista = document.getElementById('lista-movimentacoes');
        if (!lista) return;

        const vazio = lista.querySelector('.vazio');
        if (vazio) vazio.remove();

        const item = document.createElement('li');
        const classeTipo = dados.tipo === 'emprestimo' ? 'tipo-emprestimo' : 'tipo-devolucao';
        const rotuloTipo = dados.tipo === 'emprestimo' ? 'Retirou' : 'Devolveu';
        const agora = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

        item.innerHTML = `
            <div class="linha-topo">
                <span class="${classeTipo}">${rotuloTipo}</span>
                <span class="detalhe">${agora}</span>
            </div>
            <div class="detalhe">${dados.funcionario} · ${dados.ferramenta}</div>
        `;

        lista.prepend(item);
    }
});
