(function(window){
  init(window);
}(window));

function init(window) {
  "use strict";
  var document = window.document;

  var imageUrl = document.getElementById('image-info').getAttribute('url');
  console.log(imageUrl);
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var scale = 1;

  const img = new Image();
  img.src = '/images/result/' + imageUrl;
  img.crossOrigin = 'anonymous';

  img.onload = function() {
    ctx.drawImage(img, canvas.width / 10 +  this.width / 2, 0);
  };

  img.onerror = function() {
    console.log('画像の読み込み失敗');
  };

  // ドラッグで移動
  var isDragging = false;   // ドラッグ状態かどうか
  var start = {x: 0, y: 0}; // ドラッグ開始位置
  var diff  = {x: 0, y: 0}; // ドラッグ中の位置
  var end   = {x: 0, y: 0}; // ドラッグ終了後の位置

  const redraw = function() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.scale(scale, scale);
    ctx.drawImage(img, diff.x, diff.y);
    ctx.scale(1 / scale, 1 / scale);
  };

  canvas.addEventListener('mousedown', function(event) {
    isDragging = true;
    start.x = event.clientX;
    start.y = event.clientY;
  });

  canvas.addEventListener('mousemove', function(event) {
    if (isDragging) {
      diff.x = (event.clientX - start.x) + end.x;
      diff.y = (event.clientY - start.y) + end.y;
      redraw();
    }
  });

  canvas.addEventListener('mouseup', function() {
    isDragging = false;
    end.x = diff.x;
    end.y = diff.y;
  });

  // 縮小・拡大
  const slider = document.getElementById('zoom-slider');
  slider.value = scale;
  slider.min = 0.01;
  slider.max = 2;
  slider.step = 'any';
  slider.addEventListener('input', function(event) {
    scale = event.target.value;
    redraw();
  });

  // シルエットON/OFF
  const monochromeRadio = document.getElementsByName('monochrome-radio');
  for(var i = 0; i < monochromeRadio.length; i++) {
    monochromeRadio[i].addEventListener('change', function (event) {
      if (event.target.value === '1') {
        const silhouetteImageData = ctx.getImageData(0, 0, canvas.clientWidth, canvas.clientHeight);
        const silhouetteData = silhouetteImageData.data;
        for(var n = 0; n < silhouetteData.length; n += 4){
          silhouetteData[n] = 10;
          silhouetteData[n + 1] = 10;
          silhouetteData[n + 2] = 10;
        }
        silhouetteImageData.data.set(silhouetteData);
        ctx.putImageData(silhouetteImageData, 0, 0);
      } else {
        console.log('OFF');
      }
    });
  }
}

function take() {
  html2canvas(document.getElementById('canvas')).then(function(canvas) {
    var output = document.getElementById('output');
    output.textContent = null;
    output.appendChild(canvas);

    // ダウンロードボタン
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
  });
}
