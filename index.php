<?php
require_once 'vendor/autoload.php';

/**
 * UITLISER MAILCATCHER AVEC SWIFTMAILER.
 * https://mailcatcher.me/
 *
 * BUT : 
 * Catcher les emails sur l'url http://127.0.0.1:1080/
 * On simule un shoot d'email, nous permettant de visualiser un "webmail" sur http://127.0.0.1:1080/
 * 
 * DOC : 
 * - MailCatcher : https://mailcatcher.me/ / https://github.com/sj26/mailcatcher
 * - SwiftMailer : https://swiftmailer.symfony.com/docs/introduction.html
 *
 * INSTALL :
 * gem install mailcatcher
 * mailcatcher
 * Go to http://localhost:1080/
 * Send mail through smtp://localhost:1025
 * 
 * URL TEST : 
 * - http://mailcatcher.oo:8888/
 *
 * API :
 * https://mailcatcher.me/ (more informations)
 * http://127.0.0.1:1080/messages
 * 		[{"id":1,"sender":"<john@doe.com>","recipients":["<receiver@domain.org>","<other@domain.org>"],"subject":"Wonderful Subject","size":"348","created_at":"2018-06-30T07:51:52+00:00"},{"id":2,"sender":"<john@doe.com>","recipients":["<receiver@domain.org>","<other@domain.org>"],"subject":"Wonderful Subject","size":"348","created_at":"2018-06-30T08:02:56+00:00"}]
 * http://127.0.0.1:1080/messages/1:id.json
 * 		{"id":1,"sender":"<john@doe.com>","recipients":["<receiver@domain.org>","<other@domain.org>"],"subject":"Wonderful Subject","source":"Message-ID: <bdde25d1f2b6e72d00c333472e7bbb01@mailcatcher.oo>\r\nDate: Fri, 30 Jun 2018 07:51:51 +0000\r\nSubject: Wonderful Subject\r\nFrom: John Doe <john@doe.com>\r\nTo: receiver@domain.org, A name <other@domain.org>\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: quoted-printable\r\n\r\nHere is the message itself\r\n","size":"348","type":"text/plain","created_at":"2018-06-30T07:51:52+00:00","formats":["source","plain"],"attachments":[]}
 * http://127.0.0.1:1080/messages/1:id.html
 * 		"Here is the message <b>itself</b>"
 * http://127.0.0.1:1080/messages/1:id.plain
 * 		Here is the message itself
 * http://127.0.0.1:1080/messages/1:id/:cid
 * http://127.0.0.1:1080/messages/1:id.source
 * 		Message-ID: <bdde25d1f2b6e72d00c333472e7bbb01@mailcatcher.oo>
		Date: Fri, 30 Jun 2018 07:51:51 +0000
		Subject: Wonderful Subject
		From: John Doe <john@doe.com>
		To: receiver@domain.org, A name <other@domain.org>
		MIME-Version: 1.0
		Content-Type: text/plain; charset=utf-8
		Content-Transfer-Encoding: quoted-printable

		Here is the message itself
 *
 * (ou le chiffre "1" est l'id de l'email)
 */

//-----------------------------------------------------------------------
// DISPLAY
//-----------------------------------------------------------------------

echo 'Mail ('.date("Y-m-d H:i:s").')<br>';

//-----------------------------------------------------------------------
// EMAIL
// https://swiftmailer.symfony.com/docs/messages.html
//-----------------------------------------------------------------------

// Create the Transport
$transport = (new Swift_SmtpTransport('127.0.0.1', 1025))
  ->setUsername('')
  ->setPassword('')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['john@doe.com' => 'John Doe'])
  ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
  ->setBody('Here is the message itself')

  // And optionally an alternative body
  ->addPart('<q>Here is the message <b>itself</b></q>', 'text/html')

  // Optionally add any attachments
  ->attach(Swift_Attachment::fromPath('aaa.pdf'))
  ;

// Send the message
$result = $mailer->send($message);
