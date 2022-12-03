<main class="contenedor seccion contenido-centrado">
    <h1>Inciar sesión</h1>
    <!--ERRORES-->
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend> Email y password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu email" id="email">
            
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu password" id="password">
        </fieldset>

        <input type="submit" value="Iniciar sesión" class="boton boton-verde">

    </form>
</main>