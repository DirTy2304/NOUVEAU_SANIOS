
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="media/css/asset.css">
    <title>QRCODE</title>
</head>
<body>









<div class="container mt-4">
  <div class="row ">

    <div class="col-md-6">
    <div class="card text-center ">
  <div class="card-header"> HYGIENE - <?=$immatriculation ?> </div>
  <div class="card-body">
    <p class="card-text">
    <?php echo '<img src="'.$pngAbsoluteFilePathRoulant.'" />'; ?>
    </p>


  </div>
</div>
    </div>

    <div class="col-md-6">
    <div class="card text-center ">
  <div class="card-header"> ARS - <?=$immatriculation ?></div>
  <div class="card-body">
    <p class="card-text">
    <?php echo '<img src="'.$pngAbsoluteFilePathArs.'" />'; ?>

    </p>


  </div>
</div>
    </div>

  </div>

  <div class="row mt-5">


<div class="col-md-12 h5 m-auto text-center">
<a target="_blank" class="btn btn-primary px-4 py-2" href="../vue/pdfGenerator.php?roulantpath=<?=$pngAbsoluteFilePathRoulant?>&arspath=<?=$pngAbsoluteFilePathArs?>&id=<?=$immatriculation?>" > Télécharger les fichiers pdf  </a>

</div>

</div>


</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>