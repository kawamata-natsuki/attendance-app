<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
  @yield('css')
  <title>@yield('title', 'Attendance App')</title>
</head>

<body class="@yield('body-class')">
  <header class="header">
    <nav class="header-nav">
      <div class="header-logo">
        NKA.lab
      </div>

      <!-- ヘッダーナビ -->
      @auth
      @if($navView = \App\Helpers\LayoutHelper::headerNavView())
      @include($navView)
      @endif
      @endauth
    </nav>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>