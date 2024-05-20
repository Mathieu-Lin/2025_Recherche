<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./src/components/footer.css">
</head>

<body>
  <footer class="container-up text-center text-white">
    <div class="container p-4 pb-0">
      <p class="d-flex justify-content-center align-items-center">
        <?php
        if ($_SESSION["user"] == "") {
        ?>
          <span class="me-3">Inscris toi maintenant !</span>
          <button data-mdb-ripple-init type="button" class="btn btn-outline-light btn-rounded" onclick="window.location.href='?page=Inscription';">
            Inscription
          </button>
        <?php
        }
        ?>

      </p>
    </div>

    <div class="text-center p-3">
      © 2024 Copyright:
      <a class="text-white" href="https://mdbootstrap.com/">PolyRecherche.com</a>
    </div>
  </footer>
</body>

</html>