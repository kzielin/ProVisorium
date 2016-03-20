<?php
/**
 * Smarty plugin
 *
 */
 
function smarty_modifier_base64encode($string)
{
   return base64_encode($string);
}