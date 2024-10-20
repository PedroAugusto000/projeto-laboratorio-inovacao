document.getElementById('nome_fantasia').addEventListener('change', function () {
    const nomeFantasiaInput = document.getElementById('nome_fantasia_input');
    nomeFantasiaInput.disabled = !this.checked;
});
