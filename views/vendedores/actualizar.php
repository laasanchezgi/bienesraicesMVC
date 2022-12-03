<main class="contenedor seccion">
    <h1>Actualizar vendedor(a)</h1>
    <a href="/admin" class="boton boton-verde"> Volver</a>

    <!--MENSAJE DE ERROR EN PHP-->
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST">
        <?php include 'formulario.php'; ?>
        <input type="submit" value="Guardar cambios" class="boton boton-verde">
    </form>
</main>