## Important Reminder!

This Project is currently being developed, so there is absolutely nothing much too see yet.
The purpose of this project will be to deliver an opensource alternative for the paid API of QRCode Monkey.
![QRCode Monkey Screenshot](https://github.com/Sublime-Software-Design/iQR/blob/stable/qrmonkey.png?raw=true "QRCode Monkey Screenshot")
Currently there is only one custom layout that is able to be generated.
I Allready published this version for some close friends who needed this.
Stay tuned for future updates in where I'll try to add all the same options as in QRCode Monkey asap.

## Installation

```
composer require ssd/iqr
```

## Quickstart

```
$qr = new Ssd\Iqr\IQR();
$qr->setData("https://qrtech.me");
<img src="<?= $qr->imageSrc() ?>" />
```

Copyright 2022 Frank Wayong <fwayong@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
