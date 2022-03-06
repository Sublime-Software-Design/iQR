<?php 
  // ini_set('display_errors', 'false');
  require_once 'vendor/autoload.php';

  $qr = new Ssd\Iqr\IQR();
  $qr->setData("https://qrtech.me");
  $qr->setColors([
    '#132b46',
    '#132b46',
    '#132b46'
  ]);
  
?><table>
  <tr>
    <td valign="top">
      <?= $qr->visualiser() ?>
    </td>
    <td valign="top">
      <?php 
        /* 
          Body Shapes: 
            Ssd\Iqr\Body::DEFAULT
            Ssd\Iqr\Body::FLUID

          Frame Shapes:
            Ssd\Iqr\Frame::DEFAULT
            Ssd\Iqr\Frame::ROUNDED

          EyeBall Shapes:
            Ssd\Iqr\Ball::DEFAULT
            Ssd\Iqr\Ball::ROUNDED
        */
        echo $qr->svg( Ssd\Iqr\Body::FLUID, Ssd\Iqr\Frame::ROUNDED, Ssd\Iqr\Ball::ROUNDED );
      ?>
      <img src="<?= $qr->imageSrc( Ssd\Iqr\Body::FLUID, Ssd\Iqr\Frame::ROUNDED, Ssd\Iqr\Ball::ROUNDED ) ?>" />
    </td>
    <!-- <td valign="top" style="padding-left: 20px;">
      <pre style="font-size: 10px;"><?= json_encode( [
        'eyeFrames' => $GLOBALS['iqr']['eyeFrames'],
        'matrix' => $GLOBALS['iqr']['matrixExtra']
      ], JSON_PRETTY_PRINT) ?></pre>
    </td> -->
  </tr>
</table>