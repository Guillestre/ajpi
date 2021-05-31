<?php
	$invoiceCode = $_GET['invoiceCode'];
	$date = $_GET['date'];
	$TTC = $_GET['TTC'];
	$HT = $_GET['HT'];
	$description = $_GET['description'];
?>

<h1>Facture <?php print($invoiceCode); ?></h1>

<p>
	Client :
	<?php 
		$url = 
		"<a href='clients.php?clientCode={$_GET['clientCode']}'>" .
		$_GET['name'] .
		"</a>";
		print($url);
	?>
</p>
	

<p>Date de facturation : <?php print($date);?></p>
<p>Montant TTC : <?php print($TTC);?> €</p>
<p>Montant HT : <?php print($HT);?> €</p>


<?php if(trim($_GET['description']) != ""){ ?>

	<h2>Description : </h2>

	<div id="descriptionBox">
		<?php print("" . $description . ""); ?>
	</div>

<?php } ?>

<?php

	$number = substr($invoiceCode, 2);
	$log_directory = 'AJPI_invoices';

	if (is_dir($log_directory))
	{
        if ($handle = opendir($log_directory))
        {
            //Notice the parentheses I added:
            while(($file = readdir($handle)) !== FALSE)
            {
            	$pattern = "~[^0-9]*${number}[^0-9]*$~";
				if(preg_match($pattern, $file) == 1)
			   		$url = "AJPI_invoices/" . $file;
            }
            closedir($handle);
        }
	}

if(isset($url)){
?>
	<p> <a target="_blank" href= "<?php echo $url; ?>" > Voir fichier PDF </a> </p>
<?php } ?>

