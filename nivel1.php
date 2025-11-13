<?php

$imagenes = [
    ['id' => 'Bonnie', 'image' => 'Bonnie.png'],
    ['id' => 'Chica', 'image' => 'Chica.png'],
    ['id' => 'Foxy', 'image' => 'Foxy.png'],
    ['id' => 'Freddy', 'image' => 'freddy.png'],
    ['id' => 'endo', 'image' => 'endo.png'],
    ['id' => 'Golden_Freddy', 'image' => 'golden_freddy.png'],
];

function generarCartas($num_cartas)
{
    global $imagenes;
    $max_cartas = count($imagenes) * 2;
    if ($num_cartas > $max_cartas) $num_cartas = $max_cartas;
    if ($num_cartas % 2 !== 0) $num_cartas++;
    $num_pares = floor($num_cartas / 2);
    $seleccionadas = array_rand($imagenes, $num_pares);
    if (!is_array($seleccionadas)) $seleccionadas = [$seleccionadas];
    $cartas = [];
    foreach ($seleccionadas as $index) {
        $cartas[] = $imagenes[$index];
        $cartas[] = $imagenes[$index];
    }
    shuffle($cartas);
    return $cartas;
}

$horaActual = isset($_GET['hora']) ? intval($_GET['hora']) : 1;
if ($horaActual < 1) $horaActual = 1;
if ($horaActual > 6) $horaActual = 6;
$num_cartas = 4 + ($horaActual - 1) * 2;
$cartas = generarCartas($num_cartas);
$totalPares = count($cartas) / 2;
$movimientosMax = $num_cartas;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Noche 1 - <?php echo $horaActual; ?> AM</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
background: url('imagenes/fondoInicio.png') no-repeat center center fixed;
background-size: cover;
color: white;
text-align: center;
min-height: 100vh;
}
.tablero {
display: flex;
flex-wrap: wrap;
justify-content: center;
max-width: 800px;
margin: 30px
auto;
}
.carta {
width: 170px;
height: 220px;
margin: 10px;
position: relative;
perspective: 1000px;
cursor: pointer;
}
.carta-inner {
position: relative;
width: 100%;
height: 100%;
transition: transform .6s;
transform-style: preserve-3d;
}
.carta.volteada .carta-inner {
transform: rotateY(180deg);
}
.carta-frente, .carta-dorso {
position: absolute;
width: 100%;
height: 100%;
backface-visibility: hidden;
border-radius: 10px;
overflow: hidden;
}
.carta-frente img, .carta-dorso img
{
width: 100%;
height: 100%;
object-fit: cover;
}
.carta-dorso {
transform: rotateY(180deg);
}
.carta.encontrada {
opacity: .5;
pointer-events: none;
}
.overlay-pantalla {
position: fixed;
inset: 0;
display: none;
justify-content: center;
align-items: center;
flex-direction: column;
background: rgba(0,0,0,.95);
z-index: 1000;
color: white;
}
.overlay-pantalla.activo {
display: flex;
}
video.jumpscare {
position: fixed;
inset: 0;
width: 100%;
height: 100%;
object-fit: cover;
z-index: 2000;
display:none;
}
</style>
</head>
<body>

<audio id="audioHora" src="sonidos/reloj.mp3" preload="auto"></audio>
<audio id="audioVictoria" src="sonidos/victoria.mp3" preload="auto"></audio>
<audio id="audioFondo" src="sonidos/cancion.mp3" preload="auto"></audio>

<div id="interfaz" class="container mt-4">
    <h1>Five Nights at Freddy's - Noche 1</h1>
    <div id="info" class="mb-3">
        <div>Hora: <span id="hora"><?php echo $horaActual; ?></span> AM</div>
        <div>Movimientos restantes: <span id="movs"><?php echo $movimientosMax; ?></span></div>
        <div>Pares encontrados: <span id="pares">0</span> / <?php echo $totalPares; ?></div>
    </div>

    <div class="tablero">
        <?php foreach ($cartas as $index => $carta): ?>
            <div class="carta" data-id="<?php echo $carta['id']; ?>" data-index="<?php echo $index; ?>">
                <div class="carta-inner">
                    <div class="carta-frente"><img src="imagenes/logo.png"></div>
                    <div class="carta-dorso"><img src="imagenes/<?php echo $carta['image']; ?>"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="overlayHora" class="overlay-pantalla"><h1 id="textoHora"></h1></div>
    <div id="gameOver" class="overlay-pantalla text-center">
        <h2>¡GAME OVER!</h2>
        <button id="reiniciar" class="btn btn-danger mt-3">Reintentar</button>
    </div>
    <div id="nocheCompletada" class="overlay-pantalla text-center">
        <h2>¡Noche completada!</h2>
        <button id="menuInicio" class="btn btn-success mt-3">Volver al menú</button>
    </div>
</div>

<video id="jumpscare" class="jumpscare"></video>

<script>
const $imagenes = <?php echo json_encode($imagenes); ?>;
</script>

<script>
const cartas=document.querySelectorAll('.carta'),
      movsDisplay=document.getElementById('movs'),
      horaDisplay=document.getElementById('hora'),
      paresDisplay=document.getElementById('pares'),
      overlayHora=document.getElementById('overlayHora'),
      textoHora=document.getElementById('textoHora'),
      gameOverScreen=document.getElementById('gameOver'),
      nocheCompletada=document.getElementById('nocheCompletada'),
      jumpscare=document.getElementById('jumpscare'),
      audioHora=document.getElementById('audioHora'),
      audioVictoria=document.getElementById('audioVictoria'),
      audioFondo=document.getElementById('audioFondo'),
      reiniciarBtn=document.getElementById('reiniciar'),
      menuBtn=document.getElementById('menuInicio');
const totalPares=<?php echo intval($totalPares); ?>,
      horaActual=<?php echo $horaActual; ?>;

let cartasVolteadas=[],
    paresEncontrados=0,
    movimientos=<?php echo $movimientosMax; ?>,
    juegoActivo=true;

const jumpscares={
    'Bonnie':'videos/jumpscare_bonnie.mp4',
    'Chica':'videos/jumpscare_chica.mp4',
    'Foxy':'videos/jumpscare_foxy.mp4',
    'Freddy':'videos/jumpscare_freddy.mp4',
    'endo':'videos/jumpscare_endo.mp4',
    'Golden_Freddy':'videos/jumpscare_goldenfreddy.mp4'
};
audioFondo.play();
function gameOver(anim){
    audioFondo.pause();
    juegoActivo=false;
    cartas.forEach(c=>c.style.pointerEvents='none');
    const personaje=$imagenes.find(p=>p.id.toLowerCase()===anim.toLowerCase());
    if(!personaje)return;
    const video=jumpscares[personaje.id];
    if(!video)return;
    jumpscare.src=video;
    jumpscare.style.display='block';
    jumpscare.play();
    setTimeout(()=>{
        jumpscare.pause();
        jumpscare.currentTime=0;
        jumpscare.style.display='none';
        gameOverScreen.classList.add('activo');
    },4000);
}
function mostrarCambioHora(nuevaHora){
    juegoActivo=false;
    textoHora.textContent=nuevaHora+' AM';
    overlayHora.classList.add('activo');
    audioHora.play();
    setTimeout(()=>{
        overlayHora.classList.remove('activo');
        window.location.href='nivel1.php?hora='+nuevaHora;
    },2500);
}
function mostrarFinal(){
    audioFondo.pause();
    juegoActivo=false;
    audioVictoria.play();
    nocheCompletada.classList.add('activo');
}
function actualizarMovimientos(delta){
    movimientos+=delta;
    if(movimientos<0)movimientos=0;
    movsDisplay.textContent=movimientos;
    if(movimientos===0&&juegoActivo){
        const ultimo=cartasVolteadas.length>0?cartasVolteadas[0].dataset.id:'Bonnie';
        gameOver(ultimo);
    }
}
function actualizarPares(){
    paresDisplay.textContent=paresEncontrados;
}

cartas.forEach(carta=>{
    carta.addEventListener('click',()=>{
        if(!juegoActivo||cartasVolteadas.length>=2||carta.classList.contains('volteada')||carta.classList.contains('encontrada'))return;
        carta.classList.add('volteada');
        cartasVolteadas.push(carta);
        if(cartasVolteadas.length===2){
            const[c1,c2]=cartasVolteadas;
            if(c1.dataset.id===c2.dataset.id&&c1.dataset.index!==c2.dataset.index){
                paresEncontrados++;
                actualizarPares();
                setTimeout(()=>{
                    c1.classList.add('encontrada');
                    c2.classList.add('encontrada');
                    cartasVolteadas=[];
                },600);
                if(paresEncontrados===totalPares){
                    if(horaActual<6)setTimeout(()=>mostrarCambioHora(horaActual+1),1200);
                    else setTimeout(()=>mostrarFinal(),1200);
                }
            }else{
                actualizarMovimientos(-1);
                setTimeout(()=>{
                    c1.classList.remove('volteada');
                    c2.classList.remove('volteada');
                    cartasVolteadas=[];
                },800);
            }
        }
    });
});

reiniciarBtn.onclick=()=>location.reload();
menuBtn.onclick=()=>window.location.href='inicio.php';
</script>
</body>
</html>