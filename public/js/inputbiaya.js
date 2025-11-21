document.addEventListener('DOMContentLoaded', function () {
    const pksSelect = document.getElementById('pks');

    if (pksSelect) {
        pksSelect.addEventListener('change', function () {
            const pks = this.value;
            if (pks) {
                const url = new URL(window.location.href);
                url.searchParams.set('pks', pks);
                window.location.href = url.toString();
            }
        });
    }
});