<?php
# @ 2013 Benj Golding. All rights reserved. GNU/GPL licence
# @ 2014-2016 Vitaliy Zhukov. All rights reserved. GNU/GPL v3 licence

# Assert file included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

#YouTube Content Plugin
class plgContentyoutube extends JPlugin
{

	function PluginYoutube( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	function onContentPrepare ( $context, &$article, &$params, $page = 0)
		{
		global $mainframe;

		if ( JString::strpos( $article->text, '{youtube}' ) === false ) {
		return true;
		}

		$article->text = preg_replace_callback('|{youtube}(.*){\/youtube}|',function ($match){return $this->embedVideo($match[1]);}, $article->text);
		return true;
	}

	function embedVideo($vCode)
	{
	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
        $confidence = $params->get('confidence', 0);
        $fullscreen = $params->get('fullscreen', 1);

        #Logic
        if($confidence) $url='www.youtube-nocookie.com'; else $url='www.youtube.com';
        if($fullscreen) $fscr=' allowfullscreen'; else $fscr='';
	
		return '<iframe width="'.$width.'" height="'.$height.'" src="https://'.$url.'/embed/'.$vCode.'" frameborder="0"'.$fscr.'></iframe>';
	}

	function plVideo($vCode)
    {
        $params = $this->params;

        $width = $params->get('width', 425);
        $height = $params->get('height', 344);
        $confidence = $params->get('confidence', 0);
        $fullscreen = $params->get('fullscreen', 1);

        #Logic
        if($confidence) $url='www.youtube-nocookie.com'; else $url='www.youtube.com';
        if($fullscreen) $fscr=' allowfullscreen'; else $fscr='';

        return '<iframe width="'.$width.'" height="'.$height.'" src="https://'.$url.'/embed/videoseries?list='.$vCode.'" frameborder="0" '.$fscr.'></iframe>';
    }
}
