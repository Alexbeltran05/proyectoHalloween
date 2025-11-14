<?php
require 'funciones.php';
protegerPagina();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="styleInicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <div class="card" id="titulo">
    <div>
      <a href="logout.php" style="float:right; margin:20px; color:white; background:red; padding:10px; border-radius:5px;">Cerrar sesión</a>
    </div>
    <h2 id="textoTitulo"> ¡Enhorabuena! Has sido seleccionado, bienvenido a tu nuevo trabajo.</h2>
  </div>

  <div class="card" id='card2'>
    <h3 style='color:coral; text-align:center'>Indicaciones:</h3>
    <p style='color:white; text-align:center;'>Eres el vigilante de seguridad de las distintas instalaciones de Five Nights at Freddy's, debes sobreviv... digo... vigilar las instalaciones durante las noches, tu turno comienza a las 12am y concluye a las 6am, no te preocupes, las noches son muy tranquilas
    </p>
  </div>

    <div class="card" id='card3'>
  <h2 style='color:coral; text-align:center'>Niveles</h2>
  
  <div class="niveles">
    <div class="card" id='nivel1'><h1>Nivel 1 - FNAF 1</h1><button id="btnNivel1">Jugar</button></div>
    <div class="card" id='nivel2'><h1>Nivel 2 - FNAF Sister Location</h1><button id="btnNivel2">Jugar</button></div>
    <div class="card" id='nivel3'><h1>Nivel 3 - Modo Pesadilla</h1><button id="btnNivel3">Jugar</button></div>
  </div>
</div>
<footer class="card" id="footer">
  <div id="contenidoFooter">Designed by - @BeltranProgramming SL.</div>
  <container id="programadores">
    <h5>Programadores:</h5>
    <p>- Alex Beltrán Morales</p>
    <p>- Lola Ávila Ros</p>
    <p>- Jesus Ortega Torres</p>
  </container>

</footer>
<script>
  const btnNv1 = document.getElementById("btnNivel1"),
    btnNv2 = document.getElementById("btnNivel2"),
    btnNv3 = document.getElementById("btnNivel3");

  btnNv1.onclick = () => window.location.href = 'nivel1.php';
  btnNv2.onclick = () => window.location.href = 'nivel2.php';
  btnNv3.onclick = () => window.location.href = 'nivel3.php';


</script>

    
</body>
</html>