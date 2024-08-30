function copyToClipboard(username) {
    const BASE_URL = "http://127.0.0.1:8000";
    const url = `${BASE_URL}/list/favoritos/${username}`;
    navigator.clipboard.writeText(url)
        .then(() => {
            alert('URL de favoritos copiada para sua área de transferência!');
        })
        .catch(err => {
            console.error('Erro ao copiar para a área de transferência:', err);
        });
}

