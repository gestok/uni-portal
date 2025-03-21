// Add Footer Copyright
const addFooterCopyright = () => {
  const element = document.querySelector("footer .copyright");

  if (!element) {
    return;
  }

  const year = new Date().getFullYear();
  element.innerHTML = `© ${year} - Με επιφύλαξη παντός δικαιώματος`;
};

document.addEventListener("DOMContentLoaded", () => {
  addFooterCopyright();
});
