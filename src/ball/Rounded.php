<?php
namespace Subsof\Iqr\Ball;
class Rounded {
  public static function get() {
    $shape = "roundedSquare";
    $yxArray = [
      [6,6],
      [6,count($GLOBALS['iqr']['matrix'])-9],
      [count($GLOBALS['iqr']['matrix']) -9, 6]
    ];
    $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
    if(!$GLOBALS['iqr']['gradient']) {
      // $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
      $css .= 'fill: ' . $GLOBALS['iqr']['colors']['body'] . ';';
      $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['body'] . ';';
    }
    $css .= 'stroke-width: 0px;';
    $svg = ""; $ctr = 0;
    foreach($yxArray as $row) {
      $y = $row[0]*10; $x = $row[1]*10;
      // $rotation = 0;
      // if($ctr == 1) {$rotation = 90;}
      // if($ctr == 2) {$rotation = 270;}
      // $svg .= "<{$GLOBALS['iqr']['svgShapes']['eyeBalls'][$shape]['element']} d='{$GLOBALS['iqr']['svgShapes']['eyeBalls'][$shape]['d']}' style='{$css}' transform='translate({$x},{$y}) rotate({$rotation}, 15, 15)' />";
      $d = "M ".($x).",".($y+10.5)." Q ".($x).",".($y)." ".($x+10.5).",".($y)." L ".($x+19.5).",".($y)." Q ".($x+30).",".($y)." ".($x+30).",".($y+10.5)." L ".($x+30).",".($y+19.5)." Q ".($x+30).",".($y+30)." ".($x+19.5).",".($y+30)." L ".($x+10.5).",".($y+30)." Q ".($x).",".($y+30)." ".($x).",".($y+19.5)." L ".($x).",".($y+10.5)."";
      $svg .= '<path d="'.$d.'" style="'.$css.'" />';
      $ctr++;
    }
    return $svg;
  }
}
