<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div id="input">
  <canvas id="canvas" width="500" height="480"></canvas>
</div>
<div id="output"></div>
<script type="text/javascript" src="/js/sagen-0.2.25.min.js"></script>
<script type="text/javascript" src="/js/sankaku-0.2.9.min.js"></script>
<script type="text/javascript" src="/js/html2canvas.min.js"></script>
<script type="text/javascript">
  (function(window){
    "use strict";

    var document = window.document;
    var requestAnimationFrame = self.requestAnimationFrame;
    const SANKAKU = window.Sankaku;
    const SAGEN = window.Sagen;
    var element = SAGEN.Device.getElement();
    var _touch = SAGEN.hasClass(element, 'touch');
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    var scene;
    var inside;
    var target;
    var offset;

    function size () {
      return { w: canvas.width, h: canvas.height };
    }

    function onMove(event) {
      var v;
      if (!!target) {
        v = new SANKAKU.Vector2D(event.pageX - canvas.offsetLeft, event.pageY - canvas.offsetTop);
        target.setX(v.x - offset.x);
        target.setY(v.y - offset.y);
      }
    }

    function onDown(event) {
      var v, contains;
      v = new SANKAKU.Vector2D( event.pageX - canvas.offsetLeft, event.pageY - canvas.offsetTop );
      contains = inside.check(v);
      if (contains.length > 0) {
        target = contains[0];
        target.setColor("#6cbad3").setAlpha(0.95);
        offset = {
          x: v.x - target.x,
          y: v.y - target.y
        };
        scene.highest(target);

        if (!_touch) {
          canvas.addEventListener("mousemove", onMove, false);
          canvas.addEventListener("mouseout", onUp, false);
          document.getElementById('input').style.cssText = "cursor: move";
        } else {
          event.preventDefault();
          canvas.addEventListener("touchmove", onMove, false);
        }
      }
    }

    function onUp(){
      var children = scene.children, i, limit;

      for (i=0, limit = children.length; i < limit; i++) {
        children[i].setColor("#ffffff").setAlpha(0.5);
      }

      if (!_touch) {
        canvas.removeEventListener("mousemove", onDown);
        canvas.removeEventListener("mouseout", onUp);
        document.getElementById('input').style.cssText = "cursor: auto";
      } else {
        canvas.removeEventListener("touchmove", onMove);
      }

      target = null;
    }

    if (!_touch) {
      // may be PC
      canvas.addEventListener("mousedown", onDown, false);
      canvas.addEventListener("mouseup", onUp, false);
    } else {
      // touch
      canvas.addEventListener("touchstart", onDown, false);
      canvas.addEventListener("touchend", onUp, false);
    }

    function draw() {
      scene.draw(ctx);
    }

    function loop () {
      requestAnimationFrame(loop);
      var rect = size();
      ctx.clearRect(0, 0, rect.w, rect.h);
      draw();
    }

    function init () {
      var rect = size();
      var c1 = new SANKAKU.Shape(rect.w * 0.5, 60, 60, 60, "#ffffff");
      var c2 = new SANKAKU.Tripod(rect.w * 0.5, 160, 60, 60, "#ffffff");
      var c3 = new SANKAKU.Circle(rect.w * 0.5, 260, 30, "#ffffff");
      c1.setAlpha(0.5).setMode(SANKAKU.Shape.FILL).setRotate(45);
      c2.setAlpha(0.5).setMode(SANKAKU.Shape.FILL).setRotate(-90);
      c3.setAlpha(0.5).setMode(SANKAKU.Shape.FILL);

      scene = new SANKAKU.Scene();
      scene.add(c1);
      scene.add(c2);
      scene.add(c3);
      inside = new SANKAKU.Inside(scene);

      loop();
    }

    init();
  }(window));
</script>
<script type="text/javascript">
  function take() {
    html2canvas(document.getElementById('canvas')).then(function(canvas) {
      var output = document.getElementById('output');
      output.textContent = null;
      output.appendChild(canvas);
    });
  }
</script>
</body>
</html>
