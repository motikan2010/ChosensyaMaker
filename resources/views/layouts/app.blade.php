<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="description" content="『挑戦者が現れました』メーカー"/>
  <meta name="keywords" content="挑戦者が現れました,メーカー,ジェネレーター"/>
  <meta name="thumbnail" content="/images/after.png"/>
  <title>『挑戦者が現れました』メーカー</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
    </div>
  </div>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="/" class="navbar-brand d-flex align-items-center">
        <strong>『挑戦者が現れました』メーカー</strong>
      </a>
    </div>
  </div>
</header>

<main role="main">
  <section class="jumbotron text-center">
    <div class="container">
      @yield('content')
    </div>
  </section>
</main>

<footer class="text-muted">
  <div class="container">
    <p>&copy; @motikan2010</p>
  </div>
</footer>
@yield('javascript')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-90313174-5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-90313174-5');
</script>
</body>
</html>
