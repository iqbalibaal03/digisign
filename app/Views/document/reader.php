<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getenv('app.name') ?></title>

    <link rel="stylesheet" href="<?= base_url() ?>/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/bootstrap/css/jumbotron.css">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
</head>

<body>

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="navbar-form navbar-left">
                <h4>Digisign Scanner</h4>
            </div>
            <div class="navbar-form navbar-right">
                <select class="form-control" id="camera-select">
                    <option value="2c7c45d49d4952a85844f40ac31e1aade1cf49497fc26aa9eeb448dd3f650c1e">USB2.0 VGA UVC WebCam (13d3:5a01)</option>
                </select>
                <div class="form-group">
                    <input id="image-url" type="text" class="form-control" placeholder="Image url">
                    <button title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="button" data-toggle="tooltip"><i class="fas fa-upload fa-fw"></i></button>
                    <button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><i class="fas fa-image fa-fw"></i></button>
                    <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><i class="fas fa-play fa-fw"></i></button>
                    <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><i class="fas fa-pause fa-fw"></i></button>
                    <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><i class="fas fa-stop fa-fw"></i></button>
                </div>
            </div>
        </div>
        <div class="panel-body text-center">
            <div class="col-md-6">
                <div class="well" style="position: relative;display: inline-block;">
                    <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                    <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                    <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                    <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                    <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                </div>
                <div class="well" style="width: 100%;">
                    <label id="zoom-value" width="100">Zoom: 2</label>
                    <input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="20">
                    <label id="brightness-value" width="100">Brightness: 0</label>
                    <input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0">
                    <label id="contrast-value" width="100">Contrast: 0</label>
                    <input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
                    <label id="threshold-value" width="100">Threshold: 0</label>
                    <input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0">
                    <label id="sharpness-value" width="100">Sharpness: off</label>
                    <input id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
                    <label id="grayscale-value" width="100">grayscale: off</label>
                    <input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
                    <br>
                    <label id="flipVertical-value" width="100">Flip Vertical: off</label>
                    <input id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
                    <label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
                    <input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnail" id="result">
                    <div class="well" style="overflow: hidden;">
                        <img width="320" height="240" id="scanned-img" src="">
                    </div>
                    <div class="caption">
                        <h3>Scanned result</h3>
                        <p id="scanned-QR"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detail-wrapper">
        <div class="scanned-results" id="scanned-results">

        </div>
    </div>

    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/qrcodelib.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/webcodecamjs.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/main.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/filereader.js"></script>
</body>

</html>
<!-- 
            Using jquery version:
            <script type="text/javascript" src="js/jquery.js"></script>
            <script type="text/javascript" src="js/qrcodelib.js"></script>
            <script type="text/javascript" src="js/webcodecamjquery.js"></script>
        -->