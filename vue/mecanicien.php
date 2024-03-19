<?php
session_start();
if ($_SESSION['fk_emploi'] != 2 && !isset($_SESSION['alias'])) {
  header('location: ../index.php');
}
require __DIR__ . '/../vuemodel/mecanicienVueModel.php';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="media/css/asset.css">
</head>

<body>
  <header>
    <div class="px-3 py-2 bg-lightBlue text-dark">
      <div class="container">

        <div class="d-flex align-items-center row gx-1  my-2 justify-content-between mx-3">

          <div class="text-start">
            <ul class="d-flex flex-column nav col-md-6 mb-2 col-lg-auto ">
              <li>
                <h1> Bonjour <?= $_SESSION['nom'] ?> </h1>
              </li>
              <li>
                <h3>Véhicule <?= $alias ?></h3>
              </li>
            </ul>
          </div>
          <div class="col-md-6 d-flex justify-content-between">
            <?php if (isset($accueil)) : ?>
              <a href="mecanicien.php"> <i class="fa fa-solid fa-arrow-left"></i></a>
          </div>

        <?php endif; ?>
        <div class="col-md-6">
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="submit" class="p-2 btn btn-light" name="deconnexion" value="Me deconnecter" />
          </form>
        </div>
        </div>
      </div>
    </div>
    </div>
  </header>


  <?php if (isset($accueil)) : ?>
  <?php else : ?>

    <div class="container mt-5 w-90">
      <div class="row justify-content-center">

        <div class="col-12 m-auto mt_2">
          <label> Renseigner un entretien <label>
              <a href="mecanicienEntretien.php" class="btn btn-primary w-100 btn-lg btn-block"> ENTRETIEN </a>
        </div>

      </div>

      <div class="row justify-content-center mt-5">

        <div class="col-12 m-auto mt_2">
          <label> Suivis pneumatique <label>
              <a href="mecanicienModification.php" class="btn btn-primary w-100 btn-lg btn-block"> PNEUS </a>
        </div>
        <div class="row justify-contentcenter mt-5">

          <div class="col-12 m-auto mt_2">
            <label>Historique pneumatique <label>
                <a href="mecanicienHistorique.php" class="btn btn-primary w-100 btn-lg btn-block"> HISTORIQUE PNEUMATIQUE </a>
          </div>
        </div>
      </div>

      <div class="container mt-5 w-90">
        <div class="row justify-content-center">

          <div class="col-12 m-auto mt_2">
            <label> Historique entretien <label>
                <a href="mecanicienHistorique2.php" class="btn btn-primary w-100 btn-lg btn-block"> HISTORIQUE ENTRETIEN </a>
          </div>

        </div>
      </div>
    </div>


  <?php endif; ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>