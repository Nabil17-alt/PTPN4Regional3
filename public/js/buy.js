document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('input[placeholder="Cari Unit..."]');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        tableRows.forEach(row => {
            const unitText = row.querySelector('td')?.textContent.toLowerCase() || '';
            if (unitText.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});