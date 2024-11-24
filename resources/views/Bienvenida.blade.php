<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <title>welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.min.css"rel="stylesheet">
</head>
<body>
    <!---HEADER SECTION---->
    <header class="header-bienvenida">
        <a href="#" class="logo-bienvenida">Facultad<span> Multidisciplinaria Oriental</span></a>
        <a href="" class="logo-bienvenida">Universidad de El Salvador</a>
    </header>

    <!---HOME SECTION---->
    <section class="home-bienvenida" id="home-bienvenida">
        <div class="content-bienvenida">
            <h3>¡Bienvenidos al Proyecto de <span>Horas Sociales!</span></h3>
            <p>Estamos comprometidos con el desarrollo y el servicio a nuestra comunidad. A través de este proyecto, buscamos generar un impacto positivo, aplicando los conocimientos adquiridos en nuestra formación académica.</p>
            <p class="frase">HACIA LA LIBERTAD POR LA CULTURA</p>
            <a href="{{ route('login') }}" class="btn-bienvenida">
                <div class="button__content">
                    <span class="button__text">Iniciar Sesión</span>
                    <i class="ri-user-shared-2-line button__icon"></i>
                    <div class="button__reflection-1"></div>
                    <div class="button__reflection-2"></div>
                </div>
                <div class="button__shadow"></div>
            </a>
        </div>
        <div class="image-bienvenida">
            <img src="{{ asset('img/Escudo_de_la_Universidad_de_El_Salvador.svg') }}" alt="">
        </div>
    </section>

      <!---footer SECTION---->
      <footer class="footer-bienvenida">
        <div class="footer-content">
            © 2024 - Técnicas de Programación para Internet
        </div>
    </footer>
    
</body>
</html>