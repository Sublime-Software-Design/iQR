<?php 
namespace Ssd\Iqr\Frame;
class Standard {
  public static function get() {
    $yxArray = [
      [4,4],
      [4,count($GLOBALS['iqr']['matrix'])-11],
      [count($GLOBALS['iqr']['matrix']) -11, 4]
    ];
    $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
    $css .= 'fill: ' . $GLOBALS['iqr']['colors']['ball'] . ';';
    $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['ball'] . ';'; 
    $css .= 'stroke-width: 0px;';
    $svg = "";
    foreach($yxArray as $row) {
      $y = $row[0]*10; $x = $row[1]*10;
      $rotation = 0;
      $svg .= "<{$GLOBALS['iqr']['svgShapes']['eyeFrames']['square']['element']} d='{$GLOBALS['iqr']['svgShapes']['eyeFrames']['square']['d']}' style='{$css}' transform='translate({$x},{$y})' />";
    }
    return $svg;
  }

}
?>