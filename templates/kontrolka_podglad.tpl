
<style type="text/css">
div.component_{$name|urlencode}:hover {
   border: 1px dashed #ddd;
}
div.component_{$name|urlencode} {
   border: 1px dashed transparent;
   {$css}
}
div.component_{$name|urlencode} > .pv-movable-handle {
	display:none;
	position: absolute;
	width: 16px;
	height: 16px;
	border: 1px dashed gray;
	background-color: white;
	opacity: 0.5;
	z-index:999;
	margin-top: -8px;
	margin-left: -8px;
	
}

</style>
<body style="background-color: #fff">
   <div class="component_{$name|urlencode}" id="previewDiv"><span class="pv-movable-handle ui-icon ui-icon-arrow-4"></span>{$html}</div>
   <script type="text/javascript">
      $(function(){
         $('#previewDiv')
            .resizable()
            .draggable({ handle: '.pv-movable-handle' })
            .css('top', function(){ return ($(document).height()-$(this).height())/2; })
            .css('left', function(){ return ($(document).width()-$(this).width())/2; })
			.hover(
				function(){ $(this).find('.pv-movable-handle').show() },
				function(){ $(this).find('.pv-movable-handle').hide() }
			);
      });
      
      $(".component_{$name|urlencode}").each(function(){
         {$js}
      });
   </script>
