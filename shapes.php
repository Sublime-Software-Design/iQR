<style>
  * {
    font-family: 'Arial';
  }
  *:not(h1,h2,h3,h4,h5,h6) {
    font-size: 12px;
  }
  html {
    padding: 20px;
  }
</style>
<?php 

define("SHOW_JSON", isset($_GET['show']));
define("IMG_SIZE", "25");
define("SHOW_GRID", true);

// define("SHAPE_RENDERING", '');
define("SHAPE_RENDERING", ' shape-rendering="geometricPrecision"');

$json = json_decode(file_get_contents('shapes.json'), true);

function createShape( $svgShape ) {
  $svgSize = SHOW_JSON ? IMG_SIZE : 500;
  $grid = "";
  for($a=0;$a<11;$a++) {
    $grid .= '<line x1="'.$a.'" y1="0" x2="'.$a.'" y2="10" style="stroke:grey;stroke-width:0.001" />';
    $grid .= '<line x1="0" y1="'.$a.'" x2="10" y2="'.$a.'" style="stroke:grey;stroke-width:0.001" />';
  }
  $svg = '<?xml version="1.1" encoding="UTF-8" standalone="no"?>';
  $svg .= '<svg width="'.$svgSize.'px" height="'.$svgSize.'px" version="1.1" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 10 10" style="border: 1px solid #787878;"'.SHAPE_RENDERING.'>';
  $svg .= $svgShape;
  $svg .= SHOW_JSON ? "" : $grid;
  // $svg .= '<circle cx="5" cy="5" r="4.95" stroke="red" stroke-width="0" fill="red" />';
  $svg .= "</svg>";
  echo $svg;
}

function createEyeFrame( $svgShape ) {
  $svgSize = SHOW_JSON ? IMG_SIZE * 7 : 700;
  $grid = "";
  for($a=0;$a<11;$a++) {
    $grid .= '<line x1="'.($a*10).'" y1="0" x2="'.($a*10).'" y2="70" style="stroke:grey;stroke-width:0.001" />';
    $grid .= '<line x1="0" y1="'.($a*10).'" x2="70" y2="'.($a*10).'" style="stroke:grey;stroke-width:0.001" />';
  }
  $svg = '<?xml version="1.1" encoding="UTF-8" standalone="no"?>';
  $svg .= '<svg width="'.$svgSize.'px" height="'.$svgSize.'px" version="1.1" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 70 70" style="border: 0px solid #787878;"'.SHAPE_RENDERING.'>';
  $svg .= $svgShape;
  $svg .= !SHOW_JSON && SHOW_GRID ? $grid : "";
  // $svg .= '<circle cx="5" cy="5" r="4.95" stroke="red" stroke-width="0" fill="red" />';
  $svg .= "</svg>";
  echo $svg;
}

function createEyeBall( $svgShape ) {
  $svgSize = SHOW_JSON ? IMG_SIZE * 3 : 300;
  $grid = "";
  for($a=0;$a<3;$a++) {
    $grid .= '<line x1="'.($a*10).'" y1="0" x2="'.($a*10).'" y2="30" style="stroke:grey;stroke-width:0.05" />';
    $grid .= '<line x1="0" y1="'.($a*10).'" x2="30" y2="'.($a*10).'" style="stroke:grey;stroke-width:0.05" />';
  }
  $svg = '<?xml version="1.1" encoding="UTF-8" standalone="no"?>';
  $svg .= '<svg width="'.$svgSize.'px" height="'.$svgSize.'px" version="1.1" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" style="border: 0px solid #787878;"'.SHAPE_RENDERING.'>';
  $svg .= $svgShape;
  $svg .= !SHOW_JSON && SHOW_GRID ? $grid : "";
  // $svg .= '<circle cx="5" cy="5" r="4.95" stroke="red" stroke-width="0" fill="red" />';
  $svg .= "</svg>";
  echo $svg;
}

if(SHOW_JSON) {
  $pointShapes = ['polygon'];
  $sizeShapes = ['rect'];
  $pathShapes = ['path'];
  echo "<h1>BODY BITS:</h1>";
  foreach( $json['bits'] as $type => $data ) {
    echo "<br /><strong style=\"font-size: 16px;\">" . $type . "</strong> :<br />";
    $props = [];
    switch($type) {
      // point shapes
      case in_array($data['element'], $pointShapes):
        $props[] = 'points="' . $data['points'] . '"';
        break;
      // size shapes
      case in_array($data['element'], $sizeShapes):
        $props[] = 'width="' . $data['width'] . '"';
        $props[] = 'height="' . $data['height'] . '"';
        break;
      // path shapes
      case in_array($data['element'], $pathShapes):
        $props[] = 'd="' . $data['d'] . '"';
        break;
    }
    if(isset($data['style'])) {
      $styles = [];
      foreach($data['style'] as $key => $value) {
        $styles[] = $key . ': ' . $value;
      }
      $props[] = 'style="' . implode("; ",$styles) . '"';
    }
    $implode = " " . implode(" ", $props);
    $transform = "";
    if(isset($data['transform'])) {
      $transform = 'transform="' . $data['transform'] . '"';
    }
    $thisShape = "<{$data['element']} {$implode} {$transform} />";
    createShape( $thisShape );
    echo "<br />" . htmlspecialchars($thisShape) . "<hr />";
  }
  echo "<h1>EYE FRAMES:</h1>";
  foreach( $json['eyeFrames'] as $type => $data ) {
    echo "<br /><strong style=\"font-size: 16px;\">" . $type . "</strong> :<br />";
    $props = [];
    switch($type) {
      // point shapes
      case in_array($data['element'], $pointShapes):
        $props[] = 'points="' . $data['points'] . '"';
        break;
      // size shapes
      case in_array($data['element'], $sizeShapes):
        $props[] = 'width="' . $data['width'] . '"';
        $props[] = 'height="' . $data['height'] . '"';
        break;
      // path shapes
      case in_array($data['element'], $pathShapes):
        $props[] = 'd="' . $data['d'] . '"';
        break;
    }
    if(isset($data['style'])) {
      $styles = [];
      foreach($data['style'] as $key => $value) {
        $styles[] = $key . ': ' . $value;
      }
      $props[] = 'style="' . implode("; ",$styles) . '"';
    }
    $implode = " " . implode(" ", $props);
    $transform = "";
    if(isset($data['transform'])) {
      $transform = 'transform="' . $data['transform'] . '"';
    }
    $thisShape = "<{$data['element']} {$implode} {$transform} />";
    createEyeFrame( $thisShape );
    echo "<br />" . htmlspecialchars($thisShape) . "<hr />";
  }
  echo "<h1>EYE BALLS:</h1>";
  foreach( $json['eyeBalls'] as $type => $data ) {
    echo "<br /><strong style=\"font-size: 16px;\">" . $type . "</strong> :<br />";
    $props = [];
    switch($type) {
      // point shapes
      case in_array($data['element'], $pointShapes):
        $props[] = 'points="' . $data['points'] . '"';
        break;
      // size shapes
      case in_array($data['element'], $sizeShapes):
        $props[] = 'width="' . $data['width'] . '"';
        $props[] = 'height="' . $data['height'] . '"';
        break;
      // path shapes
      case in_array($data['element'], $pathShapes):
        $props[] = 'd="' . $data['d'] . '"';
        break;
    }
    if(isset($data['style'])) {
      $styles = [];
      foreach($data['style'] as $key => $value) {
        $styles[] = $key . ': ' . $value;
      }
      $props[] = 'style="' . implode("; ",$styles) . '"';
    }
    $implode = " " . implode(" ", $props);
    $transform = "";
    if(isset($data['transform'])) {
      $transform = 'transform="' . $data['transform'] . '"';
    }
    $thisShape = "<{$data['element']} {$implode} {$transform} />";
    createEyeFrame( $thisShape );
    echo "<br />" . htmlspecialchars($thisShape) . "<hr />";
  }
}else{
  // M 0,10 Q 1,-10 10,10
  $shape = '<path 
    d="M 5,0 L 10,5 L 5,10 L 0,5" 
    style="stroke: black; stroke-linecap: square; stroke-width: 0" 
  />';
  createShape( $shape );
  // createEyeFrame( $shape );
  // createEyeBall( $shape );
}
?>