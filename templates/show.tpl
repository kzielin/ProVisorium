<map name="screenMap">
{foreach from=$areas item="link"}
<area href="/show/{$projekt}/{$link.href}"
   onclick="window.location='show/{$projekt}/{$link.href}" 
   alt="{$link.nazwa}" 
   title="{$link.nazwa}" 
   shape=rect 
   coords="{$link.x1},{$link.y1},{$link.x2},{$link.y2}">
{/foreach}
</map>

<div class="ui-corner-all show center">
   <span class="fr icon-active ui-corner-all ui-icon ui-icon-arrowreturnthick-1-w"
      onClick="window.location='{$smarty.const.BASE_HREF}'"
      title="Powrót do listy pokazów"
   ></span>
   <span class="fr icon-active ui-corner-all ui-icon ui-icon-help"
      onMouseOver="$('#helpArea').fadeIn()"
      onMouseOut="$('#helpArea').fadeOut()"
   ></span>
   <div class=showTitle>{$projektTxt}</div>
   
   <div style="position: relative; display: inline-block;">
      <div id=helpArea class=hide>
      {foreach from=$areas item="link"}
         <div class=helpRegion style="left:{$link.x1}px; top:{$link.y1}px; width:{$link.x2-$link.x1}px; height:{$link.y2-$link.y1}px; "></div>
      {/foreach}
      </div>
      <img src="{$plikSrc}jpg" usemap="#screenMap" border=0>
   </div>
   <div class=clr></div>
</div>
