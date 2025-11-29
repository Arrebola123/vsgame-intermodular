const modal_inicio = document.getElementById('login-modal');
const email_inicio = document.getElementById('player-email');
const contra_inicio = document.getElementById('player-passwd');
const btn_inicio = document.getElementById('login-btn');
const btn_modal_registro = document.getElementById('register-modal-btn');

const modal_registro = document.getElementById('register-modal');
const email_registro = document.getElementById('player-email-register');
const contra_registro = document.getElementById('player-passwd-register');
const btn_registro = document.getElementById('register-btn');
const btn_modal_login = document.getElementById('login-modal-btn');

const closePopupBtn = document.getElementById('closePopupBtn');
const popup = document.getElementById('popup');
const tituloPopup = popup.querySelector('h2');
const textoPopup  = popup.querySelector('.popup-text');
const botonReiniciar = document.getElementById('restartGame');

const contadorRondas = document.querySelector('.ronda');
const puntuacionJ1 = document.querySelector('.puntuacionJ1');
const puntuacionJ2 = document.querySelector('.puntuacionJ2');

const cartaJugador = document.getElementById('playerCard');
const cartaJuego = document.getElementById('gameCard')
const botonAtacar = document.getElementById('atacar');
const botonDefender = document.getElementById('defender');

const contenedorBandera = document.getElementById('bandera');
const bandera = contenedorBandera.firstElementChild;

let gameState = {
    id:0,
    nombre:null,
    rondas:0,
    wins:0,
    loses:0,
    isGameOver:false
};


async function login(){
    //validar campos, iniciar sesión con login.php y solicitar inicio de juego con start_game.php
    const email = email_inicio.value;
    const password = contra_inicio.value;
    let mensaje = null;
    if(validarEmail(email) && validarPassword(password)){
        const inicio_sesion ={
            email:email,
            password:password
        }

        await fetch('prueba.php',{
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(inicio_sesion)
        })
        .then(response => response.json())
        .then(datos => {
            if(datos.status === "success"){
                const usuario ={
                    email : datos.email,
                    password : datos.password, 
                    nombre : datos.nombre
                }
                mensaje = datos.mensaje;
                return usuario;
            }
            else{
                mensaje = datos.mensaje
                return
            }
        })
        .catch(error => {
            console.error("Error en la petición:", error);
            return
        });
        modal_inicio.style.display = 'none';

    }else{
        mensaje = "El email o la contraseña no cumplen los requerimientos.";
    }
}

async function start_game(usuario){
    await fetch('prueba_start.php',{
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(usuario)
    }).then(response => response.json())
    .then(datos => {
        if(datos.status === "success"){
            gameState.id = datos.id;
            gameState.nombre = datos.nombre;
            gameState.wins = datos.wins;
            gameState.loses = datos.loses;
            gameState.rondas = datos.rondas;
        }
    })
    .catch(error=>{
        console.error("Error en la petición:",error);
    });
    handle_next_round("start");
}

async function handle_next_round(action){
    let carta1 = {};//objeto de carta usuario
    let carta2 = {};//objeto de carta juego
    try{
        const response = await fetch('prueba_cartas.php');
        const data = await response.json();

        //asignacion de variables para los 2 objetos a partir de la respuesta
        carta1.ataque = data.ataque1;
        carta1.defensa = data.defensa1;
        carta1.url = data.url1;

        carta2.ataque = data.ataque2;
        carta2.defensa = data.defensa2;
        carta2.url = data.url2;

        puntuacionJ1.textContent = gameState.wins;
        puntuacionJ2.textContent = gameState.loses;

        if(action == "start"){
            cartaJugador.src = 'img/cards/'+carta1.url;
            cartaJugador.dataset.attack = carta1.ataque;
            cartaJugador.dataset.defensa = carta1.defensa;

            cartaJuego.src = 'img/cards/'+carta2.url;
            cartaJuego.dataset.attack = carta1.ataque;
            cartaJuego.dataset.defensa = carta1.defensa;

            tituloPopup.textContent = `Bienvenido ${gameState.nombre}!` ;
            textoPopup.textContent = 'Cierra este menu para comenzar a jugar';

            contadorRondas.textContent = 1;

        }
        else if(action == "attack"){
            if(cartaJugador.dataset.attack > cartaJuego.dataset.defensa){
                //gana
            }
            else if(cartaJugador.dataset.attack == cartaJuego.dataset.defensa){
                //empate
            }
            else{
                //pierde
            }
        }
        else if(action == "defend"){
        }

        if(gameState.rondas < (parseInt(contadorRondas.textContent))) endGame();

    }catch(error){
        console.error('La petición de cartas ha fallado:', error);
    }
}

function crear_usuario(){
    const email = email_registro.value.trim();
    const contra = contra_registro.value.trim();

    gameState.usuario = {email};
    modal_registro.style.display='none'
    modal_inicio.style.display = 'flex';
}

btn_inicio.addEventListener('click',async function(){
    const usuario = await login();
    start_game(usuario);
});

btn_registro.addEventListener('click',crear_usuario);


//Oculta el modal de login para mostrar el de registro
btn_modal_registro.addEventListener('click',function(){
    modal_inicio.style.display = 'none';
    modal_registro.style.display = 'flex';
});
//Oculta el modal de Registro y muestra el de login
btn_modal_login.addEventListener('click',function(){
    modal_registro.style.display = 'none';
    modal_inicio.style.display = 'flex';
});

botonAtacar.addEventListener('click', () => handle_next_round("attack"));
botonDefender.addEventListener('click', () => handle_next_round("defend"));

function validarEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function validarPassword(password) {
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;
  return passwordRegex.test(password);
}





    // function atacar(){
    //     selectOculto.value = 'ataque'; // Cambia el valor del select
    //     formulario.submit();
    // };

    // function defender() {
    //     selectOculto.value = 'defensa'; // Cambia el valor del select
    //     formulario.submit();
    // };

    closePopupBtn.addEventListener('click', function() {
        popup.classList.remove('active');
    });

    // window.addEventListener('click', function(e) {
    //     if (e.target === popup) {
    //         popup.classList.remove('active');
    //     }
    // });