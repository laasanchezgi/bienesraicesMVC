<?php

    require_once __DIR__ . '/../includes/app.php';

    use MVC\Router;
    use Controllers\PropiedadController;
    use Controllers\VendedorController;
    use Controllers\PaginasController;
    use Controllers\LoginController;

    $router = new Router();

    // url, [clase, 'funcion asociada a dicha clase y url']
    $router->get('/admin', [PropiedadController::class, 'index']);
    // Zona privada
    // Propiedades --> Acciones (Administrador)
    $router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
    $router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
    $router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);
    // Vendedores --> Acciones (Administrador)
    $router->get('/vendedores/crear', [VendedorController::class, 'crear']);
    $router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
    $router->post('/vendedores/crear', [VendedorController::class, 'crear']);
    $router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
    $router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar']);
    // Zona pública
    // Paginas que no necesitan login (Visitantes)
    $router->get('/', [PaginasController::class, 'index']);
    $router->get('/nosotros', [PaginasController::class, 'nosotros']);
    $router->get('/propiedades', [PaginasController::class, 'propiedades']);
    $router->get('/propiedad', [PaginasController::class, 'propiedad']);
    $router->get('/blog', [PaginasController::class, 'blog']);
    $router->get('/entrada', [PaginasController::class, 'entrada']);
    $router->get('/contacto', [PaginasController::class, 'contacto']);
    $router->post('/contacto', [PaginasController::class, 'contacto']);
    // Login y autenticación
    // Mostrar el formulario
    $router->get('/login', [LoginController::class, 'login']);
    // Cerrar sesión
    $router->get('/logout', [LoginController::class, 'logout']);
    // Enviar datos al formulario
    $router->post('/login', [LoginController::class, 'login']);

    $router->comprobarRutas();