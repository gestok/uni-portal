/**
 * Ενημερώνει το επιλεγμένο μάθημα και το select στοιχείο με βάση τον τρέχοντα δείκτη.
 *
 * @param select Τo select στοιχείο
 * @param selected Το στοιχείο που θα εμφανίζει το επιλεγμένο μάθημα
 * @param lessons Τα διαθέσιμα μαθήματα
 * @param index Ο τρέχων δείκτης του επιλεγμένου μαθήματος
 */
const updateSelectedLesson = (select, selected, lessons, index) => {
  if (!select || !selected || !lessons || index === undefined) {
    return;
  }

  if (index >= 0 && index < lessons.length) {
    selected.textContent = lessons[index].textContent;
    select.value = lessons[index].value;

    // Ανακατεύθυνση σε νέο URL με το επιλεγμένο μάθημα
    if (select.value) {
      window.location.href = `${window.location.pathname}?lesson_id=${select.value}`;
    }
  } else {
    selected.textContent = "Επιλέξτε μάθημα";
    select.value = "";
  }
};

/**
 * Ενημερώνει την επιλεγμένη εργασία και το select στοιχείο με βάση τον τρέχοντα δείκτη.
 *
 * @param select Τo select στοιχείο
 * @param selected Το στοιχείο που θα εμφανίζει την επιλεγμένη εργασία
 * @param assignments Οι διαθέσιμες εργασίες
 * @param index Ο τρέχων δείκτης της επιλεγμένης εργασίας
 * @param lessonId Το ID του επιλεγμένου μαθήματος
 */
const updateSelectedAssignment = (
  select,
  selected,
  assignments,
  index,
  lessonId
) => {
  if (!select || !selected || !assignments || index === undefined) {
    return;
  }

  if (index >= 0 && index < assignments.length) {
    selected.textContent = assignments[index].textContent;
    select.value = assignments[index].value;

    // Ανακατεύθυνση σε νέο URL με το επιλεγμένο μάθημα και την επιλεγμένη εργασία
    if (select.value) {
      window.location.href = `${window.location.pathname}?lesson_id=${lessonId}&assignment_id=${select.value}`;
    }
  } else {
    selected.textContent = "Επιλέξτε εργασία";
    select.value = "";
  }
};

/**
 * Μειώνει τον τρέχοντα δείκτη.
 */
const decrement = (index) => {
  if (index === undefined) {
    return;
  }

  if (index > 0) {
    return index - 1;
  }

  return 0;
};

/**
 * Αυξάνει τον τρέχοντα δείκτη.
 */
const increment = (items, index) => {
  if (index === undefined) {
    return;
  }

  if (index < items.length - 1) {
    return index + 1;
  }

  return items.length - 1;
};

document.addEventListener("DOMContentLoaded", () => {
  // Μάθημα
  const lessonItems =
    Array.from(document.querySelectorAll("#lesson_id option"))?.slice(1) || [];
  const lessonSelected = document.querySelector(
    ".selected:not(.assignment-selected)"
  );
  const lessonPrevButton = document.querySelector(
    ".prev:not(.assignment-prev)"
  );
  const lessonNextButton = document.querySelector(
    ".next:not(.assignment-next)"
  );
  const lessonSelect = document.getElementById("lesson_id");

  // Αρχικοποίηση δείκτη μαθήματος
  let lessonIndex = -1;
  // Εύρεση τρέχοντος επιλεγμένου μαθήματος
  if (lessonSelect && lessonSelect.value) {
    lessonIndex = lessonItems.findIndex(
      (item) => item.value === lessonSelect.value
    );
  }

  // Προσθήκη event listeners για τα μαθήματα
  if (lessonPrevButton && lessonNextButton && lessonSelect && lessonSelected) {
    lessonPrevButton.addEventListener("click", () => {
      lessonIndex = decrement(lessonIndex);
      updateSelectedLesson(
        lessonSelect,
        lessonSelected,
        lessonItems,
        lessonIndex
      );
    });

    lessonNextButton.addEventListener("click", () => {
      lessonIndex = increment(lessonItems, lessonIndex);
      updateSelectedLesson(
        lessonSelect,
        lessonSelected,
        lessonItems,
        lessonIndex
      );
    });
  }

  // Εργασία
  const assignmentItems =
    Array.from(document.querySelectorAll("#assignment_id option"))?.slice(1) ||
    [];
  const assignmentSelected = document.querySelector(".assignment-selected");
  const assignmentPrevButton = document.querySelector(".assignment-prev");
  const assignmentNextButton = document.querySelector(".assignment-next");
  const assignmentSelect = document.getElementById("assignment_id");

  // Αρχικοποίηση δείκτη εργασίας
  let assignmentIndex = -1;
  // Εύρεση τρέχουσας επιλεγμένης εργασίας
  if (assignmentSelect && assignmentSelect.value) {
    assignmentIndex = assignmentItems.findIndex(
      (item) => item.value === assignmentSelect.value
    );
  }

  // Προσθήκη event listeners για τις εργασίες
  if (
    assignmentPrevButton &&
    assignmentNextButton &&
    assignmentSelect &&
    assignmentSelected
  ) {
    assignmentPrevButton.addEventListener("click", () => {
      assignmentIndex = decrement(assignmentIndex);
      updateSelectedAssignment(
        assignmentSelect,
        assignmentSelected,
        assignmentItems,
        assignmentIndex,
        lessonSelect.value
      );
    });

    assignmentNextButton.addEventListener("click", () => {
      assignmentIndex = increment(assignmentItems, assignmentIndex);
      updateSelectedAssignment(
        assignmentSelect,
        assignmentSelected,
        assignmentItems,
        assignmentIndex,
        lessonSelect.value
      );
    });
  }
});
