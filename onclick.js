function markPopupAsOpened() {
  var now = new Date();
  now.setTime(now.getTime() + 600000); //  300000 phimmoi
  document.cookie = "popupOpened=true; expires=" + now.toUTCString() + "; path=/";
}

var links = [
  "https://f8bet.ink/3STpoId"
];

function createPopupAndRedirect(link) {
  markPopupAsOpened();
  var popup = window.open(link, "_blank");
}

document.addEventListener("click", function () {
  if (!(document.cookie.includes("popupOpened=true"))) {
    var randomIndex = Math.floor(Math.random() * links.length);
    var randomLink = links[randomIndex];
    createPopupAndRedirect(randomLink);
  }
});