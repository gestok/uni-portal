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
  } else {
    selected.textContent = "Επιλέξτε μάθημα";
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
const increment = (lessons, index) => {
  if (index === undefined) {
    return;
  }

  if (index < lessons.length - 1) {
    return index + 1;
  }

  return lessons.length - 1;
};

const onFileChange = (event, preview) => {
  const file = event?.target?.files?.[0];
  if (!file) {
    return;
  }

  updatePreview(file, preview);
};

const onFileDragOver = (event) => {
  event.preventDefault();
  event.stopPropagation();
};

const onFileDrop = (event, input, preview) => {
  event.preventDefault();
  event.stopPropagation();

  input.files = event?.dataTransfer?.files || null;

  const file = event?.dataTransfer?.files?.[0];
  if (!file) {
    return;
  }

  updatePreview(file, preview);
};

const updatePreview = (file, preview) => {
  preview.innerHTML = "";
  const image = document.createElement("img");
  image.src = URL.createObjectURL(file);
  image.style.width = "100%";
  image.style.height = "100%";
  preview.appendChild(image);
};

document.addEventListener("DOMContentLoaded", () => {
  // Επιλογές μαθημάτων
  const lessons =
    Array.from(document.querySelectorAll("#lesson_id option"))?.slice(1) || [];

  // Αν δεν υπάρχουν μαθήματα, επιστρέφουμε
  if (lessons.length === 0) {
    selected.textContent = "Δεν υπάρχουν διαθέσιμα μαθήματα";
    select.disabled = true;
    return;
  }

  // Επιλεγμένο μάθημα
  const selected = document.querySelector(".selected");
  // Κουμπιά πλοήγησης
  const prevButton = document.querySelector(".prev");
  const nextButton = document.querySelector(".next");
  // Select στοιχείο
  const select = document.getElementById("lesson_id");
  // Upload wrapper στοιχείο
  const uploadWrapper = document.querySelector(".upload-wrapper");
  // File input στοιχείο
  const fileInput = uploadWrapper?.querySelector("#thumbnail");
  // Preview στοιχείο
  const preview = uploadWrapper?.querySelector(".preview");

  if (
    !selected ||
    !prevButton ||
    !nextButton ||
    !select ||
    !fileInput ||
    !uploadWrapper ||
    !preview
  ) {
    return;
  }

  // Αρχικοποίηση τρέχοντος δείκτη
  let index = -1;

  // Προσθήκη event listeners
  prevButton.addEventListener("click", () => {
    index = decrement(index);
    updateSelectedLesson(select, selected, lessons, index);
  });
  nextButton.addEventListener("click", () => {
    index = increment(lessons, index);
    updateSelectedLesson(select, selected, lessons, index);
  });
  fileInput.addEventListener("change", (event) => {
    onFileChange(event, preview);
  });
  uploadWrapper.addEventListener("dragover", (event) => {
    onFileDragOver(event);
  });
  uploadWrapper.addEventListener("drop", (event) => {
    onFileDrop(event, fileInput, preview);
  });

  // Κλήση της updateSelectedLesson για να εμφανιστεί το placeholder
  updateSelectedLesson(select, selected, lessons, index);
});
