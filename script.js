document.addEventListener("DOMContentLoaded", function () {
  // LOGIKA DETAIL.PHP
  const mejaChecks = document.querySelectorAll(".meja-check");
  const btnLanjut = document.getElementById("btnLanjut");

  if (mejaChecks.length > 0) {
    mejaChecks.forEach((check) => {
      check.addEventListener("change", () => {
        const checkedAny = Array.from(mejaChecks).some((c) => c.checked);
        btnLanjut.disabled = !checkedAny;
      });
    });
  }

  // LOGIKA PAYMENT.PHP
  const durasiSelects = document.querySelectorAll(".durasi-select");
  const timeStarts = document.querySelectorAll(".time-start");
  const hargaPerJam = document.getElementById("harga_per_jam")?.value || 0;
  const displayTotal = document.getElementById("display-total");

  function calculateEverything() {
    let total = 0;

    durasiSelects.forEach((select, index) => {
      const durasi = parseInt(select.value);
      const startTime = timeStarts[index].value;

      // Hitung Subtotal
      total += durasi * hargaPerJam;

      // Hitung Jam Selesai
      if (startTime) {
        const [hours, minutes] = startTime.split(":");
        let endHours = parseInt(hours) + durasi;
        if (endHours >= 24) endHours -= 24;
        const formattedEnd =
          (endHours < 10 ? "0" : "") + endHours + ":" + minutes;
        document.querySelectorAll(".time-end")[index].innerText = formattedEnd;
      }
    });

    if (displayTotal) {
      displayTotal.innerText = "Rp " + total.toLocaleString("id-ID");
    }
  }

  if (durasiSelects.length > 0) {
    durasiSelects.forEach((s) =>
      s.addEventListener("change", calculateEverything),
    );
    timeStarts.forEach((t) =>
      t.addEventListener("change", calculateEverything),
    );
    calculateEverything(); // Inisialisasi awal
  }
});
