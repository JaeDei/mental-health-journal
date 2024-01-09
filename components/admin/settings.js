function darkMode() {
  var element = document.body;
  let content = document.getElementById("DarkModetext");
  element.classList.add("dark-mode");
  content.innerText = "Dark Mode is ON";
  localStorage.setItem('darkMode', 'true');
}

function lightMode() {
  var element = document.body;
  let content = document.getElementById("DarkModetext");
  element.classList.remove("dark-mode");
  content.innerText = "Dark Mode is OFF";
  localStorage.setItem('darkMode', 'false');

}
const isDarkMode = localStorage.getItem('darkMode') === 'true';

if (isDarkMode) {
  applyDarkMode();
}

function toggleDarkMode() {
  const checkBox = document.getElementById('checkBox');
  if (checkBox.checked) {
    applyDarkMode();
  } else {
    applyLightMode();
  }
}

function applyDarkMode() {
  var element = document.body;
  element.classList.add("dark-mode");
  localStorage.setItem('darkMode', 'true');
}

function applyLightMode() {
  var element = document.body;
  element.classList.remove("dark-mode");
  localStorage.setItem('darkMode', 'false');
}
