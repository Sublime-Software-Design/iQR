<?php 

/**
 * iQR - QRCode creator for PHP
 * 
 * @author    Frank Wayong <fwayong@gmail.com>
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Ssd\Iqr;

use \chillerlan\QRCode\QRCode;
use \chillerlan\QRCode\QROptions;

class IQR
{

  public $qr;

  function __construct() 
  {
    $data = "qr content here";

    $options = new QROptions([
      'version'    => QRCode::VERSION_AUTO,
      'outputType' => QRCode::OUTPUT_MARKUP_SVG,
      'eccLevel'   => QRCode::ECC_L,
    ]);
    $this->qr = new QRCode($options);
  }

  public function matrix($data)
  {
    $qrBits = [];
    $matrix = $this->qr->getMatrix($data);
    foreach($matrix->matrix() as $y => $row){
      $thisBits = [];
      foreach($row as $x => $module){
        $value = $matrix->get($x, $y);
        if($matrix->check($x, $y)) { // if($module >> 8 > 0)
          $thisBits[] = 1;
        }else{
          $thisBits[] = 0;
        }
      }
      $qrBits[] = $thisBits;
    }
    return $qrBits;
  }

  public function visualiser( $qrBits, $squareSize = 5, $debug = false ) {
    $html = '<table cellpadding="0" cellspacing="0" style="border: 1px solid #787878;">';
    foreach($qrBits as $row) {
      $html .= '<tr>';
      foreach($row as $bit) {
        $html .= '<td style="width: '.$squareSize.'px; height: '.$squareSize.'px;background-color: '.($bit ? 'black' : 'white').';"></td>';
      }
      $html .= '</tr>';
    }
    $html .= '</table>';
    if($debug) {
      $html .= '<pre style="font-size: 8px;">GridSize = ' . count($row) . PHP_EOL . json_encode($qrBits[4], JSON_PRETTY_PRINT) . '</pre>';
    }
    return $html;
  }

  public function svg( $qrBits, $size, $squareSize = 5 ) {
    // eye frame positions = 4,4 / 4, gridize - 11
    $eyeFrames = $this->getEyeFrameCoords( $qrBits );
    $size = count($qrBits) * $squareSize;
    $ret = '<svg width="'.$size.'px" height="'.$size.'px" version="1.1" xmlns="http://www.w3.org/2000/svg" style="border: 1px solid #787878;">';
    
    $y = 0; $masks = []; $bits = []; $eyes = [];
    foreach($qrBits as $row) {
      $x = 0; 
      foreach($row as $bit) {
        $yx = $y.','.$x;
        if($bit === 0) {
          // $masks[] = $yx;
          // $masks[] = Shapes::square( $squareSize, 'white', ($x*$squareSize), ($y*$squareSize) );
          // $masks[] = Shapes::circle( $squareSize, 'white', ($x*$squareSize), ($y*$squareSize) );
        }
        if(!in_array($yx, $eyeFrames)) {
          // $bits[] = Shapes::square( $squareSize, $bit ? 'black' : 'white', ($x*$squareSize), ($y*$squareSize) );
          if($bit) {
            $bits[] = Shapes::roof( $squareSize, $bit ? 'white' : 'white', ($x*$squareSize), ($y*$squareSize) );
          }else{
            // $bits[] = Shapes::circle( $squareSize, $bit ? 'black' : 'white', ($x*$squareSize), ($y*$squareSize) );
          }
        }else if($yx == '4,4' || $yx == '4,'.(count($qrBits)-11) || $yx == (count($qrBits)-11).',4') {
          // $ret .= Shapes::square( $squareSize, 'green', ($x*$squareSize), ($y*$squareSize) );
          // if($bit) {
          //   $bits[] = Shapes::square( $squareSize, $bit ? 'white' : 'white', ($x*$squareSize), ($y*$squareSize) );
          // }
          $position = 'topleft';
          if($yx == '4,'.(count($qrBits)-11)) {
            $position = 'topright';
          }
          if($yx == (count($qrBits)-11).',4') {
            $position = 'bottomleft';
          }
          $eyes[] = Eyeframe::default( $squareSize, 'white', 'white', ($x*$squareSize), ($y*$squareSize), $position );
        }else{
          if($bit) {
            // $bits[] = Shapes::roof( $squareSize, $bit ? 'white' : 'white', ($x*$squareSize), ($y*$squareSize) );
          }
          // $ret .= Shapes::square( $squareSize, 'red', ($x*$squareSize), ($y*$squareSize) );
        }
        $x++;
      }
      $y++;
    }
    $ret .= '<defs>';
    $ret .= '<linearGradient x1="100%" y1="50%" x2="0%" y2="50%" id="gradient">
       <stop stop-color="#000000" stop-opacity="0.6" offset="0%"></stop>
       <stop stop-color="#000000" stop-opacity="0.6" offset="100%"></stop>
     </linearGradient>';
    $ret .= '<mask id="mask">';
    $ret .= implode(PHP_EOL,$masks);
    $ret .= '</mask>';
    $ret .= '</defs>';
    // $ret .= '<image xlink:href="https://picsum.photos/'.$size.'/'.$size.'" x="0" y="0" width="'.$size.'" height="'.$size.'" mask="url(#mask)" />';
    $ret .= '<image xlink:href="https://picsum.photos/'.$size.'/'.$size.'" x="0" y="0" width="'.$size.'" height="'.$size.'" />';
    $ret .= '<rect width="'.$size.'" height="'.$size.'" fill="url(#gradient)"></rect>';
    
    $ret .= implode(PHP_EOL,$bits);
    $ret .= implode(" ",$eyes);
    $ret .= '</svg>';
    $ret .= '<pre>' . json_encode($eyeFrames, JSON_PRETTY_PRINT) . '</pre>';
    return $ret;
  }

  private function getEyeFrameCoords( $qrBits ) 
  {
    /* 
      Notes: buitenrand = 4 bits
      EYE SIZE FRAME 7 x 7
      EYE SIZE 3 x 3
    */
    $yx = [];
    $gridSize = count($qrBits[0]);
    // top & bottom left eye frame 
    $startPoints = [
      4,
      ($gridSize-11)
    ];
    foreach($startPoints as $start) {
      for($a=$start;$a<$start+7;$a++){
        for($b=4;$b<11;$b++){
          $yx[] = $a.','.$b;
        }
      }
    }
    // top right eye frame
    for($a=4;$a<11;$a++){
      for($b=$gridSize-11;$b<$gridSize - 4;$b++){
        $yx[] = $a.','.$b;
      }
    }
    return $yx;
  }


}
?>