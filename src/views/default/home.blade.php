@extends('tweetcompare::layout')

@section('title')
	Twitter Compare
@stop

@section('style')
@stop

@section('header')

	<h1>Compare Twitter Users</h1>
	<hr />

@stop

@section('content')

<div class="col-xs-4">

	<form action="{{ URL::route('add') }}" method="post" id="compare" class="well">

		<div class="form-group row" id="fields">
			<label for="field1" class="col-lg-12 control-label">Add a new user account</label>
			<div class="col-xs-12" id="profs">
				<div class="input-group">

					<input type="hidden" name="count" value="1" />
					<input
						autocomplete="off"
						class="form-control"
						id="field"
						name="account[]"
						type="text"
						placeholder="Twitter Username"/>

					<span class="input-group-btn">
						<button id="b1" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-plus"></span></button>
						<button id="b2" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-cog"></span></button>
					</span>

				</div>
			</div>
		</div>
	</form>

	<div class="form-group row">
		<div class="col-xs-12">
			<button id="clear" type="button" class="btn btn-primary btn-lg btn-block">
				Refresh&nbsp;
				<span class="glyphicon glyphicon-refresh"></span>
			</button>
			<hr />
		</div>

		<div class="col-xs-12">
			<h4>Guide</h4>
			<ul>
				<li><small>To add a new account, enter the Twitter username and hit +</small></li>
				<li><small>The app will attempt to retreive up to 200 of the users most recent tweets.</small></li>
				<li><small><b>Max Distance</b> shows the maximum distance spanned between any two tweets in the sample that were made with <em>Geo Location</em> data switched on.</small></li>
				<li><small><b>Avg sent in a work day</b> shows the average number of tweets the user will make on a workday between the hours of 9am - 5:30pm. Workdays after the most recent tweet are not considered when calculating the average.</small></li>
				<li><small><b>Spelling (and grammar) Mistake Freq</b> is calculated from a random sampling of up to 10 tweets.</small></li>
			</ul>
			<hr />
		</div>
	</div>
</div>

<div class="col-xs-8">

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">Tweet Statistics</div>
		<table id="results" class="table table-condensed table-bordered">
		    <thead>
		      <tr>
		        <th valign="middle">#</th>
		        <th>Screen Name</th>
		        <th>Max Distance<br />(km)</th>
		        <th>Avg sent in a work day</th>
		        <th>Spelling Mistake Freq<br />(%)</th>
		      </tr>
		    </thead>
		    <tbody>
		    	<!-- Results -->
		    </tbody>
		</table>
	</div>
</div>

@stop

@section('scripts')

	{{ HTML::script('packages/kcahir/tweetcompare/js/app.js') }}

	<script type="text/javascript">

	$(function(){

		var App = new twitterApp({element:"compare",results:"results"});

	});

	</script>

@stop
