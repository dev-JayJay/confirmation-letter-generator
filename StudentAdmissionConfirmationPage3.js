document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("educationForm");
  const formMessage = document.getElementById("formMessage");
  const backBtn = document.getElementById("backBtn");

  function markError(el, on = true) {
    if (!el) return;
    if (on) el.classList.add("error");
    else el.classList.remove("error");
  }

  function validateSubjects() {
    let ok = true;
    for (let i = 1; i <= 8; i++) {
      const subj = document.getElementById("subject" + i);
      const grade = document.getElementById("grade" + i);
      const hasSubj = subj && subj.value.trim() !== "";
      const hasGrade = grade && grade.value.trim() !== "";

      if (!hasSubj || !hasGrade) {
        ok = false;
        markError(subj, !hasSubj);
        markError(grade, !hasGrade);
      } else {
        markError(subj, false);
        markError(grade, false);
      }
    }
    const s9 = document.getElementById("subject9");
    const g9 = document.getElementById("grade9");
    if (s9 && g9) {
      const oneFilled = s9.value.trim() !== "" || g9.value.trim() !== "";
      if (oneFilled && (s9.value.trim() === "" || g9.value.trim() === "")) {
        ok = false;
        markError(s9, s9.value.trim() === "");
        markError(g9, g9.value.trim() === "");
      } else {
        markError(s9, false);
        markError(g9, false);
      }
    }
    return ok;
  }

  function validateFiles() {
    const fileIds = ["birthCert","primaryCert","olevelOriginal","jambLetter","jambResult","indigeneCert"];
    let ok = true;
    fileIds.forEach(id => {
      const el = document.getElementById(id);
      if (!el || !el.files || el.files.length === 0) {
        ok = false;
        markError(el, true);
      } else {
        const file = el.files[0];
        if (file.size > 6 * 1024 * 1024) {
          ok = false;
          markError(el, true);
        } else {
          markError(el, false);
        }
      }
    });
    return ok;
  }

  function validateYears() {
    let ok = true;
    const py = document.getElementById("primaryYear");
    const sy = document.getElementById("secondaryYear");
    [py, sy].forEach(el => {
      if (!el) return;
      const v = el.value.trim();
      const num = Number(v);
      if (!v || isNaN(num) || num < 1900 || num > (new Date().getFullYear() + 1)) {
        markError(el, true);
        ok = false;
      } else {
        markError(el, false);
      }
    });
    return ok;
  }

  function validateRequiredTexts() {
    const requiredIds = ["primarySchool","secondarySchool","olevelType"];
    let ok = true;
    requiredIds.forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      if ((el.tagName === "INPUT" || el.tagName === "SELECT") && el.value.trim() === "") {
        markError(el, true);
        ok = false;
      } else {
        markError(el, false);
      }
    });
    return ok;
  }

  form.querySelectorAll("input, select").forEach(el => {
    el.addEventListener("input", function () { markError(el, false); });
    el.addEventListener("change", function () { markError(el, false); });
  });

  backBtn.addEventListener("click", function (e) {
    e.preventDefault();
    window.location.href = "StudentAdmissionConfirmationPage2.html";
  });

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    formMessage.textContent = "";
    formMessage.style.color = "#333";

    const okSubjects = validateSubjects();
    const okFiles = validateFiles();
    const okYears = validateYears();
    const okRequired = validateRequiredTexts();

    if (!okRequired) {
      formMessage.textContent = "Please fill all required fields.";
      formMessage.style.color = "#d9534f";
      return;
    }
    if (!okYears) {
      formMessage.textContent = "Please provide valid years for the schools.";
      formMessage.style.color = "#d9534f";
      return;
    }
    if (!okSubjects) {
      formMessage.textContent = "Please fill in the first 8 subject & grade pairs (9th optional).";
      formMessage.style.color = "#d9534f";
      return;
    }
    if (!okFiles) {
      formMessage.textContent = "Please upload all required documents (ensure file size ≤ 6MB).";
      formMessage.style.color = "#d9534f";
      return;
    }

    // ✅ Save all education-related details to localStorage
    localStorage.setItem("primarySchool", document.getElementById("primarySchool").value);
    localStorage.setItem("primaryYear", document.getElementById("primaryYear").value);
    localStorage.setItem("secondarySchool", document.getElementById("secondarySchool").value);
    localStorage.setItem("secondaryYear", document.getElementById("secondaryYear").value);
    localStorage.setItem("olevelExam", document.getElementById("olevelType").value);

    // Save subjects and grades (1–9)
    for (let i = 1; i <= 9; i++) {
      const subjEl = document.getElementById("subject" + i);
      const gradeEl = document.getElementById("grade" + i);
      if (subjEl) localStorage.setItem("subject" + i, subjEl.value);
      if (gradeEl) localStorage.setItem("grade" + i, gradeEl.value);
    }

    // Optional flag
    localStorage.setItem("educationSaved", "true");

    formMessage.textContent = "✅ Education details and documents saved successfully. Redirecting...";
    formMessage.style.color = "#2a7a2a";

    setTimeout(function () {
      window.location.href = "StudentAdmissionConfirmationPage4.html";
    }, 1000);
  });
});
