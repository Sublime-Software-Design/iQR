<?php 
namespace Ssd\Iqr;

class Eyeframe 
{
  private static $frameBits = [
    [0,0],[0,1],[0,2],[0,3],[0,4],[0,5],[0,6],
    [1,0],[2,0],[3,0],[4,0],[5,0],
    [1,6],[2,6],[3,6],[4,6],[5,6],
    [6,0],[6,1],[6,2],[6,3],[6,4],[6,5],[6,6],
  ];

  private static $eyeBits = [
    [2,2],[2,3],[2,4],
    [3,2],[3,3],[3,4],
    [4,2],[4,3],[4,4]
  ];

  private static function calcRotation( $eyeframePosition )
  {
    if($eyeframePosition == 'topright') { return 90; }
    if($eyeframePosition == 'bottomleft') { return 270; }
    return 0;
  }
  private static function calcCenterPoint( $bitSize )
  {
    return ($bitSize*7) / 2;
  }

  public static function default( $bitSize, $colorFrame = 'black', $colorEye = 'black', $x = 0, $y = 0, $eyeframePosition = 'topleft' ) 
  {
    
    $ret = '<g transform="translate('.$x.','.$y.')">';
    $ret .= self::roundedCornerFrame( $bitSize, $colorFrame, $eyeframePosition );
    $ret .= self::roundedCornerEye( $bitSize, $colorEye, $eyeframePosition );
    $ret .= '</g>';
    return $ret;
  }

  /**
   * Frames of the eyeframe
   */
  private static function squareFrame( $bitSize, $color = 'black' ) 
  {
    $ret = '';
    foreach(self::$frameBits as $bit) {
      $ret .= Shapes::square( $bitSize, $color, $bit[0]*$bitSize, $bit[1]*$bitSize );
    }
    return $ret;
  }

  private static function roundedCornerFrame( $bitSize, $color, $eyeframePosition ) 
  {
    $skip = [
      '0,0','0,1','0,2','1,0','2,0',
    ];
    $cp = self::calcCenterPoint( $bitSize ); // center point
    $degrees = self::calcRotation( $eyeframePosition );
    $ret = '<g transform="rotate('.$degrees.','.$cp.','.$cp.')">';
    foreach(self::$frameBits as $bit) {
      $xy = $bit[0].','.$bit[1];
      if(!in_array($xy,$skip)) {
        $ret .= Shapes::square( $bitSize, $color, $bit[0]*$bitSize, $bit[1]*$bitSize );
      }
    }
    $curvePath = [
      'M0 '.($bitSize*3).' ',
      'q0 -'.($bitSize*3).' '.($bitSize*3).' -'.($bitSize*3).' ',
      'L'.($bitSize*3).' '.$bitSize,
      'q-'.($bitSize*2).' 0 -'.($bitSize*2).' '.($bitSize*2).' ',
      'L0 '.($bitSize*3),
    ];
    $ret .= '<path d="'.implode($curvePath).'" stroke="none" stroke-width="0" fill="'.$color.'" />';
    $ret .= '</g>';
    return $ret;
  }

  private static function twoRoundedCornerFrame( $bitSize, $color, $eyeframePosition ) 
  {
    $skip = [
      '0,0','0,1','0,2','1,0','2,0',
      '6,6','5,6','6,5','6,4','4,6'
    ];
    $cp = self::calcCenterPoint( $bitSize ); // center point
    $degrees = self::calcRotation( $eyeframePosition );
    $ret = '<g transform="rotate('.$degrees.','.$cp.','.$cp.')">';
    foreach(self::$frameBits as $bit) {
      $xy = $bit[0].','.$bit[1];
      if(!in_array($xy,$skip)) {
        $ret .= Shapes::square( $bitSize, $color, $bit[0]*$bitSize, $bit[1]*$bitSize );
      }
    }
    $curvePath = [
      'M'.($bitSize*4).' '.$bitSize*7,
      'q'.($bitSize*3).' 0 '.($bitSize*3).' -'.($bitSize*3),
      'L'.($bitSize*6).' '.($bitSize*4),
      'q0 '.($bitSize*2).' -'.($bitSize*2).' '.($bitSize*2),
      'L'.($bitSize*4).' '.($bitSize*7),
    ];
    $ret .= '<path d="'.implode($curvePath).'" stroke="red" stroke-width="0" fill="'.$color.'" />';
    $curvePath = [
      'M0 '.($bitSize*3).' ',
      'q0 -'.($bitSize*3).' '.($bitSize*3).' -'.($bitSize*3).' ',
      'L'.($bitSize*3).' '.$bitSize,
      'q-'.($bitSize*2).' 0 -'.($bitSize*2).' '.($bitSize*2).' ',
      'L0 '.($bitSize*3),
    ];
    $ret .= '<path d="'.implode($curvePath).'" stroke="red" stroke-width="0" fill="'.$color.'" />';
    $ret .= '</g>';
    return $ret;
  }

  /**
   * Eyes of the eyeframe
   */
  private static function squareEye( $bitSize, $color = 'black' )
  {
    $ret = '';
    foreach(self::$eyeBits as $bit) {
      $ret .= Shapes::square( $bitSize, $color, $bit[0]*$bitSize, $bit[1]*$bitSize );
    }
    return $ret;
  }

  private static function roundedCornerEye( $bitSize, $color, $eyeframePosition )
  {
    $skip = [
      '2,2','4,4'
    ];
    $cp = self::calcCenterPoint( $bitSize ); // center point
    $degrees = self::calcRotation( $eyeframePosition );
    $ret = '<g transform="rotate('.$degrees.','.$cp.','.$cp.')">';
    foreach(self::$eyeBits as $bit) {
      $xy = $bit[0].','.$bit[1];
      if(!in_array($xy,$skip)) {
        $ret .= Shapes::square( $bitSize, $color, $bit[0]*$bitSize, $bit[1]*$bitSize );
      }
    }
    $curvePath = [
      'M'.($bitSize*2).' '.($bitSize*3),
      'q0 -'.($bitSize).' '.($bitSize).' -'.($bitSize),
      'L'.($bitSize*3).' '.($bitSize*3),
      'L'.($bitSize*2).' '.($bitSize*3)
    ];
    $ret .= '<path d="'.implode($curvePath).'" stroke="red" stroke-width="0" fill="'.$color.'" />';
    $curvePath = [
      'M'.($bitSize*4).' '.($bitSize*5),
      'q'.($bitSize).' 0 '.($bitSize).' -'.($bitSize),
      'L'.($bitSize*4).' '.($bitSize*4),
      'L'.($bitSize*4).' '.($bitSize*5),
    ];
    $ret .= '<path d="'.implode($curvePath).'" stroke="red" stroke-width="0" fill="'.$color.'" />';
    $ret .= '</g>';
    return $ret;
  }

  

}
?>