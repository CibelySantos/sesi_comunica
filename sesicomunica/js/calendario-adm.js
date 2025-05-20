document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale: "pt-br",
        selectable: true,
        dateClick: function (info) {
            document.getElementById("eventDate").value = info.dateStr;
            openForm();
        },
        events: "carregaEventos.php",
        eventClick: function (info) {
            const evento = info.event;
            alert(
                "Título: " +
                    evento.title +
                    "\n" +
                    "Descrição: " +
                    (evento.extendedProps.description || "Sem descrição") +
                    "\n" +
                    "Categoria: " +
                    (evento.extendedProps.category || "Não informada") +
                    "\n" +
                    "Data: " +
                    evento.start.toLocaleDateString("pt-BR"),
            );
        },
    });
    calendar.render();

    fetch("carregaEventos.php")
        .then((response) => response.json())
        .then((eventos) => {
            const divs = {
                fundamental1: document.querySelector(".activity-box .fundamental1").nextElementSibling,
                fundamental2: document.querySelector(".activity-box .fundamental2").nextElementSibling,
                medio: document.querySelector(".activity-box .medio").nextElementSibling,
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
}

function closeForm() {
    document.getElementById("eventForm").style.display = "none";
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
