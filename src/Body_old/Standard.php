<?php
namespace Subsof\Iqr\Body;
class Standard {
  public static function get() {
    $imgSize = count($GLOBALS['iqr']['matrix']) * 10;
    $css = '-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px;';
    $css .= 'fill: ' . $GLOBALS['iqr']['colors']['body'] . ';';
    $css .= 'stroke: ' . $GLOBALS['iqr']['colors']['body'] . ';';
    $css .= 'stroke-width: 0px;';
    $svg = "";
    foreach($GLOBALS['iqr']['matrixExtra'] as $key => $data) {
      $yx = explode(':', $key);
      $y = $yx[0]*10; $x = $yx[1]*10;
      if($data['state'] == 1) {
        $svg .= '<rect x="'.$x.'" y="'.$y.'" width="10" height="10" style="'.$css.'" />';
      }
    }
    return $svg;
  }

}
?>
