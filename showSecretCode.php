<?php 

include "ext/common.php";

$redirection = "location:javascript://history.go(-1)";

if(!isset($_GET['secretId']))
	header($redirection);


$secretId = $_GET['secretId'];
$label = $secretDao->getLabel($secretId);

if(!$secretDao->exist($label))
	header($redirection);

if($isAdmin)
	print($secretDao->getCode($secretId));

if(!$isAdmin)
{
	if($user->getSecretId() == $secretId)
		print($secretDao->getCode($secretId));
	else
		header($redirection);
}

?>