

function hostDetails( scan , host )
{		
	$( "#hostDetails" ).slideUp('fast' , function() 
	{	
		$.get( "intel_ajax_query.php", 
			{ 
				hostdataLog: true,
				scanid: scan, 
				hostid: host 
			},
			function( data )
			{					
				$( "#hostDetails" ).html( data );
				$( "#hostDetails" ).slideDown('slow' );
				$( "#errorDetails" ).slideUp('fast');
				$('html, body').animate({scrollTop:0}, 'slow');
			}
		);
	});
}


function launchRemoteDesktop( client )
{
	$.get( "intel_ajax_query.php", 
		{ 
			remoteDesktop: true,
			target: client
		},
		function( data )
		{					
			if( data.indexOf( 'Error' ) > -1 || data.indexOf( 'error' ) > -1 )
			{
				$( "#errorDetails" ).html( data );
				$( "#errorDetails" ).slideDown('fast');
				$('html, body').animate({scrollTop:0}, 'slow');
			}
		}
	);
}

var windowHeight;

$(document).ready( function()
{	
	windowHeight = $( window ).height();
	$( "#hostDetails" ).hide();
	$( "#errorDetails" ).hide();
	if( window.log_pie_chart )
	{
		log_pie_chart();
	}
	
	if( window.prepWolList )
	{
		prepWolList();
	}
	
	$( "#wakeupButton" ).button({
        icons: {
            primary: 'ui-icon-play'
        }
    });
	
	$( "#wakeupButton" ).click(function() { alert('test'); });
});
