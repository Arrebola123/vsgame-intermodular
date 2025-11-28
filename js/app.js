const selectOculto = document.getElementById('opcionJugada');
const formulario = document.getElementById('formEnvio');

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

let gameState = {
    usuario:null,
    rondas:5,
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
                //Poner el  mensaje desde php
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
    await fetch('start_game.php',{
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(usuario)
    })
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
btn_modal_registro.addEventListener('click',function(){
    modal_inicio.style.display = 'none';
    modal_registro.style.display = 'flex';
});

btn_modal_login.addEventListener('click',function(){
    modal_registro.style.display = 'none';
    modal_inicio.style.display = 'flex';
});

function renderBoard(){}


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

    // // POPUP
    // const closePopupBtn = document.getElementById('closePopupBtn');
    // const popup = document.getElementById('popup');

    // closePopupBtn.addEventListener('click', function() {
    //     popup.classList.remove('active');
    // });

    // window.addEventListener('click', function(e) {
    //     if (e.target === popup) {
    //         popup.classList.remove('active');
    //     }
    // });