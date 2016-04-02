{include file="_menu.tpl"}

<div class="content ui-corner-all">
   <h2>Zmiana hasła {if !empty($dlaLoginu)} dla loginu: {$dlaLoginu}{/if}</h2>
   <div class="row">
      <div class="col-sm-12">
         <form class="form-horizontal" method="post" onSubmit="return chgPassFormCheck()">
            {if !empty($dlaLoginu)}<input type="hidden" name="dlaLoginu" value="{$dlaLoginu}"> {/if}
            <div class="form-group">
               <label for="p1" class="col-sm-2 control-label">stare hasło</label>
               <div class="col-sm-10">
                  <input type="password" id="p1" name="oldpass">
               </div>
            </div>
            <div class="form-group">
               <label for="p2" class="col-sm-2 control-label">nowe hasło</label>
               <div class="col-sm-10">
                  <input type="password" id="p2" onKeyUp="chgPassFormCheck()" name="newpass">
               </div>
            </div>
            <div class="form-group">
               <label for="p3" class="col-sm-2 control-label">powtórz nowe hasło</label>
               <div class="col-sm-10">
                  <input type="password" id="p3" onKeyUp="chgPassFormCheck()" name="newpass2">
               </div>
            </div>
            <div class="form-group">
               <div class="col-sm-10 col-sm-offset-2">
                  <button>
                     <span class="ui-icon ui-icon-check"></span>
                     zmień hasło
                  </button>
               </div>
            </div>
         </form>
      </div>
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