document.addEventListener("DOMContentLoaded", function () {
  const tipoUsuario = document.body.dataset.tipoUsuario || "comum";
  const calendarEl = document.getElementById("calendar");

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    locale: "pt-br",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek",
    },
    events: {
      url: "carregaEventos.php", // ajustado para seu caminho
      failure: function () {
        alert("Erro ao carregar eventos!");
      },
    },

    eventClick: function (info) {
      const event = info.event;

      let html = `<strong>${
        event.title
      }</strong><br>${event.start.toLocaleString()}<br>${
        event.extendedProps.descricao || ""
      }`;

      if (tipoUsuario === "adm") {
        html += `<br><button onclick="excluirEvento(${event.id})">Excluir</button>`;
      }

      info.jsEvent.preventDefault(); // evita comportamento padrão

      // Pega os dados do evento
      const title = info.event.title;
      const description =
        info.event.extendedProps.description || "Sem descrição";
      const category =
        info.event.extendedProps.category || "Categoria não informada";
      const date = info.event.start; // objeto Date

      // Formata a data para dd/mm/yyyy
      const dataFormatada = date.toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });

      // Mapeia categoria para nome amigável (opcional)
      const categoriasMap = {
        fundamental1: "Ensino Fundamental I",
        fundamental2: "Ensino Fundamental II",
        medio: "Ensino Médio",
      };

      const categoriaNome = categoriasMap[category] || category;

      // Monta o conteúdo HTML para mostrar no SweetAlert
      const htmlContent = `
        <p><strong>Título:</strong> ${title}</p>
        <p><strong>Descrição:</strong> ${description}</p>
        <p><strong>Categoria:</strong> ${categoriaNome}</p>
        <p><strong>Data:</strong> ${dataFormatada}</p>
    `;

      // Exibe SweetAlert com as informações
      Swal.fire({
        title: "Detalhes do Evento",
        html: htmlContent,
        icon: "info",
        confirmButtonText: "Fechar",
        customClass: {
          popup: "swal2-custom-popup", // opcional para customização CSS
        },
      });
    },

    eventDisplay: "block", // Faz o evento usar cor de fundo
    eventDidMount: function (info) {
      // Remove borda

      console.log(tipoUsuario); // Verifica o tipo de usuário
      info.el.style.border = "none";

      // Remove horário, se existir
      const timeEl = info.el.querySelector(".fc-event-time");
      if (timeEl) {
        timeEl.remove();
      }

      if (tipoUsuario === "administrador") {
        const deleteBtn = document.createElement("span");
        deleteBtn.innerHTML = "✖";
        deleteBtn.style.float = "left";
        deleteBtn.style.marginRight = "5px";
        deleteBtn.style.color = "#fff";
        deleteBtn.style.cursor = "pointer";
        deleteBtn.style.fontWeight = "bold";
        deleteBtn.style.fontSize = "14px";
        deleteBtn.title = "Excluir evento";

        deleteBtn.addEventListener("click", function (e) {
          e.stopPropagation();
          if (confirm("Deseja excluir este evento?")) {
            fetch(`../adm/excluir_evento.php?id=${info.event.id}`, {
              method: "GET",
            })
              .then((response) => response.text())
              .then((data) => {
                if (data.trim() === "ok") {
                  info.event.remove();
                } else {
                  alert("Erro ao excluir evento: " + data);
                }
              })
              .catch((error) => {
                console.error("Erro:", error);
                alert("Erro ao excluir evento.");
              });
          }
        });

        const titleEl = info.el.querySelector(".fc-event-title");
        if (titleEl) {
          titleEl.prepend(deleteBtn);
        }
      }
    },

    eventColor: "", // evita cor padrão do FullCalendar
    eventTextColor: "#fff", // texto branco para contraste

    dateClick: function (info) {
      // Mostra o modal
      openForm();

      // Coloca a data clicada no input de data do formulário
      // info.dateStr vem no formato YYYY-MM-DD, que é aceito pelo input type=date
      document.getElementById("eventDate").value = info.dateStr;

      // Limpa os outros campos para novo evento
      document.getElementById("eventTitle").value = "";
      document.getElementById("eventDescription").value = "";
      document.getElementById("eventCategory").value = "fundamental1"; // valor padrão
    },
  });

  calendar.render();

  fetch("carregaEventos.php")
    .then((response) => response.json())
    .then((eventos) => {
      const divs = {
        fundamental1: document.querySelector(".activity-box .fundamental1")
          .nextElementSibling,
        fundamental2: document.querySelector(".activity-box .fundamental2")
          .nextElementSibling,
        medio: document.querySelector(".activity-box .medio")
          .nextElementSibling,
      };

      // Limpa textos padrões
      for (const key in divs) {
        divs[key].innerHTML = "";
      }

      if (eventos.length === 0) {
        for (const key in divs) {
          divs[key].innerHTML = "Não há nenhuma atividade para esse período";
        }
      } else {
        eventos.forEach((evento) => {
          const dataFormatada = formatarData(evento.start);
          const texto = `<span class="highlight">${dataFormatada} - ${evento.title}</span><br>`;
          if (divs[evento.category]) {
            divs[evento.category].innerHTML += texto;
          }
        });

        // Se algum grupo ainda estiver vazio, mostra a mensagem padrão
        for (const key in divs) {
          if (divs[key].innerHTML.trim() === "") {
            divs[key].innerHTML = "Não há nenhuma atividade para esse período";
          }
        }
      }

      function formatarData(dataStr) {
        const data = new Date(dataStr);
        const dia = String(data.getDate()).padStart(2, "0");
        const mes = String(data.getMonth() + 1).padStart(2, "0");
        return `${dia} / ${mes}`;
      }
    });

  window.addEventListener("addEventSuccess", () => {
    calendar.refetchEvents();
  });
});

function openForm() {
  document.getElementById("eventForm").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

function closeForm() {
  document.getElementById("eventForm").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function addEvent() {
  const title = document.getElementById("eventTitle").value;
  const description = document.getElementById("eventDescription").value;
  const category = document.getElementById("eventCategory").value;
  const date = document.getElementById("eventDate").value;

  if (!title || !description || !category || !date) {
    alert("Preencha todos os campos.");
    return;
  }

  const formData = new FormData();
  formData.append("title", title);
  formData.append("description", description);
  formData.append("category", category);
  formData.append("date", date);

  fetch("add_evento.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      if (data.trim() === "ok") {
        closeForm();
        window.dispatchEvent(new Event("addEventSuccess"));
      } else {
        alert("Erro ao adicionar evento: " + data);
      }
    })
    .catch((error) => {
      console.error("Erro:", error);
      alert("Erro ao enviar evento.");
    });
}
