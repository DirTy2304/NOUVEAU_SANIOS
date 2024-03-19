<?php


// récupération de l'alias du véhicule via la methode GET 
if (isset($_GET['alias'])) {
  $immatriculation = $_GET['alias'];
  require __DIR__.'/../vuemodel/arsVueModel.php';
}else{
  header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="media/css/asset.css">
    <title>ARS - <?= $immatriculation ?> </title>
</head>
<body>
    
<header>
<div class="px-3 py-2 bg-light text-dark">
      <div class="container">
      <div class="d-flex  flex-wrap align-items-center my-2 justify-content-evenly mx-3">
        <div class="text-start">
          <ul class="nav col-12 col-lg-auto text-small">
              <li > <i class="fa-solid fa-star-of-life text-primary h2 px-2 pt-4"></i></li>
              <li class="pt-3">  <h1 class="display-2">  Sanios  </h1>  </li>
            </ul>
        </div>
        </div>
      </div>
    </div>
  </header>


 
  <div class="container ">
  <div class="row border">
      <h2 class="h2 bg-whiteBlue p-3 mb-0"> Identitée du véhicule </h2>
    <div class="col-12 px-0">
          <ul class="list-group list-group-flush h4">
          <li class="list-group-item  p-2 w-100 bg-lightBlue ">  <?= $vehicule['societe_nom'] ?></li>
              <li class="list-group-item  mt-2 "> numero véhicule : <?= $vehicule['ancien_id'] ?></li>

              <li class="list-group-item mt-2 "> marque véhicule : <?= $vehicule['marque_nom'] ?></li>

              <li class="list-group-item mt-2"> immatriculation : <?= $immatriculation ?> </li>

              <li class="list-group-item my-2"> date du jour : <?= date('d-m-Y') ?> </li>
              
          </ul>
          </div>
          </div>
          </div>
          <div class="container mt-3">
  <div class="row text-center">

    <div class="col-12">
 <a href="../vue/arsPdfGenerator.php?immatriculation=<?=$immatriculation?>" target="_blank" class="btn w-100 mb-3 btn-primary h3 py-2" > voir le pdf </a>
    </div>

  </div>
</div>

          <div class="container bg-light">
        <div class="row border">
      <h2 class="h2 bg-whiteBlue p-3"> Hygiene du véhicule </h2>
    <div class="col-12">


 


  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Date de l'hygiène </th>
      <th scope="col">Type d'hygiène</th>
      <th scope="col">Personnel</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach ($hygienesDatas as $data) : ?>

    <tr>
     
      <td>  <?= $data['date'] ?></td>
      <input type="hidden" name="date" value="<?=$data['date'] ?>" >
      <td> <?= $data['hygieneNom'] ?>  </td>
      <input type="hidden" name="hygieneNom" value="<?=$data['hygieneNom'] ?>" >
      <td><?= $data['userName'] ?></td>
      <input type="hidden" name="userName" value="<?=$data['userName'] ?>" >

    </tr>

  <?php endforeach; ?>
  </tbody>
</table>

    </div></div>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>