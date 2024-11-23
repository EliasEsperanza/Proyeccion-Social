<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <title>welcome</title>
</head>
<body>
    
<body>
    <div class="decoration"></div>
    <div class="decoration"></div>

    <header>
        <h2>Facultad Multidisciplinaria Oriental</h2>
        <h3>Universidad de El Salvador</h3>
    </header>

    <main>
        <div class="logo-container">
            <div class="logo">
           <img src="{{ asset('img/logo.png') }}" alt="Logo UES" />   
            </div>
        </div>

        <div class="counter">

        </div>

        <div class="welcome-text">
            <h1>¡Bienvenidos al Proyecto de Horas Sociales!</h1>
            <p>Estamos comprometidos con el desarrollo y el servicio a nuestra comunidad. 
                A través de este proyecto, buscamos generar un impacto positivo, aplicando los conocimientos adquiridos en nuestra formación académica.</p>
            <div class="lema">HACIA LA LIBERTAD POR LA CULTURA</div>
            <p>Juntos, construimos un mejor futuro para El Salvador.</p>

            <a href="{{ route('login') }}" class="btn">Iniciar Secion</a>

        </div>
    </main>

    <footer>
        <p>© 2024 Facultad Multidisciplinaria Oriental - Tecnicas de Programacion para Internet</p>
    </footer>
</body>
</body>
</html>

