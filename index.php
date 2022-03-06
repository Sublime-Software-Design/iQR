<?php
  // ini_set('display_errors', 'false');
  require_once 'vendor/autoload.php';

<<<<<<< Updated upstream
  $qr = new Ssd\Iqr\IQR();
  $qr->setData("https://www.throughout.nl");
=======
  $qr = new Subsof\Iqr\IQR();
  $qr->setData("https://qrtech.me");
>>>>>>> Stashed changes
  $qr->setColors([
    '#132b46',
    '#132b46',
    '#132b46'
<<<<<<< Updated upstream
  ])
  
=======
  ]);

>>>>>>> Stashed changes
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

          Frame Shapes:
            Subsof\Iqr\Frame::DEFAULT
            Subsof\Iqr\Frame::ROUNDED

          EyeBall Shapes:
            Subsof\Iqr\Ball::DEFAULT
            Subsof\Iqr\Ball::ROUNDED
        */
        echo $qr->svg( Subsof\Iqr\Body::FLUID, Subsof\Iqr\Frame::ROUNDED, Subsof\Iqr\Ball::ROUNDED );
      ?>
      <img src="<?= $qr->imageSrc( Subsof\Iqr\Body::FLUID, Subsof\Iqr\Frame::ROUNDED, Subsof\Iqr\Ball::ROUNDED ) ?>" />
    </td>
    <!-- <td valign="top" style="padding-left: 20px;">
      <pre style="font-size: 10px;"><?= json_encode( [
        'eyeFrames' => $GLOBALS['iqr']['eyeFrames'],
        'matrix' => $GLOBALS['iqr']['matrixExtra']
      ], JSON_PRETTY_PRINT) ?></pre>
    </td> -->
  </tr>
</table>
