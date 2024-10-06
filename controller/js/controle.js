const data = new Date();
const opcoes = { year: 'numeric', month: 'long', day: 'numeric' };
const dataFormatada = data.toLocaleDateString('pt-BR', opcoes);
document.getElementById('dataAtual').textContent = dataFormatada;
function mostrarProgramacao(dia) {
    const programacoes = document.querySelectorAll('.programacao');
    programacoes.forEach(p => p.classList.remove('active'));
    document.getElementById(dia).classList.add('active');
}