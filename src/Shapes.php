<?php 
/* 
shape-rendering="crispEdges"
(strakke randern gelden voor de volgende vormen:)

  <circle>
  <ellipse>
  <line>
  <path>
  <polygon>
  <polyline>
  <rect>


  available body shape classNames:
  - iqr-svg-body-square
  - iqr-svg-body-pointy
  - iqr-svg-body-triangle


*/
namespace Ssd\Iqr;

class Shapes 
{

  public static function square( $color = 'black', $x = 0, $y = 0 ) 
  {
    return '<rect class="iqr-svg-body-square" x="'.$x.'" y="'.$y.'" width="10" height="10" style="fill:'.$color.'; stroke-linecap: square; stroke-width: 0; stroke: '.$color.'" shape-rendering="crispEdges" />';
  }

  public static function circle( $color = 'black', $x = 0, $y = 0) {
    // return '<defs>
    //   <filter id="circf_'.$x.'_'.$y.'" x="0" y="0">
    //     <feGaussianBlur in="SourceGraphic" stdDeviation="0,1" />
    //   </filter>
    // </defs>
    // <circle cx="'.($x + ($bitSize/2)).'" cy="'.($y + ($bitSize/2)).'" r="'.(($bitSize/2)-4).'" stroke="none" stroke-width="0" fill="'.$color.'"shape-rendering="crispEdges" />
    // <circle cx="'.($x + ($bitSize/2)).'" cy="'.($y + ($bitSize/2)).'" r="'.(($bitSize/2)-2).'" stroke="black" stroke-width="2" fill="none" shape-rendering="crispEdges" />';
  }

  public static function triangle( $color = 'black', $x = 0, $y = 0 )
  {
    return '<polygon class="iqr-svg-body-triangel" points="'.($x).','.$y.' '.($x+10).','.($y).' '.($x+(10/2)).','.($y+10).'" style="fill:'.$color.';;stroke-width:0" shape-rendering="crispEdges" />';
  }


  /**
   * POINTY THEME 1 CONNECTED
   */
  public static function pointy( $color = 'black', $x = 0, $y = 0, $rotation = 0 )
  {
    $return = '<g transform="translate('.$x.', '.$y.') ">';
    $return .= '<polygon class="iqr-svg-body-pointy" points="';
    $return .= '0,0 0,10 2.5,10 5,7.5 7.5,10 10,10 10,0';
    $return .= '" style="fill: '.$color.'; stroke-linecap: square; stroke-width: 0.5;" ';
    $return .= 'transform="rotate('.$rotation.', 5, 5)" />';
    $return .= '</g>';
    return $return;
  }

  /**
   * POINTY THEME 2 CONNECTED OPOSITES
   */
  public static function pointyTwoOposite($color = 'black', $x = 0, $y = 0, $rotation = 0)
  {
    $return = '<g transform="translate('.$x.', '.$y.') ">';
    $return .= '<polygon class="iqr-svg-body-pointy" points="';
    $return .= '0,0 0,10 2.5,10 5,7.5 7.5,10 10,10 10,0 7.5,0 5,2.5 2.5,0';
    $return .= '" style="fill: '.$color.'; stroke-linecap: square; stroke-width: 0.5;" ';
    $return .= 'transform="rotate('.$rotation.', 5, 5)" />';
    $return .= '</g>';
    return $return;
  }

  /**
   * POINTY THEME 2 CONNECTED ONE CORNER
   */
  public static function pointyTwoSide($color = 'black', $x = 0, $y = 0, $rotation = 0)
  {
    $return = '<g transform="translate('.$x.', '.$y.') ">';
    $return .= '<polygon class="iqr-svg-body-pointy" points="';
    $return .= '0,0 0,10 2.5,10 5,7.5 7.5,10 10,10 10,7.5 7.5,5 10,2.5 10,0';
    $return .= '" style="fill: '.$color.'; stroke-linecap: square; stroke-width: 0.5;" ';
    $return .= 'transform="rotate('.$rotation.', 5, 5)" />';
    $return .= '</g>';
    return $return;
  }

  /**
   * POINTY THEME 3 CONNECTED
   */
  public static function pointyTrheeSide($color = 'black', $x = 0, $y = 0, $rotation = 0)
  {
    $return = '<g transform="translate('.$x.', '.$y.') ">';
    $return .= '<polygon class="iqr-svg-body-pointy" points="';
    $return .= '0,0 0,10 2.5,10 5,7.5 7.5,10 10,10 10,7.5 7.5,5 10,2.5 10,0 7.5,0 5,2.5 2.5,0';
    $return .= '" style="fill: '.$color.'; stroke-linecap: square; stroke-width: 0.5;" ';
    $return .= 'transform="rotate('.$rotation.', 5, 5)" />';
    $return .= '</g>';
    return $return;
  }

  /**
   * POINTY THEME 4 CONNECTED
   */
  public static function cross($color = 'black', $x = 0, $y = 0, $rotation = 0)
  {
    $return = '<g transform="translate('.$x.', '.$y.') ">';
    $return .= '<polygon class="iqr-svg-body-pointy" points="';
    $return .= '0,10 2.5,10 5,7.5 7.5,10 10,10 10,7.5 7.5,5 10,2.5 10,0 7.5,0 5,2.5 2.5,0 0,0 0,2.5 2.5,5 0,7.5';
    $return .= '" style="fill: '.$color.'; stroke-linecap: square; stroke-width: 0.5;" ';
    $return .= 'transform="rotate('.$rotation.', 5, 5)" />';
    $return .= '</g>';
    return $return;
  }

  

}
?>