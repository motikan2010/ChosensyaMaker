var width = window.innerWidth;
var height = window.innerHeight;

function MyCanvas(image, imageUrl, stageWidth, stageHeight) {
    var imageWidth = image.width;
    var imageHeight = image.height;
    
    var stage = new Konva.Stage({
        container: 'input',
        width: 500, // stageWidth,
        height: 280 // stageHeight
    });
    
    var layer = new Konva.Layer();
    stage.add(layer);
    
    var rect = new Konva.Rect({
        x: 160,
        y: 10,
        width: imageWidth,
        height: imageHeight,
        name: 'rect',
        draggable: true,
        fillPatternImage: image,
        fillPatternRepeat: 'no-repeat'
    });
    layer.add(rect);
    
    var tr = new Konva.Transformer();
    layer.add(tr);
    tr.attachTo(rect);
    layer.draw();
    
    /* デバッグ
    var text = new Konva.Text({x: 5, y: 5});
    layer.add(text);
    updateText();
    rect.on('transformstart', function () {
      console.log('transform start');
    });
    rect.on('dragmove', function () {
      updateText();
    });
    rect.on('transform', function () {
      updateText();
      console.log('transform');
    });
    rect.on('transformend', function () {
      console.log('transform end');
    });
    function updateText() {
      var lines = [
        'x: ' + rect.x(),
        'y: ' + rect.y(),
        'rotation: ' + rect.rotation(),
        'width: ' + rect.width(),
        'height: ' + rect.height(),
        'scaleX: ' + rect.scaleX(),
        'scaleY: ' + rect.scaleY()
      ];
      text.text(lines.join('\n'));
      layer.batchDraw();
    }
    // /* */
    
    layer.batchDraw();
    
    this.image = image;
    this.imageUrl = imageUrl;
    this.rect = rect;
    this.tr = tr;
    this.layer = layer;
}

MyCanvas.prototype.take = function() {
    var tr = this.tr;
    var layer = this.layer;
    var rect = this.rect;
    
    tr.detach();
    layer.draw();
    html2canvas(document.getElementById('input')).then(function(canvas) {
        var output = document.getElementById('output');
        output.textContent = null;
        output.appendChild(canvas);
        tr.attachTo(rect);
        layer.draw();
        enableDownload(canvas);
    });
};

/**
 * ダウンロードボタンの有効化
 *
 * @param canvas
 */
function enableDownload(canvas) {
    var downloadBtn = document.getElementById('download-button');
    downloadBtn.disabled = false;
    var download = document.getElementById('download');
    var imgData = canvas.toDataURL();
    download.src = imgData;
    download.href = imgData;
    
    var now = new Date();
    const padZero = function (num){
        var result;
        if (num < 10) {
            result = "0" + num;
        } else {
            result = "" + num;
        }
        return result;
    };
    var date = '' + now.getFullYear() + padZero(now.getMonth() + 1) + padZero(now.getDate()) + '_' +
        padZero(now.getHours()) + padZero(now.getMinutes()) + padZero(now.getSeconds());
    download.download = 'chosensya_' + date + '.png';
}

/**
 * シルエットの有効化
 */
MyCanvas.prototype.changeMonochrome = function() {
    var canvas = document.createElement('canvas');
    canvas.width = this.image.width;
    canvas.height = this.image.height;
    var context = canvas.getContext('2d');
    context.drawImage(this.image, 0, 0);
    
    const silhouetteImageData = context.getImageData(0, 0, this.image.width, this.image.height);
    const silhouetteData = silhouetteImageData.data;
    for(var n = 0; n < silhouetteData.length; n += 4){
        silhouetteData[n] = 10;
        silhouetteData[n + 1] = 10;
        silhouetteData[n + 2] = 10;
    }
    silhouetteImageData.data.set(silhouetteData);
    context.putImageData(silhouetteImageData, 0, 0);
    this.image.src = canvas.toDataURL();
};

/**
 * シルエットの無効化
 */
MyCanvas.prototype.resetMonochrome = function() {
    this.image.src = this.imageUrl;
};


// 初期化
var myCanvas = null;
var image = new Image();
var imageUrl = '/images/result/' + document.getElementById('image-info').getAttribute('url');
image.onload = function() {
    myCanvas = new MyCanvas(image, imageUrl, width, height);
};
image.src = imageUrl;


// シルエットON/OFF
const monochromeRadio = document.getElementsByName('monochrome-radio');
for(var i = 0; i < monochromeRadio.length; i++) {
    monochromeRadio[i].addEventListener('change', function (event) {
        if (event.target.value === '1') {
            myCanvas.changeMonochrome();
        } else {
            myCanvas.resetMonochrome();
        }
    });
}

/**
 * 画像化
 */
function take() {
    myCanvas.take();
}

