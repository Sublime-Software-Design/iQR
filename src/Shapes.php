<?php 

namespace Ssd\Iqr;

class Shapes 
{

  public static function square( $bitSize, $color = 'black', $x = 0, $y = 0 ) 
  {
    return '<rect x="'.$x.'" y="'.$y.'" width="'.$bitSize.'" height="'.$bitSize.'" style="fill:'.$color.';stroke-linecap: square;stroke-width:0;stroke:'.$color.'" />';
  }

  public static function circle( $bitSize, $color = 'black', $x = 0, $y = 0) {
    return '<defs>
      <filter id="circf_'.$x.'_'.$y.'" x="0" y="0">
        <feGaussianBlur in="SourceGraphic" stdDeviation="0,1" />
      </filter>
    </defs>
    <circle cx="'.($x + ($bitSize/2)).'" cy="'.($y + ($bitSize/2)).'" r="'.(($bitSize/2)-4).'" stroke="none" stroke-width="0" fill="'.$color.'" />
    <circle cx="'.($x + ($bitSize/2)).'" cy="'.($y + ($bitSize/2)).'" r="'.(($bitSize/2)-2).'" stroke="black" stroke-width="2" fill="none" />';
  }

  public static function triangle( $bitSize, $color = 'black', $x = 0, $y = 0 )
  {
    return '<polygon points="'.($x).','.$y.' '.($x+$bitSize).','.($y).' '.($x+($bitSize/2)).','.($y+$bitSize).'" style="fill:'.$color.';;stroke-width:0" />';
  }

  public static function roof( $bitSize, $color = 'black', $x = 0, $y = 0 )
  {
    $points = [
      $x.','.$y,
      $x.','.($y+($bitSize/2)),
      ($x+($bitSize/2)).','.($y+$bitSize),
      ($x+$bitSize).','.($y+($bitSize/2)),
      ($x+$bitSize).','.$y
    ];
    /*
      x,y
      x,y+(bit/2)
      x+(bit/2),y
      x+bit,y+(bit/2)
      x+bit,y+bit
    */
    return '<polygon points="'.implode(" ",$points).'" style="fill:'.$color.';stroke-width:0" />';
  }

}
?>