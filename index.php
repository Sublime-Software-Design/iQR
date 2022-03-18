<?php
  ini_set('display_errors', 'true');
  require_once 'vendor/autoload.php';

  $qr = new Subsof\Iqr\IQR();
  $qr->setData("https://qrtech.me");
  $qr->setGradient(
    '#ffff00',
    '#ff0000',
    45
  );
  // $qr->setColors([
  //   '#132b46',
  //   '#132b46',
  //   '#132b46'
  // ]);
?><table>
  <tr>
    <td valign="top">
      <?= $qr->visualiser() ?>
    </td>
    <td valign="top">
      <?php
        /*
          Body Shapes:
            Subsof\Iqr\Body::DEFAULT
            Subsof\Iqr\Body::FLUID
            Subsof\Iqr\Body::DOTS
            Subsof\Iqr\Body::TINYDOTS
            Subsof\Iqr\Body::LIQUID
            Subsof\Iqr\Body::RIBBON
            Subsof\Iqr\Body::RIBBONDOTS
            Subsof\Iqr\Body::FINGER
            Subsof\Iqr\Body::GEMS

          Frame Shapes:
            Subsof\Iqr\Frame::DEFAULT
            Subsof\Iqr\Frame::ROUNDED

          EyeBall Shapes:
            Subsof\Iqr\Ball::DEFAULT
            Subsof\Iqr\Ball::ROUNDED
        */
        echo $qr->svg( Subsof\Iqr\Body::TINYDOTS, Subsof\Iqr\Frame::ROUNDED, Subsof\Iqr\Ball::ROUNDED );
      ?>
      <img src="<?= $qr->imageSrc( Subsof\Iqr\Body::FINGER, Subsof\Iqr\Frame::ROUNDED, Subsof\Iqr\Ball::ROUNDED ) ?>" />
    </td>
    <!-- <td valign="top" style="padding-left: 20px;">
      <pre style="font-size: 10px;"><?= json_encode( [
        'eyeFrames' => $GLOBALS['iqr']['eyeFrames'],
        'matrix' => $GLOBALS['iqr']['matrixExtra']
      ], JSON_PRETTY_PRINT) ?></pre>
    </td> -->
  </tr>
</table>
