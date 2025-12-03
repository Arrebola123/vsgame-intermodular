const modal_inicio = document.getElementById("login-modal")
const email_inicio = document.getElementById("player-email")
const contra_inicio = document.getElementById("player-passwd")
const btn_inicio = document.getElementById("login-btn")
const btn_modal_registro = document.getElementById("register-modal-btn")

const modal_registro = document.getElementById("register-modal")
const nombre_registro = document.getElementById("player-name-register")
const email_registro = document.getElementById("player-email-register")
const contra_registro = document.getElementById("player-passwd-register")
const btn_registro = document.getElementById("register-btn")
const btn_modal_login = document.getElementById("login-modal-btn")

const mensajeLogin = document.getElementById("login-msg")
const mensajeRegistro = document.getElementById("register-msg")

const closePopupBtn = document.getElementById("closePopupBtn")
const popup = document.getElementById("popup")
const tituloPopup = popup.querySelector("h2")
const textoPopup = popup.querySelector(".popup-text")
const botonReiniciar = document.getElementById("restartGame")

const contadorRondas = document.querySelector(".ronda")
const puntuacionJ1 = document.querySelector(".puntuacionJ1")
const puntuacionJ2 = document.querySelector(".puntuacionJ2")

const cartaJugador = document.getElementById("playerCard")
const cartaJuego = document.getElementById("gameCard")
const botonAtacar = document.getElementById("atacar")
const botonDefender = document.getElementById("defender")

const contenedorBandera = document.getElementById("bandera")
const bandera = contenedorBandera.firstElementChild

const gameState = {
    id: 0,
    nombre: null,
    usuario_id: null,
    rondas: 0,
    wins: 0,
    loses: 0,
    isGameOver: false,
}
let rondasJugadas = 1

async function login() {
    const email = email_inicio.value
    const password = contra_inicio.value
    let mensaje = null
    let usuario = null

    if (validarEmail(email) && validarPassword(password)) {
        const inicio_sesion = {
            email: email,
            password: password,
        }

        try {
            const response = await fetch("api/login.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(inicio_sesion),
            })

            const datos = await response.json()

            if (datos.status === "success") {
                usuario = {
                    email: datos.email,
                    usuario_id: datos.usuario_id,
                    nombre: datos.nombre,
                }
                mensaje = datos.mensaje
                mensajeLogin.className = "modal-msg-success"
                mensajeLogin.textContent = mensaje
                setTimeout(() => {
                    modal_inicio.style.display = "none"
                }, 1200)
            } else {
                mensaje = datos.mensaje
                mensajeLogin.className = "modal-msg-error"
                mensajeLogin.textContent = mensaje
                console.error(mensaje)
            }
        } catch (error) {
            console.error("Error en la petición:", error)
            mensajeLogin.className = "modal-msg-error"
            mensajeLogin.textContent = "Error de conexión con el servidor"
        }
    } else {
        mensaje = "El email o la contraseña no cumplen los requerimientos."
        mensajeLogin.className = "modal-msg-error"
        mensajeLogin.textContent = mensaje
        console.error(mensaje)
    }

    return usuario
}

async function registro() {
    const nombre = nombre_registro.value.trim()
    const email = email_registro.value.trim()
    const password = contra_registro.value.trim()

    if (!nombre || !email || !password) {
        mensajeRegistro.className = "modal-msg-error"
        mensajeRegistro.textContent = "Todos los campos son obligatorios"
        return
    }

    if (!validarEmail(email)) {
        mensajeRegistro.className = "modal-msg-error"
        mensajeRegistro.textContent = "Email inválido"
        return
    }

    if (!validarPassword(password)) {
        mensajeRegistro.className = "modal-msg-error"
        mensajeRegistro.textContent = "La contraseña debe tener al menos 6 caracteres, 1 mayúscula y 1 número"
        return
    }

    try {
        const response = await fetch("api/registro.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                usuario: nombre,
                email: email,
                password: password,
            }),
        })

        const datos = await response.json()

        if (response.ok) {
            mensajeRegistro.className = "modal-msg-success"
            mensajeRegistro.textContent = datos.mensaje

            nombre_registro.value = ""
            email_registro.value = ""
            contra_registro.value = ""

            setTimeout(() => {
                modal_registro.style.display = "none"
                modal_inicio.style.display = "flex"
            }, 1200)
        } else {
            mensajeRegistro.className = "modal-msg-error"
            mensajeRegistro.textContent = datos.mensaje
        }
    } catch (error) {
        console.error("Error en la petición:", error)
        mensajeRegistro.className = "modal-msg-error"
        mensajeRegistro.textContent = "Error de conexión con el servidor"
    }
}

async function start_game(usuario) {
    if (!usuario) {
        console.error("Usuario no válido")
        return
    }

    try {
        const response = await fetch("api/iniciar_juego.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ usuario_id: usuario.usuario_id }),
        })

        const datos = await response.json()

        if (datos && datos.length > 0) {
            gameState.id = usuario.usuario_id
            gameState.nombre = usuario.nombre
            gameState.usuario_id = usuario.usuario_id
            gameState.wins = 0
            gameState.loses = 0
            gameState.rondas = 5
        }
    } catch (error) {
        console.error("Error en la petición:", error)
    }

    handle_next_round("start")
}

async function handle_next_round(action) {
    const carta1 = {} //carta usuario
    const carta2 = {} //de carta juego
    try {
        //Primera ronda obtencion de cartas
        if (action == "start") {
            const response = await fetch("api/cartas_aleatorias.php")
            const data = await response.json()

            //asignacion de variables para los 2 objetos a partir de la respuesta
            carta1.ataque = data.ataque1
            carta1.defensa = data.defensa1
            carta1.url = data.url1

            carta2.ataque = data.ataque2
            carta2.defensa = data.defensa2
            carta2.url = data.url2

            cartaJugador.src = "img/cards/" + carta1.url
            cartaJugador.dataset.ataque = carta1.ataque
            cartaJugador.dataset.defensa = carta1.defensa

            cartaJuego.src = "img/cards/" + carta2.url
            cartaJuego.dataset.ataque = carta2.ataque
            cartaJuego.dataset.defensa = carta2.defensa

            tituloPopup.textContent = `Bienvenido ${gameState.nombre}!`
            textoPopup.textContent = "Cierra este menu para comenzar a jugar"

            contadorRondas.textContent = rondasJugadas
        }

        //El jugador elije ataque
        else if (action == "attack") {
            const ataqueJ = Number.parseInt(cartaJugador.dataset.ataque)
            const defensaM = Number.parseInt(cartaJuego.dataset.defensa)

            if (ataqueJ > defensaM) {
                // gana jugador
                rondasJugadas++
                gameState.wins++
                tituloPopup.textContent = `Jugada`
                textoPopup.textContent = `Gana el jugador por ${ataqueJ} de ataque frente a ${defensaM} de defensa`
                popup.classList.add("active")
                bandera.src = "img/win1.png"
                bandera.alt = "win"
                contenedorBandera.classList.add("show")
            } else if (ataqueJ === defensaM) {
                // empate
                tituloPopup.textContent = `Jugada`
                textoPopup.textContent = `Empate: ambos tienen ${ataqueJ} de ataque/defensa`
                popup.classList.add("active")
                bandera.src = "img/win1.png"
                bandera.alt = "draw"
                contenedorBandera.classList.add("show")
            } else {
                // pierde jugador
                rondasJugadas++
                gameState.loses++
                tituloPopup.textContent = `Jugada`
                textoPopup.textContent = `Gana la máquina por ${defensaM} de defensa frente a ${ataqueJ} de ataque`
                popup.classList.add("active")
                bandera.src = "img/win2.png"
                bandera.alt = "loss"
                contenedorBandera.classList.add("show")
            }
        }

        //El jugador elije defensa
        else if (action == "defend") {
            const defensaJ = Number.parseInt(cartaJugador.dataset.defensa)
            const ataqueM = Number.parseInt(cartaJuego.dataset.ataque)

            if (defensaJ > ataqueM) {
                // gana
                rondasJugadas++
                gameState.wins++
                tituloPopup.textContent = `Jugada`
                textoPopup.textContent = `Gana el jugador por ${defensaJ} de defensa frente a ${ataqueM} de ataque`
                popup.classList.add("active")
                bandera.src = "img/win1.png"
                bandera.alt = "win"
                contenedorBandera.classList.add("show")
            } else if (defensaJ == ataqueM) {
                // empate
                tituloPopup.textContent = `Jugada`
                textoPopup.textContent = `Empate del jugador y la maquina de ${defensaJ} de defensa frente a ${ataqueM} de ataque`
                popup.classList.add("active")
                bandera.src = "img/win1.png"
                bandera.alt = "draw"
                contenedorBandera.classList.add("show")
            } else {
                // pierde
                rondasJugadas++
                gameState.loses++
                tituloPopup.textContent = `Jugada`
                textoPopup.textContent = `Gana la maquina por ${ataqueM} de ataque frente a ${defensaJ} de defensa`
                popup.classList.add("active")
                bandera.src = "img/win2.png"
                bandera.alt = "loss"
                contenedorBandera.classList.add("show")
            }
        }

        if (gameState.rondas < rondasJugadas) {
            endGame()
        } else {
            contadorRondas.textContent = rondasJugadas

            const response = await fetch("api/cartas_aleatorias.php")
            const data = await response.json()

            carta1.ataque = data.ataque1
            carta1.defensa = data.defensa1
            carta1.url = data.url1

            carta2.ataque = data.ataque2
            carta2.defensa = data.defensa2
            carta2.url = data.url2

            cartaJugador.src = "img/cards/" + carta1.url
            cartaJugador.dataset.ataque = carta1.ataque
            cartaJugador.dataset.defensa = carta1.defensa

            cartaJuego.src = "img/cards/" + carta2.url
            cartaJuego.dataset.ataque = carta2.ataque
            cartaJuego.dataset.defensa = carta2.defensa
            setTimeout(() => {
                bandera.src = ""
                bandera.alt = ""
                contenedorBandera.classList.remove("show")
            }, 4500)
        }
        puntuacionJ1.textContent = gameState.wins
        puntuacionJ2.textContent = gameState.loses
    } catch (error) {
        console.error("La petición de cartas ha fallado:", error)
    }
}

async function endGame() {
    try {
        const response = await fetch("api/guardar_puntuacion.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                usuario_id: gameState.usuario_id,
                puntuacion: gameState.wins,
            }),
        })

        const datos = await response.json()
        console.log("Puntuación guardada:", datos)
    } catch (error) {
        console.error("Error al guardar puntuación:", error)
    }

    gameState.isGameOver = true
    tituloPopup.textContent = "Fin del Juego"

    textoPopup.textContent = `Juego Terminado! Puntuación Final: Victorias:${gameState.wins} - Derrotas:${gameState.loses}`
    popup.classList.add("active")

    botonReiniciar.style.display = "block"
}

btn_inicio.addEventListener("click", async () => {
    const usuario = await login()
    if (usuario) {
        start_game(usuario)
    }
})

btn_registro.addEventListener("click", registro)

//Oculta el modal de login para mostrar el de registro
btn_modal_registro.addEventListener("click", () => {
    modal_inicio.style.display = "none"
    modal_registro.style.display = "flex"
    mensajeRegistro.textContent = ""
})
//Oculta el modal de Registro y muestra el de login
btn_modal_login.addEventListener("click", () => {
    modal_registro.style.display = "none"
    modal_inicio.style.display = "flex"
    mensajeLogin.textContent = ""
})

botonAtacar.addEventListener("click", () => handle_next_round("attack"))
botonDefender.addEventListener("click", () => handle_next_round("defend"))



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
botonReiniciar.addEventListener("click", () => {
    location.reload()
})
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validarEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return emailRegex.test(email)
}

function validarPassword(password) {
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{6,}$/
    return passwordRegex.test(password)
}

closePopupBtn.addEventListener("click", () => {
    popup.classList.remove("active")
})

window.addEventListener("click", (e) => {
    if (e.target === popup) {
        popup.classList.remove("active")
    }
})