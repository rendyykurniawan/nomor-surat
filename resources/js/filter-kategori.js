document.addEventListener("DOMContentLoaded", function () {
    // Gunakan event delegation karena elemen mungkin dibuat dinamis
    document.addEventListener("change", function (e) {
        if (!e.target.matches('[id^="filter_kode"]')) return;

        const filterKode = e.target;
        const selectedKode = filterKode.value;

        // Cari dropdown kategori terdekat dalam container yang sama
        const container = filterKode.closest("[data-surat-item]");
        if (!container) return;

        const filterKategori = container.querySelector(
            '[id^="filter_kategori"]',
        );
        if (!filterKategori) return;

        const options = filterKategori.querySelectorAll("option");

        options.forEach((option) => {
            if (option.value === "") return;
            if (selectedKode === "" || option.dataset.kode === selectedKode) {
                option.style.display = "";
            } else {
                option.style.display = "none";
            }
        });

        filterKategori.value = "";
    });
});
