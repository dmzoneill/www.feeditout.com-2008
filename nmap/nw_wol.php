<?php

require_once( "conf.php" );
require_once( "intel_header.php" );

?>

<div id="optionPanels" class="slide" style="width:600px">
	<div id="1">
		<table>
			</tr>
				<td valign='top'>
					<div id="slider-vertical"></div>
				</td>
				<td valign='top'>
					<div id="content">
					    	<div id="scroll-pane"></div>
					</div>
					<br />
					<button id='wakeupButton'>Send Wake Up</button>					
				</td>
				<td valign='top'>
					<div style='margin-left:20px' id='result'>
						<?php 						
							flush();
							function wol( $addr , $mac , $socket_number )
							{
								$addr_byte = explode( ':' , $mac );
								$hw_addr = '';
							
								for ( $a=0; $a < 6; $a++ )
								{
									$hw_addr .= chr( hexdec( $addr_byte[$a] ) );
								}
							
								$msg = chr( 255 ) . chr( 255 ) . chr( 255 ) .chr( 255 ) . chr( 255 ) . chr( 255 );
							
								for ( $a = 1; $a <= 16; $a++ )
								{
									$msg .= $hw_addr;
								}
							
								$s = socket_create( AF_INET , SOCK_DGRAM , SOL_UDP );
								if ( $s == false )
								{
									echo "Error creating socket!\n";
									echo "Error code is '" . socket_last_error( $s ) . "' - " . socket_strerror( socket_last_error( $s ) );
								}
								else
								{
									$opt_ret = socket_set_option( $s , 1 , 6 , TRUE );
									if( $opt_ret < 0 )
									{
								 		echo "setsockopt() failed, error: " . strerror( $opt_ret ) . "\n";
									}
									$e = socket_sendto( $s , $msg , strlen($msg) , 0 , $addr , $socket_number );
									socket_close( $s );
									echo "Magic Packet sent to [ $mac ]<br />";
								}
							}
							
							$macs[] = "08:00:37:75:1E:B2";
							$macs[] = "00:1D:72:8C:94:5D";
							$macs[] = "00:90:A9:21:3A:F8";
							$macs[] = "00:90:D0:46:ED:F8";
							
							$socket_number = "32446";
							$ip_addy = "192.168.0.255";
							
							foreach( $macs as $mac )
							{	
								wol( $ip_addy , $mac , $socket_number );
							}						
						?>					
					</div>
				</td>													
			</tr>												
		</table>
	</div>
</div>


<script type='text/javascript' language='javascript'>

	
function handleSliderChange2(e, ui)
{
	var maxScroll = $("#content-scroll").attr("scrollHeight") - $("#content-scroll").height();
	$("#content-scroll").attr({scrollTop: -ui.value * (maxScroll / 100) });
}

function handleSliderSlide2(e, ui)
{
	var maxScroll = $("#content-scroll").attr("scrollHeight") - $("#content-scroll").height();
	$("#content-scroll").attr({scrollTop: -ui.value * (maxScroll / 100) });
}

function prepWolList()
{	
	$( "#content" ).css( "height" , (windowHeight - 300) + "px" );
	$( "#slider-vertical" ).css( "height" , (windowHeight - 300) + "px" );
	$( "#scroll-pane" ).empty();
	$( "#scroll-pane" ).html( "<ul id='variables'>" );

	<?php 
		$logs = $db->prepare( "SELECT DISTINCT addr FROM addresses where addrtype='mac'" );
		$logs->execute();
		$rows = $logs->fetchAll();
		
		print "var macs = new Array();\n";
		
		$i = 0;
		
		foreach( $rows as $row )
		{			
			print "        macs[ $i ] = '" . $row['addr'] . "';\n";
			$i++;
		}
	?>

	for( var t = 0 ; t < macs.length; t++)
	{
		$( "#scroll-pane" ).append( "<li><input type='checkbox' class='checkbox'> " + macs[t] + "</li>" );
	}
	$( "#scroll-pane" ).append( "</ul>" );
	
	var scrollPane = $( "#scroll-pane" );
	var scrollableHeight = scrollPane.height() - scrollPane.parent().height() || 0;
	$( "#slider-vertical" ).slider({
		animate:true,
		orientation: "vertical",
		range: "max",
		min: 0,
		max: scrollableHeight,
		value: scrollableHeight,
		change: function( event , ui ) 
		{
			scrollPane.css({top: ui.value - scrollableHeight});
		},
		slide: function( event , ui ) 
		{
			scrollPane.css({top: ui.value - scrollableHeight});
		}
	});
	
	$( "#slider-vertical" ).slider( "value" , scrollableHeight );
}

</script>

<?php

require_once( "intel_footer.php" );

?>
