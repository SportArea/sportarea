<?php

namespace SportArea\Core;

use Application\Settings\SettingsModel;
use SportArea\Core\Utils;

class Email
{

    private $_attachment_string;

    public function addAttachmentString($content, $name, $type = 'application/octet-stream')
    {
        if (!isset($this->_attachment_string)) {
            $this->_attachment_string = array();
        }
        array_push($this->_attachment_string, array('content' => $content, 'name' => $name, 'type' => $type));
    }

    public function getAttachmentString()
    {
        return $this->_attachment_string;
    }

    public function send($email, $title, $body)
    {
        require_once(dirname(__FILE__) .'/PHPMailer/class.phpmailer.php');
        $mail = new \PHPMailer();

		//$mail->IsSMTP(); // telling the class to use SMTP
		$mail->IsMail();
		$mail->Host       = 'smtp.gmail.com';   // SMTP server
		$mail->SMTPDebug  = false;              // enables SMTP debug information (for testing)
		// 1 = errors and messages
		// 2 = messages only
		$mail->SMTPAuth   = false;              // enable SMTP authentication
		$mail->SMTPSecure = 'tls';				// sets the prefix to the servier
		$mail->Host       = 'localhost';	    // sets GMAIL as the SMTP server
		$mail->Port       = 25;                 // set the SMTP port for the GMAIL server
		$mail->Username   = '';					// GMAIL username
		$mail->Password   = '';					// GMAIL password

		$mail->SetFrom(SettingsModel::get('email_address'), SettingsModel::get('email_name'));
		$mail->AddReplyTo(SettingsModel::get('email_address'), SettingsModel::get('email_name'));

        $mail->Subject = $title;

        $attachmentString = $this->getAttachmentString();
        if (is_array($attachmentString)) {
            foreach ($attachmentString as $attachment) {
                $mail->AddStringAttachment($attachment['content'], $attachment['name'], 'base64', $attachment['type']);
            }
        }

        $toReplace = array(
            '{base_url}'        => BASE_URL,
            '{content}'         => $body,
            '{current_year}'    => date('Y')
        );

        $content = str_replace(array_keys($toReplace), array_values($toReplace), file_get_contents(ROOT . '/templates/email.html.php'));

        $mail->AltBody = Utils::compressSpaces(strip_tags($content));
        $mail->MsgHTML(Utils::htmlMinifier($content));

        $mail->AddAddress($email, '');

        if (!$mail->Send()) {
            return false;
        } else {
            //LoguriLoguriModel::add(LoguriLoguriModel::ACTIUNE_CREATE, "E-mail a fost trimis la {$email}, subiect: {$title}");
            return true;
        }
    }

}
