// Course toggle functionality
const enableToggling = () => {
  const courses = document.querySelectorAll(".courses .course");

  if (!courses.length) {
    return;
  }

  courses.forEach((course) => {
    const topBar = course.querySelector(".top-bar");
    const content = course.querySelector(".content");

    if (topBar && content) {
      topBar.addEventListener("click", () => {
        // Toggle class
        topBar.classList.toggle("active");

        // Adjust height
        const maxHeight = content.scrollHeight;
        if (content.classList.contains("expanded")) {
          content.style.maxHeight = "0px";
          content.classList.remove("expanded");
        } else {
          content.style.maxHeight = `${maxHeight}px`;
          content.classList.add("expanded");
        }

        // Adjust icon
        const icon = topBar.querySelector(".icon i");
        if (!icon) {
          return;
        }

        if (icon.classList.contains("fa-plus")) {
          icon.classList.remove("fa-plus");
          icon.classList.add("fa-minus");
        } else {
          icon.classList.remove("fa-minus");
          icon.classList.add("fa-plus");
        }
      });
    }
  });
};

document.addEventListener("DOMContentLoaded", function () {
  enableToggling();
});
