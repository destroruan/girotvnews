function loadHeader() {
    const header = document.getElementById('cabeca');
    
    fetch('view/assets/include/cabeca.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            header.innerHTML = data;
        })
        .catch(error => {
            console.error('Houve um problema com a solicitação Fetch:', error);
        });

    const login = document.getElementById('login');

    fetch('view/assets/include/login.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            login.innerHTML = data;
        })
        .catch(error => {
            console.error('Houve um problema com a solicitação Fetch:', error);
        });
}
function mostrarnopainel(arquivo) {
    const painel = document.getElementById('painel-do-usuario');
    const pasta = 'controller/'; // Define a pasta onde os arquivos estão

    // Limpa o conteúdo do painel antes de carregar o novo
    painel.innerHTML = 'Carregando...';
    
    // Faz uma requisição para o arquivo na pasta especificada
    fetch(pasta + arquivo)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar o conteúdo.');
            }
            return response.text(); // Obtém o texto do conteúdo
        })
        .then(data => {
            painel.innerHTML = data; // Insere o conteúdo no painel
        })
        .catch(error => {
            painel.innerHTML = 'Erro ao carregar o conteúdo: ' + error.message;
        });
}
loadHeader();