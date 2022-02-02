<?php 
  require_once 'vendor/autoload.php';

  // header("Content-Type: text/plain");

  $bitSize = 20;

  $qr = new Ssd\Iqr\IQR();

  $data = hash('sha1','Short Code');
  $data = md5('test');

  $qrBits = $qr->matrix($data);
?><table>
  <tr>
    <td valign="top">
      <?= $qr->visualiser($qrBits, $bitSize, true) ?>
    </td>
    <td valign="top" style="padding-left: 20px;">
      <?= $qr->svg($qrBits, count($qrBits) * $bitSize, $bitSize) ?>
    </td>
    <!-- <td valign="top" style="padding-left: 20px;">

      <svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400">
        <defs>
          <linearGradient x1="100%" y1="50%" x2="0%" y2="50%" id="gradient">
            <stop stop-color="#6300FF" stop-opacity="0.7" offset="0%"></stop>
            <stop stop-color="#251D4B" offset="100%"></stop>
          </linearGradient>
          <mask id="mask">
            <path d="M812.532 489.667L1306.8 -4.60034H-106L388.268 489.667C505.425 606.825 695.374 606.825 812.532 489.667Z" fill="#C4C4C4"/>
          </mask>
        </defs>
        <image xlink:href="https://picsum.photos/600/400" x="0" y="0" width="600" height="400" mask="url(#mask)" />
        <rect width="1400" height="742" mask="url(#mask)" fill="url(#gradient)"></rect>
      </svg>

    </td> -->
  </tr>
</table>