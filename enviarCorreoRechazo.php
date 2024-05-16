<?php

    $variables = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once 'PHPMailVendor/vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        // Configure PHPMailer
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        // Configure SMTP Server
        $mail->Host = 'mx98.hostgator.mx';
        $mail->Username = 'soporte@vvnorth.com';
        $mail->Password = 'eBZ6_$H2Sl-z';
    
        // Configure Email1
        $envia =  'Evidencia '.$variables['status'];
        $mail->setFrom('soporte@vvnorth.com', $envia);
        
        if($variables['status']=='Rechazada'){
            $correo = $variables['correo']; 
            $asunto = 'Evidencia rechazada del mes '.$variables['mes'].' - '.$variables['anio'];
            $Body = 'Se rechazó la evidencia.<br><br>
            <b>Proyecto:</b> '.$variables['nombre_proyecto'].'<br>
            <b>Motivo:</b> '.$variables['motivo'].'<br>
            <b>Mes y Año:</b> '.$variables['mes'].' / '.$variables['anio'];
        }
        if($variables['status']=='Aceptada'){ 
            $correo = $variables['correo']; 
            $asunto = 'Evidencia aceptada';
            $Body = 'Se acepto la evidencia.<br><br>
            <b>Proyecto:</b> '.$variables['nombre_proyecto'].'<br>
            <b>Mes y Año:</b> '.$variables['mes'].' / '.$variables['anio'];
        }
        if($variables['status']=='Corregida'){ 
            $correo = 'fgomez@enerya.com';
            $asunto = 'Evidencia corregida';
            $Body = 'Se corrigió la evidencia.<br><br>
            <b>Proyecto:</b> '.$variables['nombre_proyecto'].'<br>
            <b>Motivo:</b> '.$variables['motivo'].'<br>
            <b>Mes y Año:</b> '.$variables['mes'].' / '.$variables['anio'];

        }

        $mail->addAddress($correo);
        $mail->AddCC('gvillanuevap@enerya.com');
        //$mail->AddCC('gvillanuevap@enerya.com');
        //$mail->addAttachment($numeroAuditoria.'.xls',$numeroAuditoria.'.xls');
        $mail->Subject = $asunto;
        $mail->isHTML(true);
        $mail->Body=$Body;
        // send mail
        if($mail->Send()){
            echo json_encode(true);
               // echo "CORREO ENVIADO CON EXITO, AL CORREO AUDITOR: ".$correo_auditor." Y CORREO RESPONSABLE: ".$correo_responsable;
            }else{
                echo json_encode("correo no enviado".$mail->ErrorInfo);
               // echo 'NO SE ENVIO EL CORREO.';
            }
        } catch (Exception $e) {
            echo json_encode('No logramos enviar el correo: '. $mail->ErrorInfo);
        }
?>