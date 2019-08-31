<?php

namespace Boussaid\Tips;

class Dev 
{	
    public static function hashes()
    {
    }
    
    public static function devBranding()
    {
        $text = 'Tips By <a target="_blank" href="https://github.com/boussaid/">BOUSSAID Mustafa</a>';
        return \XF::app()->templater()->formRow(
            self::hashes() ? '' : $text, []
        );
    }
}