<?php 
namespace Ssd\Iqr;

class Functions
{

  public static function getMatrix( $qr, $qrData ) 
  {
    $qrBits = [];
    $matrix = $qr->getMatrix($qrData);
    foreach($matrix->matrix() as $y => $row){
      $thisBits = [];
      foreach($row as $x => $module){
        $value = $matrix->get($x, $y);
        if($matrix->check($x, $y)) {
          $thisBits[] = 1;
        }else{
          $thisBits[] = 0;
        }
      }
      $qrBits[] = $thisBits;
    }
    return $qrBits;
  }

  public static function getMatrixFull( $qr, $qrData ) 
  {
    $qrBits = self::getMatrix( $qr, $qrData );
    $qrEyes = self::getEyeFrameCoords($qrBits);
    $return = [
      'qrSize' => count($qrBits[0]),
      'eyeBits' => $qrEyes,
      'mapping' => []
    ];
    $mapping = [];
    $y = 0;
    foreach($qrBits as $row) {
      $x = 0;
      foreach($row as $val) {
        $key = $y.':'.$x;
        $topKey = ($y-1).':'.$x;
        $rightKey = $y.':'.($x+1);
        $bottomKey = ($y+1).':'.$x;
        $leftKey = $y.':'.($x-1);
        if(!in_array($key, $qrEyes)) {
          $mapping[$key] = [
            'state' => $val,
            'connecting' => [
              'top' => $topKey,
              'right' => $rightKey,
              'bottom' => $bottomKey,
              'left' => $leftKey
            ]
          ];
        }
        $x++;
      }
      $y++;
    }
    // modify the array with the connecting values 
    foreach($mapping as $key => $data) {
      $myConn = $data['connecting'];
      $data['connections'] = [];
      $data['connections'][] = $mapping[$myConn['top']]['state'] ?? 0;
      $data['connections'][] = $mapping[$myConn['right']]['state'] ?? 0;
      $data['connections'][] = $mapping[$myConn['bottom']]['state'] ?? 0;
      $data['connections'][] = $mapping[$myConn['left']]['state'] ?? 0;
      unset($data['connecting']);
      $return['mapping'][$key] = $data;
    }
    return $return;
  }

  public static function getEyeFrameCoords( $qrBits ) 
  {
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
    return $yx;
  }

  public static function makeVisualizer( $qrBits, $bitSize ) {
    $html = '<table cellpadding="0" cellspacing="0" style="border: 0px solid #787878;">';
    foreach($qrBits as $row) {
      $html .= '<tr>';
      foreach($row as $bit) {
        $html .= '<td style="width: '.$bitSize.'px; height: '.$bitSize.'px;background-color: '.($bit ? 'black' : 'white').';"></td>';
      }
      $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
  }

  public static function actualBitSize( $qrSize, $imageSize )
  {
    // 200 / 29 * 10
    return $imageSize / $qrSize;
  }

  public static function findDotRotation( $connections ) {
    // connections = [0,0,0,0] TOP / RIGHT / BOTTOM / LEFT
    if(array_sum($connections) == 0) {
      return 0;
    }else{
      // check out where my connections are 
      if(array_sum($connections) == 1) {
        // ONE connecting dot
        if($connections[0] == 1) {
          return 0;
        }else if($connections[1] == 1) {
          return 90;
        }else if($connections[2] == 1) {
          return 180;
        }else if($connections[3] == 1) {
          return 270;
        }
      }
    }
  }

}
?>