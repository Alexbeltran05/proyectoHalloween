<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nivel 1</title>

</head>
<body>
    <div id="interfaz">

        <div id="info">
            <div>Movimientos restantes: <span id="movs">0</span></div>
            <div><span id="hora"></span></div>
        </div>

        <div id="gameOver">
            <h2>¡Fin del Juego!</h2>
            <button id="reiniciar">Reintentar</button>
        </div>

        <div id="instruciones">
            Tu trabajo:
            - Selecciona una tarjeta para ver el animatronico.
            - encuentra las parejas de animatronicos para pasar la noche.
            - No acabes como el anterior vigilante, buena suerte.
        </div>

    </div>
</body>
<script>
const interfaz = document.getElementById('interfaz');
const movimientos = document.getElementById('movs');
const hora = document.getElementById('hora');
const muerte = document.getElementById('gameOver');
const restartBtn = document.getElementById('restartBtn');

let movimientos = 0;
let hora = 1;
let gameActive = true;
let tarjetas = [];
let gameLoop;

const CONTAINER_WIDTH = 600;
const CONTAINER_HEIGHT = 500;
const tamañoTarjeta = 40;

function resetGameVariables() {
    movimientos = 0;
    hora = 3;
    gameActive = true;
    playerPosition = 270;
    movimientosDisplay.textContent = movimientos;
    horaDisplay.textContent = hora;
    gameOverScreen.style.display = 'none';
}

//funciones tarjetas:
function crearTarjetas() {
    const obj = document.createElement('div');
    obj.className = 'tarjeta';


    obj.textContent = isGood ? '🎃' : '👻';
    obj.dataset.type = isGood ? 'good' : 'bad';


    // Posición aleatoria horizontal
    const randomX = Math.random() * (CONTAINER_WIDTH - OBJECT_SIZE);
    obj.style.left = randomX + 'px';
    obj.style.top = '-50px';


    gameContainer.appendChild(obj);
    fallingObjects.push({
        element: obj,
        x: randomX,
        y: -50,
        type: isGood ? 'good' : 'bad'
    });
}
</script>
</html>