## Important Reminder!

This Project is currently being developed, so there is absolutely nothing much too see yet.
The purpose of this project will be to deliver an opensource alternative for the paid API of QRCode Monkey.
![QRCode Monkey Screenshot](https://github.com/Sublime-Software-Design/iQR/blob/stable/qrmonkey.png?raw=true "QRCode Monkey Screenshot")
Currently there is only one custom layout that is able to be generated.
I Allready published this version for some close friends who needed this.
Stay tuned for future updates in where I'll try to add all the same options as in QRCode Monkey asap.

## Installation

```
composer require subsof/iqr
```

## Quickstart

```
$qr = new Subsof\Iqr\IQR();
$qr->setData("https://qrtech.me");
<img src="<?= $qr->imageSrc() ?>" />
```
