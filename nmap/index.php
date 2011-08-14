<?php

require_once( "conf.php" );

?>
<html>
<head>
<style>

* {margin:0;padding:0}
/* mac hide \*/
html,body
{
	height:100%;
	width:100%;
	font-family: 'andale mono', 'monotype.com', monaco, 'courier new', courier, monospace;
}
/* end hide */
body 
{ 
	background-color: #ffffff;
	text-align:center;
	min-height:468px;/* for good browsers*/
	min-width:552px;/* for good browsers*/
}

#outer
{
	height:100%;
	width:100%;
	display:table;
	vertical-align:middle;
}

#container 
{
	text-align: center;
	position:relative;
	vertical-align:middle;
	display:table-cell;
	height: 468px;
} 

#inner 
{
	width: 752px;
	background:ffffff;
	height: 468px;
	text-align: center;
	margin-left:auto;
	margin-right:auto;
	border:0px solid #000;
}

fieldset
{
	border:0px solid #00d;
}

table, tr, td
{
	padding-left:10px;
	font-family: 'andale mono', 'monotype.com', monaco, 'courier new', courier, monospace;
	font-size:12pt;
	color:#095FA8;
	font-weight:bold;
}

input
{
	border: 0px;
	padding:5px;
	font-family: 'andale mono', 'monotype.com', monaco, 'courier new', courier, monospace;
	font-size:12pt;
	padding-top:2px;
	color:#095FA8;
}

</style>
</head>
<body>
<div id='outer'>
	<div id='container'>
		<div id='inner'>		
			<form>
			<table>
				<tr>
					<td>
						<img src='images/intel.jpg' />	
					</td>
					<td>			
						<br /><br />
						<table style='width:350px'>
							<tr>
								<td>
									Username :<br /><br />
								</td>
								<td>
									<input type='text' name='name' value='GER\ad_'><br /><br />
								</td>
							</tr>
							<tr>
								<td>
									Password :<br /><br />
								</td>
								<td>
									<input type='password' name='name'><br /><br />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:center;font-size:20pt'>Intel asset discovery and security analyzer</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>
