<?php
// M 10,0 Q 0.75,0.75 0,10 L 10,10 Q 5,5 10,0
namespace Subsof\Iqr\Body;
class Liquid {
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
          // 0 degrees        => M 10,0 Q 0.75,0.75 0,10 L 10,10 Q 5,5 10,0
          // 90 degrees       => M 10,10 Q 10,0 0,0 L 0,10 Q 5,5 10,10
          // 180 degrees      => M 0,10 Q 10,10 10,0 L 0,0 Q 5,5 0,10
          // 270 degrees      => M 0,0 Q 0,10 10,10 L 10,0 Q 5,5 0,0
          $d = "M ".($x+10).",".($y)." Q ".($x+0.75).",".($y+0.75)." ".($x).",".($y+10)." L ".($x+10).",".($y+10)." Q ".($x+7.5).",".($y+5)." ".($x+10).",".($y)."";
          if($data['connecting'] == [0,0,0,1]) {
            $d = "M ".($x+10).",".($y+10)." Q ".($x+10).",".($y)." ".($x).",".($y)." L ".($x).",".($y+10)." Q ".($x+5).",".($y+7.5)." ".($x+10).",".($y+10)."";
          }
          if($data['connecting'] == [1,0,0,0]) {
            $d = "M ".($x).",".($y+10)." Q ".($x+10).",".($y+10)." ".($x+10).",".($y)." L ".($x).",".($y)." Q ".($x+2.5).",".($y+5)." ".($x).",".($y+10)."";
          }
          if($data['connecting'] == [0,1,0,0]) {
            $d = "M ".($x).",".($y)." Q ".($x).",".($y+10)." ".($x+10).",".($y+10)." L ".($x+10).",".($y)." Q ".($x+5).",".($y+2.5)." ".($x).",".($y)."";
          }
          $svg .= '<path d="'.$d.'" style="'.$css.'" />';
        }else if($connecting == 2){
          if($data['connecting'] == [1,1,0,0] || $data['connecting'] == [0,1,1,0] || $data['connecting'] == [0,0,1,1] || $data['connecting'] == [1,0,0,1]) {
            $d ="M ".($x+10).",".($y+10)." L ".($x+10).",".($y)." Q ".($x).",".($y)." ".($x).",".($y+10)."";
            if($data['connecting'] == [0,0,1,1]) {
              $d ="M ".($x).",".($y+10)." L ".($x+10).",".($y+10)." Q ".($x+10).",".($y)." ".($x).",".($y)."";
            }
            if($data['connecting'] == [1,0,0,1]) {
              $d ="M ".($x).",".($y)." L ".($x).",".($y+10)." Q ".($x+10).",".($y+10)." ".($x+10).",".($y)."";
            }
            if($data['connecting'] == [1,1,0,0]) {
              $d ="M ".($x+10).",".($y)." L ".($x).",".($y)." Q ".($x).",".($y+10)." ".($x+10).",".($y+10)."";
            }
            $svg .= '<path d="'.$d.'" style="'.$css.'" />';
          }else{
            $svg .= "<rect x='{$x}' y='{$y}' width='10' height='10' style='{$css}' />";
          }
        }else{
          $svg .= "<rect x='{$x}' y='{$y}' width='10' height='10' style='{$css}' />";
        }
      }
    }
    return $svg;
  }
}
?>