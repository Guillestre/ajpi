<!-- REFRESH CURRENT PAGE JUST ONCE -->
 
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

<!-- IMPORT AWESOME FONT ------->

<script src="https://kit.fontawesome.com/3e8a897278.js" crossorigin="anonymous"></script>