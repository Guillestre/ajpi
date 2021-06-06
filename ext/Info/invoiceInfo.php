<?php
	$invoiceCode = $invoice->getCode();
	$date = $invoice->getDate();
	$TTC = $invoice->getTotalIncludingTaxes();
	$HT = $invoice->getTotalExcludingTaxes();
	$description = $invoice->getDescription();

	$clientCode = $client->getCode();
	$name = $client->getName();
?>

<h1>Facture <?php print($invoiceCode); ?></h1>

<p>
	Client :
	<?php 
		$url = 
		"<a href='client.php?clientCode=${clientCode}'>" . $name . "</a>";
		print($url);
	?>
</p>
	

<p>Date de facturation : <?php print($date);?></p>
<p>Montant TTC : <?php print($TTC);?> €</p>
<p>Montant HT : <?php print($HT);?> €</p>


<?php if(trim($description) != ""){ ?>

	<h2>Description : </h2>

	<div id="boxDescriptionInvoice">
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
            	$pattern = "/([\D])${number}([\D])/";
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

