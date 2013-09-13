<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie10 lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie10 lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
	@yield('title')
    </title>

    {{ HTML::style('packages/kcahir/tweetcompare/css/bootstrap.css') }}
    {{ HTML::style('packages/kcahir/tweetcompare/css/main.css') }}

    @yield('style')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      {{ HTML::script('packages/kcahir/tweetcompare/js/respond.min.js') }}
      {{ HTML::script('packages/kcahir/tweetcompare/js/html5shiv.js') }}
    <![endif]-->

  </head>
	<body>


	<div class="wrapper">
		<div class="header">
			<div class="col-xs-12">
				@yield('header')
			</div>
		</div>
		<div class="content">

			@yield('content')

		</div>
	</div>

	<!-- JavaScript plugins (requires jQuery) -->
	<script src="http://code.jquery.com/jquery.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	{{ HTML::script('packages/kcahir/tweetcompare/js/bootstrap.min.js') }}

	@yield('scripts')

	</body>
</html>
