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
loadHeader();