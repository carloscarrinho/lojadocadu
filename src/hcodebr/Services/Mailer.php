<?php

namespace Hcode\Services;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Rain\Tpl;

class Mailer
{
    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName, $data = [])
    {
        Tpl::configure([
            "tpl_dir" => $_SERVER['DOCUMENT_ROOT'] . CONF_VIEW_DIR_EMAIL,
            "cache_dir" => $_SERVER['DOCUMENT_ROOT'] . CONF_VIEW_DIR_CACHE,
            "debug" => false,
        ]);

        $tpl = new Tpl();

        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
        }

        $html = $tpl->draw($tplName, true);

        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Debugoutput = 'html';
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = CONF_MAIL_USERNAME;
        $this->mail->Password = CONF_MAIL_PASSWORD;
        $this->mail->setFrom(CONF_MAIL_USERNAME, CONF_MAIL_FROM);
        $this->mail->addAddress($toAddress, $toName);
        $this->mail->Subject = $subject;
        $this->mail->msgHTML($html);
        $this->mail->AltBody = 'Esta é uma mensagem de teste';
    }

    public function send()
    {
        try {
            return $this->mail->send();
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
}
