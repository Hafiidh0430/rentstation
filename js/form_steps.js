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
 let currentStep = 1;
 
  function isStep2Valid() {
    if (!nama.value.trim()) return false;
    if (!email.value.includes("@") || !email.value.includes(".")) return false;
    let noHp = phone.value.replace(/\D/g, "");
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

    if (currentStep === 3) {
      nextBtn.textContent = "Bayar Sekarang";
      nextBtn.type = "button";
    } else {
      nextBtn.textContent = "Selanjutnya";
      nextBtn.type = "button";
    }
  }

  if (nama && email && phone) {
    nama.oninput = () => currentStep === 2 && updateButtons();
    email.oninput = () => currentStep === 2 && updateButtons();
    phone.oninput = () => currentStep === 2 && updateButtons();
  }

  nextBtn.onclick = () => {
    if (currentStep === 2 && !isStep2Valid()) {
      alert("Isi data diri dengan benar!");
      return;
    }

    if (currentStep === 3) {
      form.submit();
      return;
    }

    if (currentStep < 3) currentStep++;
    updateButtons();
  };

  prevBtn.onclick = () => {
    if (currentStep > 1) currentStep--;
    updateButtons();
  };

  form.onsubmit = (e) => {
    e.preventDefault();
    if (currentStep === 3) {
      nextBtn.onclick();
    }
  };
  updateButtons();
});