<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forza Entrenamientos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tu CSS local --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-dark sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">
            <span class="text-white fw-bold">FORZA</span> 
            <span class="orange">entrenamientos</span>
        </a>

        <button class="navbar-toggler collapsed link-light bg-secondary"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
          <span class="navbar-toggler-icon orange"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active link-light" href="#porqueentrenar">¿Por qué entrenar?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-light" href="#quienes-somos">¿Quiénes somos?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-light" href="#contacto">Contactanos</a>
            </li>
          </ul>

          <div class="ms-auto">
              <a class="btn btn-naranja" href="/admin">Ingresar</a>
          </div>
        </div>
      </div>
    </nav>


    <!-- CARROUSEL -->
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/img-01.jpg') }}" class="d-block w-100" alt="img1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/img-02.jpg') }}" class="d-block w-100" alt="img2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/img-03.jpg') }}" class="d-block w-100" alt="img3">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/img-04.jpg') }}" class="d-block w-100" alt="img4">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
    </div>


    <!-- MAIN -->
    <main>

      <div class="d-flex justify-content-center mt-5">
          <a class="btn btn-naranja text-white p-3" href="#">Quiero empezar a entrenar!</a>
      </div>

      <!-- POR QUÉ ENTRENAR -->
      <section class="mt-1 mb-5 pt-5 container">
        <h2 class="text-center fw-bold" id="porqueentrenar">¿Por qué entrenar?</h2>

        <div class="cards-container d-flex flex-wrap justify-content-around row-gap-3 mt-4">

            <div class="card shadow-lg border-light" style="width: 18rem;">
                <img src="{{ asset('img/muscle.png') }}" class="card-img-top">
                <div class="card-body">
                    <p class="card-text text-center">
                        Entrenar la fuerza aumenta tu masa <span class="fw-bolder">muscular y previene lesiones</span>.
                    </p>
                </div>
            </div>

            <div class="card shadow-lg border-light" style="width: 18rem;">
                <img src="{{ asset('img/happiness.png') }}" class="card-img-top">
                <div class="card-body">
                    <p class="card-text text-center">
                        Mejora tu bienestar emocional, <span class="fw-bolder">reduce la ansiedad</span> y previene la depresión.
                    </p>
                </div>
            </div>

            <div class="card shadow-lg border-light" style="width: 18rem;">
                <img src="{{ asset('img/health.png') }}" class="card-img-top">
                <div class="card-body">
                    <p class="card-text text-center">
                        <span class="fw-bolder">Cuida tu salud cardiovascular</span> y fortalece tus músculos para un bienestar integral.
                    </p>
                </div>
            </div>
        </div>
      </section>


      <!-- QUIÉNES SOMOS -->
      <section class="quienes-somos background-image pt-5 bg-claro" id="quienes-somos">
        <h2 class="text-center fw-bold mt-2">¿Quiénes somos?</h2>

        <div class="d-flex container justify-content-center align-items-center pt-3 column-gap-3 quienes-somos-content">

          <div class="d-flex align-self-stretch">
            <p class="align-self-center fw-bolder text-light text-shadow quienes-somos-text">
              Nuestra meta es acompañar a los alumnos en sus objetivos, asistirlos,
              y cuidarlos. Planificamos las rutinas cuidadosamente para cada uno.
            </p>
          </div>

          <div>
            <img src="{{ asset('img/img-retrato.png') }}" class="quienes-somos-img">
          </div>

        </div>
      </section>


      <!-- CONTACTO -->
      <section class="pt-3 d-flex flex-column bg-secondary pb-5" id="contacto">
        <div class="container d-flex flex-column justify-content-center">

          <h2 class="mt-5 text-center fw-bold text-light">Contactanos y comenzá a entrenar.</h2>

          <p class="text-center text-light">Envianos un WhatsApp y resolvemos todas tus dudas.</p>

          <div class="d-grid gap-2 col-5 mx-auto pt-3 pb-3">
            <button type="button" class="btn btn-light">
              <i class="bi bi-whatsapp"></i> Whatsapp
            </button>
          </div>

          <p class="text-center text-light mt-3">
            O acercate al gimnasio en Avenida Siempreviva 742.
          </p>

        </div>
      </section>

    </main>


    <!-- FOOTER -->
    <footer class="bg-dark d-flex">
      <div class="container d-flex justify-content-end">
        <p class="text-white align-self-center text-end fs-6">
          Landing page developed with Bootstrap by Juan Gobber & Felipe Gobber
        </p>
      </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>