{include file="_menu.tpl"}

<div class="content ui-corner-all">
   <h2>Zmiana hasła {if !empty($dlaLoginu)} dla loginu: {$dlaLoginu}{/if}</h2>
   <div style="width: 230px; margin: 100px auto;" class="right d2 space">
      <form method="post" onSubmit="return chgPassFormCheck()">
         {if !empty($dlaLoginu)}<input type="hidden" name="dlaLoginu" value="{$dlaLoginu}"> {/if}
         stare hasło: <input type="password" id="p1" name="oldpass">
          nowe hasło: <input type="password" id="p2" onKeyUp="chgPassFormCheck()" name="newpass">
             powtórz: <input type="password" id="p3" onKeyUp="chgPassFormCheck()" name="newpass2">
         <button>
            <span class="ui-icon ui-icon-check"></span>
            zmień hasło
         </button>
      </form>
   </div>
</div>
<script type="text/javascript">
   $("#p1").focus();
   function chgPassFormCheck()
   {
      $('#p1,#p2,#p3').removeClass('bad');
      if ($('#p2').val().length < 6)
      {
         $('#p2').addClass('bad');
         return false;
      }
      if ($('#p2').val()!=$('#p3').val())
      {
         $('#p3').addClass('bad');
         return false;
      }
      return true;
   }
</script> 