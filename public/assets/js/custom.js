(function() {
    if (window.addEventListener) {
        window.addEventListener("load", loaderFadeout, false);
      } else {
        window.attachEvent("onload", loaderFadeout);
      }
})();

function loaderFadeout() {
    setTimeout(function() {
        document.getElementById("preloader-wrap").style.opacity = 0;
        document.getElementById("preloader-wrap").style.display = 'none';
    }, 1000);
}
