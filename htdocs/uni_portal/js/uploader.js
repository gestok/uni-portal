/**
 * Update uploaded filename
 */
const onFileChange = (event, text) => {
  const segments = event?.target?.value?.split("\\");
  const filename = segments?.[segments.length - 1];

  if (!filename) {
    return;
  }

  text.innerText = filename;
};

const onFileDragOver = (event) => {
  event.preventDefault();
  event.stopPropagation();
};

const onFileDrop = (event, input, text) => {
  event.preventDefault();
  event.stopPropagation();

  const files = event?.dataTransfer?.files;
  if (!files?.length) {
    return;
  }

  input.files = files;
  text.innerText = files?.[0]?.path || files?.[0]?.name;
};

onLessonChange = (event) => {
  window.location.href = `/uni_portal/uploader?lesson_id=${event?.target?.value}`;
};

onAssignmentChange = (event, lesson) => {
  window.location.href = `/uni_portal/uploader?lesson_id=${lesson}&assignment_id=${event?.target?.value}`;
};

document.addEventListener("DOMContentLoaded", () => {
  // Lesson select element
  const lessonSelect = document.getElementById("lessonSelect");
  let lessonId = lessonSelect?.value || null;

  if (lessonSelect) {
    lessonSelect.addEventListener("change", onLessonChange);
  }

  // Assignment select element
  const assignmentSelect = document.getElementById("assignmentSelect");

  if (assignmentSelect) {
    assignmentSelect.addEventListener("change", (event) =>
      onAssignmentChange(event, lessonId)
    );
  }

  // File upload element
  const wrapper = document.querySelector(".custom-file-upload");
  const input = wrapper.querySelector("input");
  const text = wrapper.querySelector(".uploaded-file");

  if (!input || !wrapper || !text) {
    return;
  }

  wrapper.addEventListener("dragover", (event) => onFileDragOver(event));
  wrapper.addEventListener("drop", (event) => onFileDrop(event, input, text));
  input.addEventListener("change", (event) => onFileChange(event, text));
});
