/* Author: Andreas Gehle */

$(document).ready(function() {


//Build Ad-Slider
adslider(4);

//Bind menu mousehover
$('nav > ul > li').mouseover(navOpen);
$('nav > ul > li').mouseout(navTimer);


//Bind tops and flops
var last_action = 0;
var lock = false;

//Disable form submit
$('form.send_rate').submit(function() { return false; });

$('button[name="rate"]').click(function(){
	var button = $(this);
	if( ! lock && ! button.is(last_action)){
		lock = true;
		last_action = button;
		sendRate(button.parents('form:eq(0)'), button.val());
	}
});

//Ajax Rating
function sendRate(form, value){
	var parent = form.parents('li:eq(0)');
	var like = parent.find('.like:eq(0)');
	var dislike = parent.find('.dislike:eq(0)');
	
	form.ajaxSubmit({
		type: 'POST',
		data: { rate: value},
    	dataType: 'json',
		beforeSubmit: function() {
			//Clean old info
			$('#info').html('');
		},
		success: function(json){
			//Display errors
			for(var i in json.errors) {
				$('#info').append(
					'<p class="error color border"><span class="icon color icon100"></span>'+
					json.errors[i] +
					'</p>'
				);
			}
			
			//Update chartbar
			if( ! $.isEmptyObject(json.data)){
				like.css('width', json.data.like);
				dislike.css('width', json.data.dislike);
	
				var num;
	
				if(value != json.data.has_rated){
					if(value == 1){
						num = parseInt(like.text());
						like.text(num +1);
						if(json.data.has_rated >= 0){
							num = parseInt(dislike.text());
							dislike.text(num -1);
						}
					}else{
						num = parseInt(dislike.text());
						dislike.text(num +1);
						if(json.data.has_rated >= 0){
							num = parseInt(like.text());
							like.text(num -1);
						}
					}
				}
			}
			
			//Set new csrf
			$('input[name="'+json.csrf_token_name+'"]').val(json.csrf_hash);
			
			//Rest lock
			lock = false;
		},
		error: function(e){
			$('#info').html(
				'<p class="error color border"><span class="icon color icon100"></span>'+
				e.responseText +
				'</p>'
			);
		}
	});
}

//Ajax Uploader
$('form#upload').ajaxForm({
	type: 'POST',
	dataType: 'json',
	beforeSubmit: function() {
		//Clean old info
		$('#info').html('');
	},
	success: function(json){
		//Display errors
		for(var i in json.errors) {
			$('#info').append(
				'<p class="error color border"><span class="icon color icon100"></span>'+
				json.errors[i] +
				'</p>'
			);
		}
		
		//Display new uploads
		if(json.data.length > 0) {
			for(var i in json.data) {
				$('#info').append(
					'<p class="success color border"><span class="icon color icon101"></span>'+
					'Uploaded '+json.data[i].file_name +' successful.'+
					'</p>'
				);
			
				$('#list > ul').append(
					'<li>'+
						'<div style="width:110px; height:64px">'+
							'<img src="'+json.data[i].preview+'" alt="'+json.data[i].raw_name+' preview" width="64" height="64" />'+
						'</div>'+
						'<p>'+
							json.data[i].raw_name +
						'</p>'+
					'</li>'
				);
			}
			
			$(this).clearForm();
		}
		//Set new csrf
		$('input[name="'+json.csrf_token_name+'"]').val(json.csrf_hash);
	},
	error: function(e){
		$('#info').html(
			'<p class="error color border"><span class="icon color icon100"></span>'+
			e.responseText +
			'</p>'
		);
	}
});

//Ajax comment
$('form#comment').ajaxForm({
	type: 'POST',
	dataType: 'json',
	beforeSubmit: function() {
		//Clean old info
		$('#info').html('');
	},
	success: function(json){
		//Display errors
		for(var i in json.errors) {
			$('#info').append(
				'<p class="error color border"><span class="icon color icon100"></span>'+
				json.errors[i] +
				'</p>'
			);
		}
		
		//Update input
		if(json.errors.toString().length > 0) {
			if(json.data.length > 0) {
				$('textarea[name="comment"]').val(json.data);
			}
		}
		//Display new comment
		else
		{
			$('#info').append(
				'<p class="success color border"><span class="icon color icon101"></span>'+
				'Comment added.' +
				'</p>'
			);
			
			$('#lister ul > br').first().after(
				'<li style="height: 90px">'+
					'<time style="padding:0;" datetime="'+ISODateString(new Date())+'">'+
						'Today'+
					'</time><br/>'+
					'<span class="none solid">You</span>'+
				'</li>'+
				'<li style="width: 496px; margin-left:15px; text-align: left;">'+
					json.data+
				'</li>'+
				'<br class="clear" />'
			);
			
			$(this).clearForm();
		}
		//Set new csrf
		$('input[name="'+json.csrf_token_name+'"]').val(json.csrf_hash);
	},
	error: function(e){
		$('#info').html(
			'<p class="error color border"><span class="icon color icon100"></span>'+
			e.responseText +
			'</p>'
		);
	}
});

//Close document ready
});

function ISODateString(d) {
    function pad(n){
        return n<10 ? '0'+n : n
    }
    return d.getUTCFullYear()+'-'
    + pad(d.getUTCMonth()+1)+'-'
    + pad(d.getUTCDate())+'T'
    + pad(d.getUTCHours())+':'
    + pad(d.getUTCMinutes())+':'
    + pad(d.getUTCSeconds())+'Z'
}