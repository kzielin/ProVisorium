<?php

function smarty_modifier_contains($haystack, $needle)
{
   return strpos($haystack, $needle) !== false;
} 
