<div style="width: 400px; margin: 50px auto;" class="center d2 space ui-corner-all">
   <h3>ProVisorium</h3>
    Pomaga układać formatki i udostępnia je on-line
    
   <div class="dtxt left" style="width: 300px; margin: 10px auto;" >
      Wersja testowa. Dostęp dla poszczególnych ról:
      <li>Administrator - login: root hasło: root</li>
      <li>Projektant - login: projektant hasło: projektant</li>
      <li>Użytkownik - login: test hasło: test</li>
   </div>
</div>
<div style="width: 250px; margin: 100px auto;" class="center d2 space ui-corner-all">
   <form method="post" action="" class="form-horizontal" >

      <div class="form-group">
         <label for="login_field" class="col-sm-2 control-label">login</label>
         <div class="col-sm-10">
            <input type="text" name="login" id="login_field">
         </div>
      </div>
      <div class="form-group">
         <label for="pass_field" class="col-sm-2 control-label">hasło</label>
         <div class="col-sm-10">
            <input type="password" id="pass_field" name="pass">
         </div>
      </div>

      <button type="submit">
         <span class="ui-icon ui-icon-check"></span>
         zaloguj
      </button>

   </form>
</div>
<script type="text/javascript">
   if ($("#login_field").val().length == 0 && $("#pass_field").val().length == 0) $("#login_field").focus();
</script> 