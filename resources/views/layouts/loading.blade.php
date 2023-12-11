<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loading Page</title>
    
    <style>
        /* Stili per il centro della pagina */
        .layover {
        color: lightgray;
        backdrop-filter: blur(5px);

        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Aggiunto per far sì che il div di caricamento occupi l'intera altezza della finestra */
        width: 100%;
        z-index: 10;
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5); 
      }

      .icon {
        text-align: center;
      }
    </style>
</head>
<body>
  <div class="layover">
    <div class="icon">
      <i class="fa-solid fa-spinner fa-6x fa-spin"></i>
      <div class="mt-2">
        <span>Loading...</span>
      </div>
    </div>
  </div>

</body>
</html>