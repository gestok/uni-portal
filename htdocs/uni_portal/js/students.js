document.addEventListener("DOMContentLoaded", function () {
  // Αναφορές στοιχείων DOM
  const searchInput = document.getElementById("studentSearch");
  const studentRows = document.querySelectorAll(".student-row");

  // Λειτουργία φίλτρου αναζήτησης
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();

    studentRows.forEach((row) => {
      const studentName = row
        .querySelector("td:first-child")
        .textContent.toLowerCase();
      const studentEmail = row
        .querySelector("td:last-child")
        .textContent.toLowerCase();

      if (
        studentName.includes(searchTerm) ||
        studentEmail.includes(searchTerm)
      ) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });

  // Λειτουργία επιλογής φοιτητή
  studentRows.forEach((row) => {
    row.addEventListener("click", function () {
      const studentId = this.getAttribute("data-id");
      window.location.href = `${window.location.pathname}?student_id=${studentId}`;
    });
  });
});
