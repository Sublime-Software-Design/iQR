<?php 
namespace Ssd\Iqr;

class Body {

  const DEFAULT = 'Standard';
  const FLUID = 'Fluid';

  public static function get( $body = null ) {
    if(is_null($body)) {$body = self::DEFAULT;}
    $body = 'Ssd\Iqr\Body\\'.$body;
    if(!class_exists($body)) {
      throw new \Exception("Invalid Body Type: {$body} !!");
    }else{
      return $body::get();
    }
  }

}
?>