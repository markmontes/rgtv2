@extends('layouts.app')

@section('content')

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <!-- <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
</head>
<body style="background-color:#ffffff;">

</body>
    
<input type="hidden" id="reportId" value="{{ $report->id }}">
<input type="hidden" id="reportExcel" value="{{ $report->excel }}">

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
               
                <div class="card-header">
                    Report Details ({{ $report->id }})
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" id="lenCount" value="{{ $lenCount }}">
                    Report Name
                    <br>
                    <b>{{ $report->report_name }}</b><br><br>

                    Client Name
                    <br>
                    <b>{{ $report->client }}</b><br><br>

                    Created By
                    <br>
                    <b>{{ $report->user->name }}</b><br>
                    <br><br>

                    <b>Generate Single Report</b>
                    <br>
                    Shopper's Name<br>
                    <select id="shopperId" name="shopperId" class="form-control">
                    </select>
                    <br>
                    <button id="generateReport" class="btn btn-primary form-control">
                        <i class="far fa-file-pdf"></i> Generate Single Report
                    </button> 
                    <br><br>

                    <div id="tGuide" style="background-color:#c9fff8;">
                        type
                        <input type="text" id="genType" value="{{ $report->generate }}" class="form-control">
                        current
                        <input type="text" id="current" value="{{ $report->current }}" class="form-control">
                        to
                        <input type="text" id="sTo" value="{{ $report->sTo }}" class="form-control">
                        <br>
                    </div>
                    <div>
                        <b>Generate Batch Report</b>
                    @if($report->generate=="single")
                            <br>
                            From
                            <br>
                            <select id="shopperIdf" name="shopperId" class="form-control">
                            </select>
                            To
                            <br>
                            <select id="shopperIdt" name="shopperId" class="form-control">
                            </select>
                            <br>
                            <button id="generateReport2" class="btn btn-primary form-control">
                               <i class="far fa-file-pdf"></i> <i class="far fa-file-pdf"></i> Generate Batch Report
                            </button>
                        </div> 
                    @else($report->generate=="single")
                            <button id="stopBatch" class="btn btn-danger form-control">
                                Stop Batch Generating
                            </button>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Report Progress

                    <div class="pull-right">
                        
                    </div>
                </div>
                <div class="card-body">
                    <span id="pCalc">Fetching Excel Data...<br></span>
                    <span id="pGen">Generating PDF Charts and Contents...<br></span>
                    <div id="pProg" class="progress">
                        <div id="mainBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>

                     @if($report->generate == "batch")
                        @php ($pdf1 = intval($report->current) - intval($report->sFrom)) @endphp
                        @php ($pdf2 = (intval($report->sTo) - intval($report->sFrom)) + 1) @endphp

                        <div id="pdfProg">
                            Generated PDF: <b><span style="color:green;">{{ $pdf1 }} / {{ $pdf2 }}</span></b>
                        </div>
                    @endif
                    
                    <span id="pFin" style="color:green;"><b>Rendering Finished!</b><br></span>
                    <div id="pView">
                        <a href="/reports/manage/preview/{{ $report->id }}" target="_blank">
                            <button class="btn btn-success">
                                <i class="fa fa-eye"></i> View PDF
                            </button>
                        </a>
                        <a href="/reports/manage/download/{{ $report->id }}" target="_blank">
                            <button class="btn btn-success">
                                <i class="fa fa-download"></i> Download PDF
                            </button>
                        </a>
                        
                    </div>

                    <div id="grid1" ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>

                </div>
            </div>
        </div>

    </div>
    <div id="nexter"></div>

    <br><br>
    <!-- <canvas id="chartjs-1" width="100%" style="visibility:visible;"></canvas>
    <br>
    <canvas id="chartjs-2" width="100%" style="visibility:visible; background-color:#e8e8e8;"></canvas> -->
    <br>

    <div style="background-color:#ffffff;">
        <br>
        <div><canvas id="canDev1" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <div><canvas id="canDev2" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <div><canvas id="canDev3" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <div><canvas id="canBar" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <div><canvas id="canBar4" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <div><canvas id="canLine" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <div><canvas id="canHorBar" width="100%" style="visibility:visible; background-color:#ffffff;"></canvas></div>
        <br>
        <br>
        <div><canvas id="canDoA1" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
        <div><canvas id="canDoA2" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
        <div><canvas id="canDoA3" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>

        <div><canvas id="canDoB1" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
        <div><canvas id="canDoB2" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
        <div><canvas id="canDoB3" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>

        <div><canvas id="canDoC1" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
        <div><canvas id="canDoC2" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
        <div><canvas id="canDoC3" width="100%" style="visibility:visible; background-color:#e8e8e8"></canvas></div>
        <br>
    </div>



</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Edit Source File</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <form method="POST" action="{{ route('reports.edit') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="reportId" value="{{ $lenCount }}">
            Replace Excel File<br>
            <input type="file" name="file" class="form-control" class="btn btn-primary" accept=".xlsx" required><br>
            <input type="submit" value="Update" class="btn btn-primary form-control">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

  <script>
    
    $(document).ready(function(){
        $('#tGuide').hide();
        var reportId = $('#reportId').val();
        var reportExcel= $('#reportExcel').val();
        var jsonResp = JSON.parse(reportExcel);
        var doCount = 1;  

        $.each(jsonResp, function(key, val) { 
            var selData = jsonResp[key][2];
            $("#shopperId").append($('<option>', {
                value: key,
                text: selData
            }));

            $("#shopperIdf").append($('<option>', {
                value: key,
                text: selData
            }));

            $("#shopperIdt").append($('<option>', {
                value: key,
                text: selData
            }));

        })

        resetProg();

        // $('#generateReport2').click(function(){
        //     lenCount++;
        //     var url = "/reports/manage/" + lenCount;
        //     window.location.assign(url);
        //     window.open('/reports/manage/preview/1', '_blank'); 
        // });


        function splitter(arr){

            var dataArr = arr.split('<break>');
            // console.log(dataArr)
            var newData = dataArr.join("\n");
            return newData;
        }

        function makeArray(arr){
            var dataArr = arr.split('<break>');
            return dataArr;
        }

        function resetProg(){
            $('#pCalc').hide();
            $('#pGen').hide();
            $('#pProg').hide();
            $('#pFin').hide();
            $('#pView').hide();
        }

        

        $('#stopBatch').click(function(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/reports/addrow',
                async: true,
                data: {reportId: reportId, genType: 'single', sFrom: "", sTo: "", saveType: 'editGenType'},
                success: function(result){
                    location.reload();
                }
            });
        });

        $('#generateReport2').click(function(){
            var sFrom = $('#shopperIdf').val();
            var sTo = $('#shopperIdt').val();

            if(parseInt(sFrom) > parseInt(sTo) || parseInt(sFrom) == parseInt(sTo)){
                alert("Invalid Sequence");
            }
            else {
                $('#current').val('batch');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/reports/addrow',
                    async: true,
                    data: {reportId: reportId, genType: 'batch', sFrom: sFrom, sTo: sTo, saveType: 'editGenType'},
                    success: function(result){
                        location.reload();
                    }
                });

            }
            
        });


        $('#generateReport').click(function(){
            resetProg();
            $('#current').val('single');
            var shopperId = $('#shopperId').val();
            var row = parseInt(shopperId) + 1;
            var sData = jsonResp[shopperId];
            var arrLen = sData.length;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/reports/addrow',
                async: true,
                data: {saveType: 'clear'},
                success: function(result){

                }
            });

            $.ajax({
                type: 'GET',
                url: '/reports/updaterep',
                async: true,
                data: {id: reportId, bgroup: sData[1], broker: sData[2], type: sData[3]},
                success: function(result){

                }
            });

            var num1 = 4;
            var prev = "";


            $('#pCalc').show();
            var totCont = 0;
            var chrtCont = 0;
            sData.forEach(function(item) {
                if(item=="toc" || item=="tac" || item=="pagebreak" || item=="aboutus" || item=="header" || item=="content" || item=="numbering" || item=="definition"  ||item=="line" ||item=="textbold" || item=="donut" || item=="Donut" || item=="well"|| item=="bar" || item=="horbar" || item=="table" || item=="progress" || item=="colorwell" || item=="donuthead" || item=="donut2" || item=="device1" || item=="device2" || item=="device3" || item=="wellans" || item=="donuthead"){
                    totCont++;
                }
            });

            var ajaxCnt = 0;
            var adder = 50 / totCont;
            var testProd = adder * totCont;
            // console.log("adder = " + adder);
            // console.log("total  = " + totCont);
            $('#pGen').show();
            $('#pProg').show();
            var progVal = 0;
            $('#mainBar').css('width', progVal+'%');


            var runReport = setInterval(function(){
                // console.log(sData[num1]);
                if(sData[num1] == "toc"){
                    var pCon = splitter(sData[num1+1]);
                    var pNum = splitter(sData[num1+2]);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'toc', pCon: pCon, pNum: pNum},
                        success: function(result){
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "toc";
                    num1 += 3;
                }

                else if(sData[num1] == "tac"){
                    var title = sData[num1+1];
                    var def = splitter(sData[num1+2]);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'tac', title: title, def: def},
                        success: function(result){
                            // // console.log("tac");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "tac";
                    num1 += 3;
                }

                else if(sData[num1] == "pagebreak"){
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'Page Break'},
                        success: function(result){
                            // // console.log("pagebreak");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "pagebreak";
                    num1++;

                }

                else if(sData[num1] == "aboutus"){
                    // console.log("aboutus");
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'aboutus'},
                        success: function(result){
                            // // console.log("pagebreak");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "aboutus";
                    num1++;

                }

                else if(sData[num1] == "header"){
                    var title = sData[num1+1];
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, headerText: title, saveType: 'header'},
                        success: function(result){
                            // // console.log("header");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "header";
                    num1 += 2;
                    
                }
                else if(sData[num1] == "content"){
                    var text = splitter(sData[num1+1]);
                     $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, inputText: text, saveType: 'content'},
                        success: function(result){
                            // // console.log("content");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                     prev = "content";
                    num1 += 2;
                }
                else if(sData[num1] == "numbering"){
                    var num = splitter(sData[num1+1]);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, inputText: num, saveType: 'numbering'},
                        success: function(result){
                            // // console.log("numbering");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "numbering";
                    num1 += 2;
                }
                else if(sData[num1] == "definition"){
                    var sub = splitter(sData[num1+1]);
                    var def = splitter(sData[num1+2]);

                     $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, sub: sub, def: def, saveType: 'definition'},
                        success: function(result){
                            // // console.log("def");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "definition";
                    num1 += 3;
                }
                else if(sData[num1] == "bar"){
                    var title = sData[num1+1];

                    var name1 = sData[num1+2];
                    var data1 = parseInt(sData[num1+3]);

                    var name2 = sData[num1+4];
                    var data2 = parseInt(sData[num1+5]);

                    var name3 = sData[num1+6];
                    var data3 = parseInt(sData[num1+7]);

                    // console.log("bar " + sData[num1+3] + " " + sData[num1+5] + " " + sData[num1+7]);

                    var cols = [name1, name2, name3];
                    var vals = [data1, data2, data3];
                    var len = cols.length;
                    var arr = [];
                    var num = 0;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, name1: name1, data1: data1, name2: name2, data2: data2, name3: name3, data3: data3, imgData: 'n.a.', title: title, saveType: 'bar'},
                        success: function(result){
                            // // console.log("bar");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });


                    prev = "bar";

                    num1 += 8;
                }

                else if(sData[num1] == "bar4"){
                    var name1 = sData[num1+1];
                    var name2 = sData[num1+2];
                    var data = sData[num1+3];
                    var leg = sData[num1+4];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, name1: name1, name2: name2, data: data, leg: leg, saveType: 'bar4'},
                        success: function(result){
                            // // console.log("bar");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });


                    prev = "bar4";

                    num1 += 5;
                }

                else if(sData[num1] == "line"){

                    var disType = makeArray(sData[num1+1]);
                    var data1s = makeArray(sData[num1+3]);
                    var data2s = makeArray(sData[num1+5]);

                    var name1 = sData[num1+2];
                    var name2 = sData[num1+4];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, legend: sData[num1+1], name1: name1, name2: name2, data2s: sData[num1+3], data1s: sData[num1+5], imgData: 'n.a.', saveType: 'line'},
                        success: function(result){
                            // // console.log("line");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    
                    prev = "line";
                    num1 += 6;
                }

                else if(sData[num1] == "textbold"){
                    var boldText = sData[num1+1]
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, boldText: boldText, saveType: 'textbold'},
                        success: function(result){
                            // // console.log("textbold");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                    prev = "textbold";
                    num1 += 2;
                }

                else if(sData[num1] == "Donut"){
                    var header = sData[num1+1];

                    var name1 = sData[num1+2];
                    var data1 = sData[num1+3];
                    var name2 = sData[num1+4];
                    var data2 = sData[num1+5];
                    var name3 = sData[num1+6];
                    var data3 = sData[num1+7];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, disType: disType, header: header, name1: name1, data1: data1, name2: name2, data2: data2, name3: name3, data3: data3, imgData1: 'n.a.', imgData2: 'n.a.', imgData3: 'n.a.', saveType: 'donut'},
                        success: function(result){
                            // // console.log("donut");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });
                   
                    prev = "donut";
                    num1 += 8;
                }

                else if(sData[num1] == "well"){
                    var content = sData[num1 + 1];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, content: content, saveType: 'well'},
                        success: function(result){
                            // // console.log("well");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "well";
                    num1 += 2;
                }

                else if(sData[num1] == "horbar"){
                    var ans = sData[num1 + 1];
                    var name1 = sData[num1 + 2];
                    var data1 = sData[num1 + 3];
                    var name2 = sData[num1 + 4];
                    var data2 = sData[num1 + 5];
                    var leg = sData[num1 + 6];

                    var cols = [name1, name2];
                    var val = [data1, data2];

                     $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId,  ans: ans, leg: leg,  name1: name1, data1: data1, name2: name2, data2: data2, imgData: 'n.a.', saveType: 'horbar'},
                        success: function(result){
                            // // console.log("HorBar");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });


                    prev = "horbar";
                    num1 += 7;
                }

                else if(sData[num1] == "table"){
                    var head = splitter(sData[num1+1]);
                    var body = splitter(sData[num1+2]);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, head:head, body:body, saveType: 'table'},
                        success: function(result){
                            // // console.log("table");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "table";
                    num1 += 3;
                }

                else if(sData[num1] == "wellans"){
                    var inputAnswer = sData[num1+1];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'wellans', inputAnswer: inputAnswer},
                        success: function(result){
                            // // console.log("wellans");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "wellans";
                    num1 += 2;
                }

                else if(sData[num1] == "progress"){
                    var name1 = sData[num1 + 1];
                    var name2 = sData[num1 + 2];
                    var data12 = splitter(sData[num1+3]);
                    var leg = splitter(sData[num1+4]);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'progress', name1: name1, name2: name2, data12: data12, leg: leg},
                        success: function(result){
                            // // console.log("progress");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "progress";
                    num1 += 5;
                }

                else if(sData[num1] == "colorwell"){
                    var text1 = sData[num1 + 1];
                    var text2 = sData[num1 + 2];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'colorwell', text1: text1, text2: text2},
                        success: function(result){
                            // // console.log("colorwell");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "colorwell";
                    num1 += 3;
                }

                else if(sData[num1] == "donuthead"){
                    var name1 = sData[num1 + 1];
                    var name2 = sData[num1 + 2];
                    var name3 = sData[num1 + 3];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, saveType: 'donuthead', name1: name1, name2:name2, name3: name3},
                        success: function(result){
                            // // console.log("donuthead");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    num1 += 4;
                }

                else if(sData[num1] == "donut2"){
                    var text = sData[num1 + 1];
                    var data1 = sData[num1 + 2];
                    var data2 = sData[num1 + 3];
                    var data3 = sData[num1 + 4];

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, text: text, data1: data1, data2: data2, data3: data3, imgData1: 'n.a.', imgData2: 'n.a.', imgData3: 'n.a.', saveType: 'donut2'},
                        success: function(result){
                            // // console.log("donut2");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "donut2";

                    num1 += 5;
                }

                else if(sData[num1] == "device1"){
                    var name1 = sData[num1 + 1];
                    var name2 = sData[num1 + 2];
                    var n1 = sData[num1 + 3];
                    var n2 = sData[num1 + 4];
                    var n3 = sData[num1 + 5];
                    var n4 = sData[num1 + 6];
                    var n5 = sData[num1 + 7];
                    var n6 = sData[num1 + 8];
                    var n7 = sData[num1 + 9];
                    var n8 = sData[num1 + 10];
                    var n9 = sData[num1 + 11];
                    var n10 = sData[num1 + 12];
                    var n11 = sData[num1 + 13];
                    var n12 = sData[num1 + 14];


                    var vals = [n1, n2, n3, n4, n5, n6, n7, n8, n9, n10, n11, n12];
                    var valJoin = vals.join(",");

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, name1: name1, name2: name2, imgData: 'n.a.', valJoin: valJoin, saveType: 'device1'},
                        success: function(result){
                            // // console.log("device1");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "device1";
                    num1 += 15;
                }

                else if(sData[num1] == "device2"){
                    var name1 = sData[num1 + 1];
                    var name2 = sData[num1 + 2];
                    var n1 = sData[num1 + 3];
                    var n2 = sData[num1 + 4];
                    var n3 = sData[num1 + 5];
                    var n4 = sData[num1 + 6];
                    var n5 = sData[num1 + 7];
                    var n6 = sData[num1 + 8];
                    var n7 = sData[num1 + 9];
                    var n8 = sData[num1 + 10];
                    var n9 = sData[num1 + 11];
                    var n10 = sData[num1 + 12];


                    var vals = [n1, n2, n3, n4, n5, n6, n7, n8, n9, n10];
                    var valJoin = vals.join(",");

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, name1: name1, name2: name2, imgData: 'n.a.', valJoin: valJoin, saveType: 'device2'},
                        success: function(result){
                            // // console.log("device2");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "device2";
                    num1 += 13;
                }

                else if(sData[num1] == "device3"){
                    var name1 = sData[num1 + 1];
                    var name2 = sData[num1 + 2];
                    var n1 = sData[num1 + 3];
                    var n2 = sData[num1 + 4];
                    var n3 = sData[num1 + 5];
                    var n4 = sData[num1 + 6];
                    var n5 = sData[num1 + 7];
                    var n6 = sData[num1 + 8];


                    var vals = [n1, n2, n3, n4, n5, n6];
                    var valJoin = vals.join(",");

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/addrow',
                        async: true,
                        data: {id: reportId, name1: name1, name2: name2, imgData: 'n.a.', valJoin: valJoin, saveType: 'device3'},
                        success: function(result){
                            // // console.log("device3");
                            progVal = progVal + adder;
                            // console.log("=== " + progVal +  " === ");
                            $('#mainBar').css('width', progVal+'%');
                        }
                    });

                    prev = "device3";
                    num1 += 9;
                }

                else{
                    clearInterval(runReport);
                    // // console.log("DONE!");
                    var errCol = convertToNumberingScheme(num1);
                    // // console.log("ERROR ON COLUMN # " + errCol);

                    setTimeout(function(){ 
                        renderChart(reportId, progVal);
                    }, 5000);
                    


                    num1++;
                    //alert("Excel File Error on row " + row);
                }

                if(num1 >= arrLen){
                    // // console.log("DONE 2");
                    clearInterval(runReport);
                    renderChart(reportId, progVal);
                }
                // // console.log(prev + " 2");
                

            }, 500)

        });

        function convertToNumberingScheme(number) {
            var baseChar = ("A").charCodeAt(0),
              letters  = "";

            do {
                number -= 1;
                letters = String.fromCharCode(baseChar + (number % 26)) + letters;
            number = (number / 26) >> 0; // quick `floor`
            } while(number > 0);

          return letters;
        }


        function renderChart(reportId, progVal){
            // console.log("passed ProgVal = " + progVal);
            var arrRen = [];
            var numRen = 0;
            $.ajax({
                type: 'GET',
                url: '/reports/chartdata',
                async: true,
                data: {id: reportId},
                success: function(result){
                    arrRen = JSON.parse(result);
                    progVal = 50;
                    var arrRenLen = arrRen.length;
                    var adder = 50 / arrRenLen;
                    $('#mainBar').css('width', '50%');

                    var runRender = setInterval(function(){
                        console.log("start -> " + arrRen[numRen].rowType);
                        if(arrRen[numRen].rowType == "bar"){
                            var barId = arrRen[numRen].id;
                            var title = arrRen[numRen].content8;

                            var name1 = arrRen[numRen].content1;
                            var data1 = arrRen[numRen].content2;

                            var name2 = arrRen[numRen].content3;
                            var data2 = arrRen[numRen].content4;

                            var name3 = arrRen[numRen].content5;
                            var data3 = arrRen[numRen].content6;

                            var cols = [name1, name2, name3];
                            var vals = [data1, data2, data3];
                            var len = cols.length;
                            var arr = [];
                            var num = 0;

                            var ctx = document.getElementById("canBar").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: cols,
                                    datasets: [{
                                        label: '# of Votes',
                                        data: vals,
                                        backgroundColor: [
                                            'rgba(237, 134, 0, 1)',
                                            'rgba(84, 84, 84, 1)',
                                            'rgba(28, 164, 255, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderColor: [
                                            'rgba(237, 134, 0, 1)',
                                            'rgba(84, 84, 84, 1)',
                                            'rgba(28, 164, 255, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 5
                                    }]
                                },
                                options: {

                                    animation: {
                                        duration: 0,
                                      onComplete: function () {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        var height = chartInstance.controller.boxes[0].bottom;
                                        ctx.textAlign = "center";
                                        ctx.fontSize = 50;
                                        ctx.fillStyle = "white";

                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                          var meta = chartInstance.controller.getDatasetMeta(i);
                                          Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            var barData = parseInt(dataset.data[index]);
                                            var barYdata = bar._model.y + 70;
                                            if(barData < 25){
                                                barYdata = barYdata - 85;
                                                ctx.fillStyle = "#ed8601";
                                                ctx.fillText(dataset.data[index], bar._model.x, barYdata);
                                            }
                                            else {
                                                ctx.fillStyle = "white";
                                                ctx.fillText(dataset.data[index], bar._model.x, bar._model.y + 70);
                                            }

                                            
                                          }),this)
                                        }),this);
                                      }
                                    },

                                    legend: {
                                        display: false
                                     },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display:false,
                                                color: 'black',
                                                gridThickness: 20,
                                            },
                                            ticks: {
                                                beginAtZero:true,
                                                max: 100,
                                                fontSize: 40
                                            }
                                        }],
                                        xAxes: [{
                                            maxBarThickness: 140,
                                            borderWidth: 1,
                                            gridLines: {
                                                display:false,
                                            },
                                            display:false
                                        }]
                                    }
                                }
                            });

                            var inputGraphTitle = title;
                            var imgData;

                            html2canvas(document.getElementById("canBar"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);
                                    

                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: barId, name1: name1, data1: data1, name2: name2, data2: data2, name3: name3, imgData: imgData, title: title, saveType: 'barEdit'},
                                        success: function(result){
                                            progVal = progVal + adder;
                                            // console.log("=== " + progVal +  " === ");
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> bar");
                                            if(progVal >= 99.99){
                                                clearInterval(runRender);
                                                fncDone();
                                            }
                                        }
                                    });

                                },
                            });
                        }

                        else if(arrRen[numRen].rowType == "bar4"){

                            var name1 = arrRen[numRen].content1;
                            var name2 = arrRen[numRen].content2;
                            var data = makeArray(arrRen[numRen].content3);
                            var legTemp = arrRen[numRen].content4;
                            var leg = legTemp.split('<break>');
                            var num1 = data[0];
                            var num2 = data[1];
                            var num3 = data[2];
                            var num4 = data[3];
                            var num5 = data[4];
                            var num6 = data[5];
                            var num7 = data[6];
                            var num8 = data[7];

                            var leg1 = leg[0];
                            var leg2 = leg[1];
                            var leg3 = leg[2];
                            var leg4 = leg[3];

                            var ctx = document.getElementById("canBar4").getContext("2d");

                            var data = {
                                labels: leg,
                                datasets: [
                                    {
                                        label: name1,
                                        backgroundColor: "#545454",
                                        data: [num1, num3, num5, num7]
                                    },
                                    {
                                        label: name2,
                                        backgroundColor: "#1ca4ff",
                                        data: [num2, num4, num6, num8]
                                    }
                                ]
                            };

                            var myBarChart = new Chart(ctx, {
                                type: 'bar',
                                data: data,
                                options: {
                                    legend: {
                                        display: false
                                     },

                                    animation: {
                                        duration: 0,
                                      onComplete: function () {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        var height = chartInstance.controller.boxes[0].bottom;
                                        ctx.textAlign = "center";
                                        ctx.fontSize = 50;
                                        ctx.fillStyle = "white";

                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                          var meta = chartInstance.controller.getDatasetMeta(i);
                                          Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            var barData = parseInt(dataset.data[index]);
                                            var barYdata = bar._model.y + 70;
                                            if(barData < 25){
                                                barYdata = barYdata - 85;
                                                ctx.fillStyle = "black";
                                                ctx.fillText(dataset.data[index], bar._model.x, barYdata);
                                            }
                                            else {
                                                ctx.fillStyle = "white";
                                                ctx.fillText(dataset.data[index], bar._model.x, bar._model.y + 70);
                                            }

                                            
                                          }),this)
                                        }),this);
                                      }
                                    },

                                    legend: {
                                        display: false
                                     },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display:false,
                                                color: 'black',
                                                gridThickness: 20,
                                            },
                                            ticks: {
                                                beginAtZero:true,
                                                max: 100,
                                                fontSize: 40
                                            }
                                        }],
                                        xAxes: [{
                                            maxBarThickness: 140,
                                            borderWidth: 1,
                                            gridLines: {
                                                display:false,
                                            },
                                            display: false
                                            
                                        }]
                                    }
                                }
                            });


                            var imgData;
                            var bar4Id = arrRen[numRen].id;
                            html2canvas(document.getElementById("canBar4"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);
                                    

                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: bar4Id, name1: name1, name2: name2, leg1: leg1, leg2: leg2, leg3: leg3, leg4: leg4, imgData: imgData, saveType: 'bar4Edit'},
                                        success: function(result){
                                            progVal = progVal + adder;
                                            // console.log("=== " + progVal +  " === ");
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> bar4");
                                            if(progVal >= 99.99){
                                                fncDone();
                                            }
                                        }
                                    });

                                },
                            });


                        }

                        else if(arrRen[numRen].rowType == "line"){

                            var disType = makeArray(arrRen[numRen].content6);
                            var data1s = makeArray(arrRen[numRen].content4);
                            var data2s = makeArray(arrRen[numRen].content5);

                            var name1 = arrRen[numRen].content2;
                            var name2 = arrRen[numRen].content3;

                            var d1min = Math.min.apply(Math,data1s);
                            var d1max = Math.max.apply(Math,data1s);
                            var d2min = Math.min.apply(Math,data2s);
                            var d2max = Math.max.apply(Math,data2s);

                            if(d1min < d2min){
                                var minVal = d1min - 27;
                            }
                            else
                            {
                                var minVal = d2min - 27;
                            }

                            if(d1max > d2max){
                                var maxVal = d1max + 27;
                            }
                            else
                            {
                                var maxVal = d2max + 27;
                            }

                            var labelArr = [];

                            

                            var config = {
                                type: 'line',
                                data: {
                                    labels: disType,
                                    datasets: [{
                                        label: 'My First dataset',
                                        backgroundColor: 'rgba(84, 84, 84, 1)',
                                        borderColor: 'rgba(84, 84, 84, 1)',
                                        data: data1s,
                                        fill: false,
                                        lineTension: 0,
                                        borderWidth: 10,
                                        pointRadius: 25
                                    }, {
                                        label: 'My Second dataset',
                                        fill: false,
                                        backgroundColor:'rgba(237, 134, 0, 1)',
                                        borderColor:'rgba(237, 134, 0, 1)',
                                        data: data2s,
                                        lineTension: 0,
                                        borderWidth: 10,
                                        pointRadius: 25
                                    }]
                                },
                                options: {
                                    animation: {
                                        duration: 0
                                    },
                                    layout: {
                                        padding: {
                                          right: 35
                                        }
                                      },
                                    percentageInnerCutout: 40,
                                    bezierCurve: false,
                                    responsive: true,
                                    legend: {
                                        display:false
                                    },
                                    title: {
                                        display: false,
                                    },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display:false,
                                            },
                                            display: false,
                                            ticks: {
                                                min: minVal,
                                                max: maxVal,
                                                fontSize: 20,
                                            }
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display:false,
                                                color: 'black',
                                                gridThickness: 20,
                                            },
                                            ticks: {
                                                autoSkip: false,
                                                fontSize: 25,
                                                maxRotation: 45,
                                                minRotation: 45
                                            }
                                        }]
                                    }
                                },

                                plugins: [{
                                    afterDatasetsDraw: function(chart) {
                                        var ctx = chart.ctx;
                                        var initLine = chart.data.datasets;
                                        var d1Len = initLine[0].data.length;
                                        
                                    
                                        var disp = [];
                                        var cNum1 = 0;
                                        var cNum2 = 0;
                                        var cSum = 0;
                                        var cNeg = "x";
                                        initLine[0].data.forEach(function(value, index) {
                                            cNum1 = parseInt(value);
                                            cNum2 = parseInt(initLine[1].data[index]);
                                            cSum = cNum1 - cNum2;
                                            if(cSum < 0){
                                                cSum = cSum * -1;
                                                cNeg = "neg";
                                            }
                                            else {
                                                cNeg = "pos";
                                            }

                                            if(cSum < 11){
                                                disp.push("adj" + cNeg);
                                            }
                                            else
                                            {
                                                disp.push("same");
                                            }

                                        });
                                            var setCount = 0;

                                            chart.data.datasets.forEach(function(dataset, index) {
                                                setCount++;
                                             var datasetMeta = chart.getDatasetMeta(index);
                                             if (datasetMeta.hidden) return;
                                             datasetMeta.data.forEach(function(point, index) {
                                                var value = dataset.data[index];
                                                var x = point.getCenterPoint().x;
                                                var y = point.getCenterPoint().y;
                                                var radius = point._model.radius;
                                                var fontSize = 30;
                                                var fontFamily = 'Calibri';
                                                var fontColor = 'white';
                                                var fontStyle = 'bold';
                                                var yCoor = (y - radius - fontSize) + 53;
                                                ctx.save();
                                                ctx.textBaseline = 'middle';
                                                ctx.textAlign = 'center';
                                                ctx.font = fontStyle + ' ' + fontSize + 'px' + ' ' + fontFamily; 

                                                // if(setCount == 1){
                                                //     if(disp[index] == "adj"){
                                                //         fontColor = '#eb8501';
                                                //         yCoor = yCoor - 50;
                                                //     }
                                                // }

                                                if(setCount == 2){
                                                    if(disp[index] == "adjpos"){
                                                        fontColor = '#eb8501';
                                                        yCoor = yCoor + 50;
                                                    }
                                                    else if(disp[index] == "adjneg"){
                                                        fontColor = '#eb8501';
                                                        yCoor = yCoor - 50;
                                                    }
                                                }

                                                ctx.fillStyle = fontColor;
                                                ctx.fillText(value, x, yCoor);
                                                ctx.restore();
                                             });
                                          });

                                      }
                                      
                                   
                                }]
                            };

                            var lineId = arrRen[numRen].id;

                            var ctx = document.getElementById('canLine').getContext('2d');
                            window.myLine = new Chart(ctx, config);

                            var imgData;
                            html2canvas(document.getElementById("canLine"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: lineId, imgData: imgData, saveType: 'lineEdit'},
                                        success: function(result){
                                            // // console.log("line");
                                            progVal = progVal + adder;
                                            // console.log("=== " + progVal +  " === ");
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> line");
                                            if(progVal >= 99.99){
                                                fncDone();
                                            }
                                        }
                                    });
                                    
                                    
                                },
                            });

                        }

                        else if(arrRen[numRen].rowType == "donut"){

                            var header = arrRen[numRen].content1;

                            var name1 = arrRen[numRen].content2;
                            var data1 = arrRen[numRen].content3;
                            var name2 = arrRen[numRen].content5;
                            var data2 = arrRen[numRen].content6;
                            var name3 = arrRen[numRen].content8;
                            var data3 = arrRen[numRen].content9;
                            // console.log("donut" + data1 + " " + data2 + " " + data3);

                            // 1st donut
                            if (data1 == "N/A" || data1 == "N.A." || data1 == "Not applicable" || data1 == "not applicable"){
                                var dispVal1 = "N/A";
                                var value1 = 0;
                            }
                            else
                            {
                                var dispVal1 = data1;
                                var value1 = data1;
                            }
                            var data = {
                              labels: [
                                "My val",
                                ""
                              ],
                              datasets: [
                                {
                                  data: [value1, 100-value1],
                                  backgroundColor: [
                                    "#ed8601",
                                    "#d9d9d9"
                                  ],
                                  hoverBackgroundColor: [
                                    "#FF6384",
                                    "#AAAAAA"
                                  ],
                                  hoverBorderColor: [
                                    "#FF6384",
                                    "#ffffff"
                                  ]
                                }]
                            };

                            var myChart = new Chart(document.getElementById("canDoA1"), {
                              type: 'doughnut',
                              data: data,
                              options: {
                                animation: false,
                                elements: {
                                    arc: {
                                        borderWidth: 15
                                    }
                                },
                                segmentShowStroke: false,
                                responsive: true,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 65,
                                tooltips: {
                                    filter: function(item, data) {
                                    var label = data.labels[item.index];
                                    if (label) return item;
                                  }
                                }
                              }
                            });

                            //textCenter(value);

                            function textCenter(val) {
                              Chart.pluginService.register({
                                beforeDraw: function(chart) {
                                  var width = chart.chart.width,
                                      height = chart.chart.height,
                                      ctx = chart.chart.ctx;

                                  ctx.restore();
                                  var fontSize = (height / 40).toFixed(2);
                                  ctx.font = fontSize + "em sans-serif";
                                  ctx.textBaseline = "middle";
                                  var text = dispVal,
                                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                                      textY = height / 2;
                                  ctx.fillText("", "", "");
                                  ctx.fillText(text, textX, textY);
                                  ctx.fillStyle = dColor;
                                  ctx.save();
                                }
                              });
                            }


                            // 2nd donut
                            if (data2 == "N/A" || data2 == "N.A." || data2 == "Not applicable" || data2 == "not applicable"){
                                var dispVal2 = "N/A";
                                var value2 = 0;
                            }
                            else
                            {
                                var dispVal2 = data2;
                                var value2 = data2;
                            }
                            var data = {
                              labels: [
                                "My val",
                                ""
                              ],
                              datasets: [
                                {
                                  data: [value2, 100-value2],
                                  backgroundColor: [
                                    "#545454",
                                    "#d9d9d9"
                                  ],
                                  hoverBackgroundColor: [
                                    "#FF6384",
                                    "#AAAAAA"
                                  ],
                                  hoverBorderColor: [
                                    "#FF6384",
                                    "#ffffff"
                                  ]
                                }]
                            };

                            var myChart = new Chart(document.getElementById("canDoA2"), {
                              type: 'doughnut',
                              data: data,
                              options: {
                                animation: false,
                                elements: {
                                    arc: {
                                        borderWidth: 15
                                    }
                                },
                                segmentShowStroke: false,
                                responsive: true,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 65,
                                tooltips: {
                                    filter: function(item, data) {
                                    var label = data.labels[item.index];
                                    if (label) return item;
                                  }
                                }
                              }
                            });

                            //textCenter(value);

                            function textCenter(val) {
                              Chart.pluginService.register({
                                beforeDraw: function(chart) {
                                  var width = chart.chart.width,
                                      height = chart.chart.height,
                                      ctx = chart.chart.ctx;

                                  ctx.restore();
                                  var fontSize = (height / 40).toFixed(2);
                                  ctx.font = fontSize + "em sans-serif";
                                  ctx.textBaseline = "middle";
                                  var text = dispVal,
                                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                                      textY = height / 2;
                                  ctx.fillText("", "", "");
                                  ctx.fillText(text, textX, textY);
                                  ctx.fillStyle = dColor;
                                  ctx.save();
                                }
                              });
                            }


                            // 3rd donut
                            if (data3 == "N/A" || data3 == "N.A." || data3 == "Not applicable" || data3 == "not applicable"){
                                var dispVal2 = "N/A";
                                var value2 = 0;
                            }
                            else
                            {
                                var dispVal3 = data3;
                                var value3 = data3;
                            }
                            var data = {
                              labels: [
                                "My val",
                                ""
                              ],
                              datasets: [
                                {
                                  data: [value3, 100-value3],
                                  backgroundColor: [
                                    "#1ca4ff",
                                    "#d9d9d9"
                                  ],
                                  hoverBackgroundColor: [
                                    "#FF6384",
                                    "#AAAAAA"
                                  ],
                                  hoverBorderColor: [
                                    "#FF6384",
                                    "#ffffff"
                                  ]
                                }]
                            };

                            var myChart = new Chart(document.getElementById("canDoA3"), {
                              type: 'doughnut',
                              data: data,
                              options: {
                                animation: false,
                                elements: {
                                    arc: {
                                        borderWidth: 15
                                    }
                                },
                                segmentShowStroke: false,
                                responsive: true,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 65,
                                tooltips: {
                                    filter: function(item, data) {
                                    var label = data.labels[item.index];
                                    if (label) return item;
                                  }
                                }
                              }
                            });

                            //textCenter(value);

                            function textCenter(val) {
                              Chart.pluginService.register({
                                beforeDraw: function(chart) {
                                  var width = chart.chart.width,
                                      height = chart.chart.height,
                                      ctx = chart.chart.ctx;

                                  ctx.restore();
                                  var fontSize = (height / 40).toFixed(2);
                                  ctx.font = fontSize + "em sans-serif";
                                  ctx.textBaseline = "middle";
                                  var text = dispVal,
                                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                                      textY = height / 2;
                                  ctx.fillText("", "", "");
                                  ctx.fillText(text, textX, textY);
                                  ctx.fillStyle = dColor;
                                  ctx.save();
                                }
                              });
                            }

                            var lineDonut = arrRen[numRen].id;


                            var imgData1;    
                            html2canvas(document.getElementById("canDoA1"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData1 = canvas.toDataURL("image/jpeg", 2.0);

                                    var imgData2;    
                                    html2canvas(document.getElementById("canDoA2"), {
                                        async: true,
                                        onrendered: function (canvas) {
                                            imgData2 = canvas.toDataURL("image/jpeg", 2.0);

                                            var imgData3;    
                                            html2canvas(document.getElementById("canDoA3"), {
                                                async: true,
                                                onrendered: function (canvas) {
                                                    imgData3 = canvas.toDataURL("image/jpeg", 2.0);

                                                     $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        type: 'POST',
                                                        url: '/reports/addrow',
                                                        async: true,
                                                        data: {id: lineDonut, data1: dispVal1, imgData1: imgData1, data2: dispVal2, imgData2: imgData2, data3: dispVal3, imgData3: imgData3, saveType: 'donutEdit'},
                                                        success: function(result){

                                                            progVal = progVal + adder;
                                                            // console.log("=== " + progVal +  " === ");
                                                            $('#mainBar').css('width', progVal+'%');
                                                            console.log("end -> donut");
                                                            if(progVal >= 99.99){
                                                                fncDone();
                                                            }
                                                        }
                                                    });

                                                },
                                            });

                                        },
                                    });

                                },
                            });

                        }

                        else if(arrRen[numRen].rowType == "horbar"){

                            var ans = arrRen[numRen].content6;
                            var name1 = arrRen[numRen].content1;
                            var data1 = arrRen[numRen].content2;
                            var name2 = arrRen[numRen].content3;
                            var data2 = arrRen[numRen].content4;
                            var leg = arrRen[numRen].content7;

                            var cols = [name1, name2];
                            var val = [data1, data2];


                            var ctx = document.getElementById("canHorBar");
                            var myChart = new Chart(ctx, {
                                type: 'horizontalBar',
                                
                                options: {
                                  animation: false,
                                
                                  legend: {
                                    display: false
                                  },

                                  scales: {
                                          yAxes: [{
                                              ticks: {
                                                    display: false
                                                },
                                              gridLines: {
                                                  display: false,
                                                  lineWidth: 3,
                                                  color: 'black'
                                              },
                                            barThickness: 130
                                          }],
                                          xAxes: [{
                                            ticks: {
                                                min: 0,
                                                max: 100,
                                                fontSize: 55,
                                                stepSize: 20
                                            },
                                            gridLines: {
                                              display: false,
                                              lineWidth: 3,
                                              color: 'black'
                                            },
                                            display: true
                                          }]
                                      },
                                  title: {
                                    display: false,
                                    position: "bottom"
                                  }
                                },

                                data: {
                                    labels: cols,
                                    datasets: [{
                                        data: val,
                                        backgroundColor: [
                                            'rgba(84, 84, 84, 1)',
                                            'rgba(28, 164, 255, 1)'
                                        ]
                                    }]
                                }
                            });

                            var idHorbar = arrRen[numRen].id;

                            html2canvas(document.getElementById("canHorBar"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);

                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: idHorbar, imgData: imgData, saveType: 'horbarEdit'},
                                        success: function(result){
                                            progVal = progVal + adder;
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> horbar");
                                            if(progVal >= 99.99){
                                                fncDone();
                                            }
                                        }
                                    });

                                },
                            });

                        }

                        else if(arrRen[numRen].rowType == "device1"){

                            var name1 = arrRen[numRen].content2
                            var name2 = arrRen[numRen].content3

                            var initVals = arrRen[numRen].content4;

                            var vals = initVals.split(",");
                            var cols = ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"];

                            var ctx = document.getElementById("canDev1").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: cols,
                                    datasets: [{
                                        label: '# of Votes',
                                        data: vals,
                                        backgroundColor: [
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)'

                                        ],
                                        borderColor: [
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {

                                    animation: {
                                        duration: 0,
                                      onComplete: function () {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        var height = chartInstance.controller.boxes[0].bottom;
                                        ctx.textAlign = "center";
                                        ctx.fontSize = 35;
                                        ctx.fillStyle = "black";
                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                          var meta = chartInstance.controller.getDatasetMeta(i);
                                          Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 20);
                                          }),this)
                                        }),this);
                                      }
                                    },

                                    legend: {
                                        display: false
                                     },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display:false,
                                                color: 'black',
                                                gridThickness: 20,
                                            },
                                            ticks: {
                                                beginAtZero:true,
                                                max: 100,
                                                fontSize: 40
                                            }
                                        }],
                                        xAxes: [{
                                            maxBarThickness: 140,
                                            borderWidth: 1,
                                            gridLines: {
                                                display:false,
                                            },
                                            display:false
                                        }]
                                    }
                                }
                            });

                            var dev1Id = arrRen[numRen].id;
                            html2canvas(document.getElementById("canDev1"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);
                                    
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: dev1Id, imgData: imgData, saveType: 'device1Edit'},
                                        success: function(result){

                                            progVal = progVal + adder;
                                            // console.log("=== " + progVal +  " === ");
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> device1");
                                            if(progVal >= 99.99){
                                                fncDone();
                                            }
                                        }
                                    });
                                    
                                },
                            });

                        }

                        else if(arrRen[numRen].rowType == "device2"){

                            var name1 = arrRen[numRen].content2;
                            var name2 = arrRen[numRen].content3;

                            var initVals = arrRen[numRen].content4;

                            var vals = initVals.split(",");
                            var cols = ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a"];

                            var ctx = document.getElementById("canDev2").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: cols,
                                    datasets: [{
                                        label: '# of Votes',
                                        data: vals,
                                        backgroundColor: [
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)'

                                        ],
                                        borderColor: [
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {

                                    animation: {
                                        duration: 0,
                                      onComplete: function () {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        var height = chartInstance.controller.boxes[0].bottom;
                                        ctx.textAlign = "center";
                                        ctx.fontSize = 35;
                                        ctx.fillStyle = "black";
                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                          var meta = chartInstance.controller.getDatasetMeta(i);
                                          Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 20);
                                          }),this)
                                        }),this);
                                      }
                                    },

                                    legend: {
                                        display: false
                                     },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display:false,
                                                color: 'black',
                                                gridThickness: 20,
                                            },
                                            ticks: {
                                                beginAtZero:true,
                                                max: 100,
                                                fontSize: 40
                                            }
                                        }],
                                        xAxes: [{
                                            maxBarThickness: 140,
                                            borderWidth: 1,
                                            gridLines: {
                                                display:false,
                                            },
                                            display:false
                                        }]
                                    }
                                }
                            });

                            var dev2Id = arrRen[numRen].id;
                            html2canvas(document.getElementById("canDev2"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);
                                    
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: dev2Id, imgData: imgData, saveType: 'device2Edit'},
                                        success: function(result){

                                            progVal = progVal + adder;
                                            // console.log("=== " + progVal +  " === ");
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> device2");
                                            if(progVal >= 99.99){
                                                fncDone();
                                            }
                                        }
                                    });
                                    
                                },
                            });

                        }

                        else if(arrRen[numRen].rowType == "donut2"){

                            var text = arrRen[numRen].content1;
                            var data1 = arrRen[numRen].content2;
                            var data2 = arrRen[numRen].content4;
                            var data3 = arrRen[numRen].content6;

                            // 1st donut
                            if (data1 == "N/A" || data1 == "N.A." || data1 == "Not applicable" || data1 == "not applicable"){
                                var dispVal1 = "N/A";
                                var value1 = 0;
                            }
                            else
                            {
                                var dispVal1 = data1;
                                var value1 = data1;
                            }
                            var data = {
                              labels: [
                                "My val",
                                ""
                              ],
                              datasets: [
                                {
                                  data: [value1, 100-value1],
                                  backgroundColor: [
                                    "#ed8601",
                                    "#d9d9d9"
                                  ],
                                  hoverBackgroundColor: [
                                    "#FF6384",
                                    "#AAAAAA"
                                  ],
                                  hoverBorderColor: [
                                    "#FF6384",
                                    "#ffffff"
                                  ]
                                }]
                            };

                            var myChart = new Chart(document.getElementById("canDoA1"), {
                              type: 'doughnut',
                              data: data,
                              options: {
                                animation: false,
                                elements: {
                                    arc: {
                                        borderWidth: 15
                                    }
                                },
                                segmentShowStroke: false,
                                responsive: true,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 65,
                                tooltips: {
                                    filter: function(item, data) {
                                    var label = data.labels[item.index];
                                    if (label) return item;
                                  }
                                }
                              }
                            });

                            //textCenter(value);

                            function textCenter(val) {
                              Chart.pluginService.register({
                                beforeDraw: function(chart) {
                                  var width = chart.chart.width,
                                      height = chart.chart.height,
                                      ctx = chart.chart.ctx;

                                  ctx.restore();
                                  var fontSize = (height / 40).toFixed(2);
                                  ctx.font = fontSize + "em sans-serif";
                                  ctx.textBaseline = "middle";
                                  var text = dispVal,
                                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                                      textY = height / 2;
                                  ctx.fillText("", "", "");
                                  ctx.fillText(text, textX, textY);
                                  ctx.fillStyle = dColor;
                                  ctx.save();
                                }
                              });
                            }


                            // 2nd donut
                            if (data2 == "N/A" || data2 == "N.A." || data2 == "Not applicable" || data2 == "not applicable"){
                                var dispVal2 = "N/A";
                                var value2 = 0;
                            }
                            else
                            {
                                var dispVal2 = data2;
                                var value2 = data2;
                            }
                            var data = {
                              labels: [
                                "My val",
                                ""
                              ],
                              datasets: [
                                {
                                  data: [value2, 100-value2],
                                  backgroundColor: [
                                    "#545454",
                                    "#d9d9d9"
                                  ],
                                  hoverBackgroundColor: [
                                    "#FF6384",
                                    "#AAAAAA"
                                  ],
                                  hoverBorderColor: [
                                    "#FF6384",
                                    "#ffffff"
                                  ]
                                }]
                            };

                            var myChart = new Chart(document.getElementById("canDoA2"), {
                              type: 'doughnut',
                              data: data,
                              options: {
                                animation: false,
                                elements: {
                                    arc: {
                                        borderWidth: 15
                                    }
                                },
                                segmentShowStroke: false,
                                responsive: true,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 65,
                                tooltips: {
                                    filter: function(item, data) {
                                    var label = data.labels[item.index];
                                    if (label) return item;
                                  }
                                }
                              }
                            });

                            //textCenter(value);

                            function textCenter(val) {
                              Chart.pluginService.register({
                                beforeDraw: function(chart) {
                                  var width = chart.chart.width,
                                      height = chart.chart.height,
                                      ctx = chart.chart.ctx;

                                  ctx.restore();
                                  var fontSize = (height / 40).toFixed(2);
                                  ctx.font = fontSize + "em sans-serif";
                                  ctx.textBaseline = "middle";
                                  var text = dispVal,
                                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                                      textY = height / 2;
                                  ctx.fillText("", "", "");
                                  ctx.fillText(text, textX, textY);
                                  ctx.fillStyle = dColor;
                                  ctx.save();
                                }
                              });
                            }


                            // 3rd donut
                            if (data3 == "N/A" || data3 == "N.A." || data3 == "Not applicable" || data3 == "not applicable"){
                                var dispVal2 = "N/A";
                                var value2 = 0;
                            }
                            else
                            {
                                var dispVal3 = data3;
                                var value3 = data3;
                            }
                            var data = {
                              labels: [
                                "My val",
                                ""
                              ],
                              datasets: [
                                {
                                  data: [value3, 100-value3],
                                  backgroundColor: [
                                    "#1ca4ff",
                                    "#d9d9d9"
                                  ],
                                  hoverBackgroundColor: [
                                    "#FF6384",
                                    "#AAAAAA"
                                  ],
                                  hoverBorderColor: [
                                    "#FF6384",
                                    "#ffffff"
                                  ]
                                }]
                            };

                            var myChart = new Chart(document.getElementById("canDoA3"), {
                              type: 'doughnut',
                              data: data,
                              options: {
                                animation: false,
                                elements: {
                                    arc: {
                                        borderWidth: 15
                                    }
                                },
                                segmentShowStroke: false,
                                responsive: true,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 65,
                                tooltips: {
                                    filter: function(item, data) {
                                    var label = data.labels[item.index];
                                    if (label) return item;
                                  }
                                }
                              }
                            });

                            //textCenter(value);

                            function textCenter(val) {
                              Chart.pluginService.register({
                                beforeDraw: function(chart) {
                                  var width = chart.chart.width,
                                      height = chart.chart.height,
                                      ctx = chart.chart.ctx;

                                  ctx.restore();
                                  var fontSize = (height / 40).toFixed(2);
                                  ctx.font = fontSize + "em sans-serif";
                                  ctx.textBaseline = "middle";
                                  var text = dispVal,
                                      textX = Math.round((width - ctx.measureText(text).width) / 2),
                                      textY = height / 2;
                                  ctx.fillText("", "", "");
                                  ctx.fillText(text, textX, textY);
                                  ctx.fillStyle = dColor;
                                  ctx.save();
                                }
                              });
                            }




                            var imgData1; 
                            var don2Id = arrRen[numRen].id;   
                            html2canvas(document.getElementById("canDoA1"), {
                                onrendered: function (canvas) {
                                    imgData1 = canvas.toDataURL("image/jpeg", 2.0);

                                    var imgData2;    
                                    html2canvas(document.getElementById("canDoA2"), {
                                        onrendered: function (canvas) {
                                            imgData2 = canvas.toDataURL("image/jpeg", 2.0);

                                            var imgData3;    
                                            html2canvas(document.getElementById("canDoA3"), {
                                                onrendered: function (canvas) {
                                                    imgData3 = canvas.toDataURL("image/jpeg", 2.0);

                                                     $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        type: 'POST',
                                                        url: '/reports/addrow',
                                                        async: true,
                                                        data: {id: don2Id, data1: dispVal1, imgData1: imgData1, data2: dispVal2, imgData2: imgData2, data3: dispVal3, imgData3: imgData3, saveType: 'donut2Edit'},
                                                        success: function(result){
                                                            progVal = progVal + adder;
                                                            // console.log("=== " + progVal +  " === ");
                                                            $('#mainBar').css('width', progVal+'%');
                                                            console.log("end -> donut2");
                                                            if(progVal >= 99.99){
                                                                fncDone();
                                                            }
                                                        }
                                                    });

                                                },
                                            });

                                        },
                                    });

                                },
                            });

                        }

                        else if(arrRen[numRen].rowType == "device3"){
                            var dev3 = arrRen[numRen].content4;
                            var vals = dev3.split(",");
                            vals[0] = parseInt(vals[0]);
                            vals[1] = parseInt(vals[1]);
                            vals[2] = parseInt(vals[2]);
                            vals[3] = parseInt(vals[3]);
                            vals[4] = parseInt(vals[4]);
                            vals[5] = parseInt(vals[5]);
                            var cols = ["a", "a", "a", "a", "a", "a"];

                            var ctx = document.getElementById("canDev3").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: cols,
                                    datasets: [{
                                        label: '# of Votes',
                                        data: vals,
                                        backgroundColor: [
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)'

                                        ],
                                        borderColor: [
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)',
                                            'rgba(83, 86, 90, 1)',
                                            'rgba(0, 145, 218, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {

                                    animation: {
                                      duration: 0,
                                      onComplete: function () {
                                        var chartInstance = this.chart;
                                        var ctx = chartInstance.ctx;
                                        var height = chartInstance.controller.boxes[0].bottom;
                                        ctx.textAlign = "center";
                                        ctx.fontSize = 35;
                                        ctx.fillStyle = "#000000";
                                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                          var meta = chartInstance.controller.getDatasetMeta(i);
                                          Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                            ctx.fillText(dataset.data[index] + "%", bar._model.x, bar._model.y - 15);
                                          }),this)
                                        }),this);
                                      }
                                    },

                                    legend: {
                                        display: false
                                     },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display:false,
                                                color: 'black',
                                                gridThickness: 20,
                                            },
                                            ticks: {
                                                beginAtZero:true,
                                                max: 100,
                                                fontSize: 40
                                            }
                                        }],
                                        xAxes: [{
                                            maxBarThickness: 140,
                                            borderWidth: 1,
                                            gridLines: {
                                                display:false,
                                            },
                                            display:false
                                        }]
                                    }
                                }
                            });

                            var dev3Id = arrRen[numRen].id;
                            html2canvas(document.getElementById("canDev3"), {
                                async: true,
                                onrendered: function (canvas) {
                                    imgData = canvas.toDataURL("image/jpeg", 2.0);
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        type: 'POST',
                                        url: '/reports/addrow',
                                        async: true,
                                        data: {id: dev3Id, imgData: imgData, saveType: 'device3Edit'},
                                        success: function(result){

                                            progVal = progVal + adder;
                                            // console.log("=== " + progVal +  " === ");
                                            $('#mainBar').css('width', progVal+'%');
                                            console.log("end -> device3");
                                            if(progVal >= 99.99){
                                                fncDone();
                                            }
                                        }
                                    });
                                    
                                },
                            });


                        }
                        numRen++;

                        if(numRen >= arrRenLen){
                            clearInterval(runRender);
                        }
                        
                    }, 10000)

                }
            });

            
        }

        var initGenType = $('#genType').val();
        if(initGenType=="batch"){
            var initCurrent = $('#current').val();
            var sTo = $('#sTo').val();
            if(parseInt(initCurrent) <= parseInt(sTo)){
                var newCurrent = parseInt(initCurrent) + 1;

                $("#shopperId").val(initCurrent);
                $('#generateReport').click();
            }
        }


        function fncDone(){
            var genType = $('#genType').val();
            // console.log("fncDone");
            if(genType=="batch"){
                // console.log("fnc batch");
                var current = $('#current').val();
                var newCurrent = parseInt(initCurrent) + 1;
                var reportId = $('#reportId').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/reports/addrow',
                    async: true,
                    data: {reportId: reportId, current: newCurrent, saveType: 'nextcurrent'},
                    success: function(result){
                        window.open('/reports/manage/download/1', '_blank');
                        location.reload();
                    }
                });
            }
            else {
                // console.log("fncSingle");
                $('#pFin').show();
                $('#pView').show();
            }

            



            
        }
        

    });

  </script>

@endsection
