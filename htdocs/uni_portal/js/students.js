document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("studentSearch");
  const studentRows = document.querySelectorAll(".student-row");

  if (!searchInput || !studentRows) {
    return;
  }

  addRowFiltering(studentRows, searchInput);
  addClickableRows(studentRows);
});

/**
 * Προσθέτει λειτουργία φιλτραρίσματος στις γραμμές με βάση την αναζήτηση.
 */
const addRowFiltering = (rows, searchInput) => {
  if (!rows?.length || !searchInput) {
    return;
  }

  searchInput.addEventListener("input", () => {
    const searchTerm = searchInput.value?.toLowerCase();

    rows.forEach((row) => {
      const studentName = row
        .querySelector("td:first-child")
        ?.textContent?.toLowerCase();
      const studentEmail = row
        .querySelector("td:last-child")
        ?.textContent?.toLowerCase();

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
};

/**
 * Προσθέτει λειτουργία κλικ στις γραμμές για να μεταφέρει τον χρήστη στη σελίδα του φοιτητή.
 */
const addClickableRows = (rows) => {
  if (!rows?.length) {
    return;
  }

  rows.forEach((row) => {
    row.addEventListener("click", () => {
      const studentId = row.getAttribute("data-id");
      window.location.href = `${window.location.pathname}?student_id=${studentId}`;
    });
  });
};
