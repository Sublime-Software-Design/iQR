<?php 
namespace Ssd\Iqr;

class Svg 
{

  public static function ThemeQR( $matrix, $theme, $imageSize, $bitSize ) {
    $svgEyes = self::makeEyes( $matrix, $theme, $bitSize );
    $svgBody = self::makeBody( $matrix, $theme['body'], $bitSize );
    $svg = '<?xml version="1.1" encoding="UTF-8" standalone="no"?>';
    $svg .= '<svg width="'.$imageSize.'px" height="'.$imageSize.'px" version="1.1" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 '.(($matrix['qrSize'] * 10) -0).' '.(($matrix['qrSize'] * 10) -0).'" style="border: 0px solid #787878;" shape-rendering="crispEdges">';
    // $svg .= '<defs>';
    // $svg .= '<filter id="sharpEdges">';
    // $svg .= '<feBlend mode="normal" in="SourceGraphic"/>';
    // $svg .= '</filter>';
    // $svg .= '</defs>';
    $svg .= $svgBody;
    $svg .= $svgEyes;
    $svg .= '</svg>';
    // $svg .= '<pre style="font-size: 9px;">' . json_encode([
    //   'theme' => $theme,
    //   // 'eyes' => $svgEyes,
    //   // 'mapping' => $matrix['mapping']
    // ], JSON_PRETTY_PRINT) . '</pre>';
    return $svg;
  }

  /**
   * Body Dots
   */
  private static function makeBody( $matrix, $style, $bitSize ) {
    $return = [];
    foreach($matrix['mapping'] as $key => $data) {
      $split = explode(':',$key);
      $y = (int)$split[0]; $x = (int)$split[1];
      switch($style['shape']) {
        // -----------------------------------------------------------------------
        case 'square':
          if($data['state'] === 1) {
            $return[] = Shapes::square( 10, $style['color'], ($x*10), ($y*10) );
          }
        break;
        // -----------------------------------------------------------------------
        case 'fence':
          if($data['state'] === 1) {
            // check for connections
            // $connections = $data['connections'];
            // $connected = array_sum($connections);
            // if($connected == 1) {
            //   $return[] = Shapes::pointyTrheeSide( $style['color'], ($x*10), ($y*10), Functions::findDotRotation($connections)+90 );
            // }else if($connected == 2){
            //   if($connections === [1,0,1,0] || $connections === [0,1,0,1]) {
            //     $rotation = $connections === [1,0,1,0] ? 90 : 0;
            //     $return[] = Shapes::pointyTwoOposite( $style['color'], ($x*10), ($y*10), $rotation );
            //   }else{
            //     $rotation = 0;
            //     if($connections === [1,1,0,0]){ $rotation = 90; }
            //     if($connections === [0,1,1,0]){ $rotation = 180; }
            //     if($connections === [0,0,1,1]){ $rotation = 270; }
            //     $return[] = Shapes::pointyTwoSide( $style['color'], ($x*10), ($y*10), $rotation );
            //   }
            // }else if($connected == 3){
            //   $rotation = 0;
            //   if($connections === [1,1,1,0]){ $rotation = 90; }
            //   if($connections === [0,1,1,1]){ $rotation = 180; }
            //   if($connections === [1,0,1,1]){ $rotation = 270; }
            //   $return[] = Shapes::pointy( $style['color'], ($x*10), ($y*10), $rotation );
            // }else if($connected == 4){
            //   $return[] = Shapes::square( $style['color'], ($x*10), ($y*10) );
            // }else{
            //   $return[] = Shapes::cross( $style['color'], ($x*10), ($y*10) );
            // }
            $return[] = Shapes::cross( $style['color'], ($x*10), ($y*10) );
          }
        break;
        // -----------------------------------------------------------------------
        // -----------------------------------------------------------------------
      }
    }
    $group = '<g class="iqr-svg-body">' . (implode(PHP_EOL, $return)) . '</g>';
    return $group;
  }

  /**
   * Eye Dots & Frame
   */
  private static function makeEyes( $matrix, $style, $bitSize ) {
    $bits = $matrix['eyeBits'];

    // points to place shape in case not default squares 
    $eyePos = [
      'topLeft' => [4,4],
      'topRight' => [$matrix['qrSize']-11,4],
      'bottomLeft' => [4,$matrix['qrSize']-11],
    ];
    $return = [];
    ## FRAMES ##################################################################
    switch($style['eyeFrame']['shape']) {
      // -----------------------------------------------------------------------
      case 'square':
        $return[] = Eyeframe::squareFrame( $style['eyeFrame']['color']); // top left
        $return[] = Eyeframe::squareFrame( $style['eyeFrame']['color'], $matrix['qrSize']-11, 4 ); // top right 
        $return[] = Eyeframe::squareFrame( $style['eyeFrame']['color'], 4, $matrix['qrSize']-11 ); // bottom left
      break;
      // -----------------------------------------------------------------------
      // -----------------------------------------------------------------------
      // -----------------------------------------------------------------------
    }
    ## EYES ####################################################################
    switch($style['eye']['shape']) {
      // -----------------------------------------------------------------------
      case 'square':
        $return[] = Eyeframe::squareEye( $style['eyeFrame']['color']); // top left
        $return[] = Eyeframe::squareEye( $style['eyeFrame']['color'], $matrix['qrSize']-11, 4 ); // top right 
        $return[] = Eyeframe::squareEye( $style['eyeFrame']['color'], 4, $matrix['qrSize']-11 ); // bottom left
      break;
      // -----------------------------------------------------------------------
      // -----------------------------------------------------------------------
      // -----------------------------------------------------------------------
    }
    $group = '<g class="iqr-svg-eyes">' . (implode(PHP_EOL, $return)) . '</g>';
    return $group;
  }

}
?>