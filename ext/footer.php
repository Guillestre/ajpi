<!-- FOOTER -->

<?php

  /* BUTTONS MANAGER */

  //Set pages where history pages is needed
  $backPages = array("client.php", "invoice.php", "secret.php");

  //Set pages where pagination is needed
  $paginationPages = array("dashboard.php");

  if(in_array($currentPage, $backPages))
  {

?>

  <div class="footer">

    <div>
      <button onclick="history.back()">
        Retour
      </button>
    </div>
    
  </div>


<?php } else if(in_array($currentPage, $paginationPages)) { ?>

  <div class="footer">

    <div>
      <?php  if($previousAvailable && !$emptyResult) { ?>
        <button type="submit" name="previousButton" form="invoiceTableForm">
          Page précédente
        </button>
      <?php } ?>
    </div>

    <div style="text-align: right;">
      <?php if($nextAvailable && !$emptyResult) { ?>
        <button type="submit" name="nextButton" form="invoiceTableForm">
          Page suivante
        </button>
      <?php } ?>
    </div>

  </div>

<?php } ?>