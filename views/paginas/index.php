<main class="contenedor seccion">
    <h1>Más sobre nosotros</h1>
    <?php include 'iconos.php'; ?>
</main>

<section class="seccion contenedor">
    <h2>Casas y apartamentos en venta</h2>
        <?php 
            $limite = 3;
            include 'listado.php';
        ?>
    <div class="alinear-derecha">
        <a href="/propiedades" class="boton-verde">Ver todas</a>
    </div>
</section>

<section class="imagen-contacto">
    <h2>Encuentra la casa de tus sueños</h2>
    <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo lo más pronto posible</p>
    <a href="/contacto" class="boton-amarillo">Contactános</a>
</section>

<div class="contenedor seccion seccion-inferior">
    <section class="blog">
        <h3>Nuestro blog</h3>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog1.jpg" alt="Texto Entrada Blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p class="informacion-meta">Escrito el: <span>05/11/2022</span> por: <span>Admin</span> </p>

                    <p>
                        Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog2.jpg" alt="Texto Entrada Blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <p class="informacion-meta">Escrito el: <span>05/11/2022</span> por: <span>Admin</span> </p>

                    <p>
                        Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article>
    </section>

    <section class="testimoniales">
        <h3>Testimoniales</h3>

        <div class="testimonial">
            <blockquote>
                El personal se comportó de una forma excelente, muy buena la etención y la casa que me ofrecieron cumple con todas mis expectativas.
            </blockquote>
            <p>- Alejandra Giraldo</p>
        </div>
    </section>
</div>
