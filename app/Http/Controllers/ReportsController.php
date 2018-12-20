<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Reports;
use App\Teams;
use App\Rows;
use App\Cells;
use App\Images;
use App\Doughnuts;
use Importer;
use PDF;


class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->addStatus != 'save') {
            $request->addStatus == 'empty';
        }

    	$reports = Reports::Where('user_id',  auth()->user()->id)
        ->OrderBy('id', 'Asc')
    	->get();

        return view('reports.index')
        ->with(compact('reports'))
        ->with('addStatus', $request->addStatus);
    }

    public function create(Request $request) {

    	$excel = Importer::make('Excel');
		$excel->load($request->file);
		$collection = $excel->getCollection();

    	$report = new Reports;
    	$report->report_name = $request->report_name;
    	$report->user_id = auth()->user()->id;
    	$report->client = $request->client;
    	$report->excel = $collection;
    	$report->description = $request->description;
    	$report->status = "Active";
        $report->generate = "single";
    	$report->save();

    	$reports = Reports::OrderBy('id', 'Asc')
    	->get();

        return redirect()->route('reports', ['addStatus' => 'save']);
    }

    public function manage(Request $request) {

        $report = Reports::FindorFail($request->id);

        $rows = Rows::Where('reportId', $report->id)
        ->delete();

        return view('reports.manage')
        ->with('lenCount', $request->id)
        ->with(compact('report'));
    }

    public function edit(Request $request){
        $excel = Importer::make('Excel');
        $excel->load($request->file);
        $collection = $excel->getCollection();

        $report = Reports::FindorFail($request->reportId);
        $report->excel = $collection;
        $report->save();

        return \Redirect::back()
        ->with('lenCount', $request->reportId)
        ->with(compact('report'));
    }

    public function addrow(Request $request) {
        if($request->saveType == "nextcurrent") {
            $report = Reports::FindorFail($request->reportId);
            $report->current = $request->current;
            $report->save();
        }

        if($request->saveType == "editGenType") {
            $report = Reports::FindorFail($request->reportId);
            $report->generate = $request->genType;
            $report->sFrom = $request->sFrom;
            $report->current = $request->sFrom;
            $report->sTo = $request->sTo;
            $report->save();
        }

        if($request->saveType == "clear") {
            $rows = Rows::Where('reportId', $request->id)
            ->delete();
        }


    	if($request->saveType == "header") {
    		$rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "header";
            $row->content1 = $request->headerText;
            $row->save();
	    }
        else if($request->saveType == "toc") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "toc";
            $row->content1 = $request->pCon;
            $row->content2 = $request->pNum;
            $row->save();
        }
        else if($request->saveType == "tac") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "tac";
            $row->content1 = $request->title;
            $row->content2 = $request->def;
            $row->save();
        }
        else if($request->saveType == "textbold") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "textbold";
            $row->content1 = $request->boldText;
            $row->save();
        }
        else if($request->saveType == "Colored Well") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "Colored Well";
            $row->colCount = "1";
            $row->content = $request->titleText;
            $row->content2 = $request->inputColContent;
            $row->save();
        }
        else if($request->saveType == "Progress Bar") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "Progress Bar";
            $row->colCount = "1";
            $row->content = $request->progressBar;
            $row->save();
            return $request->id;
        }
	    else if($request->saveType == "content") {
	    	$rows= Rows::Where('reportId', $request->id)
    		->get();
    		$check = $rows->max('rowOrder');
    		$check++;

    		$row = new Rows;
	    	$row->reportId = $request->id;
	    	$row->rowOrder = $check;
	    	$row->rowType = "content";
	    	$row->content1 = $request->inputText;
	    	$row->save();
	    }

        else if($request->saveType == "numbering") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "numbering";
            $row->content1 = $request->inputText;
            $row->save();
        }

        else if($request->saveType == "definition") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "definition";
            $row->content1 = $request->sub;
            $row->content2 = $request->def;
            $row->save();
        }

        else if($request->saveType == "bar") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "bar";
            $row->content1 = $request->name1;
            $row->content2 = $request->data1;
            $row->content3 = $request->name2;
            $row->content4 = $request->data2;
            $row->content5 = $request->name3;
            $row->content6 = $request->data3;
            $row->content7 = $request->imgData;
            $row->content8 = $request->title;
            $row->save();
        }

        else if($request->saveType == "bar4") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "bar4";
            $row->content1 = $request->name1;
            $row->content2 = $request->name2;
            $row->content3 = $request->data;
            $row->content4 = $request->leg;
            $row->save();
        }

        else if($request->saveType == "barEdit") {
            $row = Rows::FindorFail($request->id);
            $row->content7 = $request->imgData;
            $row->save();
        }

        else if($request->saveType == "bar4Edit") {
            $row = Rows::FindorFail($request->id);
            $row->content3 = $request->imgData;
            $row->content4 = $request->leg1;
            $row->content5 = $request->leg2;
            $row->content6 = $request->leg3;
            $row->content7 = $request->leg4;
            $row->save();
        }

        else if($request->saveType == "device1") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "device1";
            $row->content1 = $request->imgData;
            $row->content2 = $request->name1;
            $row->content3 = $request->name2;
            $row->content4 = $request->valJoin;
            $row->save();
        }

        else if($request->saveType == "device2") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "device2";
            $row->content1 = $request->imgData;
            $row->content2 = $request->name1;
            $row->content3 = $request->name2;
            $row->content4 = $request->valJoin;
            $row->save();
        }

        else if($request->saveType == "device1Edit") {
            $row = Rows::FindorFail($request->id);
            $row->content1 = $request->imgData;
            $row->save();
        }

        else if($request->saveType == "device2Edit") {
            $row = Rows::FindorFail($request->id);
            $row->content1 = $request->imgData;
            $row->save();
        }

        else if($request->saveType == "device3") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "device3";
            $row->content1 = $request->imgData;
            $row->content2 = $request->name1;
            $row->content3 = $request->name2;
            $row->content4 = $request->valJoin;
            $row->save();
        }

        else if($request->saveType == "device3Edit") {
            $row = Rows::FindorFail($request->id);
            $row->content1 = $request->imgData;
            $row->save();
        }

        else if($request->saveType == "donut") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "donut";
            $row->content1 = $request->header;

            $row->content2 = $request->name1;
            $row->content3 = $request->data1;
            $row->content4 = $request->imgData1;
            $row->content5 = $request->name2;
            $row->content6 = $request->data2;
            $row->content7 = $request->imgData2;
            $row->content8 = $request->name3;
            $row->content9 = $request->data3;
            $row->content10 = $request->imgData3;

            $row->save();
        }

        else if($request->saveType == "donutEdit") {
            $row = Rows::FindorFail($request->id);
            $row->content3 = $request->data1;
            $row->content4 = $request->imgData1;
            $row->content6 = $request->data2;
            $row->content7 = $request->imgData2;
            $row->content9 = $request->data3;
            $row->content10 = $request->imgData3;
            $row->save();
        }

        else if($request->saveType == "donut2") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "donut2";
            $row->content1 = $request->text;

            $row->content2 = $request->data1;
            $row->content3 = $request->imgData1;
            $row->content4 = $request->data2;
            $row->content5 = $request->imgData2;
            $row->content6 = $request->data3;
            $row->content7 = $request->imgData3;

            $row->save();
        }

        else if($request->saveType == "donut2Edit") {
            $row = Rows::FindorFail($request->id);
            $row->content2 = $request->data1;
            $row->content3 = $request->imgData1;
            $row->content4 = $request->data2;
            $row->content5 = $request->imgData2;
            $row->content6 = $request->data3;
            $row->content7 = $request->imgData3;

            $row->save();
        }

        else if($request->saveType == "horbar") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "horbar";

            $row->content1 = $request->name1;
            $row->content2 = $request->data1;
            $row->content3 = $request->name2;
            $row->content4 = $request->data2;
            $row->content5 = $request->imgData;
            $row->content6 = $request->ans;
            $row->content7 = $request->leg;

            $row->save();
        }

        else if($request->saveType == "horbarEdit") {
            $row= Rows::FindorFail($request->id);
            $row->content5 = $request->imgData;
            $row->save();
        }

        else if($request->saveType == "table") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "table";

            $row->content1 = $request->head;
            $row->content2 = $request->body;

            $row->save();
        }

        else if($request->saveType == "wellans") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "wellans";
            $row->content1 = $request->inputAnswer;

            $row->save();
        }

        else if($request->saveType == "colorwell") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "colorwell";
            $row->content1 = $request->text1;
            $row->content2 = $request->text2;

            $row->save();
        }

        else if($request->saveType == "donuthead") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "donuthead";
            $row->content1 = $request->name1;
            $row->content2 = $request->name2;
            $row->content3 = $request->name3;

            $row->save();
        }

        else if($request->saveType == "progress") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "progress";
            $row->content1 = $request->name1;
            $row->content2 = $request->name2;
            $row->content3 = $request->data12;
            $row->content4 = $request->leg;

            $row->save();
        }

        else if($request->saveType == "line") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "line";
            $row->content1 = $request->imgData;
            $row->content2 = $request->name1;
            $row->content3 = $request->name2;
            $row->content4 = $request->data1s;
            $row->content5 = $request->data2s;
            $row->content6 = $request->legend;
            $row->save();
        }

        else if($request->saveType == "lineEdit") {
            $row = Rows::FindorFail($request->id);
            $row->content1 = $request->imgData;
            $row->save();
        }

        else if($request->saveType == "Content with Text") {
            $ids = [];
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "Content with Text";
            $row->colCount = $request->colCount;
            $row->content = $request->headerText;
            $row->save();

            if($request->colCount > 3) {

            }
            else
            {
                $count = $request->colCount;
            }

            for($num=1;$num<=$count;$num++) {
                $cell = new Cells;
                $cell->rowId = $row->id;
                $cell->colCount = $num;
                $cell->type = 'Text';
                $cell->ContentA = 'n.a.';
                $cell->ContentB = 'n.a.';
                $cell->image = 'n.a.';
                $cell->save();
                $ids[] = $cell->id;
            }
            return $ids;
        }
        else if($request->saveType == "well") {
            $ids = [];
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "well";
            $row->content1 = $request->content;
            $row->save();
        }
        else if($request->saveType == "Spacer") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "Spacer";
            $row->colCount = "1";
            $row->content = "n.a.";
            $row->save();
        }

        else if($request->saveType == "Page Break") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "Page Break";
            $row->content1 = "n.a.";
            $row->save();
        }

        else if($request->saveType == "aboutus") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "aboutus";
            $row->save();
        }

        else if($request->saveType == "Doughnut Header") {
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request ->id;
            $row->rowOrder = $check;
            $row->rowType = "Doughnut Header";
            $row->colCount = "1";
            $row->content = "n.a.";
            $row->save();
        }

        else if($request->saveType == "Well (Header and Content)") {
            $ids = [];
            $rows= Rows::Where('reportId', $request->id)
            ->get();
            $check = $rows->max('rowOrder');
            $check++;

            $row = new Rows;
            $row->reportId = $request->id;
            $row->rowOrder = $check;
            $row->rowType = "Well (Header and Content)";
            $row->colCount = $request->colCount;
            $row->content = $request->headerText;
            $row->save();

            if($request->colCount > 3) {

            }
            else
            {
                $count = $request->colCount;
            }

            for($num=1;$num<=$count;$num++) {
                $cell = new Cells;
                $cell->rowId = $row->id;
                $cell->colCount = $num;
                $cell->type = 'Text';
                $cell->ContentA = 'n.a.';
                $cell->ContentB = 'n.a.';
                $cell->image = 'n.a.';
                $cell->save();
                $ids[] = $cell->id;
            }
            return $ids;
        }
    }

    public function chartdata(Request $request){
        $arrChart = array("bar", "bar4", "line", "donut", "horbar", "donut2", "device1", "device2", "device3");
        $rows = Rows::whereIn('rowType', $arrChart)
        ->get();
        return json_encode($rows);
    }

    public function getcell(Request $request) {
        $cell = Cells::FindorFail($request->id);
        return $cell;
    }

    public function updatecell(Request $request){
        $cell = Cells::FindorFail($request->id);

        if($request->type == "Text" || $request->type == "Bullet" || $request->type == "Numbering") {
            $cell->type = $request->type;
            $cell->ContentA = $request->inputText;
            $cell->save();
        }
        else if($request->type=="Well with Answer"){
            $cell->type = $request->type;
            $cell->ContentA = $request->inputAnswer;
            $cell->save();
        }
        else if($request->type == "Table") {
            $cell->type = $request->type;
            $cell->ContentA = $request->inputTableHeader;
            $cell->ContentB = $request->inputTableBody;
            $cell->save();
        }
        else if($request->type == "Definition") {
            $cell->type = $request->type;
            $cell->ContentA = $request->inputWord;
            $cell->ContentB = $request->inputDef;
            $cell->save();
        }

        else if($request->type == "Graph") {
            $cell->type = 'Graph';
            $cell->ContentA = $request->inputColumn;
            $cell->ContentB = $request->inputValue;
            $cell->image = $request->imgData;
            $cell->ContentC = $request->inputGraphTitle;
            $cell->save();
        }
        else if($request->type == "Graph Dual") {
            $cell->type = 'Graph Dual';
            $cell->ContentA = $request->inputColumn;
            $cell->ContentB = $request->inputValue;
            $cell->image = $request->imgData;
            $cell->ContentC = 'n.a.';
            $cell->save();
        }
        else if($request->type == "Device Graph 1") {
            $cell->type = 'Device Graph 1';
            $cell->ContentA = $request->inputDevValue1;
            $cell->ContentB = 'n.a.';
            $cell->image = $request->imgData;
            $cell->ContentC = 'n.a.';
            $cell->save();
        }
        else if($request->type == "Device Graph 2") {
            $cell->type = 'Device Graph 2';
            $cell->ContentA = $request->inputDevValue2;
            $cell->ContentB = 'n.a.';
            $cell->image = $request->imgData;
            $cell->ContentC = 'n.a.';
            $cell->save();
        }
        else if($request->type == "Horizontal Graph") {
            $cell->type = 'Horizontal Graph';
            $cell->ContentA = $request->inputColumn;
            $cell->ContentB = $request->inputValue;
            $cell->image = $request->imgData;
            $cell->ContentC = $request->inputGraphTitle;
            $cell->save();
        }
        else if($request->type == "Doughnut") {
            $cell->type = 'Doughnut';
            $cell->image = $request->imgData;
            $cell->ContentA = $request->dVal;
            $cell->ContentB = $request->dTot;
            $cell->ContentC = $request->dTitle;
            $cell->ContentD = $request->dColor;
            $cell->save();
        }
        else if($request->type == "Line") {
            $cell->type = 'Line';
            $cell->image = $request->imgData;
            $cell->ContentA = $request->inputData1;
            $cell->ContentB = $request->inputData2;
            $cell->save();
        }
    }

    public function preview(Request $request) {
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '8192M');
    	$report = Reports::FindorFail($request->id);
        $images = Images::OrderBy('id', 'Asc')
        ->get();
        $doughnuts = Doughnuts::OrderBy('id', 'Asc')
        ->get();

        $pdf = PDF::loadView('reports/preview', 
        	['report' => $report, 'images' => $images, 'user' =>  auth()->user()]
        );
        $pdf->setOptions(['isPhpEnabled' => true]);
       	$pdf->setPaper('A4', 'portrait');
        $finalName = "$report->broker_group  - $report->client";
       	return $pdf->stream($finalName.'.pdf',array('Attachment'=>0));

        /*$report = Reports::FindorFail($request->id);

        return view('reports.preview')
        ->with(compact('report')); */
    }

    public function download(Request $request) {
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '8192M');
        $report = Reports::FindorFail($request->id);
        $images = Images::OrderBy('id', 'Asc')
        ->get();
        $doughnuts = Doughnuts::OrderBy('id', 'Asc')
        ->get();

        $pdf = PDF::loadView('reports/preview', 
            ['report' => $report, 'images' => $images, 'user' =>  auth()->user()]
        );
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');
        $finalName = "$report->broker_group  - $report->client";
        return $pdf->download($finalName.'.pdf',array('Attachment'=>0));

        /*$report = Reports::FindorFail($request->id);

        return view('reports.preview')
        ->with(compact('report')); */
    }

    public function updaterep(Request $request){
        $report = Reports::FindorFail($request->id);
        $report->broker_group = $request->bgroup;
        $report->client = $request->broker;
        $report->type = $request->type;
        $report->save();
    }

}
