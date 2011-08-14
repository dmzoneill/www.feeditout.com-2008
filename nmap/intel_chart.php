<?php 

function pie_chart( $title , $subtitle , $data )
{
	$chart = "
	var chart;
	
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'pie_container',
			margin: [50, 50, 50, -150],
			height:450,
			width:650
		},
		title: {
			text: '$title'
		},
		plotArea: {
			shadow: true,
			borderWidth: null,
			backgroundColor: null
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				dataLabels: {
					enabled: true,
					formatter: function() {
						if (this.y > 5) return this.point.name;
					},
					color: 'white',
					style: {
						font: '13px Trebuchet MS, Verdana, sans-serif'
					}
				}
			}
		},
		legend: {
			layout: 'vertical',
			style: {
				left: 'auto',
				bottom: 'auto',
				right: '20px',
				top: '150px'
			}
		},
	        series: [{
			type: 'pie',
			name: '$subtitle',
			data: [";
			for( $i = 0; $i < count($data); $i++ )
			{
				$dataarr = $data[ $i ];
				if( count( $dataarr ) == 0 )
				{
					$chart .= "['" . $dataarr[0] . "', " . $dataarr[1] . "],";					
				}
				else
				{
					$chart .= "{
						name: '" . $dataarr[0] . "',
						y: " . $dataarr[1] . ",
						sliced: true,
						selected: true
					},";
					
				}
			}
			$chart = substr( $chart , 0 , -1 );
			$chart .= "
			]			
		}]
	});	
	";
			
	return $chart;
}

?>