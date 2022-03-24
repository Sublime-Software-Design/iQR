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
    if(!$GLOBALS['iqr']['gradient']) {
      // $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
      $css .= 'fill: ' . $GLOBALS['iqr']['colors']['frame'] . ';';
      $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['frame'] . ';';
    }
    $css .= 'stroke-width: 0px;';
    $svg = ""; $ctr = 0;
    foreach($yxArray as $row) {
      $y = $row[0]*10; $x = $row[1]*10;
      $d = "M ".($x).",".($y+25)." Q ".($x).",".($y)." ".($x+25).",".($y)." L ".($x+45).",".($y)." Q ".($x+70).",".($y)." ".($x+70).",".($y+25)." L ".($x+70).",".($y+45)." Q ".($x+70).",".($y+70)." ".($x+45).",".($y+70)." L ".($x+25).",".($y+70)." Q ".($x).",".($y+70)." ".($x).",".($y+45)." L ".($x).",".($y+25)." L ".($x+10).",".($y+25)." L ".($x+10).",".($y+45)." Q ".($x+10).",".($y+60)." ".($x+25).",".($y+60)." L ".($x+45).",".($y+60)." Q ".($x+60).",".($y+60)." ".($x+60).",".($y+45)." L ".($x+60).",".($y+25)." Q ".($x+60).",".($y+10)." ".($x+45).",".($y+10)." L ".($x+25).",".($y+10)." Q ".($x+10).",".($y+10)." ".($x+10).",".($y+25)."";
      $svg .= '<path d="'.$d.'" style="'.$css.'" />';
      $ctr++;
    }
    return $svg;
  }
}
