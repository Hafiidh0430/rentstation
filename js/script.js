document.addEventListener("DOMContentLoaded", () => {
  const meja_checkbox = document.querySelectorAll(".meja-check");
  const tombol_lanjut = document.getElementById("btnLanjut");
  const jumlah_terpilih = document.getElementById("jumlah-terpilih");
  const harga_per_jam = parseInt(
    document.getElementById("harga_per_jam")?.value || 0,
  );
  const label_total = document.getElementById("display-total");

  const updateTotalHarga = () => {
    if (!label_total) return;
    const total = [...document.querySelectorAll(".durasi-select")].reduce(
      (akumulasi, select) => akumulasi + parseInt(select.value) * harga_per_jam,
      0,
    );
    label_total.innerHTML = "Rp " + total.toLocaleString("id-ID");
  };

  meja_checkbox.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      const terpilih = [...meja_checkbox].filter(
        (check) => check.checked && !check.disabled,
      );
      tombol_lanjut.disabled = terpilih.length === 0;
      jumlah_terpilih.textContent = terpilih.length;
    });
  });

  document.querySelectorAll(".meja-durasi").forEach((elemen_meja) => {
    const jam_yang_diblokir = elemen_meja.dataset.jam_blokir
      ? elemen_meja.dataset.jam_blokir.split(",").map(Number)
      : [];

    const pilihan_durasi = elemen_meja.querySelector(".durasi-select");
    const pilihan_jam = elemen_meja.querySelector(".jam-select");
    const label_selesai = elemen_meja.querySelector(".time-end");

    const updateWaktuSelesai = () => {
      const jam_selesai =
        parseInt(pilihan_jam.value) + parseInt(pilihan_durasi.value);
      label_selesai.textContent = `${String(jam_selesai).padStart(2, "0")}:00`;
    };

    const updateOpsiJam = () => {
      const durasi = parseInt(pilihan_durasi.value);

      pilihan_jam.querySelectorAll("option").forEach((opsi) => {
        const jam_mulai = parseInt(opsi.value);
        const jam_selesai = jam_mulai + durasi;
        const melebihi_operasional = jam_selesai > 22;
        const bentrok =
          !melebihi_operasional &&
          jam_yang_diblokir.some(
            (jam_blocked) =>
              jam_blocked >= jam_mulai && jam_blocked < jam_selesai,
          );

        opsi.disabled = melebihi_operasional || bentrok;
        opsi.innerHTML = melebihi_operasional
          ? `${opsi.value}:00 - Melebihi jam operasional`
          : bentrok
            ? `${opsi.value}:00 - Sudah dibooking`
            : `${opsi.value}:00`;
      });

      const opsi_terpilih = pilihan_jam[pilihan_jam.selectedIndex];
      if (opsi_terpilih?.disabled) {
        const jam_tersedia = [...pilihan_jam].find((opsi) => !opsi.disabled);
        if (jam_tersedia) pilihan_jam.value = jam_tersedia.value;
      }
      updateWaktuSelesai();
    };

    pilihan_durasi.addEventListener("change", updateOpsiJam);
    pilihan_jam.addEventListener("change", updateWaktuSelesai);
    updateOpsiJam();
  });

  document
    .querySelectorAll(".durasi-select")
    .forEach((select) => select.addEventListener("change", updateTotalHarga));

  updateTotalHarga();
});
