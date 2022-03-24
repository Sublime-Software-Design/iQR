<?php 

/**
 * iQR - QRCode creator for PHP
 * 
 * @author    Frank Wayong <fwayong@gmail.com>
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Subsof\Iqr;

use \chillerlan\QRCode\QRCode;
use \chillerlan\QRCode\QROptions;

class Iqr
{

  private $svgRendering = 'auto'; // auto | optimizeSpeed | crispEdges | geometricPrecision
  private $gradient = false;

  function __construct() {
     $GLOBALS['iqr'] = [];
     $options = new QROptions([
      'version'    => QRCode::VERSION_AUTO,
      'outputType' => QRCode::OUTPUT_MARKUP_SVG,
      'eccLevel'   => QRCode::ECC_M, // L | M \ Q | H
    ]);
    $GLOBALS['iqr']['qr'] = new QRCode($options);
    $GLOBALS['iqr']['svgShapes'] = json_decode(file_get_contents(__DIR__.'/shapes.json'), true);
    $GLOBALS['iqr']['gradient'] = $this->gradient;
    $GLOBALS['iqr']['gradientRotate'] = 0;
    $GLOBALS['iqr']['gradientColors'] = [
      'rgb(255,0,0)','rgb(255,255,0)'
    ];
    $this->setColors();
  }

  public function setData( $data ) {
    $GLOBALS['iqr']['data'] = $data;
    $matrix = $GLOBALS['iqr']['qr']->getMatrix($data);
    $matrixArray = []; $matrixArrayFull = [];
    foreach($matrix->matrix() as $y => $row){
      $thisDots = [];
      foreach($row as $x => $module){
        $value = $matrix->get($x, $y);
        $topKey = ($y-1).':'.$x;
        $rightKey = $y.':'.($x+1);
        $bottomKey = ($y+1).':'.$x;
        $leftKey = $y.':'.($x-1);
        $matrixArrayFull[$y.':'.$x] = [
          'state' => $matrix->check($x, $y) ? 1 : 0,
          'connecting' => ['top' => $topKey,'right' => $rightKey,'bottom' => $bottomKey,'left' => $leftKey]
        ];
        $thisDots[] = $matrix->check($x, $y) ? 1 : 0;
      }
      $matrixArray[] = $thisDots;
    }
    foreach($matrixArrayFull as $key => $data) {
      $myConn = $data['connecting'];
      $conns = [];
      $conns[] = $matrixArrayFull[$myConn['top']]['state'] ?? 0;
      $conns[] = $matrixArrayFull[$myConn['right']]['state'] ?? 0;
      $conns[] = $matrixArrayFull[$myConn['bottom']]['state'] ?? 0;
      $conns[] = $matrixArrayFull[$myConn['left']]['state'] ?? 0;
      $matrixArrayFull[$key]['connecting'] = $conns;
    }
    $GLOBALS['iqr']['matrix'] = $matrixArray;
    $GLOBALS['iqr']['matrixExtra'] = $matrixArrayFull;
    $this->getEyeFramePos();
  }

  public function setColors( $colors = ['#000000', '#000000', '#000000'] ) {
    $GLOBALS['iqr']['colors'] = [
      'body' => $colors[0],
      'frame' => $colors[1],
      'ball' => $colors[2],
    ];
  }

  public function setGradient( $colorA = null, $colorB = null, $degrees = 0 ) {
    $this->gradient = true;
    $GLOBALS['iqr']['gradient'] = true;
    $GLOBALS['iqr']['gradientColors'] = [$colorA ?? 'rgb(255,0,0)', $colorB ?? 'rgb(255,255,0)'];
    if(!in_array($degrees, [0,45,90,135,180,225,270,315])) {
      $degrees = 0;
    }
    $GLOBALS['iqr']['gradientRotate'] = $degrees;
  }
 
  public function visualiser() {
    $bitSize = 10;
    $html = '<table cellpadding="0" cellspacing="0" style="border: 0px solid #787878;">';
    foreach($GLOBALS['iqr']['matrix'] as $row) {
      $html .= '<tr>';
      foreach($row as $bit) {
        $html .= '<td style="width: '.$bitSize.'px; height: '.$bitSize.'px;background-color: '.($bit ? 'black' : 'white').';"></td>';
      }
      $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
  }

  public function svg( $body = null, $eyeFrame = null, $eyeBall = null ) {
    $imageSize = count($GLOBALS['iqr']['matrix']) * 10;
    $svg = '<?xml version="1.1" encoding="UTF-8" standalone="no"?>';
    $svg .= '<svg width="'.($imageSize).'px" height="'.($imageSize).'px" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 '.$imageSize.' '.$imageSize.'" style="border: 0px solid #787878;" shape-rendering="'.$this->svgRendering.'">';

    if($this->gradient) {
      $svg .= '<defs>';
      $rotationGradients = [
        0 => ' x1="0%" y1="0%" x2="0%" y2="100%"',
        45 => ' x1="0%" y1="0%" x2="100%" y2="100%"',
        90 => ' x1="0%" y1="0%" x2="100%" y2="0%"',
        135 => ' x1="0%" y1="100%" x2="100%" y2="0%"',
        180 => ' x1="100%" y1="0%" x2="0%" y2="0%"',
        225 => ' x1="100%" y1="0%" x2="0%" y2="100%"',
        270 => ' x1="100%" y1="100%" x2="0%" y2="100%"',
        315 => ' x1="100%" y1="100%" x2="0%" y2="0%"',
      ];
      $svg .= '  <linearGradient id="gradientColors"' . $rotationGradients[$GLOBALS['iqr']['gradientRotate']] . ' gradientUnits="userSpaceOnUse">';
      $svg .= '  <stop offset="0%" style="stop-color:' . $GLOBALS['iqr']['gradientColors'][0] . ';stop-opacity:1" />';
      $svg .= '  <stop offset="100%" style="stop-color:' . $GLOBALS['iqr']['gradientColors'][1] . ';stop-opacity:1" />';
      $svg .= '  </linearGradient>';
      $svg .= '</defs>';
      $svg .= '<g fill="url(#gradientColors)">';
      $svg .= Body::get($body);
      $svg .= Frame::get($eyeFrame);
      $svg .= Ball::get($eyeBall);
      $svg .= '</g>';
    }else{
      $svg .= Body::get($body);
      $svg .= Frame::get($eyeFrame);
      $svg .= Ball::get($eyeBall);
    }
    $svg .= '</svg>';
    return $svg;
  }

  public function imageSrc( $body = null, $eyeFrame = null, $eyeBall = null ) {
    // // make png image
    // $svg = $this->svg( $body, $eyeFrame, $eyeBall );
    // file_put_contents(dirname(__DIR__)."/img.svg", $svg);
    // $im = new \Imagick();
    // // $im->setFormat('svg');
    // $im->readImageBlob($svg);
    // // $im->setImageFormat("jpeg");
    // $im->setImageFormat("jpeg");
    // // $im->setImageCompressionQuality(100);
    // // $imgSrc = $im;
    // $imgSrc = 'data:image/jpeg;base64,'.base64_encode($im);
    // $im->clear();
    // $im->destroy();
    // return $imgSrc;

    // default svg output
    $svg = $this->svg( $body, $eyeFrame, $eyeBall );
    return 'data:image/svg+xml;base64,'.base64_encode($svg);
  }

  private function getEyeFramePos() {
    $yx = [];
    $gridSize = count($GLOBALS['iqr']['matrix']);
    $startPoints = [
      4,
      ($gridSize-11)
    ];
    foreach($startPoints as $start) {
      for($a=$start;$a<$start+7;$a++){
        for($b=4;$b<11;$b++){
          $yx[] = $a.':'.$b;
        }
      }
    }
    // top right eye frame
    for($a=4;$a<11;$a++){
      for($b=$gridSize-11;$b<$gridSize - 4;$b++){
        $yx[] = $a.':'.$b;
      }
    }
    // unset the matrixExtra with the eye frame positions 
    foreach($yx as $pos) {
      unset($GLOBALS['iqr']['matrixExtra'][$pos]);
    }
    $GLOBALS['iqr']['eyeFrames'] = $yx;
  }

}
?>