<main class="contenedor seccion">
    <h1>Resgistrar vendedor(a)</h1>
    <a href="/admin" class="boton boton-verde"> Volver</a>

    <!--MENSAJE DE ERROR EN PHP-->
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/vendedores/crear">
        <?php include 'formulario.php'; ?>
        <input type="submit" value="Resgistrar vendedor(a)" class="boton boton-verde">
    </form>
</main>