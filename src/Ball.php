<?php
namespace Subsof\Iqr;

class Ball {

  const DEFAULT = 'Standard';
  const ROUNDED = 'Rounded';

  public static function get( $body = null ) {
    if(is_null($body)) {$body = self::DEFAULT;}
    $body = 'Subsof\Iqr\Ball\\'.$body;
    if(!class_exists($body)) {
      throw new \Exception("Invalid EyeBall Type: {$body} !!");
    }else{
      return $body::get();
    }
  }

}
?>
