function openMenu() {
  document.getElementById("menu").style.left = "0px"; // Abre o menu
  document.getElementById("overlay").style.display = "block"; // Exibe o overlay
}

function closeMenu() {
  document.getElementById("menu").style.left = "-610px"; // Fecha o menu
  document.getElementById("overlay").style.display = "none"; // Esconde o overlay
}
