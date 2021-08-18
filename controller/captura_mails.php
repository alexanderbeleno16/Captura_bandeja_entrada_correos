<?php 
class OptieneMails{

    var $mailbox="{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";

    function __construct() {
        
    }
    
    //metodo que realiza todo el trabajo
    function obtenerAsuntosDelMails($post=[]){
        $resp = false;
        $user=$post['txt_user'];
        $pass=$post['txt_pass'];
        $fecha=isset($post['fecha']) ? "13-AUG-2021" : "13-AUG-2021";
        // var_dump('<pre/>', $fecha);

        //realizamos la conexión por medio de nuestras credenciales
        if(@$conexion = imap_open($this->mailbox, $user, $pass)):
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="fs-2 fw-bold"><i class="bi bi-check-circle-fill"></i> Success, conexion con el correo exitosa </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            $resp = $this->extraerDatosMails($conexion, $fecha);
            // var_dump('<pre/>',$resp);
            // exit();
        else:
            echo'
                <div class="alert alert-danger" role="alert"> 
                <p class="fs-2 fw-bold"><i class="bi bi-x-circle-fill"></i> Error, el usuario o contraseña son incorrectos </p>
                <strong class="fs-5">Descripción del error: </strong> '.imap_last_error().
                '</div>  ';
            $resp = false;
        endif;
 
        return $resp;
    }

    function extraerDatosMails($conx, $fecha){
        //con la instrucción SINCE mas la fecha entre apostrofes ('')
        //indicamos que deseamos los mails desde una fecha en especifico
        //imap_search sirve para realizar un filtrado de los mails.
        if ($fecha) {
            $emails=imap_search($conx,'SINCE "'.$fecha.'"');
        }
        // var_dump('<pre/>',$fecha);
 
         //comprbamos si existen mails con el la busqueda otorgada
        if($emails) {
                //ahora recorremos los mails
            // foreach($emails as $email_number){
                //      //leemos las cabeceras de mail por mail enviando el inbox de nuestra conexión
                //      //enviando el identificdor del mail
                //     $overview=imap_fetch_overview($conexion,$email_number);

                //     //ahora recorremos las cabeceras para obtener el asunto
                //     foreach($overview as $over){

                //         //comprobamos que exista el asunto (subject) en la cabecera
                //         //y si es asi continuamos
                //         if(isset($over->subject)){

                //             //aqui pasa algo curioso
                //             //el asunto vendra con caracteres raros
                //             //para ello anexo una función que lo limpia y lo muestra ya legible
                //             //en lenguaje mortal
                //             $asunto=$this->fix_text_subject($over->subject);

                //             //y aqui simplemente hacemos un echo para mostrar el asunto
                //             echo "Asunto: ".utf8_decode($asunto)."<br/>";
                //             // var_dump($asunto);
                //         }
                //     }

            // }
            
            $inbox = [];
            $num_msg = imap_num_msg($conx);
            // echo('CANTIDAD DE CORREOS ('.$num_msg.')<br/>');

            for($i = 1; $i <= $num_msg; $i++) {
                $inbox[$i] = [
                'index'     => $i,
                'cantidad_mails'   => $num_msg,
                'header'    => imap_headerinfo($conx, $i),
                'body'      => imap_body($conx, $i),
                'structure' => imap_fetchstructure($conx, $i)
                ];
            }

            // var_dump('<pre/>',$inbox[1]['header']);

        }
        
        return $inbox;
    }
 
    //arregla texto de asunto
    function fix_text_subject($str) {
        $subject = '';
        $subject_array = imap_mime_header_decode($str);
 
        foreach ($subject_array AS $obj)
            $subject .= utf8_encode(rtrim($obj->text, "t"));
 
        return $subject;
    }

    //tabla user, pass y filtro fecha
    function tablaInicioSessionCorreo(){
        $tabla = '';

        $tabla .= '<table class="table table-bordered">';

        $tabla .='<thead class="table-secondary">';
            $tabla .='<tr>';
                $tabla .='<th colspan="2" class="text-center fs-5">CREDENCIALES (CORREO) <i class="bi bi-key-fill fs-4"></i> <i class="bi bi-envelope-fill"></i></th>';
            $tabla .='</tr>';
        $tabla .='</thead>';

        $tabla .='<tbody>';
            $tabla .='<tr class="">';
                $tabla .='<td scope="col" class="fw-bold fs-6">CORREO:</td>';
                $tabla .='<td scope="col">
                            <div class="input-group mb-3">
                                <input required type="email" name="txt_user" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </td>';
            $tabla .='</tr>';

            $tabla .='<tr>';
                $tabla .='<td scope="col" class="fw-bold fs-6">CONTRASEÑA:</td>';
                $tabla .='<td scope="col">
                            <div class="input-group mb-3">
                                <input required type="password" name="txt_pass" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </td>';
            $tabla .='</tr>';

            $tabla .='<tr>';
                $tabla .='<th colspan="2" class="text-center fs-5 table-secondary">FILTROS <i class="bi bi-funnel-fill"></i></th>';
            $tabla .='</tr>';
            $tabla .='<tr>';
                $tabla .='<td scope="col" class="fw-bold fs-6">DESDE (fecha):</td>';
                $tabla .='<td scope="col">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="fecha" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                        </td>';
            $tabla .='</tr>';

            $tabla .='<tfoot class="border-0 border border-white">';
                $tabla .='<tr class="">';
                    $tabla .='<td colspan="1" class="text-start">
                                <button type="submit" name="btn_consultar" class="btn btn-primary rounded">CONSULTAR</button>
                            </td>';
                $tabla .='</tr>';
            $tabla .='</tfoot>';
        $tabla .='</tbody>';

    $tabla .='</table>';

    return $tabla;
    }
    
}