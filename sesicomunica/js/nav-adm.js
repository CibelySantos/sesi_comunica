function openMenu() {
  document.getElementById("menu").style.right = "0"; // Abre o menu deslizando para a direita
  document.getElementById("overlay").style.display = "block"; // Exibe o overlay
}

function closeMenu() {
  const menuWidth = "300px"; // Largura do seu menu
  document.getElementById("menu").style.right = `-${menuWidth}`; // Fecha o menu (empurra para fora da tela à esquerda)
  document.getElementById("overlay").style.display = "none"; // Esconde o overlay
}

function toggleMenu() {
  const menu = document.getElementById("menu");
  menu.classList.toggle("active");
}
