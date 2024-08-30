function copyToClipboard(username) {
    const BASE_URL = "{{ config('app.url') }}";
    const url = `${BASE_URL}/list/favoritos/${username}`;
    navigator.clipboard.writeText(url)
        .then(() => {
            alert('URL copiada para a área de transferência!');
        })
        .catch(err => {
            console.error('Erro ao copiar para a área de transferência:', err);
        });
}

// function copyToClipboard(username) {
//     const url = `http://127.0.0.1:8000/list/favoritos/${username}`;

//     const tempInput = document.createElement('input');
//     tempInput.value = url;
//     document.body.appendChild(tempInput);
//     tempInput.select();
//     document.execCommand('copy');
//     document.body.removeChild(tempInput);
//     alert('URL copiada para a área de transferência!');
// }
