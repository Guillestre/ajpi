<!-- REFRESH CURRENT PAGE JUST ONCE -->
 
<?php
  
  //Pages authorized to be reload to be sure to display correct data
  $reloadPages = array("userManagement.php", "secretManagement.php");
  if(in_array($currentPage, $reloadPages)){
    
?>

  <script type='text/javascript'>
   (function()
   {
    if( window.localStorage ){
      if(!localStorage.getItem('firstReLoad')){
       localStorage['firstReLoad'] = true;
       window.location.reload();
      } else {
       localStorage.removeItem('firstReLoad');
      }
    }
   })();
  </script>

<?php } ?>

<!-- IMPORT AWESOME FONT ------->

<script src="https://kit.fontawesome.com/3e8a897278.js" crossorigin="anonymous"></script>