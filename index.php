<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Halloween</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="login">
        <h1>Inicia sesión... si te atreves</h1>
        <p>usuario: admin contraseña:1234</p>
        <form action="login.php" method="POST" id="login">
            <input type="text" name="usuario" placeholder="usuario" >
            <input type="password" name="clave" placeholder="contraseña" >
            <button type="submit">Entrar</button>
        </form>
        <p class="nota">¿Sobreviviras esta noche?</p>
    </div>
    <script>
        document.getElementById("login").addEventListener("submit", function(e){
            e.preventDefault();

            const usuario = this.usuario.value.trim();
            const clave = this.clave.value.trim();
            
            if(usuario == '' || clave == ''){
                alert("ingresa los datos correctamente");
                return;
            }
        
            this.submit();

        });
        </script>
</body>
</html>