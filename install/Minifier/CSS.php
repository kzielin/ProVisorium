<?php

namespace Install\Minifier;

use MatthiasMullie\Minify;
use MatthiasMullie\PathConverter\Converter;

/**
 * Created by PhpStorm.
 * User: vertex
 * Date: 31.03.16
 * Time: 08:47
 */
class CSS extends Minify\CSS
{
    /**
     * Moving a css file should update all relative urls.
     * Relative references (e.g. ../images/image.gif) in a certain css file,
     * will have to be updated when a file is being saved at another location
     * (e.g. ../../images/image.gif, if the new CSS file is 1 folder deeper).
     *
     * @param Converter $converter Relative path converter
     * @param string $content The CSS content to update relative urls for.
     *
     * @return string
     */
    protected function move(Converter $converter, $content)
    {
        return $content;
    }
}
