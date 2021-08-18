<?php
    //FORZAMOS OCULTAR NOTICES 
    error_reporting(E_ALL ^ E_NOTICE);
    require('controller/captura_mails.php');

    //creamos el objeto
    $obtieneMails = new OptieneMails();
    // $obtieneMails->obtenerAsuntosDelMails("belenoalexande16@gmail.com", "beleno0516", "13-AUG-2021");

    isset($_POST['btn_consultar']) ? $resp=$obtieneMails->obtenerAsuntosDelMails($_POST) : NULL;
    // var_dump('<pre/>',$resp);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correos | Captura bandeja entrada</title>
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css">    
    <link rel="stylesheet" href="bootstrap-5.0.2/icons-1.5.0/font/bootstrap-icons.css">
    <script src="bootstrap-5.0.2/js/bootstrap.min.js" ></script>
</head>
<body>
    <div class="container">
        <div class="col-12 mt-3">
            <p class="fs-2 text-center fw-bold text-primary">CONSULTAR BANDEJA DE ENTRADA | <i class="bi bi-inboxes-fill"></i></p>
        </div>
        <div class="row pt-0">
            <div class="col-7">
                <form  method="POST">
                <?php
                    echo $obtieneMails->tablaInicioSessionCorreo(); 
                ?>
                </form>
            </div>
            <!-- <div class="col-5">
                <div class="ratio ratio-1x1">
                    <iframe src="https://www.lupajuridica.com.co/prueba_laboratorio/services/mensajeria/envio_masivo.php?a=a&men=2021"  allowfullscreen></iframe>
                </div>
            </div> -->
        </div>

        <div class="row">
            <?php
                if ($resp != false) {
                //    echo "CANTIDAD DE CORREOS (".$resp[1]['cantidad_mails'].")";
            ?>
            <div class="col-12">
                <table class="table">
                    <thead class="table-success ">
                        <tr>
                            <th colspan="5" class="text-center fs-5">CANTIDAD CORREOS EN BANDEJA (<?= $resp[1]['cantidad_mails']; ?>)</th>
                        </tr>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">EMISOR</th>
                            <th scope="col">ASUNTO</th>
                            <th scope="col">CUERPO DEL CORREO</th>
                            <th scope="col">ARCHIVO(S)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col">1</th>
                            <td scope="col">Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="col">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@mdo</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="col">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@mdo</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>