document.addEventListener("DOMContentLoaded", function () {
  // Seleciona os elementos do DOM
  const hamburgerBtn = document.getElementById("hamburger");
  const menuContainer = document.getElementById("menu");

  // Verifica se ambos os elementos existem para evitar erros
  if (hamburgerBtn && menuContainer) {
    hamburgerBtn.addEventListener("click", function () {
      // Alterna a classe 'is-open' no contêiner do menu.
      // A variável 'isOpen' guardará true se a classe foi adicionada, false se foi removida.
      const isOpen = menuContainer.classList.toggle("is-open");

      // Atualiza os atributos ARIA no botão para acessibilidade
      hamburgerBtn.setAttribute("aria-expanded", isOpen.toString()); // Converte boolean para string

      // Alterna o conteúdo (ícone) e o aria-label do botão
      if (isOpen) {
        hamburgerBtn.innerHTML = '×'; // Ícone "X" (fechar)
        hamburgerBtn.setAttribute('aria-label', 'Fechar menu');
        document.body.classList.add('menu-modal-open'); // Impede o scroll do body
      } else {
        hamburgerBtn.innerHTML = '☰'; // Ícone hambúrguer (abrir)
        hamburgerBtn.setAttribute('aria-label', 'Abrir menu');
        document.body.classList.remove('menu-modal-open'); // Permite o scroll do body
      }
    });

    // Opcional: Fechar o menu ao clicar em um dos seus links
    // Isso é útil para Single Page Applications (SPAs) ou se a navegação para uma nova página
    // não recarregar o estado do menu. Mesmo em páginas tradicionais, pode ser um bom UX.
    const menuLinks = menuContainer.querySelectorAll('a');
    menuLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        // Verifica se o menu está realmente aberto (caso o clique seja muito rápido ou outro evento ocorra)
        // e se o clique não foi em um link que abre em nova aba (target="_blank")
        // ou um link que executa alguma ação JS sem navegar (href="#", href="javascript:;")
        // Para simplificar, vamos fechar sempre que um link for clicado.
        // Se precisar de mais controle, adicione condições aqui.
        if (menuContainer.classList.contains("is-open")) {
          menuContainer.classList.remove("is-open");
          hamburgerBtn.innerHTML = '☰'; // Volta para o ícone hambúrguer
          hamburgerBtn.setAttribute('aria-expanded', 'false');
          hamburgerBtn.setAttribute('aria-label', 'Abrir menu');
          document.body.classList.remove('menu-modal-open');
        }
      });
    });

    // Opcional: Fechar o menu ao pressionar a tecla "Escape"
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && menuContainer.classList.contains('is-open')) {
            menuContainer.classList.remove('is-open');
            hamburgerBtn.innerHTML = '☰';
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            hamburgerBtn.setAttribute('aria-label', 'Abrir menu');
            document.body.classList.remove('menu-modal-open');
            hamburgerBtn.focus(); // Devolve o foco ao botão após fechar com ESC
        }
    });

  } else {
    // Loga um erro no console se os elementos não forem encontrados
    if (!hamburgerBtn) {
      console.error("Elemento do botão hambúrguer (ID: 'hamburger') não encontrado no DOM.");
    }
    if (!menuContainer) {
      console.error("Elemento do contêiner do menu (ID: 'menu') não encontrado no DOM.");
    }
  }
});