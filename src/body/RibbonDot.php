<?php
// M 10,0 Q 0.75,0.75 0,10 L 10,10 Q 5,5 10,0
namespace Subsof\Iqr\Body;
class RibbonDot {
  public static function get() {
    $imgSize = count($GLOBALS['iqr']['matrix']) * 10;
    $css = "";
    if(!$GLOBALS['iqr']['gradient']) {
      // $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
      $css .= 'fill: ' . $GLOBALS['iqr']['colors']['body'] . ';';
      $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['body'] . ';';
    }
    $css .= 'stroke-width: 0px;';
    $svg = "";
    foreach($GLOBALS['iqr']['matrixExtra'] as $key => $data) {
      $yx = explode(':', $key);
      $y = $yx[0]*10; $x = $yx[1]*10;
      if($data['state'] == 1) {
        $connecting = array_sum($data['connecting']);
        if($connecting == 0) {
          $svg .= '<circle cx="'.($x+5).'" cy="'.($y+5).'" r="5" width="10" height="10" style="'.$css.'" />';
        }else if($connecting == 1){
          // 0 degrees        => M 0,10 L 0,0 L 5,3.5 L 10,0 L 10,10
          // 90 degrees       => M 0,0 L 10,0 L 6.5,5 L 10,10 L 0,10
          // 180 degrees      => M 10,0 L 10,10 L 5,6.5 L 0,10 L 0,0
          // 270 degrees      => M 10,10 L 0,10 L 3.5,5 L 0,0 L 10,0
          $d = "M ".($x).",".($y+10)." L ".($x).",".($y)." L ".($x+5).",".($y+3.5)." L ".($x+10).",".($y)." L ".($x+10).",".($y+10)."";
          if($data['connecting'] == [0,0,0,1]) {
            $d = "M ".($x).",".($y)." L ".($x+10).",".($y)." L ".($x+6.5).",".($y+5)." L ".($x+10).",".($y+10)." L ".($x).",".($y+10)."";
          }
          if($data['connecting'] == [1,0,0,0]) {
            $d = "M ".($x+10).",".($y)." L ".($x+10).",".($y+10)." L ".($x+5).",".($y+6.5)." L ".($x).",".($y+10)." L ".($x).",".($y)."";
          }
          if($data['connecting'] == [0,1,0,0]) {
            $d = "M ".($x+10).",".($y+10)." L ".($x).",".($y+10)." L ".($x+3.5).",".($y+5)." L ".($x).",".($y)." L ".($x+10).",".($y)."";
          }
          $svg .= '<path d="'.$d.'" style="'.$css.'" />';
        }else if($connecting == 2){
          $svg .= "<rect x='{$x}' y='{$y}' width='10' height='10' style='{$css}' />";
        }else{
          $svg .= "<rect x='{$x}' y='{$y}' width='10' height='10' style='{$css}' />";
        }
      }
    }
    return $svg;
  }
}
?>