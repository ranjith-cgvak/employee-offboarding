@extends('layouts.app_home')

@section('content')


<!-- Progress bar -->

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
			<div class="progress_content">	
			<div class="arrow-steps clearfix">
				<div class="step current_prev"> <span> 1.Progress </span> </div>
				<div class="step current_prev"> <span> 2.Progress </span> </div>
				<div class="step current"> <span> 3.Progress </span> </div>
				<div class="step current_next"> <span> 4.Progress </span> </div>
				<div class="step current_next"> <span> 5.Progress </span> </div>
				<div class="step current_next"> <span> 6.Progress</span> </div>
				<div class="step current_next"> <span> 7.Progress</span> </div>
			</div>
			</div>	
        </div>
    </div>
</div>



<script>
  jQuery( document ).ready(function() {
		
		var back =jQuery(".prev");
		var	next = jQuery(".next");
		var	steps = jQuery(".step");
		
		next.bind("click", function() { 
			jQuery.each( steps, function( i ) {
				if (!jQuery(steps[i]).hasClass('current') && !jQuery(steps[i]).hasClass('done')) {
					jQuery(steps[i]).addClass('current');
					jQuery(steps[i - 1]).removeClass('current').addClass('done');
					return false;
				}
			})		
		});
		back.bind("click", function() { 
			jQuery.each( steps, function( i ) {
				if (jQuery(steps[i]).hasClass('done') && jQuery(steps[i + 1]).hasClass('current')) {
					jQuery(steps[i + 1]).removeClass('current');
					jQuery(steps[i]).removeClass('done').addClass('current');
					return false;
				}
			})		
		});

	})
</script>

@endsection
