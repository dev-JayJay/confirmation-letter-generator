document.addEventListener("DOMContentLoaded", function () {
  const passportInput = document.getElementById("passport");
  const signatureInput = document.getElementById("signature");
  const passportPreview = document.getElementById("passportPreview");
  const signaturePreview = document.getElementById("signaturePreview");
  const saveContinueBtn = document.getElementById("saveContinueBtn");
  const backBtn = document.getElementById("backBtn");

  // === Preview passport ===
  passportInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        passportPreview.src = e.target.result;
        passportPreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
  });

  // === Preview signature ===
  signatureInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        signaturePreview.src = e.target.result;
        signaturePreview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
  });

  // === Save & Continue ===
  saveContinueBtn.addEventListener("click", function (e) {
    e.preventDefault();

    if (!passportInput.files.length || !signatureInput.files.length) {
      alert("⚠️ Please upload both passport and signature before continuing.");
      return;
    }

    // Save image data to localStorage for later confirmation display
    const reader1 = new FileReader();
    const reader2 = new FileReader();

    reader1.onload = function (e) {
      localStorage.setItem("passportImage", e.target.result);
    };
    reader2.onload = function (e) {
      localStorage.setItem("signatureImage", e.target.result);
    };

    reader1.readAsDataURL(passportInput.files[0]);
    reader2.readAsDataURL(signatureInput.files[0]);

    alert("✅ Uploads saved successfully!");
    window.location.href = "StudentAdmissionConfirmationPage5.html"; // Go to final confirmation page
  });

  // === Back Button ===
  backBtn.addEventListener("click", function (e) {
    e.preventDefault();
    window.location.href = "StudentAdmissionConfirmationPage3.html"; // Previous page
  });
});
