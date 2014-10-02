<?php namespace Fbf\LaravelKss;

use \Scan\Kss\Parser;

class KssController extends \BaseController {

	public function index()
	{
	    $kssParser = new Parser( \Config::get('laravel-kss::css_scan_path') );

        $section = FALSE;

        if ( $reference = \Input::get('reference', FALSE) )
        {
            try
        	{
        		$section = $kssParser->getSection($reference);
            }
        	catch ( UnexpectedValueException $e )
        	{
                $section = FALSE;
            }
        }

        $viewFile = \Config::get('laravel-kss::view');

        $meta = array(
            'title' => 'Style Guide',
        );

        return \View::make($viewFile)->with(compact('kssParser', 'reference', 'section', 'meta'));
	}
}