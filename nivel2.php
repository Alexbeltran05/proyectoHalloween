<?php


$imagenes = [
    ['id' => 'circusbaby', 'image' => 'circusbaby.png'],
    ['id' => 'funtimechica', 'image' => 'funtimechica.png'],
    ['id' => 'funtimefoxy', 'image' => 'funtimefoxy.png'],
    ['id' => 'funtimefreddy', 'image' => 'funtimefreddy.png'],
    ['id' => 'yendo', 'image' => 'yendo.png'],
    ['id' => 'funtimebonnie', 'image' => 'funtimebonnie.png'],
    ['id' => 'ballora', 'image' => 'ballora.png'],
    ['id' => 'bidybab', 'image' => 'bidybab.png'],
    ['id' => 'electrobab', 'image' => 'electrobab.png'],
    ['id' => 'ennard', 'image' => 'ennard.png'],
    ['id' => 'minireena', 'image' => 'minireena.png'],
    ['id' => 'lolbit', 'image' => 'lolbit.png'],
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
$num_cartas = 12 + ($horaActual - 1) * 2;
$cartas = generarCartas($num_cartas);
$totalPares = count($cartas) / 2;
$movimientosMax = $num_cartas - 2;
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
background: url('imagenes/fondo2.png') no-repeat center center fixed;
background-size: cover;
color: white;
text-align: center;
min-height: 100vh;
}
.tablero {
display: flex;
flex-wrap: wrap;
justify-content: center;
max-width: 1300px;
margin: 30px
auto;
}
.carta {
width: 120px;
height: 180px;
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
#startOverlay{
    position: fixed;
    inset: 0;
    background: #000;
    color: #7dd6ff;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 3000;
    opacity: 1;
    transition: opacity .6s ease-out;
    font-family: 'Courier New', monospace;
}
#startOverlay.oculto{
    opacity: 0;
    pointer-events: none;
}




#startOverlay.glitch{
    position: relative;
    display: inline-block;
    animation: glitch 2s infinite steps(1,end);
    filter: drop-shadow(0 0 20px #00d9ff);
}
@keyframes glitch{
    0%   { transform: translate(0); }
    20%  { transform: translate(-2px, 2px); }
    40%  { transform: translate(2px, -2px); }
    60%  { transform: translate(-1px, 1px); }
    80%  { transform: translate(1px, -1px); }
    100% { transform: translate(0); }
}




#startOverlay.blink{
    animation: blink 1.8s infinite;
}
@keyframes blink{
    0%, 100%{ opacity: 1; }
    50%      { opacity: .2; }
}
</style>
</head>
<body>


<?php if ($horaActual == 1): ?>


<div id="startOverlay">
   
    <img src="imagenes/logosl.png" style="width:320px; margin-bottom:40px;">


    <button id="startNight" class="btn btn-primary btn-lg mb-3" style="width:240px;">
        Empezar la Noche
    </button>


    <button id="goMenu" class="btn btn-secondary btn-lg" style="width:240px;">
        Volver al menú
    </button>


</div>
<?php endif; ?>


<audio id="audioHora" src="sonidos/reloj.mp3" preload="auto"></audio>
<audio id="audioVictoria" src="sonidos/victoria.mp3" preload="auto"></audio>
<audio id="audioFondo" src="sonidos/cancion1.mp3" preload="auto"></audio>


<div id="interfaz" class="container mt-4">
    <h1>Five Nights at Freddy's Sister Location</h1>
    <div id="info" class="mb-3">
        <div><span id="hora"><?php echo $horaActual; ?></span> AM</div>
        <div>Movimientos restantes: <span id="movs"><?php echo $movimientosMax; ?></span></div>
        <div>Pares encontrados: <span id="pares">0</span> / <?php echo $totalPares; ?></div>
    </div>


    <div class="tablero">
        <?php foreach ($cartas as $index => $carta): ?>
            <div class="carta" data-id="<?php echo $carta['id']; ?>" data-index="<?php echo $index; ?>">
                <div class="carta-inner">
                    <div class="carta-frente"><img src="imagenes/logosl.png"></div>
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
    startNight =document.getElementById('startNight')
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
    volverMenu=document.getElementById('goMenu'),
    menuBtn=document.getElementById('menuInicio');
const totalPares=<?php echo intval($totalPares); ?>,
      horaActual=<?php echo $horaActual; ?>;


audioFondo.play();


if (startNight) {
    startNight.onclick = () => {
        audioFondo.currentTime = 0;
        audioFondo.play();
        startOverlay.style.opacity = "0";
        setTimeout(() => {
            startOverlay.style.display = "none";
        }, 500);
    };
    volverMenu.onclick = () => window.location.href='inicio.php';
}




let cartasVolteadas=[],
    paresEncontrados=0,
    movimientos=<?php echo $movimientosMax; ?>,
    juegoActivo=true;


const jumpscares={
    'circusbaby':'videos/jumpscare_circusbaby.mp4',
    'funtimechica':'videos/jumpscare_funtimechica.mp4',
    'funtimefoxy':'videos/jumpscare_funtimefoxy.mp4',
    'funtimefreddy':'videos/jumpscare_funtimefreddy.mp4',
    'yendo':'videos/jumpscare_yendo.mp4',
    'funtimebonnie':'videos/jumpscare_funtimebonnie.mp4',
    'ballora':'videos/jumpscare_ballora.mp4',
    'bidybab':'videos/jumpscare_bidybab.mp4',
    'electrobab':'videos/jumpscare_bidybab.mp4',
    'ennard':'videos/jumpscare_ennard.mp4',
    'minireena':'videos/jumpscare_minireena.mp4',
    'lolbit':'videos/jumpscare_lolbit.mp4',
};


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
    audioFondo.pause();
    juegoActivo=false;
    textoHora.textContent=nuevaHora+' AM';
    overlayHora.classList.add('activo');
    setTimeout(()=>{
        overlayHora.classList.remove('activo');
        window.location.href='nivel2.php?hora='+nuevaHora;
    },2500);


}
function mostrarFinal(){
    audioFondo.pause();
    juegoActivo=false;
    audioVictoria.play();
    nocheCompletada.classList.add('activo');
}
function actualizarMovimientos(movs){
    movimientos+=movs;
    if(movimientos<0)movimientos=0;
    movsDisplay.textContent=movimientos;
    if(movimientos===0&&juegoActivo){
        const ultimo=cartasVolteadas.length>0?cartasVolteadas[0].dataset.id:'circusbaby';
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


