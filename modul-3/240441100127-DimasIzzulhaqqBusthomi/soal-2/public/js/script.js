function openPop(event) {
  event.preventDefault();
  document.querySelector(".hidden").style.display = "block";
}

function closePop() {
  document.querySelector(".hidden").style.display = "none";
}
