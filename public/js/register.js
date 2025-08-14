document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById('buttonLoader');

    const registerForm = document.querySelector('.register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function () {
            loader.classList.remove('hidden');
        });
    }

    const signinBtn = document.getElementById('signinBtn');
    if (signinBtn) {
        signinBtn.addEventListener('click', function (e) {
            e.preventDefault();
            loader.classList.remove('hidden');
            setTimeout(() => {
                window.location.href = signinBtn.href;
            }, 1000);
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('registerForm');
    const jabatanSelect = document.getElementById("level");
    const unitKerjaSelect = document.getElementById("kode_unit");

    function pilihKantorRegional() {
        for (const option of unitKerjaSelect.options) {
            if (option.text.trim().toLowerCase().includes("kantor regional")) {
                unitKerjaSelect.value = option.value; 
                return true;
            }
        }
        return false;
    }

    jabatanSelect.addEventListener("change", function () {
        const jabatan = this.value.toLowerCase();

        if (jabatan === "admin" || jabatan === "asisten") {
            if (pilihKantorRegional()) {
                unitKerjaSelect.disabled = true;
            }
        } else {
            unitKerjaSelect.disabled = false;
        }
    });

    unitKerjaSelect.addEventListener("change", function () {
        const txt = this.options[this.selectedIndex].text.trim().toLowerCase();
        if (txt.includes("kantor regional")) {
            jabatanSelect.value = "Admin";
        }
    });

    jabatanSelect.addEventListener("change", function () {
        const jabatan = this.value.toLowerCase();

        if (jabatan === "admin" || jabatan === "asisten") {
            if (pilihKantorRegional()) {
                unitKerjaSelect.disabled = true; 
            }
        } else {
            unitKerjaSelect.disabled = false; 
            unitKerjaSelect.selectedIndex = 0;
        }
    });

    form.addEventListener('submit', function () {
        if (unitKerjaSelect.disabled) {
            unitKerjaSelect.disabled = false;
        }
        document.getElementById('pageLoader').classList.remove('hidden');
    });
});

document.getElementById('backLink').addEventListener('click', function () {
    document.getElementById('pageLoader').classList.remove('hidden');
});