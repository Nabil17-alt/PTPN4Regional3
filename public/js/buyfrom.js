function updateColumn() {
    const rendemenCpoInput = document.getElementById('rendemen_cpo');
    const rendemenPkInput = document.getElementById('rendemen_pk');
    const hargaCpoInput = document.getElementById('hargaCPO');
    const hargaPkInput = document.getElementById('hargaPK');
    const totalRendemenInput = document.getElementById('total_rendemen');
    const biayaOlahInput = document.getElementById('biayaOlah');
    const pendapatanCpoInput = document.getElementById('pendapatanCPO');
    const pendapatanPkInput = document.getElementById('pendapatanPK');
    const totalPendapatanInput = document.getElementById('totalPendapatan');
    const biayaProduksiInput = document.getElementById('biayaProduksi');
    const biayaAngkutInput = document.getElementById('biayaAngkut');
    const totalBiayaInput = document.getElementById('totalBiaya');
    const hargaPenetapanInput = document.getElementById('hargaPenetapan');
    const hargaEskalasiInput = document.getElementById('hargaEskalasi');
    const marginInput = document.getElementById('margin');

    const rendemenCpoValue = parseFloat(rendemenCpoInput.value) || 0;
    const rendemenPkValue = parseFloat(rendemenPkInput.value) || 0;
    const biayaOlahValue = parseFloat(biayaOlahInput.value) || 0;
    const hargaCpoValue = parseFloat(hargaCpoInput.value) || 0;
    const hargaPkValue = parseFloat(hargaPkInput.value) || 0;
    const biayaAngkutValue = parseFloat(biayaAngkutInput.value) || 0;
    const hargaEskalasiValue = parseFloat(hargaEskalasiInput.value) || 0;

    const totalRendemen = rendemenCpoValue + rendemenPkValue;
    const pendapatanCpo = hargaCpoValue * (rendemenCpoValue / 100);
    const pendapatanPk = hargaPkValue * (rendemenPkValue / 100);
    const totalPendapatan = pendapatanCpo + pendapatanPk;
    const biayaProduksi = (biayaOlahValue / 100) * totalRendemen;
    const totalBiaya = biayaProduksi + biayaAngkutValue;
    const hargaPenetapan = totalPendapatan - totalBiaya;

    let margin = 0;
    if (hargaPenetapan !== 0) {
        margin = ((1 - (hargaEskalasiValue / hargaPenetapan)) * 100);
    }

    totalRendemenInput.value = totalRendemen.toFixed(2);
    pendapatanCpoInput.value = pendapatanCpo.toFixed(2);
    pendapatanPkInput.value = pendapatanPk.toFixed(2);
    totalPendapatanInput.value = totalPendapatan.toFixed(2);
    biayaProduksiInput.value = biayaProduksi.toFixed(2);
    biayaProduksiInput.readOnly = true;
    totalBiayaInput.value = totalBiaya.toFixed(2);
    if (hargaPenetapanInput) hargaPenetapanInput.value = hargaPenetapan.toFixed(2);
    if (marginInput) marginInput.value = margin.toFixed(2);
}

['rendemen_cpo', 'rendemen_pk', 'hargaCPO', 'hargaPK', 'biayaAngkut', 'hargaEskalasi'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', updateColumn);
});

document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('pageLoader');
    const addbuyForm = document.getElementById('addbuyForm');

    if (addbuyForm) {
        addbuyForm.addEventListener('submit', function () {
            updateColumn();
            loader.classList.remove('hidden');
        });
    }

});