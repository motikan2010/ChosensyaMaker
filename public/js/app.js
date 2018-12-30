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


  const img = new Image();
  img.src = '/images/result/' + imageUrl;
  img.crossOrigin = 'anonymous';

  img.onload = function() {
    // Canvasを画像のサイズに合わせる
    // canvas.height = img.height;
    // canvas.width  = img.width;

    // Canvasに描画する
    ctx.drawImage(img, 0, 0);
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
    ctx.drawImage(img, diff.x, diff.y)
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
  canvas.addEventListener('mouseup', function(event) {
    isDragging = false;
    end.x = diff.x;
    end.y = diff.y;
  });
}

function take() {
  html2canvas(document.getElementById('canvas')).then(function(canvas) {
    var output = document.getElementById('output');
    output.textContent = null;
    output.appendChild(canvas);
  });
}
