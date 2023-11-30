let diaSelecionado = 1; // Começa com a segunda-feira (1)
let horaSelecionada = "";

const eventos = {
    1: {},
    2: {},
    3: {},
    4: {},
    5: {},
    6: {},
    0: {}
};

const nomesDiasSemana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

function mostrarDia(dia) {
    diaSelecionado = dia;
    limparAgenda();
    listarEventos();
    atualizarDataSemana();
}

function mostrarFormulario(hora) {
    const formulario = document.getElementById("formulario");
    formulario.style.display = "block";
    formulario.style.top = (event.clientY + 10) + "px";
    formulario.style.left = (event.clientX + 10) + "px";

    horaSelecionada = hora;

    document.getElementById("horario").value = horaSelecionada;
    document.getElementById("data").value = calcularDataAgendamento();
}

function agendarEvento() {
    const fk_id_func = document.getElementById("fk_id_func").value;
    const fk_id_serv = document.getElementById("fk_id_serv").value;
    const data = document.getElementById("data").value;
    const horario = horaSelecionada;

    // Use esses valores para inserir no banco de dados
    // ...

    listarEventos();
    document.getElementById("formulario").style.display = "none";
}

function limparAgenda() {
    const horarios = document.querySelectorAll(".horario .evento");
    horarios.forEach((horario) => {
        horario.innerHTML = "Clique para agendar";
    });
}

function listarEventos() {
    limparAgenda();
    const horarios = document.querySelectorAll(".horario");
    horarios.forEach((horario) => {
        const hora = horario.querySelector(".hora").textContent;
        const evento = eventos[diaSelecionado][hora];
        if (evento) {
            horario.querySelector(".evento").innerHTML = evento;
        }
    });
}

function atualizarDataSemana() {
    const hoje = new Date();
    const dataAtual = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate() + (diaSelecionado - hoje.getDay()));
    document.getElementById("nome-dia-semana").innerText = nomesDiasSemana[diaSelecionado];
    document.getElementById("data-semana").innerText = dataAtual.toLocaleDateString();
}

function calcularDataAgendamento() {
    const hoje = new Date();
    const dataAtual = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate() + (diaSelecionado - hoje.getDay()));
    return dataAtual.toISOString().slice(0, 10); // Formato "YYYY-MM-DD"
}

function anteriorDia() {
    if (diaSelecionado === 0) {
        mostrarDia(6); // Domingo
    } else {
        mostrarDia(diaSelecionado - 1);
    }
}


function proximoDia() {
    if (diaSelecionado === 6) {
        mostrarDia(0); // Segunda-feira
    } else {
        mostrarDia(diaSelecionado + 1);
    }
}

mostrarDia(new Date().getDay()); // Exibir o dia atual

