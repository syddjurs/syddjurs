<?php

/**
 * @file
 * Customize the e-mails sent by Webform after successful submission.
 *
 * This file may be renamed "webform-mail-[nid].tpl.php" to target a
 * specific webform e-mail on your site. Or you can leave it
 * "webform-mail.tpl.php" to affect all webform e-mails on your site.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $submission: The webform submission.
 * - $email: The entire e-mail configuration settings.
 * - $user: The current user submitting the form.
 * - $ip_address: The IP address of the user submitting the form.
 *
 * The $email['email'] variable can be used to send different e-mails to different users
 * when using the "default" e-mail template.
 */
?>

<?php print ($email['html'] ? '<p>' : ''). t('Hej ').$submission->data[1]['value'][0] .($email['html'] ? '<p>' : '')  ?>

<?php print ($email['html'] ? '<p>' : '') .$submission->data[3]['value'][0].  t(' har sendt dig et julekort') .  ($email['html'] ? '<p>' : '')  ?>

<?php print ($email['html'] ? '<p>' : ''). t('Se julekortet her ').url("julekort",array('absolute' => TRUE))."/".md5($submission->sid).($email['html'] ? '<p>' : '')   ?>



