<?php
namespace Subsof\Iqr;

class Frame {

  const DEFAULT = 'Standard';
  const ROUNDED = 'Rounded';

  public static function get( $body = null ) {
    if(is_null($body)) {$body = self::DEFAULT;}
    $body = 'Subsof\Iqr\Frame\\'.$body;
    if(!class_exists($body)) {
      throw new \Exception("Invalid Frame Type: {$body} !!");
    }else{
      return $body::get();
    }
  }

}
?>
