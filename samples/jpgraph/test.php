<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ( '../conf.php' );
require_once ( '../db_mysql.php' );

$data = $stream->do_query("select * from bbusage order by id desc limit 0,30","array");

for($it = count($data) -1; $it > -1; $it--)
{
	$tmp = $data[$it];
	$datay1[] = $tmp[2];
	$datay2[] = $tmp[8];
	$datay3[] = $tmp[14];
	$dayLabels[] = date("d.m.y",$tmp[1]); 
}



// Setup the graph
$graph = new Graph(1000,600);
$graph->SetMarginColor('white');
$graph->SetScale("textlin");
$graph->SetFrame(false);
$graph->SetMargin(60,50,30,80);

$graph->title->Set('Smart 30 Day Rolling Broadband Usage');
$graph->title->SetFont(FF_VERDANA,FS_BOLD,12);

$graph->yaxis->HideZeroLabel();
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
$graph->xgrid->Show();

$graph->xaxis->SetTickLabels($dayLabels);
$graph->xaxis->SetLabelAngle(45);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);

// Create the first line
$p1 = new LinePlot($datay1);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("navy");
$p1->mark->SetWidth(3);
$p1->SetColor("navy");
$p1->SetLegend('Down (100.36)');
$graph->Add($p1);


// Create the second line
$p2 = new LinePlot($datay2);
$p2->mark->SetType(MARK_FILLEDCIRCLE);
$p2->mark->SetFillColor("red");
$p2->mark->SetWidth(3);
$p2->SetColor("red");
$p2->SetLegend('Up (40.23)');
$graph->Add($p2);

// Create the third line
$p3 = new LinePlot($datay3);
$p3->mark->SetType(MARK_FILLEDCIRCLE);
$p3->mark->SetFillColor("orange");
$p3->mark->SetWidth(3);
$p3->SetColor("orange");
$p3->SetLegend('Total (140.36)');
$graph->Add($p3);

$graph->legend->SetShadow('gray@0.4',5);
$graph->legend->SetPos(0.06,0.06,'right','top');
// Output line
$graph->Stroke();

?>


