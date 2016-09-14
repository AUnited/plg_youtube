<?php
/**
* @ 2013 Benj Golding. All rights reserved.
* @GNU/GPL licence
*
*/

// Assert file included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
* YouTube Content Plugin
*
*/
class plgContentYoutubePlugin extends JPlugin
{

	/**
	* Ctor
	*
	* @param object $subject The object to observe
	* @param object $params The object that holds the plugin parameters
	*/
	function PluginYoutube( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	/**
	* Example prepare content method
	*
	* Method is called by the view
	*
	* @param object The article object. Note $article->text is also available
	* @param object The article params
	* @param int The 'page' number
	*/
	function onContentPrepare ( $context, &$article, &$params, $page = 0)
		{
		global $mainframe;
		

		if ( JString::strpos( $article->text, '{youtube}' ) === false || JString::strpos( $article->text, '{youpl}' ) === false) {
		return true;
		}

		$article->text = preg_replace_callback('|{youtube}(.*){\/youtube}|',function ($match){return $this->embedVideo($match[1]);}, $article->text);

        $article->text = preg_replace_callback('|{youpl}(.*){\/youpl}|',function ($match){return $this->plVideo($match[1]);}, $article->text);



		return true;
	
	}

	function embedVideo($vCode)
	{

	 	$params = $this->params;

		$width = $params->get('width', 425);
		$height = $params->get('height', 344);
	
		return '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$vCode.'" frameborder="0" allowfullscreen></iframe>';
	}

	function plVideo($vCode)
    {

        $params = $this->params;

        $width = $params->get('width', 425);
        $height = $params->get('height', 344);

        return '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/videoseries?list='.$vCode.'" frameborder="0" allowfullscreen></iframe>';
    }

}
