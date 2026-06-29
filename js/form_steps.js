document.addEventListener("DOMContentLoaded", () => {
  const step1 = document.querySelector(".form-jam-main");
  const step2 = document.querySelector(".form-data-diri");
  const step3 = document.querySelector(".form-pembayaran");
  const prevBtn = document.querySelector(".buttons .previous");
  const nextBtn = document.querySelector(".buttons .next");
  const form = document.querySelector("form");
  const nama = document.querySelector('input[name="nama"]');
  const email = document.querySelector('input[name="email"]');
  const phone = document.querySelector('input[name="phone"]');
  const metode = document.querySelectorAll("input[name='metode']");
  const modal_container = document.querySelector(".modal-container");
  const modal_buttons = document.querySelector(".modal-container .buttons");
  const btn_konfirmasi = document.querySelector("#btn-konfirmasi");
  const btn_batal = document.querySelector("#btn-batal");
  const qris = document.querySelector(".img-qris-code");
  const waktu = document.querySelector(".waktu");
  const btn_kembali = document.querySelector("#btn-konfirmasi-kembali");
  const modal_konfirmasi_container = document.querySelector(
    ".modal-konfirmasi-container",
  );

  let currentStep = 1;

  btn_kembali?.addEventListener("click", () => {
    modal_konfirmasi_container.classList.remove("active");
  });

  if (!nextBtn) return;

  function isStep2Valid() {
    if (!nama.value.trim()) return false;
    if (!email.value.includes("@") || !email.value.includes(".")) return false;
    const noHp = phone.value.replace(/\D/g, "");
    if (noHp.length < 10 || noHp.length > 13) return false;
    return true;
  }

  function updateButtons() {
    step1.style.display = currentStep === 1 ? "block" : "none";
    step2.style.display = currentStep === 2 ? "block" : "none";
    step3.style.display = currentStep === 3 ? "block" : "none";
    prevBtn.style.visibility = currentStep === 1 ? "hidden" : "visible";

    if (currentStep === 2) {
      nextBtn.disabled = !isStep2Valid();
      nextBtn.style.opacity = nextBtn.disabled ? "0.5" : "1";
    } else {
      nextBtn.disabled = false;
      nextBtn.style.opacity = "1";
    }
    nextBtn.textContent = currentStep === 3 ? "Bayar Sekarang" : "Selanjutnya";
    nextBtn.type = "button";
  }

  function countdownQris() {
    let waktu_bayar = 15 * 60;

    const countdown = setInterval(() => {
      const menit = Math.floor(waktu_bayar / 60);
      const detik = waktu_bayar % 60;
      waktu.textContent = `${String(menit).padStart(2, "0")}:${String(detik).padStart(2, "0")}`;
      if (waktu_bayar <= 0) {
        clearInterval(countdown);
        waktu.textContent = "00:00";
      }
      waktu_bayar--;
    }, 1000);
  }

  if (nama && email && phone) {
    nama.oninput = () => currentStep === 2 && updateButtons();
    email.oninput = () => currentStep === 2 && updateButtons();
    phone.oninput = () => currentStep === 2 && updateButtons();
  }

  nextBtn.addEventListener("click", () => {
    if (currentStep === 3) {
      const harga_per_jam = parseInt(
        document.getElementById("harga_per_jam").value,
      );
      const list_meja = [
        ...document.querySelectorAll("input[name='meja_ids[]']"),
      ];
      const list_durasi = [...document.querySelectorAll(".durasi-select")];
      const list_jam = [...document.querySelectorAll(".jam-select")];

      document.querySelector(".modal .nama").textContent = nama.value;
      document.querySelector(".modal .no-telp").textContent = phone.value;
      document.querySelector(".modal .nama-ps").textContent =
        document.querySelector(".ps-type").textContent;

      const metode_terpilih = [...metode].find((radio) => radio.checked).value;
      document.querySelector(".modal .metode").textContent =
        metode_terpilih === "CASH" ? "CASH (Bayar Ditempat)" : "QRIS";

      const meja_list = document.querySelector(".meja-durasi-list");
      meja_list.innerHTML = "";
      list_meja.forEach((input, index) => {
        const no_meja = input.value.split("-").pop();
        const jam_mulai = parseInt(list_jam[index].value);
        const jam_selesai = jam_mulai + parseInt(list_durasi[index].value);
        meja_list.innerHTML += `
        <div class="meja-durasi-detail">
          <span class="meja"><b>Meja. ${no_meja}</b></span>
          <span class="durasi">${list_durasi[index].value} Jam - ${String(jam_mulai).padStart(2, "0")}:00 s/d ${String(jam_selesai).padStart(2, "0")}:00</span>
        </div>`;
      });

      const total = list_durasi.reduce(
        (jumlah, select) => jumlah + parseInt(select.value) * harga_per_jam,
        0,
      );
      document.querySelector(".modal .total").textContent =
        "Rp. " + total.toLocaleString("id-ID");
      modal_container.classList.add("active");
    }

    if (currentStep < 3) currentStep++;
    updateButtons();
  });

  prevBtn.addEventListener("click", () => {
    if (currentStep > 1) currentStep--;
    updateButtons();
  });

  btn_konfirmasi.addEventListener("click", (e) => {
    e.preventDefault();
    const metode_terpilih = [...metode].find((radio) => radio.checked).value;

    if (metode_terpilih === "QRIS") {
      modal_buttons.style.display = "none";
      qris.style.display = "flex";
      countdownQris();
      setTimeout(() => form.submit(), 10000);
    } else {
      form.submit();
    }
  });

  btn_batal.addEventListener("click", (e) => {
    e.preventDefault();
    modal_container.classList.remove("active");
  });

  updateButtons();
});