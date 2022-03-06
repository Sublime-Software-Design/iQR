<?php 
namespace Ssd\Iqr\Body;
class Fluid {
  public static function get() {
    $imgSize = count($GLOBALS['iqr']['matrix']) * 10;
    $thisShape = $GLOBALS['iqr']['svgShapes']['bits']['roundedSquare'];
    $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
    $css .= 'fill: ' . $GLOBALS['iqr']['colors']['body'] . ';';
    $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['body'] . ';'; 
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
          $rotation = 0;
          if($data['connecting'] == [0,0,0,1]) { $rotation = 90; }
          if($data['connecting'] == [1,0,0,0]) { $rotation = 180; }
          if($data['connecting'] == [0,1,0,0]) { $rotation = 270; }
          $svg .= "<{$GLOBALS['iqr']['svgShapes']['bits']['roundedEnd']['element']} d='{$GLOBALS['iqr']['svgShapes']['bits']['roundedEnd']['d']}' style='{$css}' transform='translate({$x},{$y}) rotate({$rotation}, 5, 5)' />";
        }else if($connecting == 2){
          if($data['connecting'] == [1,1,0,0] || $data['connecting'] == [0,1,1,0] || $data['connecting'] == [0,0,1,1] || $data['connecting'] == [1,0,0,1]) {
            $rotation = 0;
            if($data['connecting'] == [0,0,1,1]) { $rotation = 90; }
            if($data['connecting'] == [1,0,0,1]) { $rotation = 180; }
            if($data['connecting'] == [1,1,0,0]) { $rotation = 270; }
            $svg .= "<{$GLOBALS['iqr']['svgShapes']['bits']['roundedCorner']['element']} d='{$GLOBALS['iqr']['svgShapes']['bits']['roundedCorner']['d']}' style='{$css}' transform='translate({$x},{$y}) rotate({$rotation}, 5, 5)' />";
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