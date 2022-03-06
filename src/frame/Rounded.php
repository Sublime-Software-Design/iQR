<?php
namespace Subsof\Iqr\Frame;
class Rounded {
  public static function get() {
    $shape = "roundedSquare";
    $yxArray = [
      [4,4],
      [4,count($GLOBALS['iqr']['matrix'])-11],
      [count($GLOBALS['iqr']['matrix']) -11, 4]
    ];
    $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
    $css .= 'fill: ' . $GLOBALS['iqr']['colors']['ball'] . ';';
    $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['ball'] . ';';
    $css .= 'stroke-width: 0px;';
    $svg = ""; $ctr = 0;
    foreach($yxArray as $row) {
      $y = $row[0]*10; $x = $row[1]*10;
      $rotation = 0;
      if($ctr == 1) {$rotation = 90;}
      if($ctr == 2) {$rotation = 270;}
      $svg .= "<{$GLOBALS['iqr']['svgShapes']['eyeFrames'][$shape]['element']} d='{$GLOBALS['iqr']['svgShapes']['eyeFrames'][$shape]['d']}' style='{$css}' transform='translate({$x},{$y}) rotate({$rotation}, 35, 35)' />";
      $ctr++;
    }
    return $svg;
  }
}
