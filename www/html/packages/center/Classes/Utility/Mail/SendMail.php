<?php
namespace DigitalZombies\Center\Utility\Mail;

use TYPO3\CMS\Core\Mail\MailMessage;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class SendMail
{

	/**
	 * sends Email
	 *
	 * @param $bodyContent array
	 * @param $subject string
	 * @param $emailFrom string
	 * @param $emailFromName string
	 * @param $emailTo string
	 * @param $emailToName string
	 * @param $templatePath string
	 * @param $templateName string
	 * @return boolean
	 */
	public static function sendEmail($bodyContent, $subject, $emailFrom, $emailFromName, $emailTo, $emailToName, $templatePath, $templateName)
	{
		$body = EmailFluidTemplate::generateEmailFromTemplate($bodyContent, $templateName, $templatePath, $partialPath = '', $layoutPath = '');

		// Create the message
		$mail = GeneralUtility::makeInstance(MailMessage::class);

		// Prepare and send the message
		// Give the message a subject
		$mail->setSubject($subject);

		// Set the From address with an associative array
		$mail->setFrom(array($emailFrom => $emailFromName));

		// Set the To addresses with an associative array
		$mail->setTo(array($emailTo => $emailToName));

		// Give it a body
		$mail->setBody((string)$body, 'text/html');

		// And finally do send it
		$mail->send();;

		if ($mail) {
			return true;
		} else {
			return false;
		}
	}

}

?>