<?php
namespace Subsof\Iqr\Ball;
class Standard {
  public static function get() {
    $imgSize = count($GLOBALS['iqr']['matrix']) * 10;
    $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
    $css .= 'fill: ' . $GLOBALS['iqr']['colors']['ball'] . ';';
    $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['ball'] . ';';
    $css .= 'stroke-width: 0px;';
    $svg = "";

    $yxArray = [
      [6,6],
      [6,count($GLOBALS['iqr']['matrix'])-9],
      [count($GLOBALS['iqr']['matrix']) -9, 6]
    ];
    foreach($yxArray as $row) {
      $y = $row[0]*10; $x = $row[1]*10;
      $rotation = 0;
      $svg .= "<{$GLOBALS['iqr']['svgShapes']['eyeBalls']['square']['element']} width='{$GLOBALS['iqr']['svgShapes']['eyeBalls']['square']['width']}' height='{$GLOBALS['iqr']['svgShapes']['eyeBalls']['square']['height']}' style='{$css}' transform='translate({$x},{$y})' />";
    }
    return $svg;
  }

}
?>
