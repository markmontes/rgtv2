@extends('layouts.app')

@section('content')

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
</head>
<body>

</body>


                    

<input type="hidden" id="reportId" value="{{ $report->id }}">
<input type="hidden" id="reportExcel" value="{{ $report->excel }}">

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
               
                <div class="card-header">
                    Report Details
                    <div class="pull-right">
                        <a href="">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    Report Name
                    <br>
                    <b>{{ $report->report_name }}</b><br><br>

                    Client Name
                    <br>
                    <b>{{ $report->client }}</b><br><br>

                    Created By
                    <br>
                    <b>{{ $report->user->name }}</b><br>
                    {{ $report->user->team->name }}
                    <br><br>
                    Shopper's Name<br>
                    <select id="shopperId" class="form-control">
                    </select>
                    <br>
                    <button id="generateReport" class="btn btn-primary form-control">
                        Generate Report
                    </button> 
                    
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Report Layout

                    <div class="pull-right">
                        <a href="/reports/manage/preview/{{ $report->id }}" target="_blank">
                            <i class="fa fa-eye"></i> Preview
                        </a>
                    </div>
                </div>
                <div class="card-body">

                   

                    <button class="btn btn-primary" data-toggle="modal" data-target="#rowModal">
                        <i class="fa fa-plus"></i> Add New Row
                    </button>
                    <br><br>

                    <div class="card card-body bg-light">

                        
                        @foreach($rows->sortBy('rowOrder') as $row) 

                            @if($row->rowType == "header")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                Content: <b>{{ substr($row->content, 0, 20) }}...</b>
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @elseif($row->rowType == "text bold")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                Content: <b>{{ substr($row->content, 0, 20) }}...</b>
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @elseif($row->rowType == "Colored Well")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                Content: <b>{{ substr($row->content, 0, 20) }}...</b>
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @elseif($row->rowType == "Progress Bar")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                N.A.
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @elseif($row->rowType == "content" || $row->rowType == "Content with Text" || $row->rowType == "well" || $row->rowType == "Well with Answer")

                                @if($row->colCount=="1")
                                
                                    <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                        <table class="table table-bordered" width="100%">
                                            <tr>
                                                <td width="10%">
                                                    # <b>{{ $row->rowOrder }}</b>
                                                </td>
                                                <td width="75%">
                                                    Row Type: <b>{{ ucfirst($row->rowType) }}</b> |  Cell Type: <b>{{ $row->cells[0]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[0]->id }}', '{{ $row->cells[0]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>
                                                <td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>

                                @elseif($row->colCount=="2")

                                    <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                        <table class="table table-bordered" width="100%">
                                            <tr>
                                                <td width="10%">
                                                    # <b>{{ $row->rowOrder }}</b>
                                                </td>
                                                <td width="37%">
                                                    Type: <b>{{ $row->cells[0]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[0]->id }}', '{{ $row->cells[0]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="37%">
                                                    Type: <b>{{ $row->cells[1]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[1]->id }}', '{{ $row->cells[1]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>
                                                <td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>
                                    
                                @elseif($row->colCount=="3")

                                    <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                        <table class="table table-bordered" width="100%">
                                            <tr>
                                                <td width="10%">
                                                    # <b>{{ $row->rowOrder }}</b>
                                                </td>
                                                <td width="25%">
                                                    Type: <b>{{ $row->cells[0]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[0]->id }}', '{{ $row->cells[0]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="25%">
                                                    Type: <b>{{ $row->cells[1]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[1]->id }}', '{{ $row->cells[1]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="25%">
                                                    Type: <b>{{ $row->cells[2]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[2]->id }}', '{{ $row->cells[2]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>
                                

                                @endif

                            @elseif($row->rowType == "Spacer")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                Content: <b>N.A.</b>
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            @elseif($row->rowType == "Page Break")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                Content: <b>N.A.</b>
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            @elseif($row->rowType == "Doughnut Header")
                                <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                    <table class="table table-bordered" width="100%">
                                        <tr>
                                            <td width="10%">
                                                # <b>{{ $row->rowOrder }}</b>
                                            </td>
                                            <td width="25%">
                                                Type: <b>{{ $row->rowType }}</b>
                                            </td>
                                            <td width="50%">
                                                Content: <b>N.A.</b>
                                            </td>
                                            <td width="15%">
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                &nbsp;
                                                <a href="#" data-toggle="modal" data-target="#">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            @elseif($row->rowType == "Well (Header and Content)")

                                @if($row->colCount=="1")
                                
                                    <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                        <table class="table table-bordered" width="100%">
                                            <tr>
                                                <td width="10%">
                                                    # <b>{{ $row->rowOrder }}</b>
                                                </td>
                                                <td width="75%">
                                                    Row Type: <b>{{ ucfirst($row->rowType) }}</b> |  Cell Type: <b>{{ $row->cells[0]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[0]->id }}', '{{ $row->cells[0]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>
                                                <td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>

                                @elseif($row->colCount=="2")

                                    <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                        <table class="table table-bordered" width="100%">
                                            <tr>
                                                <td width="10%">
                                                    # <b>{{ $row->rowOrder }}</b>
                                                </td>
                                                <td width="37%">
                                                    Type: <b>{{ $row->cells[0]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[0]->id }}', '{{ $row->cells[0]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="37%">
                                                    Type: <b>{{ $row->cells[1]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[1]->id }}', '{{ $row->cells[1]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>
                                                <td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>
                                    
                                @elseif($row->colCount=="3")

                                    <div style="background-color:white;padding:10px; border-style:dashed;border-color: #8d8d8e;">
                                        <table class="table table-bordered" width="100%">
                                            <tr>
                                                <td width="10%">
                                                    # <b>{{ $row->rowOrder }}</b>
                                                </td>
                                                <td width="25%">
                                                    Type: <b>{{ $row->cells[0]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[0]->id }}', '{{ $row->cells[0]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="25%">
                                                    Type: <b>{{ $row->cells[1]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[1]->id }}', '{{ $row->cells[1]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="25%">
                                                    Type: <b>{{ $row->cells[2]->type }}</b>
                                                    <a href="#" onclick="return getCellData('{{ $row->cells[2]->id }}', '{{ $row->cells[2]->type }}');" data-toggle="modal" data-target="#editCell" class="pull-right">
                                                        <i class="fa fa-cog fa-2x"></i>
                                                    </a>
                                                </td>

                                                <td width="15%">
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="#" data-toggle="modal" data-target="#">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>
                                

                                @endif



                            @endif



                        @endforeach

                    </div>

                        <br>

                        <button class="btn btn-primary" data-toggle="modal" data-target="#rowModal">
                            <i class="fa fa-plus"></i> Add New Row
                        </button>

                </div>
            </div>
        </div>

    </div>
    <div id="nexter"></div>
    <br><br>
    <canvas id="chartjs-1" width="100%" style="visibility:visible;"></canvas>
    <br>
    <canvas id="chartjs-2" width="100%" style="visibility:visible; background-color:#e8e8e8;"></canvas>

</div>


<div class="modal" id="rowModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add New Row</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <h4>Row Type</h4>
            <select id="rowType" class="form-control">
                <option>Header</option>
                <option>Text Bold</option>
                <option>Content</option>
                <option>Content with Text</option>
                <option>Well</option>
                <option>Colored Well</option>
                <option>Well (Header and Content)</option>
                <option>Progress Bar</option>
                <option>Doughnut Header</option>
                <option>Spacer</option>
                <option>Page Break</option>
            </select>
            <br>

            <div id="headerContent">
                <h4>Header Text</h4>
                <input type="text" id="headerText" name="headerText" class="form-control">
                <br>
            </div>
            <div id="boldContent">
                <h4>Text</h4>
                <input type="text" id="boldText" name="boldText" class="form-control">
                <br>
            </div>

            <div id="colWell">
                <h4>Subject</h4>
                <input type="text" id="titleText" class="form-control">
                <br>
                <h4>Content</h4>
                <textarea id="inputColContent" class="form-control"></textarea>
                <br>
            </div>

            <div id="progressBar">
                <h4>Values</h4>
                <textarea id="inputProgress" class="form-control"></textarea>
                <br>
            </div>



            <div id="rowCount">
                <h4>Column(s)</h4>
                <div class="row">
                    <div class="radio col-lg-2">
                      <label><input type="radio" name="colCount" id="colCount" value="1" checked> 1 (One)</label>
                    </div>
                    <div class="radio col-lg-2">
                      <label><input type="radio" name="colCount" id="colCount" value="2"> 2 (Two)</label>
                    </div>
                    <div class="radio col-lg-2">
                      <label><input type="radio" name="colCount" id="colCount" value="3"> 3 (Three)</label>
                    </div>
                </div>
                <br>
            </div>

            <div id="rowSample1">
                <table class="table table-bordered text-center" width="100%">
                    <tr>
                        <td>1</td>
                    </tr>
                </table>
            </div>

            <div id="rowSample2">
                <table class="table table-bordered text-center" width="100%">
                    <tr>
                        <td>1</td>
                        <td>2</td>
                    </tr>
                </table>
            </div>

            <div id="rowSample3">
                <table class="table table-bordered text-center" width="100%">
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                    </tr>
                </table>
            </div>

            <button id="saveRow" class="btn btn-primary form-control">
                Save Row
            </button>

          
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>


  <div class="modal" id="editCell">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Cell Content</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">

        <div class="row">
            <div class="col-lg-12">
                
                <input type="hidden" id="cellId" value="">
            Type
            <select id="cellType" class="form-control">
                <option value="Text">Text</option>
                <option value="Well with Answer">Well with Answer</option>
                <option value="Bullet">Bullet</option>
                <option value="Numbering">Numbering</option>
                <option value="Definition">Definition</option>
                <option value="Table">Table</option>
                <option value="Graph">Graph</option>
                <option value="Graph Dual">Graph Dual</option>
                <option value="Device Graph 1">Device Graph 1</option>
                <option value="Device Graph 2">Device Graph 2</option>
                <option value="Horizontal Graph">Horizontal Graph</option>
                <option value="Doughnut">Doughnut</option>
                <option value="Line">Line</option>
            </select>
            <br>

            
            <div id="cellText">
                Text Content
                <textarea id="inputText" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellAnswer">
                Your Shopper's Answer
                <input type="text" id="inputAnswer" class="form-control">
                <br>
            </div>

            <div id="cellBullet">
                Bullet Content
                <textarea id="inputBullet" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellNumber">
                Numbering Content
                <textarea id="inputNumber" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellTable">
                Table Header
                <textarea id="inputTableHeader" class="form-control"></textarea>
                <br>

                Table Body
                <textarea id="inputTableBody" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellGraph">
                Title
                <input type="text" id="inputGraphTitle" class="form-control">
                <br>
                Columns
                <textarea id="inputColumn" class="form-control"></textarea>
                <br>

                Value
                <textarea id="inputValue" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellGraph2">
                Columns
                <textarea id="inputColumn2" class="form-control"></textarea>
                <br>

                Value
                <textarea id="inputValue2" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellDevGraph1">
                Value
                <textarea id="inputDevValue1" class="form-control"></textarea>
                <br>
            </div>
            <div id="cellDevGraph2">
                Value
                <textarea id="inputDevValue2" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellLine">
                Data # 1
                <textarea id="inputData1" class="form-control"></textarea>
                <br>

                Data # 2
                <textarea id="inputData2" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellDou">
                Title
                <input type="text" id="inputDouTitle" class="form-control">
                <br>
                Value
                <input type="text" id="inputDou" class="form-control">
                <br>
                Total
                <input type="text" id="inputTot" class="form-control">
                <br>
                Color
                <select id="inputDouColor" class="form-control">
                    <option value="#ed8601">Orange</option>
                    <option value="#545454">Gray</option>
                </select>
                <br>
            </div>

            <div id="cellDefinition">
                Word
                <textarea id="inputWord" class="form-control"></textarea>
                <br>

                Definition
                <textarea id="inputDef" class="form-control"></textarea>
                <br>
            </div>

            <div id="cellHorGraph">
                Your shopper's answer:
                <input type="text" id="inputGraphAns" class="form-control">
                <br>
                Columns
                <textarea id="inputHorColumn" class="form-control"></textarea>
                <br>

                Value
                <textarea id="inputHorValue" class="form-control"></textarea>
                <br>
            </div>


            <button id="updateCell" class="btn btn-primary form-control">
                Update Cell
            </button>

            </div>
        </div>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>



  <script>
    function getCellData(id, type){
        $('#cellId').val(id);
        $("#cellType").val(type).change();

        $.ajax({
            method: 'GET',
            url: '/reports/getcell',
            data: {id: id},
            success: function(result){
                if(type=="Text") {
                    $('#inputText').val(result['ContentA']);
                }
                else if(type=="Bullet") {
                    $('#inputBullet').val(result['ContentA']);
                }
                else if(type=="Numbering") {
                    $('#inputNumber').val(result['ContentA']);
                }
                else if(type=="Table") {
                    $('#inputTableHeader').val(result['ContentA']);
                    $('#inputTableBody').val(result['ContentB']);
                }
                else if(type=="Graph") {
                    $('#inputColumn').val(result['ContentA']);
                    $('#inputValue').val(result['ContentB']);
                    $('#inputGraphTitle').val(result['ContentC']);
                }
                else if(type=="Definition") {
                    $('#inputWord').val(result['ContentA']);
                    $('#inputDef').val(result['ContentB']);
                }
                else if(type=="Line") {
                    $('#inputData1').val(result['ContentA']);
                    $('#inputData2').val(result['ContentB']);
                }
                else if(type=="Doughnut") {
                    $('#inputDouTitle').val(result['ContentC']);
                    $('#inputDou').val(result['ContentA']);
                    $('#inputTot').val(result['ContentB']);
                    $('#inputDouColor').val(result['ContentD']);
                }
            }
        });
    }
    
    $(document).ready(function(){
        var reportId = $('#reportId').val();
        var reportExcel= $('#reportExcel').val();
        var jsonResp = JSON.parse(reportExcel);

        $.each(jsonResp, function(key, val) { 
            if(key > 0){
                $("#shopperId").append($('<option>', {
                    value: key,
                    text: jsonResp[key][2]
                }));
            }
        })




        $('#generateReport').click(function(){
            var shopperId = $('#shopperId').val();
            var sData = jsonResp[shopperId];

            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {saveType: 'clear'},
                success: function(result){
                }
            });

            $.ajax({
                type: 'GET',
                url: '/reports/updaterep',
                async: false,
                data: {id: reportId, bgroup: sData[1], broker: sData[2]},
                success: function(result){

                }
            });

            // page 1A
            addHeader("INTERPRETING THESE RESULTS")

            // page 1B
            var p1bId = addRow1(reportId);
            var p1bContent ="CoreData enlists only bona fide consumers to participate in its ‘shadow shopping’ activities. These ‘shoppers’ are not trained by CoreData in any aspect of the ‘shop’ other than what to expect from the mortgage lending process and how to complete the post-meeting shopper survey. CoreData shoppers are not trained in compliance or any aspects of an expected level of client experience.\n\n When reading this individual report, it is very important to remember that the information provided within is based on the shopper’s ability to recall the ‘conversations & content’ from the individual shops.\n\n In particular, with reference to the provision of compliance documents, the ‘shopper’ may have received such documents in the ‘shopper interview’ but at later point in time (whilst completing the online shop survey) not recall receiving such documents.\n\n This report sets out the ‘shopper's’ opinions and perceptions and not necessarily facts. They reflect the overall impressions left in the mind of the ‘shopper’ that will guide their decision to deal with you or recommend your service to others.\n\n One person’s opinion (good or bad) needs to be considered in the context of the rest of your business performance, and is an opportunity to ‘reality check’ your customer acquisition process and identify any areas for improvement."
            cellText(p1bId, p1bContent);

            //Page 1C
            var p1cId = addRow1(reportId);
            var p1cNum =
                'Review your ‘Intention’ scores, as these scores will tell you what overall impression you left with the client\nConsider your high and low scores in the other sections, to build picture of where you can improve. Compare your performance to ' + sData[1] + ' average so you are aware of where you stand relative to your peers.';
            cellNumbering(p1cId, p1cNum);

            // Page 1D
            var p1dId = addRow1(reportId);
            var p1dContent = "Questions and feedback about the contents of this report or the process used to conduct this shadow shopping report can be directed to " + sData[1] + ".\n\n The results of the shadow shopping process are captured in a single ACQUIRE Index. The ACQUIRE Index is comprised of the following seven key categories:";
            cellText(p1dId, p1dContent);

            // Page 1E
            var p1eId = addRow1(reportId);
            var p1eWord = "Assurances\nCompliance\nQuality\nUnderstanding\nIntention\nReaction\nEnvironment";
            var p1eDef = "Ability to demonstrate and communicate knowledge/skills\nAbility to satisfy relevant financial regulations\nAbility to satisfy client needs and provide perceived value\nAbility to understand client needs\nClient’s intention to use and recommend service/product\nClient’s emotive response to purchase process\nTangible aspects of the purchase process";
            cellDefi(p1eId, p1eWord, p1eDef);

            // Page 1 Break
            pageBreak(reportId);

            // Page 2A
            addHeader("OVERALL SCORECARD")

            // Page 2B
            var p2bId = addRow1(reportId);
            var p2bCols = "Your Score\nYellow\nIndustry";
            var p2bVals = sData[24] + "\n" +  sData[25] + "\n" +  sData[26];

            

            // Page 2C
            var p2cId = addRow1(reportId);
            var p2cContent ="Your ACQUIRE component scores versus your peer group:"
            cellText(p2cId, p2cContent);

            // Page 2D
            var p2dId = addRow1(reportId);
            var data1 = sData[3]+"\n"+sData[6]+"\n"+sData[9]+"\n"+sData[12]+"\n"+sData[15]+"\n"+sData[18]+"\n"+sData[21];
            var data2 = sData[4]+"\n"+sData[7]+"\n"+sData[10]+"\n"+sData[13]+"\n"+sData[16]+"\n"+sData[19]+"\n"+sData[22];
            
            

            // Page 2 Break
            pageBreak(reportId);


            // Page 3A
            addHeader("ASSURANCES");
            var p3aId = addRow1(reportId);
            var p3aContent = "Assurances measures the mortgage lender’s ability to demonstrate and communicate knowledge and skills.\nThis is important as potential clients want to be sure they are trusting their financial future to someone with the necessary skills and experience to help them.";
            cellText(p3aId, p3aContent);

            // Page 3B
            var p3bId = addRow1(reportId);
            var p3bCols = "Your Score\nYellow\nIndustry";
            var p3bVals = sData[3] + "\n" +  sData[4] + "\n" +  sData[5];

            // Page 3C
            var p3cText = "The shopper was asked to rate the mortgage lender on the following:";
            textBold(reportId, p3cText);

            //Page 3D
            var p3dText = "Overall expertise of the product range offered";
            var p3dIdText = headAndCont(reportId, p3dText);
            var p3dVala = sData[27];
            var p3dTota = 100;
            var p3dCola = '#ed8601';
            var p3dTita = 'Your Score';
            var p3dValb = sData[28];
            var p3dTotb = 100;
            var p3dColb = '#545454';
            var p3dTitb =  sData[1];
            var p3dValc = sData[29];
            var p3dTotc = 100;
            var p3dColc = '#1ca4ff';
            var p3dTitc = 'Industry';


            // Page 3 Break
            pageBreak(reportId);

            // Page 4A
            var p4aText = "Ability to demonstrate their expertise";
            var p4aIdText = headAndCont(reportId, p4aText);

            var p4aVala = sData[30];
            var p4aTota = 100;
            var p4aCola = '#ed8601';
            var p4aTita = 'Your Score';

            var p4aValb = sData[31];
            var p4aTotb = 100;
            var p4aColb = '#545454';
            var p4aTitb =  sData[1];

            var p4aValc = sData[32];
            var p4aTotc = 100;
            var p4aColc = '#1ca4ff';
            var p4aTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            //Page 4B
            var p4bText = "Overall professionalism";
            var p4bIdText = headAndCont(reportId, p4bText);

            var p4bVala = sData[33];
            var p4bTota = 100;
            var p4bCola = '#ed8601';
            var p4bTita = 'Your Score';

            var p4bValb = sData[34];
            var p4bTotb = 100;
            var p4bColb = '#545454';
            var p4bTitb =  sData[1];

            var p4bValc = sData[35];
            var p4bTotc = 100;
            var p4bColc = '#1ca4ff';
            var p4bTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 4C
            var p4cId = addWell(reportId);
            var p4cContent = "Did the lender have a comprehensive knowledge of the loan products and services they offered you?";
            cellText(p4cId, p4cContent);

            // Add Space
            addSpace(reportId);

            // Page 4D
            var p4dId = addRow1(reportId);
            var p4dCols = [sData[1], "Industry"];
            var p4da = sData[37];
            var p4db = sData[38];
            var p4dVals = [p4da, p4db];
            var p4dTitle = sData[36];

            // Page 4 Break
            pageBreak(reportId);

            // Page 5A
            var p5aText = "The shopper was asked to rate the mortgage lender on the following:";
            textBold(reportId, p5aText);

            // Page 5B
            var p5bText = "Ability to demonstrate a comprehensive knowledge of the company's products and services";
            var p5bIdText = headAndCont(reportId, p5bText);

            var p5bVala = sData[39];
            var p5bTota = 100;
            var p5bCola = '#ed8601';
            var p5bTita = 'Your Score';

            var p5bValb = sData[40];
            var p5bTotb = 100;
            var p5bColb = '#545454';
            var p5bTitb =  sData[1];

            var p5bValc = sData[41];
            var p5bTotc = 100;
            var p5bColc = '#1ca4ff';
            var p5bTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 5C
            var p5cText = "Overall knowledge of property and lending";
            var p5cIdText = headAndCont(reportId, p5cText);

            var p5cVala = sData[42];
            var p5cTota = 100;
            var p5cCola = '#ed8601';
            var p5cTita = 'Your Score';

            var p5cValb = sData[43];
            var p5cTotb = 100;
            var p5cColb = '#545454';
            var p5cTitb =  sData[1];

            var p5cValc = sData[44];
            var p5cTotc = 100;
            var p5cColc = '#1ca4ff';
            var p5cTitc = 'Industry';
            
            // Add Space
            addSpace(reportId);

            // Page 5D
            var p5dText = "Ability to tell clients about the benefits to them of choosing the loans they were offered";
            var p5dIdText = headAndCont(reportId, p5dText);

            var p5dVala = sData[45];
            var p5dTota = 100;
            var p5dCola = '#ed8601';
            var p5dTita = 'Your Score';

            var p5dValb = sData[46];
            var p5dTotb = 100;
            var p5dColb = '#545454';
            var p5dTitb =  sData[1];

            var p5dValc = sData[47];
            var p5dTotc = 100;
            var p5dColc = '#1ca4ff';
            var p5dTitc = 'Industry';

            // Page 5 Break
            pageBreak(reportId);

            // Page 6A
            var p6aText = "Inform and educate clients about the options available";
            var p6aIdText = headAndCont(reportId, p6aText);

            var p6aVala = sData[48];
            var p6aTota = 100;
            var p6aCola = '#ed8601';
            var p6aTita = 'Your Score';

            var p6aValb = sData[49];
            var p6aTotb = 100;
            var p6aColb = '#545454';
            var p6aTitb =  sData[1];

            var p6aValc = sData[50];
            var p6aTotc = 100;
            var p6aColc = '#1ca4ff';
            var p6aTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 6B
            var p6bText = "Clear and easy to understand";
            var p6bIdText = headAndCont(reportId, p6bText);

            var p6bVala = sData[51];
            var p6bTota = 100;
            var p6bCola = '#ed8601';
            var p6bTita = 'Your Score';

            var p6bValb = sData[52];
            var p6bTotb = 100;
            var p6bColb = '#545454';
            var p6bTitb =  sData[1];

            var p6bValc = sData[53];
            var p6bTotc = 100;
            var p6bColc = '#1ca4ff';
            var p6bTitc = 'Industry';

            // Page 6 Break
            pageBreak(reportId);

            // page 7A
            addHeader("COMPLIANCE");

            // page 7B
            var p7aId = addRow1(reportId);
            var p7aContent ="Compliance measures an adviser’s ability to satisfy relevant financial regulations."
            cellText(p7aId, p7aContent);

            // Page 7C
            var p7cId = addRow1(reportId);
            var p7cCols = "Your Score\nYellow\nIndustry";
            var p7cVals = sData[6] + "\n" +  sData[7] + "\n" +  sData[8];

            // Page 7D
            var p7dText = "The shopper was asked the following questions:";
            textBold(reportId, p7dText);

            // Page 7E
            var p7eId = addWell(reportId);
            var p7eContent = "At any stage of the meeting, did you believe you might have been misled regarding your rights?";
            cellText(p7eId, p7eContent);

            // Page 7F
            var p7fId = addRow1(reportId);
            var p7fCols = [sData[1], "Industry"];
            var p7fa = sData[55];
            var p7fb = sData[56];
            var p7fVals = [p7fa, p7fb];
            var p7fTitle = sData[54];

            // Page 7 Break
            pageBreak(reportId);

            // Page 8A
            var p8aId = addWell(reportId);
            var p8aContent = "Did your lender discuss your living expenses with you?";
            cellText(p8aId, p8aContent);

            // Page 8B
            var p8bId = addRow1(reportId);
            var p8bCols = [sData[1], "Industry"];
            var p8ba = sData[58];
            var p8bb = sData[59];
            var p8bVals = [p8ba, p8bb];
            var p8bTitle = sData[57];

            // Add Space
            addSpace(reportId);

            // Page 8C
            var p8cId = addWell(reportId);
            var p8cContent = "Did the lender explain who supervises their conduct?";
            cellText(p8cId, p8cContent);

            // Page 8D
            var p8dId = addRow1(reportId);
            var p8dCols = [sData[1], "Industry"];
            var p8da = sData[61];
            var p8db = sData[62];
            var p8dVals = [p8da, p8db];
            var p8dTitle = sData[60];

            // Add Space
            addSpace(reportId);

            // Page 8E
            var p8eText = "The shopper was asked the following questions about the credit guide:";
            textBold(reportId, p8eText);

            // Page 8F
            var p8fId = addRow1(reportId);
            var p8HeadCont = sData[1] + " (%Yes)";
            var p8fHeader = "Your shopper's answer\n" +  p8HeadCont + "\nIndustry (%Yes)";
            var p8fCont = "Did the lender explain how you could make a complaint if you needed to do so?\n" + sData[63] + "\n" + sData[64] + "%\n" + sData[65] + "%\nDid the lender explain to you to whom you can complain if you need to?\n" + sData[66] + "\n" + sData[67] + "%\n" + sData[68] + "%";
            addTable(p8fId, p8fHeader, p8fCont);

            // Page 8 Break
            pageBreak(reportId);

            // Page 9A
            var p9aId = addWell(reportId);
            var p9aContent = "Did the lender tell you about all the fees and charges you would have to pay?";
            cellText(p9aId, p9aContent);

            // Add Space
            addSpace(reportId);

            // Page 9B
            var p9bId = addRow1(reportId);
            var p9bAns = sData[69];
            addWellAns(p9bId, p9bAns);

            // Add Space
            addSpace(reportId);

            // Page 9C
            var p9cContent = sData[70] + "\n" + sData[71] + "\n" + sData[72] + "\n" + sData[73] + "\n" + sData[74] + "\n" + sData[75] + "\n" + sData[76] + "\n" + sData[77] + "\n" + sData[78] + "\n" + sData[79];
            addProgress(reportId, p9cContent);

            // Add Space
            addSpace(reportId);

            // Page 9D
            var p9dId = addWell(reportId);
            var p9dContent = "What was your reaction to the amount that the lender recommended you borrow?";
            cellText(p9dId, p9dContent);

            // Page 9E
            var p9eId = addRow1(reportId);
            var p9eCols = [sData[1], "Industry"];
            var p9ea = sData[81];
            var p9eb = sData[82];
            var p9eVals = [p9ea, p9eb];
            var p9eTitle = sData[80];

            // Add Space
            addSpace(reportId);

            // Page 9F
            var p9fId = addWell(reportId);
            var p9fContent = "Did you feel that you could afford the associated payments?";
            cellText(p9fId, p9fContent);

            // Add Space
            addSpace(reportId);

            // Page 9G
            var p9gId = addRow1(reportId);
            var p9gCols = [sData[1], "Industry"];
            var p9ga = sData[84];
            var p9gb = sData[85];
            var p9gVals = [p9ga, p9gb];
            var p9gTitle = sData[83];

            // Page 9 Break
            pageBreak(reportId);

            // Add Space
            addSpace(reportId);

            // Page 10A
            var p10aId = addWell(reportId);
            var p10aContent = "Did you consider the products (loans) offered were appropriate to your circumstances and stated goals?";
            cellText(p10aId, p10aContent);

            // Page 10B
            var p10bId = addRow1(reportId);
            var p10bCols = [sData[1], "Industry"];
            var p10ba = sData[87];
            var p10bb = sData[88];
            var p10bVals = [p10ba, p10bb];
            var p10bTitle = sData[86];

            // Add Space
            addSpace(reportId);

            // Page 10C
            var p10cText = "The shopper was asked the following questions relating to personal advice:";
            textBold(reportId, p10cText);

            // Page 10D
            var p10dId = addRow1(reportId);
            var p10dHeadCont = sData[1] + " (%Yes)";
            var p10dHeader = "Your shopper's answer\n" +  p8HeadCont + "\nIndustry (%Yes)";
            var p10dCont = "Did you know or were you advised that the lender is authorised to give Financial Services advice?\n" + sData[89] + "\n" + sData[90] + "%\n" + sData[91] + "%\nDid the lender mention or show you an Australian Financial Services License?\n" + sData[92] + "\n" + sData[93] + "%\n" + sData[94] + "%" + "\nDid the lender give you any personal advice about the way your finances/investments are structured (i.e. advice that was specific to your individual circumstances)?\n"  + sData[95] + "\n" + sData[96] + "%\n" + sData[97] + "%";
            addTable(p10dId, p10dHeader, p10dCont);

            // Page 10e
            var p10eText = "The shopper was asked the following questions:";
            textBold(reportId, p10eText);

            // Page 10f
            var p10fId = addRow1(reportId);
            var p10fHeadCont = sData[1] + " (%Yes)";
            var p10fHeader = "Your shopper's answer\n" +  p8HeadCont + "\nIndustry (%Yes)";
            var p10fCont = "Were you OFFERED any advice about your superannuation?\n" + sData[98] + "\n" + sData[99] + "%\n" + sData[100] + "%\nWere you GIVEN advice on your superannuation in discussion with the lender?\n" + sData[101] + "\n" + sData[102] + "%\n" + sData[103] + "%" + "\nWas this recommendation related to your stated goals and objectives?\n"  + sData[104] + "\n" + sData[105] + "%\n" + sData[106] + "%\nWas that recommendation appropriate in your opinion?\n" + sData[107] + "\n" + sData[108] + "%\n" + sData[109] + "%";
            addTable(p10fId, p10fHeader, p10fCont);

            // Page 10 Break
            pageBreak(reportId);

            // Page 11A
            var p11aId = addWell(reportId);
            var p11aContent = "What information did the lender collect about you? [Aggregate]";
            cellText(p11aId, p11aContent);

            // Page 11B
            var p11bId = addRow1(reportId);
            var p11bCols = [sData[1], "Industry"];
            var p11ba = sData[111];
            var p11bb = sData[112];
            var p11bVals = [p11ba, p11bb];
            var p11bTitle = sData[110];

            // Add Space
            addSpace(reportId);

            // Page 11C
            var p11cId = addWell(reportId);
            var p11cContent = "Did the lender tell you what would happen to your personal information?";
            cellText(p11cId, p11cContent);

            // Page 11D
            var p11dId = addRow1(reportId);
            var p11dCols = [sData[1], "Industry"];
            var p11da = sData[114];
            var p11db = sData[115];
            var p11dVals = [p11da, p11db];
            var p11dTitle = sData[113];

            // Add Space
            addSpace(reportId);

            // Page 11E
            var p11eText = "The shopper was asked the following questions:";
            textBold(reportId, p11eText);

            // Page 11F
            var p11fId = addRow1(reportId);
            var p11fHeadCont = sData[1] + " (%Yes)";
            var p11fHeader = "Your shopper's answer\n" +  p11fHeadCont + "\nIndustry (%Yes)";
            var p11fCont = "Did the lender give you a credit guide?\n" + sData[116] + "\n" + sData[117] + "%\n" + sData[118] + "%\nDid the lender provide you with a credit quote/proposal?\n" + sData[119] + "\n" + sData[120] + "%\n" + sData[121] + "%";
            addTable(p11fId, p11fHeader, p11fCont);

            // Page 11 Break
            pageBreak(reportId);

            // page 12A
            addHeader("QUALITY");

            // page 12B
            var p12bId = addRow1(reportId);
            var p12bContent ="Quality measures a mortgage lender’s ability to satisfy client needs and provide perceived value."
            cellText(p12bId, p12bContent);

            // Page 12C
            var p12cId = addRow1(reportId);
            var p12cCols = "Your Score\nYellow\nIndustry";
            var p12cVals = sData[9] + "\n" +  sData[10] + "\n" +  sData[11];

            // Page 12D
            var p12dText = "The shopper was asked:";
            textBold(reportId, p12dText);

            // Page 12E
            var p12eText = "How well did the loans offered meet your needs?";
            var p12eIdText = headAndCont(reportId, p12eText);

            var p12eVala = sData[122];
            var p12eTota = 100;
            var p12eCola = '#ed8601';
            var p12eTita = 'Your Score';

            var p12eValb = sData[123];
            var p12eTotb = 100;
            var p12eColb = '#545454';
            var p12eTitb =  sData[1];

            var p12eValc = sData[124];
            var p12eTotc = 100;
            var p12eColc = '#1ca4ff';
            var p12eTitc = 'Industry';

            // Page 12 Break
            pageBreak(reportId);

            // Page 13A
            var p13aText = "The shopper was asked to rate the mortgage lender on the following:";
            textBold(reportId, p13aText);

            // Page 13B
            var p13bText = "The quality of the information provided";
            var p13bIdText = headAndCont(reportId, p13bText);

            var p13bVala = sData[125];
            var p13bTota = 100;
            var p13bCola = '#ed8601';
            var p13bTita = 'Your Score';

            var p13bValb = sData[126];
            var p13bTotb = 100;
            var p13bColb = '#545454';
            var p13bTitb =  sData[1];

            var p13bValc = sData[127];
            var p13bTotc = 100;
            var p13bColc = '#1ca4ff';
            var p13bTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 13C
            var p13cText = "The lender's focus on clients’ needs rather than trying to push a particular product";
            var p13cIdText = headAndCont(reportId, p13cText);

            var p13cVala = sData[128];
            var p13cTota = 100;
            var p13cCola = '#ed8601';
            var p13cTita = 'Your Score';

            var p13cValb = sData[129];
            var p13cTotb = 100;
            var p13cColb = '#545454';
            var p13cTitb =  sData[1];

            var p13cValc = sData[130];
            var p13cTotc = 100;
            var p13cColc = '#1ca4ff';
            var p13cTitc = 'Industry';

            // Page 13 Break
            pageBreak(reportId);

            // page 14A
            addHeader("UNDERSTANDING");

            // Page 14B
            var p14bId = addRow1(reportId);
            var p14bContent ="Understanding measures a mortgage lender’s ability to understand client’s needs."
            cellText(p14bId, p14bContent);

            // Page 14C
            var p14cId = addRow1(reportId);
            var p14cCols = "Your Score\nYellow\nIndustry";
            var p14cVals = sData[12] + "\n" +  sData[13] + "\n" +  sData[14];

            // Page 14D
            var p14dText = "The shopper was asked the following questions:";
            textBold(reportId, p14dText);

            // Page 14E
            var p14eText = "Please rate the lender on their: Listening skills";
            var p14eIdText = headAndCont(reportId, p14eText);

            var p14eVala = sData[131];
            var p14eTota = 100;
            var p14eCola = '#ed8601';
            var p14eTita = 'Your Score';

            var p14eValb = sData[132];
            var p14eTotb = 100;
            var p14eColb = '#545454';
            var p14eTitb =  sData[1];

            var p14eValc = sData[133];
            var p14eTotc = 100;
            var p14eColc = '#1ca4ff';
            var p14eTitc = 'Industry';

            // Page 14 Break
            pageBreak(reportId);

            // Page 15A
            var p15aId = addWell(reportId);
            var p15aContent = "Did the lender advise you that they will require documents to be brought to the appointment?";
            cellText(p15aId, p15aContent);

            // Page 15B
            var p15bId = addRow1(reportId);
            var p15bCols = [sData[1], "Industry"];
            var p15ba = sData[135];
            var p15bb = sData[136];
            var p15bVals = [p15ba, p15bb];
            var p15bTitle = sData[134];

            // Add Space
            addSpace(reportId);

            // Page 15C
            var p15cText = "Lender’s preparedness for the meeting";
            var p15cIdText = headAndCont(reportId, p15cText);

            var p15cVala = sData[137];
            var p15cTota = 100;
            var p15cCola = '#ed8601';
            var p15cTita = 'Your Score';

            var p15cValb = sData[138];
            var p15cTotb = 100;
            var p15cColb = '#545454';
            var p15cTitb =  sData[1];

            var p15cValc = sData[139];
            var p15cTotc = 100;
            var p15cColc = '#1ca4ff';
            var p15cTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 15D
            var p15dText = "Lender’s ability to elicit clients’ needs effectively";
            var p15dIdText = headAndCont(reportId, p15dText);

            var p15dVala = sData[140];
            var p15dTota = 100;
            var p15dCola = '#ed8601';
            var p15dTita = 'Your Score';

            var p15dValb = sData[141];
            var p15dTotb = 100;
            var p15dColb = '#545454';
            var p15dTitb =  sData[1];

            var p15dValc = sData[142];
            var p15dTotc = 100;
            var p15dColc = '#1ca4ff';
            var p15dTitc = 'Industry';

            // Page 15 Break
            pageBreak(reportId);
            

            // Page 17A
            addHeader("INTENTION");

            // Page 17B
            var p17bId = addRow1(reportId);
            var p17bContent ="Intention measures the likelihood of a shopper using, reusing or recommending a lender.\n\nThis category will reflect performance across the whole process as well as the effectiveness with which the mortgage lender has created a “call to action”."
            cellText(p17bId, p17bContent);

            // Page 17C
            var p17cId = addRow1(reportId);
            var p17cCols = "Your Score\nYellow\nIndustry";
            var p17cVals = sData[15] + "\n" +  sData[16] + "\n" +  sData[17];

            // Page 17D
            var p17dText = "The shopper was asked the following questions:";
            textBold(reportId, p17dText);

            // Page 17E
            var p17eText = "How likely are you to recommend this lender to your friends, family or colleagues?";
            var p17eIdText = headAndCont(reportId, p17eText);

            var p17eVala = sData[146];
            var p17eTota = 100;
            var p17eCola = '#ed8601';
            var p17eTita = 'Your Score';

            var p17eValb = sData[147];
            var p17eTotb = 100;
            var p17eColb = '#545454';
            var p17eTitb =  sData[1];

            var p17eValc = sData[148];
            var p17eTotc = 100;
            var p17eColc = '#1ca4ff';
            var p17eTitc = 'Industry';

            // Page 17 Break
            pageBreak(reportId);

            // Page 18A
            var p18aText = "How likely are you to proceed to a second appointment/meeting with this lender to finalise your loan?";
            var p18aIdText = headAndCont(reportId, p18aText);

            var p18aVala = sData[149];
            var p18aTota = 100;
            var p18aCola = '#ed8601';
            var p18aTita = 'Your Score';

            var p18aValb = sData[150];
            var p18aTotb = 100;
            var p18aColb = '#545454';
            var p18aTitb =  sData[1];

            var p18aValc = sData[151];
            var p18aTotc = 100;
            var p18aColc = '#1ca4ff';
            var p18aTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 18B
            var p18bText = "How likely are you to proceed to a loan application with this lender?";
            var p18bIdText = headAndCont(reportId, p18bText);

            var p18bVala = sData[152];
            var p18bTota = 100;
            var p18bCola = '#ed8601';
            var p18bTita = 'Your Score';

            var p18bValb = sData[153];
            var p18bTotb = 100;
            var p18bColb = '#545454';
            var p18bTitb =  sData[1];

            var p18bValc = sData[154];
            var p18bTotc = 100;
            var p18bColc = '#1ca4ff';
            var p18bTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 18C
            var p18cText = "How likely are you to re-use this lender in the future?";
            var p18cIdText = headAndCont(reportId, p18cText);

            var p18cVala = sData[155];
            var p18cTota = 100;
            var p18cCola = '#ed8601';
            var p18cTita = 'Your Score';

            var p18cValb = sData[156];
            var p18cTotb = 100;
            var p18cColb = '#545454';
            var p18cTitb =  sData[1];

            var p18cValc = sData[157];
            var p18cTotc = 100;
            var p18cColc = '#1ca4ff';
            var p18cTitc = 'Industry';

            // Page 18 Break
            pageBreak(reportId);

            // Page 19A
            addHeader("REACTION");

            // Page 19B
            var p19bId = addRow1(reportId);
            var p19bContent ="Reaction measures a client’s emotive/affective responses to the purchase process.\n\nThis is an important category as historically many of the underlying dimensions correlate strongly with overall client satisfaction."
            cellText(p19bId, p19bContent);

            // p19c
            var p19cId = addRow1(reportId);
            var p19cCols = "Your Score\nYellow\nIndustry";
            var p19cVals = sData[18] + "\n" +  sData[19] + "\n" +  sData[20];

            // p19d
            var p19dText = "The shopper was asked:";
            textBold(reportId, p19dText);

            // p19e
            var p19eText = "How well did the lender demonstrate their keenness for your business?";
            var p19eIdText = headAndCont(reportId, p19eText);

            var p19eVala = sData[158];
            var p19eTota = 100;
            var p19eCola = '#ed8601';
            var p19eTita = 'Your Score';

            var p19eValb = sData[159];
            var p19eTotb = 100;
            var p19eColb = '#545454';
            var p19eTitb =  sData[1];

            var p19eValc = sData[160];
            var p19eTotc = 100;
            var p19eColc = '#1ca4ff';
            var p19eTitc = 'Industry';

            // Page 19 Break
            pageBreak(reportId);

            // Page 20A
            addDoHead(reportId);

            // Page 20B
            var p20bIdText = addContWiText(reportId, "Highly valued");
            var p20bVala = sData[161];
            var p20bTota = 100;
            var p20bCola = '#ed8601';
            var p20bTita = 'Your Score';

            var p20bValb = sData[162];
            var p20bTotb = 100;
            var p20bColb = '#545454';
            var p20bTitb =  sData[1];

            var p20bValc = sData[163];
            var p20bTotc = 100;
            var p20bColc = '#1ca4ff';
            var p20bTitc = 'Industry';

            // Page 20C
            var p20cIdText = addContWiText(reportId, "Comfortable");
            var p20cVala = sData[164];
            var p20cTota = 100;
            var p20cCola = '#ed8601';
            var p20cTita = 'Your Score';

            var p20cValb = sData[165];
            var p20cTotb = 100;
            var p20cColb = '#545454';
            var p20cTitb =  sData[1];

            var p20cValc = sData[166];
            var p20cTotc = 100;
            var p20cColc = '#1ca4ff';
            var p20cTitc = 'Industry';

            // Page 20D
            var p20dIdText = addContWiText(reportId, "Engaged");
            var p20dVala = sData[167];
            var p20dTota = 100;
            var p20dCola = '#ed8601';
            var p20dTita = 'Your Score';

            var p20dValb = sData[168];
            var p20dTotb = 100;
            var p20dColb = '#545454';
            var p20dTitb =  sData[1];

            var p20dValc = sData[169];
            var p20dTotc = 100;
            var p20dColc = '#1ca4ff';
            var p20dTitc = 'Industry';

            // Page 20E
            var p20eIdText = addContWiText(reportId, "Satisfied");
            var p20eVala = sData[170];
            var p20eTota = 100;
            var p20eCola = '#ed8601';
            var p20eTita = 'Your Score';

            var p20eValb = sData[171];
            var p20eTotb = 100;
            var p20eColb = '#545454';
            var p20eTitb =  sData[1];

            var p20eValc = sData[172];
            var p20eTotc = 100;
            var p20eColc = '#1ca4ff';
            var p20eTitc = 'Industry';

            // Page 20F
            var p20fIdText = addContWiText(reportId, "Well treated");
            var p20fVala = sData[173];
            var p20fTota = 100;
            var p20fCola = '#ed8601';
            var p20fTita = 'Your Score';

            var p20fValb = sData[174];
            var p20fTotb = 100;
            var p20fColb = '#545454';
            var p20fTitb =  sData[1];

            var p20fValc = sData[175];
            var p20fTotc = 100;
            var p20fColc = '#1ca4ff';
            var p20fTitc = 'Industry';

            // Page 20 Break
            pageBreak(reportId);

            // Page 21A
            var p21aText = "The shopper was asked to rate the following:";
            textBold(reportId, p21aText);

            // Page 21B
            var p21bText = "Ability to build rapport with client";
            var p21bIdText = headAndCont(reportId, p21bText);

            var p21bVala = sData[176];
            var p21bTota = 100;
            var p21bCola = '#ed8601';
            var p21bTita = 'Your Score';

            var p21bValb = sData[177];
            var p21bTotb = 100;
            var p21bColb = '#545454';
            var p21bTitb =  sData[1];

            var p21bValc = sData[178];
            var p21bTotc = 100;
            var p21bColc = '#1ca4ff';
            var p21bTitc = 'Industry';

            // Add Space
            addSpace(reportId);

            // Page 21C
            var p21cId = addWell(reportId);
            var p21cContent = "Throughout the process, do you think they were always honest?";
            cellText(p21cId, p21cContent);

            // Add Space
            addSpace(reportId);

            // Page 21D
            var p21dId = addRow1(reportId);
            var p21dCols = [sData[1], "Industry"];
            var p21da = sData[180];
            var p21db = sData[181];
            var p21dVals = [p21da, p21db];
            var p21dTitle = sData[179];

            // Add Space
            addSpace(reportId);

            // Page 21E
            var p21eText = "Trustworthiness of the lender";
            var p21eIdText = headAndCont(reportId, p21eText);

            var p21eVala = sData[182];
            var p21eTota = 100;
            var p21eCola = '#ed8601';
            var p21eTita = 'Your Score';

            var p21eValb = sData[183];
            var p21eTotb = 100;
            var p21eColb = '#545454';
            var p21eTitb =  sData[1];

            var p21eValc = sData[184];
            var p21eTotc = 100;
            var p21eColc = '#1ca4ff';
            var p21eTitc = 'Industry';

            // Page 21 Break
            pageBreak(reportId);

            // Page 22A
            addHeader("ENVIRONMENT");

            // Page 22B
            var p22bId = addRow1(reportId);
            var p22bContent ="Environment measures the intangible and tangible aspects of the client-mortgage lender experience. In addition to the physical environment, this category looks at the dimensions such as the style and manner of the mortgage lender and how easy it was to make an appointment. Historically, this has been a high scoring measure for most participants and is largely considered to be a hygiene factor."
            cellText(p22bId, p22bContent);

            // Page 22C
            var p22cId = addRow1(reportId);
            var p22cCols = "Your Score\nYellow\nIndustry";
            var p22cVals = sData[21] + "\n" +  sData[22] + "\n" +  sData[23];

            // Add Space
            addSpace(reportId);

            // Page 22D
            var p22dText = "The shopper was asked the following questions about the appointment process:";
            textBold(reportId, p22dText);

            //Page 22E
            var p22eText = "How easy was it to book the appointment?";
            var p22eIdText = headAndCont(reportId, p22eText);

            var p22eVala = sData[185];
            var p22eTota = 100;
            var p22eCola = '#ed8601';
            var p22eTita = 'Your Score';

            var p22eValb = sData[186];
            var p22eTotb = 100;
            var p22eColb = '#545454';
            var p22eTitb =  sData[1];

            var p22eValc = sData[187];
            var p22eTotc = 100;
            var p22eColc = '#1ca4ff';
            var p22eTitc = 'Industry';

            // Page 22 Break
            pageBreak(reportId);

            // Page 23A
            var p23aText = "The shopper was asked the following questions about the physical environment:";
            textBold(reportId, p23aText);

            // Page 23B
            var p23bId = addRow1(reportId);
            var p23bHeadCont = sData[1];
            var p23bHeader = "Your shopper's answer\n" +  p23bHeadCont + " (% Met/ Exceeded)\nIndustry (% Met/ Eceeded)";
            var p23bCont = "How did you perceive the external environment of the office or branch?\n" + sData[188] + "\n" + sData[189] + "%\n" + sData[190] + "%\nHow did you perceive the internal environment of the office or branch?\n" + sData[191] + "\n" + sData[192] + "%\n" + sData[193] + "%";
            addTable(p23bId, p23bHeader, p23bCont);

            // Add Space
            addSpace(reportId);

            // Page 23C
            var p23cText = "The shopper was asked to rate the mortgage lender on the following:";
            textBold(reportId, p23cText);

            // Page 23D
            var p23dText = "Overall physical appearance";
            var p23dIdText = headAndCont(reportId, p23dText);

            var p23dVala = sData[194];
            var p23dTota = 100;
            var p23dCola = '#ed8601';
            var p23dTita = 'Your Score';

            var p23dValb = sData[195];
            var p23dTotb = 100;
            var p23dColb = '#545454';
            var p23dTitb =  sData[1];

            var p23dValc = sData[196];
            var p23dTotc = 100;
            var p23dColc = '#1ca4ff';
            var p23dTitc = 'Industry';

            // Page 23 Break
            pageBreak(reportId);

            // Page 24A
            addHeader("FOLLOW UP");

            // Page 24B
            var p24bId = addRow1(reportId);
            var p24bContent ="One of the recurring findings of our 'Shadow Shopping' studies is the less-than-adequate follow up rates by mortgage lender after the first 'shopper' meeting. Best practice suggests that all customers should be followed up within two days of the initial meeting, ideally by phone. Research shows clearly that the likelihood of a shopper using or recommending a mortgage lender is significantly higher when they are followed up.";
            cellText(p24bId, p24bContent);

            // Add Space
            addSpace(reportId);

            // Page 24C
            var p24cId = addRow1(reportId);
            var p24cHeadCont = sData[1] + " (%Yes)";
            var p24cHeader = "Your shopper's answer\n" +  p24cHeadCont + "\nIndustry (%Yes)";
            var p24cCont = "After the appointment/meeting were you followed up?\n" + sData[197] + "\n" + sData[198] + "%\n" + sData[199] +"%" + "\n" + "After the appointment were you followed up by phone?\n" + sData[218] + "\n" + sData[219] + "%\n" + sData[220] + "%";
            addTable(p24cId, p24cHeader, p24cCont);

            // Add Space
            addSpace(reportId);

            // Page 24D
            var p24dText = "If the shopper was followed up, the shopper was asked:";
            textBold(reportId, p24dText);

            // Page 24E
            var p24eId = addWell(reportId);
            var p24eContent = "How many days later was the follow up?";
            cellText(p24eId, p24eContent);

            // Add Space
            addSpace(reportId);

            // Page 24F
            var p24fId = addRow1(reportId);
            var p24fAns = sData[200];
            addWellAns(p24fId, p24fAns);

            // Add Space
            addSpace(reportId);

            // Page 24G
            var p24gContent = sData[201] + "\n" + sData[202] + "\n" + sData[203] + "\n" + sData[204] + "\n0\n" + sData[205] + "\n" + sData[206] + "\n" + sData[207] + "\n" + sData[208] + "\n0\n";
            addProgress(reportId, p24gContent);

            // Page 24 Break
            pageBreak(reportId);

            // Page 25A
            var p25aId = addWell(reportId);
            var p25aContent = "How did they follow up?";
            cellText(p25aId, p25aContent);

            // Add Space
            addSpace(reportId);

            // Page 25B
            var p25bId = addRow1(reportId);
            var p25bAns = sData[209];
            addWellAns(p25bId, p25bAns);

            // Add Space
            addSpace(reportId);

            // Page 25C
            var p25cId = addRow1(reportId);
            var p25cVals = sData[210] + "\n" + sData[214] + "\n" + sData[211] + "\n" + sData[215] + "\n" + sData[212] + "\n" + sData[216] + "\n" + sData[213] + "\n" + sData[217];
            addDevice(p25cId, p25cVals);




            // Charts and Graphs Rendering
            var cnt = 20500;
            //addBar(p2bId, p2bCols, p2bVals, "ACQUIRE");
            setTimeout(function() { addBar(p2bId, p2bCols, p2bVals, "ACQUIRE"); }, cnt);
            cnt += 450;
            cnt += 725;
            setTimeout(function() { addLine(p2dId, data1, data2); }, cnt);
            cnt += 450;
            cnt += 725;
            setTimeout(function() { addBar(p3bId, p3bCols, p3bVals, ""); }, cnt);

            cnt += 500;
            cnt += 725;
            setTimeout(function() { addDoughnut(p3dIdText[0], p3dVala, p3dTota, p3dCola, p3dTita); }, cnt);
            cnt += 500;
            cnt += 725;
            setTimeout(function() { addDoughnut(p3dIdText[1], p3dValb, p3dTotb, p3dColb, p3dTitb); }, cnt);
            cnt += 500;
            cnt += 725;
            setTimeout(function() { addDoughnut(p3dIdText[2], p3dValc, p3dTotc, p3dColc, p3dTitc); }, cnt);

            cnt += 550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p4aIdText[0], p4aVala, p4aTota, p4aCola, p4aTita); }, cnt);
            cnt += 550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p4aIdText[1], p4aValb, p4aTotb, p4aColb, p4aTitb); }, cnt);
            cnt += 550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p4aIdText[2], p4aValc, p4aTotc, p4aColc, p4aTitc); }, cnt);

            cnt += 650;
            cnt += 725;
            setTimeout(function() { addDoughnut(p4bIdText[0], p4bVala, p4bTota, p4bCola, p4bTita); }, cnt);
            cnt += 650;
            cnt += 725;
            setTimeout(function() { addDoughnut(p4bIdText[1], p4bValb, p4bTotb, p4bColb, p4bTitb); }, cnt);
            cnt += 650;
            cnt += 725;
            setTimeout(function() { addDoughnut(p4bIdText[2], p4bValc, p4bTotc, p4bColc, p4bTitc); }, cnt);
            cnt += 650;
            cnt += 725;
            setTimeout(function() { addHorGraph(p4dId, p4dTitle, p4dCols, p4dVals); }, cnt);

            cnt += 650;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5bIdText[0], p5bVala, p5bTota, p5bCola, p5bTita); }, cnt);
            cnt += 650;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5bIdText[1], p5bValb, p5bTotb, p5bColb, p5bTitb); }, cnt);
            cnt += 650;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5bIdText[2], p5bValc, p5bTotc, p5bColc, p5bTitc); }, cnt);
            
            cnt += 700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5cIdText[0], p5cVala, p5cTota, p5cCola, p5cTita); }, cnt);
            cnt += 700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5cIdText[1], p5cValb, p5cTotb, p5cColb, p5cTitb); }, cnt);
            cnt += 700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5cIdText[2], p5cValc, p5cTotc, p5cColc, p5cTitc); }, cnt);

            cnt += 750;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5dIdText[0], p5dVala, p5dTota, p5dCola, p5dTita); }, cnt);
            cnt += 750;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5dIdText[1], p5dValb, p5dTotb, p5dColb, p5dTitb); }, cnt);
            cnt += 750;
            cnt += 725;
            setTimeout(function() { addDoughnut(p5dIdText[2], p5dValc, p5dTotc, p5dColc, p5dTitc); }, cnt);

            cnt += 850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p6aIdText[0], p6aVala, p6aTota, p6aCola, p6aTita); }, cnt);
            cnt += 850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p6aIdText[1], p6aValb, p6aTotb, p6aColb, p6aTitb); }, cnt);
            cnt += 850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p6aIdText[2], p6aValc, p6aTotc, p6aColc, p6aTitc); }, cnt);

            cnt += 900;
            cnt += 725;
            setTimeout(function() { addDoughnut(p6bIdText[0], p6bVala, p6bTota, p6bCola, p6bTita); }, cnt);
            cnt += 900;
            cnt += 725;
            setTimeout(function() { addDoughnut(p6bIdText[1], p6bValb, p6bTotb, p6bColb, p6bTitb); }, cnt);
            cnt += 900;
            cnt += 725;
            setTimeout(function() { addDoughnut(p6bIdText[2], p6bValc, p6bTotc, p6bColc, p6bTitc); }, cnt);

            cnt += 950;
            cnt += 725;
            setTimeout(function() { addBar(p7cId, p7cCols, p7cVals, ""); }, cnt);
            cnt += 950;
            cnt += 725;
            setTimeout(function() { addHorGraph(p7fId, p7fTitle, p7fCols, p7fVals); }, cnt);

            cnt += 1000;
            cnt += 725;
            setTimeout(function() { addHorGraph(p8bId, p8bTitle, p8bCols, p8bVals); }, cnt);
            cnt += 1000;
            cnt += 725;
            setTimeout(function() { addHorGraph(p8dId, p8dTitle, p8dCols, p8dVals); }, cnt);

            cnt += 1050;
            cnt += 725;
            setTimeout(function() { addHorGraph(p9eId, p9eTitle, p9eCols, p9eVals); }, cnt);
            cnt += 1050;
            cnt += 725;
            setTimeout(function() { addHorGraph(p9gId, p9gTitle, p9gCols, p9gVals); }, cnt);

            cnt += 1050;
            cnt += 725;
            setTimeout(function() { addHorGraph(p10bId, p10bTitle, p10bCols, p10bVals); }, cnt);

            cnt += 1050;
            cnt += 725;
            setTimeout(function() { addHorGraph(p11bId, p11bTitle, p11bCols, p11bVals); }, cnt);
            cnt += 1100;
            cnt += 725;
            setTimeout(function() { addHorGraph(p11dId, p11dTitle, p11dCols, p11dVals); }, cnt);

            cnt += 1150;
            cnt += 725;
            setTimeout(function() { addBar(p12cId, p12cCols, p12cVals, ""); }, cnt);
            cnt += 1250;
            cnt += 725;
            setTimeout(function() { addDoughnut(p12eIdText[0], p12eVala, p12eTota, p12eCola, p12eTita); }, cnt);
            cnt += 1250;
            cnt += 725;
            setTimeout(function() { addDoughnut(p12eIdText[1], p12eValb, p12eTotb, p12eColb, p12eTitb); }, cnt);
            cnt += 1250;
            cnt += 725;
            setTimeout(function() { addDoughnut(p12eIdText[2], p12eValc, p12eTotc, p12eColc, p12eTitc); }, cnt);

            cnt += 1400;
            cnt += 725;
            setTimeout(function() { addDoughnut(p13bIdText[0], p13bVala, p13bTota, p13bCola, p13bTita); }, cnt);
            cnt += 1400;
            cnt += 725;
            setTimeout(function() { addDoughnut(p13bIdText[1], p13bValb, p13bTotb, p13bColb, p13bTitb); }, cnt);
            cnt += 1400;
            cnt += 725;
            setTimeout(function() { addDoughnut(p13bIdText[2], p13bValc, p13bTotc, p13bColc, p13bTitc); }, cnt);

            cnt += 1500;
            cnt += 725;
            setTimeout(function() { addDoughnut(p13cIdText[0], p13cVala, p13cTota, p13cCola, p13cTita); }, cnt);
            cnt += 1500;
            cnt += 725;
            setTimeout(function() { addDoughnut(p13cIdText[1], p13cValb, p13cTotb, p13cColb, p13cTitb); }, cnt);
            cnt += 1500;
            cnt += 725;
            setTimeout(function() { addDoughnut(p13cIdText[2], p13cValc, p13cTotc, p13cColc, p13cTitc); }, cnt);

            cnt += 1550;
            cnt += 725;
            setTimeout(function() { addBar(p14cId, p14cCols, p14cVals, ""); }, cnt);

            cnt += 1700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p14eIdText[0], p14eVala, p14eTota, p14eCola, p14eTita); }, cnt);
            cnt += 1700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p14eIdText[1], p14eValb, p14eTotb, p14eColb, p14eTitb); }, cnt);
            cnt += 1700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p14eIdText[2], p14eValc, p14eTotc, p14eColc, p14eTitc); }, cnt);

            cnt += 1750;
            cnt += 725;
            setTimeout(function() { addHorGraph(p15bId, p15bTitle, p15bCols, p15bVals); }, cnt);

            cnt += 1900;
            cnt += 725;
            setTimeout(function() { addDoughnut(p15cIdText[0], p15cVala, p15cTota, p15cCola, p15cTita); }, cnt);
            cnt += 1900;
            cnt += 725;
            setTimeout(function() { addDoughnut(p15cIdText[1], p15cValb, p15cTotb, p15cColb, p15cTitb); }, cnt);
            cnt += 1900;
            cnt += 725;
            setTimeout(function() { addDoughnut(p15cIdText[2], p15cValc, p15cTotc, p15cColc, p15cTitc); }, cnt);

            cnt += 2050;
            cnt += 725;
            setTimeout(function() { addDoughnut(p15dIdText[0], p15dVala, p15dTota, p15dCola, p15dTita); }, cnt);
            cnt += 2050;
            cnt += 725;
            setTimeout(function() { addDoughnut(p15dIdText[1], p15dValb, p15dTotb, p15dColb, p15dTitb); }, cnt);
            cnt += 2050;
            cnt += 725;
            setTimeout(function() { addDoughnut(p15dIdText[2], p15dValc, p15dTotc, p15dColc, p15dTitc); }, cnt);

            cnt += 2400;
            cnt += 725;
            setTimeout(function() { addBar(p17cId, p17cCols, p17cVals, ""); }, cnt);

            cnt += 2550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p17eIdText[0], p17eVala, p17eTota, p17eCola, p17eTita); }, cnt);
            cnt += 2550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p17eIdText[1], p17eValb, p17eTotb, p17eColb, p17eTitb); }, cnt);
            cnt += 2550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p17eIdText[2], p17eValc, p17eTotc, p17eColc, p17eTitc); }, cnt);

            cnt += 2700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18aIdText[0], p18aVala, p18aTota, p18aCola, p18aTita); }, cnt);
            cnt += 2700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18aIdText[1], p18aValb, p18aTotb, p18aColb, p18aTitb); }, cnt);
            cnt += 2700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18aIdText[2], p18aValc, p18aTotc, p18aColc, p18aTitc); }, cnt);

            cnt += 2850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18bIdText[0], p18bVala, p18bTota, p18bCola, p18bTita); }, cnt);
            cnt += 2850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18bIdText[1], p18bValb, p18bTotb, p18bColb, p18bTitb); }, cnt);
            cnt += 2850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18bIdText[2], p18bValc, p18bTotc, p18bColc, p18bTitc); }, cnt);

            cnt += 3000;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18cIdText[0], p18cVala, p18cTota, p18cCola, p18cTita); }, cnt);
            cnt += 3000;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18cIdText[1], p18cValb, p18cTotb, p18cColb, p18cTitb); }, cnt);
            cnt += 3000;
            cnt += 725;
            setTimeout(function() { addDoughnut(p18cIdText[2], p18cValc, p18cTotc, p18cColc, p18cTitc); }, cnt);

            cnt += 3100;
            cnt += 725;
            setTimeout(function() { addBar(p19cId, p19cCols, p19cVals, ""); }, cnt);

            cnt += 3250;
            cnt += 725;
            setTimeout(function() { addDoughnut(p19eIdText[0], p19eVala, p19eTota, p19eCola, p19eTita); }, cnt);
            cnt += 3250;
            cnt += 725;
            setTimeout(function() { addDoughnut(p19eIdText[1], p19eValb, p19eTotb, p19eColb, p19eTitb); }, cnt);
            cnt += 3250;
            cnt += 725;
            setTimeout(function() { addDoughnut(p19eIdText[2], p19eValc, p19eTotc, p19eColc, p19eTitc); }, cnt);

            cnt += 3400;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20bIdText[0], p20bVala, p20bTota, p20bCola, p20bTita); }, cnt);
            cnt += 3400;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20bIdText[1], p20bValb, p20bTotb, p20bColb, p20bTitb); }, cnt);
            cnt += 3400;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20bIdText[2], p20bValc, p20bTotc, p20bColc, p20bTitc); }, cnt);

            cnt += 3550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20cIdText[0], p20cVala, p20cTota, p20cCola, p20cTita); }, cnt);
            cnt += 3550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20cIdText[1], p20cValb, p20cTotb, p20cColb, p20cTitb); }, cnt);
            cnt += 3550;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20cIdText[2], p20cValc, p20cTotc, p20cColc, p20cTitc); }, cnt);

            cnt += 3700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20dIdText[0], p20dVala, p20dTota, p20dCola, p20dTita); }, cnt);
            cnt += 3700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20dIdText[1], p20dValb, p20dTotb, p20dColb, p20dTitb); }, cnt);
            cnt += 3700;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20dIdText[2], p20dValc, p20dTotc, p20dColc, p20dTitc); }, cnt);

            cnt += 3850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20eIdText[0], p20eVala, p20eTota, p20eCola, p20eTita); }, cnt);
            cnt += 3850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20eIdText[1], p20eValb, p20eTotb, p20eColb, p20eTitb); }, cnt);
            cnt += 3850;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20eIdText[2], p20eValc, p20eTotc, p20eColc, p20eTitc); }, cnt);

            cnt += 4000;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20fIdText[0], p20fVala, p20fTota, p20fCola, p20fTita); }, cnt);
            cnt += 4000;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20fIdText[1], p20fValb, p20fTotb, p20fColb, p20fTitb); }, cnt);
            cnt += 4000;
            cnt += 725;
            setTimeout(function() { addDoughnut(p20fIdText[2], p20fValc, p20fTotc, p20fColc, p20fTitc); }, cnt);

            cnt += 4150;
            cnt += 725;
            setTimeout(function() { addDoughnut(p21bIdText[0], p21bVala, p21bTota, p21bCola, p21bTita); }, cnt);
            cnt += 4150;
            cnt += 725;
            setTimeout(function() { addDoughnut(p21bIdText[1], p21bValb, p21bTotb, p21bColb, p21bTitb); }, cnt);
            cnt += 4150;
            cnt += 725;
            setTimeout(function() { addDoughnut(p21bIdText[2], p21bValc, p21bTotc, p21bColc, p21bTitc); }, cnt);

            cnt += 4250;
            cnt += 725;
            setTimeout(function() { addHorGraph(p21dId, p21dTitle, p21dCols, p21dVals); }, cnt);

            cnt += 4300;
            cnt += 725;
            setTimeout(function() { addDoughnut(p21eIdText[0], p21eVala, p21eTota, p21eCola, p21eTita); }, cnt);
            cnt += 4300;
            cnt += 725;
            setTimeout(function() { addDoughnut(p21eIdText[1], p21eValb, p21eTotb, p21eColb, p21eTitb); }, cnt);
            cnt += 4300;
            cnt += 725;
            setTimeout(function() { addDoughnut(p21eIdText[2], p21eValc, p21eTotc, p21eColc, p21eTitc); }, cnt);

            cnt += 4400;
            cnt += 725;
            setTimeout(function() { addBar(p22cId, p22cCols, p22cVals, ""); }, cnt);

            cnt += 4450;
            cnt += 725;
            setTimeout(function() { addDoughnut(p22eIdText[0], p22eVala, p22eTota, p22eCola, p22eTita); }, cnt);
            cnt += 4450;
            cnt += 725;
            setTimeout(function() { addDoughnut(p22eIdText[1], p22eValb, p22eTotb, p22eColb, p22eTitb); }, cnt);
            cnt += 4450;
            cnt += 725;
            setTimeout(function() { addDoughnut(p22eIdText[2], p22eValc, p22eTotc, p22eColc, p22eTitc); }, cnt);

            cnt += 4600;
            cnt += 725;
            setTimeout(function() { addDoughnut(p23dIdText[0], p23dVala, p23dTota, p23dCola, p23dTita); }, cnt);
            cnt += 4600;
            cnt += 725;
            setTimeout(function() { addDoughnut(p23dIdText[1], p23dValb, p23dTotb, p23dColb, p23dTitb); }, cnt);
            cnt += 4600;
            cnt += 725;
            setTimeout(function() { addDoughnut(p23dIdText[2], p23dValc, p23dTotc, p23dColc, p23dTitc); }, cnt);




            //// location.reload();
        });
        
        function addHeader(content){
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: reportId, headerText: content, saveType: 'header'},
                success: function(result){
                }
            });
        }

        function addRow1(reportId){
            var rowId="";
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: reportId, colCount: '1', saveType: 'content'},
                success: function(result){
                    rowId = result[0];
                }
            });
            return rowId;
        }

        function addSpace(reportId){
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                data: {id: reportId, saveType: 'Spacer'},
                success: function(result){
                    
                }
            });
        }

        function addWell(reportId){
            var rowId="";
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: reportId, colCount: '1', saveType: 'well'},
                success: function(result){
                    rowId = result[0];
                }
            });
            return rowId;
        }

        function addDoHead(reportId){
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                data: {id: reportId, saveType: 'Doughnut Header'},
                success: function(result){

                }
            });
        }

        function headAndCont(reportId, headerText){
            var rowId="";
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: reportId, headerText: headerText, colCount: '3', saveType: 'Well (Header and Content)'},
                success: function(result){
                    rowId = result;
                }
            });
            
            return rowId;

        }

        function addContWiText(reportId, headerText){
            var rowId="";
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: reportId, colCount: '3', headerText:headerText, saveType: 'Content with Text'},
                success: function(result){
                    rowId = result;
                }
            });
            
            return rowId;
        }

        function cellText(id, inputText){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/reports/updatecell',
                async: false,
                data: {id: id, type: 'Text', inputText: inputText},
                success: function(result){
                    
                }
            });
        }

        function cellNumbering(id, inputText){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/reports/updatecell',
                async: false,
                data: {id: id, type: 'Numbering', inputText: inputText},
                success: function(result){
                    
                }
            });
        }

        function cellDefi(id, inputWord, inputDef){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/reports/updatecell',
                async: false,
                data: {id: id, type: 'Definition', inputWord: inputWord, inputDef: inputDef},
                success: function(result){

                }
            });
        }

        function pageBreak(id){
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: id, saveType: 'Page Break'},
                success: function(result){

                }
            });
        }

            
        
        function addBar(id, inputColumn, inputValue, title){
            var cols = inputColumn.split(/\n/);
            var vals = inputValue.split(/\n/);
            var len = cols.length;
            var arr = [];
            var num = 0;

            var ctx = document.getElementById("chartjs-1").getContext('2d');
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
                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y + 70);
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

            html2canvas(document.getElementById("chartjs-1"), {
                onrendered: function (canvas) {
                    imgData = canvas.toDataURL('', 2.0);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/updatecell',
                        async: false,
                        data: {id: id, type: 'Graph', imgData: imgData, inputColumn: inputColumn, inputValue: inputValue, inputGraphTitle: inputGraphTitle},
                        success: function(result){
                            
                        }
                    });
                    
                    
                },
            });

        }

        function addLine(id, data1, data2){
            data1s = data1.split("\n");
            data2s = data2.split("\n");
            var d1min = Math.min.apply(Math,data1s);
            var d1max = Math.max.apply(Math,data1s);
            var d2min = Math.min.apply(Math,data2s);
            var d2max = Math.max.apply(Math,data2s);

            if(d1min < d2min){
                var minVal = d1min - 20;
            }
            else
            {
                var minVal = d2min - 20;
            }

            if(d1max > d2max){
                var maxVal = d1max + 20;
            }
            else
            {
                var maxVal = d2max + 20;
            }

            var config = {
                type: 'line',
                data: {
                    labels: ['Assurances', 'Compliance', 'Quality', 'Understanding', 'Intention', 'Reaction', 'Environment'],
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
                      
                      if(d1Len == 7){
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
                      
                   }
                }]
            };

            var ctx = document.getElementById('chartjs-1').getContext('2d');
            window.myLine = new Chart(ctx, config);

            var imgData;
            html2canvas(document.getElementById("chartjs-1"), {
                onrendered: function (canvas) {
                    imgData = canvas.toDataURL('', 2.0);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/updatecell',
                        async: false,
                        data: {id: id, type: 'Line', imgData: imgData, inputData1: data1, inputData2: data2},
                        success: function(result){

                        }
                    });
                    
                    
                },
            });

        }

        function textBold(id, boldText){
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                async: false,
                data: {id: id, boldText: boldText, saveType: 'text bold'},
                success: function(result){
                }
            });
        }

        function addDoughnut(id, dVal, dTot, dColor, dTitle){

             if (dVal == "N/A" || dVal == "N.A." || dVal == "Not applicable"){
                var dispVal = "N/A";
                var value = 0;
            }
            else
            {
                var dispVal = dVal;
                var value = dVal;
            }

            var data = {
              labels: [
                "My val",
                ""
              ],
              datasets: [
                {
                  data: [value, dTot-value],
                  backgroundColor: [
                    dColor,
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

            var myChart = new Chart(document.getElementById('chartjs-2'), {
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

            setTimeout(function(){ 
                
                html2canvas(document.getElementById("chartjs-2"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: 'Doughnut', imgData: imgData, dVal: dVal, dTot: dTot, dTitle: dTitle, dColor: dColor},
                            success: function(result){
                                // location.reload();
                            }
                        });
                    },
                });

            }, 100);

        }
        
        function addHorGraph(id, title, cols, vals){
            var len = cols.length;
            var arr = [];
            var num = 0;

            for(num=0; num<len;num++){
                cols[num] = " " + cols[num] + " " + vals[num];
            }

            var ctx = document.getElementById("chartjs-1");
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
                        data: vals,
                        backgroundColor: [
                            'rgba(84, 84, 84, 1)',
                            'rgba(28, 164, 255, 1)'
                        ]
                    }]
                }
            });

            html2canvas(document.getElementById("chartjs-1"), {
                onrendered: function (canvas) {
                    imgData = canvas.toDataURL('', 2.0);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/updatecell',
                        async: false,
                        data: {id: id, type: 'Horizontal Graph', imgData: imgData, inputColumn: vals[0], inputValue: vals[1], inputGraphTitle: title},
                        success: function(result){
                            // location.reload();
                        }
                    });

                    
                },
            });
        }

        function addTable(id, inputTableHeader, inputTableBody){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                    url: '/reports/updatecell',
                    async: false,
                    data: {id: id, type: "Table", inputTableHeader: inputTableHeader, inputTableBody: inputTableBody},
                    success: function(result){
                        // location.reload();
                    }
                })
        }

        function addWellAns(id, inputAnswer){
            $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                url: '/reports/updatecell',
                data: {id: id, type: 'Well with Answer', inputAnswer: inputAnswer},
                success: function(result){
                    // location.reload();
                }
            });
        }

        function addProgress(reportId, progressBar){
            $.ajax({
                type: 'GET',
                url: '/reports/addrow',
                data: {id: reportId, progressBar: progressBar, saveType: 'Progress Bar'},
                success: function(result){
                    console.log(result);
                }
            });
        }

        function addDevice(id, valsRaw){
            var vals = valsRaw.split(/\n/);
            var cols = ["a", "a", "a", "a", "a", "a", "a", "a"];

            var ctx = document.getElementById("chartjs-1").getContext('2d');
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

            var inputDevValue1 = valsRaw;

            html2canvas(document.getElementById("chartjs-1"), {
                onrendered: function (canvas) {
                    imgData = canvas.toDataURL('', 2.0);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/reports/updatecell',
                        data: {id: id, type: 'Device Graph 1', imgData: imgData, inputDevValue1: inputDevValue1},
                        success: function(result){
                            // location.reload();
                        }
                    });

                    
                },
            });
        }



        // =============== manual adding ===============

        $('#boldContent').hide();
        $('#progressBar').hide();
        $('#colWell').hide();
        $('#cellDevGraph1').hide();
        $('#cellDevGraph2').hide();
        $('#cellGraph2').hide();

        function showRowGuide() {
            var colCount = $('input[name=colCount]:checked').val();

            $('[id^="rowSample"]').each(function(){
                $(this).hide();
            });
            $('#rowSample' + colCount).show();
        }

        function cellTypeSelect(type) {
            if(type == "Text") {
                $('#cellText').show();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Bullet") {
                $('#cellText').hide();
                $('#cellBullet').show();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Table") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').show();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Numbering") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').show();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Graph") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').show();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Doughnut") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').show();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Definition") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').show();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Line") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').show();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Horizontal Graph") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').show();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Well with Answer") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').show();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Device Graph 1") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').show();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').hide();
            }
            else if(type == "Device Graph 2") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').hide();
                $('#cellDevGraph2').show();
            }
            else if(type == "Graph Dual") {
                $('#cellText').hide();
                $('#cellBullet').hide();
                $('#cellTable').hide();
                $('#cellNumber').hide();
                $('#cellGraph').hide();
                $('#cellDou').hide();
                $('#cellDefinition').hide();
                $('#cellLine').hide();
                $('#cellHorGraph').hide();
                $('#cellAnswer').hide();
                $('#cellDevGraph1').hide();
                $('#cellGraph2').show();
                $('#cellDevGraph2').hide();
            }
        }

        

        $('input[type="radio"]').click(function(){
            showRowGuide();
        });


        $('#headerContent').show();
        $('#rowCount').hide();
        var type = $('#cellType').val();
        cellTypeSelect(type);

        $('[id^="rowSample"]').each(function(){
            $(this).hide();
        });

        $('#rowType').on('change', function(){
            var type = this.value;
            if(type=="Header") {
                $('#headerContent').show();
                $('#rowCount').hide();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
            }
            else if(type=="Progress Bar") {
                $('#headerContent').hide();
                $('#rowCount').hide();
                $('#boldContent').hide();
                $('#progressBar').show();
                $('#colWell').hide();
            }
            else if(type=="Text Bold") {
                $('#boldContent').show();
                $('#headerContent').hide();
                $('#rowCount').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
            }
            else if(type=="Content" || type=="Well") {
                $('#headerContent').hide();
                $('#rowCount').show();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
                showRowGuide();
            }
            else if(type=="Content with Text") {
                $('#headerContent').show();
                $('#rowCount').show();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
                showRowGuide();
            }
            else if(type=="Well (Header and Content)") {
                $('#headerContent').show();
                $('#rowCount').show();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
                showRowGuide();
            }
            else if(type=="Spacer") {
                $('#headerContent').hide();
                $('#rowCount').hide();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
            }
            else if(type=="Page Break") {
                $('#headerContent').hide();
                $('#rowCount').hide();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
            }
            else if(type=="Colored Well") {
                $('#headerContent').hide();
                $('#rowCount').hide();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').show();
            }
            else if(type=="Doughnut Header") {
                $('#headerContent').hide();
                $('#rowCount').hide();
                $('#boldContent').hide();
                $('#progressBar').hide();
                $('#colWell').hide();
            }

        });

        $('#saveRow').click(function(){
            var reportId = $('#reportId').val();
            var type = $('#rowType').val();
            if(type=="Header") {
                var headerText = $('#headerText').val();
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, headerText: headerText, saveType: 'header'},
                    success: function(result){
                    }
                });
            }
            else if(type=="Text Bold") {
                var boldText = $('#boldText').val();
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, boldText: boldText, saveType: 'text bold'},
                    success: function(result){
                    }
                });
            }
            else if(type=="Colored Well") {
                var titleText = $('#titleText').val();
                var inputColContent = $('#inputColContent').val();
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, titleText: titleText, inputColContent: inputColContent, saveType: 'Colored Well'},
                    success: function(result){
                    }
                });
            }
            else if(type=="Progress Bar") {
                var progressBar = $('#inputProgress').val();
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, progressBar: progressBar, saveType: 'Progress Bar'},
                    success: function(result){
                    }
                });
            }
            else if(type=="Content"){
                var colCount = $('input[name=colCount]:checked').val();
                $.ajax({

                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, colCount: colCount, saveType: 'content'},
                    success: function(result){

                    }
                });
            }
            else if(type=="Content with Text"){
                var colCount = $('input[name=colCount]:checked').val();
                var headerText = $('#headerText').val();
                $.ajax({

                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, colCount: colCount, headerText:headerText, saveType: 'Content with Text'},
                    success: function(result){

                    }
                });
            }
            else if(type=="Well"){
                var headerText = $('#headerText').val();
                var colCount = $('input[name=colCount]:checked').val();
                $.ajax({

                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, colCount: colCount, saveType: 'well'},
                    success: function(result){

                    }
                });
            }
            else if(type=="Well (Header and Content)") {
                var headerText = $('#headerText').val();
                var colCount = $('input[name=colCount]:checked').val();
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, headerText: headerText, colCount: colCount, saveType: 'Well (Header and Content)'},
                    success: function(result){

                    }
                });
            }
            else if(type=="Spacer") {
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, saveType: 'Spacer'},
                    success: function(result){
                        
                    }
                });
            }
            else if(type=="Page Break") {
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, saveType: 'Page Break'},
                    success: function(result){

                    }
                });
            }
            else if(type=="Doughnut Header") {
                $.ajax({
                    type: 'GET',
                    url: '/reports/addrow',
                    data: {id: reportId, saveType: 'Doughnut Header'},
                    success: function(result){

                    }
                });
            }

            // location.reload();
            
        });

        $('#cellType').on('change', function(){
            var type = this.value;
            cellTypeSelect(type);
        });

        $('#updateCell').click(function(){
            var id = $('#cellId').val();
            var type = $('#cellType').val();
            
            if(type == "Text") {
                var inputText = $('#inputText').val();
                $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                    url: '/reports/updatecell',
                    data: {id: id, type: type, inputText: inputText},
                    success: function(result){
                        // location.reload();
                    }
                });
            }
            else if(type == "Well with Answer") {
                var inputAnswer = $('#inputAnswer').val();
                $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                    url: '/reports/updatecell',
                    data: {id: id, type: type, inputAnswer: inputAnswer},
                    success: function(result){
                        // location.reload();
                    }
                });
            }
            else if(type == "Bullet") {
                var inputText = $('#inputBullet').val();
                $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                    url: '/reports/updatecell',
                    data: {id: id, type: type, inputText: inputText},
                    success: function(result){
                        // location.reload();
                    }
                });
            }
            else if(type == "Definition") {
                var inputWord = $('#inputWord').val();
                var inputDef = $('#inputDef').val();
                $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                    url: '/reports/updatecell',
                    data: {id: id, type: type, inputWord: inputWord, inputDef: inputDef},
                    success: function(result){
                        // location.reload();
                    }
                });
            }
            else if(type == "Table") {
                var inputTableHeader = $('#inputTableHeader').val();
                var inputTableBody = $('#inputTableBody').val();
                $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                    url: '/reports/updatecell',
                    data: {id: id, type: type, inputTableHeader: inputTableHeader, inputTableBody: inputTableBody},
                    success: function(result){
                        // location.reload();
                    }
                });
            }
            else if(type == "Numbering") {
                var inputText = $('#inputNumber').val();
                $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                    url: '/reports/updatecell',
                    data: {id: id, type: type, inputText: inputText},
                    success: function(result){
                        // location.reload();
                    }
                });
            }

            else if(type == "Graph") {
                var inputColumn = $('#inputColumn').val();
                var inputValue = $('#inputValue').val();
                var inputGraphTitle = $('#inputGraphTitle').val();
                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, inputColumn: inputColumn, inputValue: inputValue, inputGraphTitle: inputGraphTitle},
                            success: function(result){
                                // location.reload();
                            }
                        });

                        
                    },
                });


            }

            else if(type == "Graph Dual") {
                var inputColumn = $('#inputColumn2').val();
                var inputValue = $('#inputValue2').val();
                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, inputColumn: inputColumn, inputValue: inputValue},
                            success: function(result){
                                // location.reload();
                            }
                        });

                        
                    },
                });
            }

            else if(type == "Device Graph 1") {
                var inputDevValue1 = $('#inputDevValue1').val();
                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, inputDevValue1: inputDevValue1},
                            success: function(result){
                                // location.reload();
                            }
                        });

                        
                    },
                });
            }

            else if(type == "Device Graph 2") {
                var inputDevValue2 = $('#inputDevValue2').val();
                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, inputDevValue2: inputDevValue2},
                            success: function(result){
                                // location.reload();
                            }
                        });

                        
                    },
                });
            }

            else if(type == "Horizontal Graph") {
                var inputColumn = $('#inputHorColumn').val();
                var inputValue = $('#inputHorValue').val();
                var inputGraphTitle = $('#inputGraphAns').val();
                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, inputColumn: inputColumn, inputValue: inputValue, inputGraphTitle: inputGraphTitle},
                            success: function(result){
                                // location.reload();
                            }
                        });

                        
                    },
                });
            }

            else if(type == "Doughnut") {
                var dVal = $('#inputDou').val();
                var dTot = $('#inputTot').val();
                var dTitle = $('#inputDouTitle').val();
                var dColor = $('#inputDouColor').val();


                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, dVal: dVal, dTot: dTot, dTitle: dTitle, dColor: dColor},
                            success: function(result){
                                // location.reload();
                            }
                        });
                    },
                });
            }
            else if(type == "Line") {
                var inputData1 = $('#inputData1').val();
                var inputData2 = $('#inputData2').val();
                var imgData;
                html2canvas(document.getElementById("chartjs-1"), {
                    onrendered: function (canvas) {
                        imgData = canvas.toDataURL('', 2.0);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: '/reports/updatecell',
                            data: {id: id, type: type, imgData: imgData, inputData1: inputData1, inputData2: inputData2},
                            success: function(result){
                                // location.reload();
                            }
                        });

                        
                    },
                });
            }

            
            
        });


        $('#inputColumn, #inputValue').on('keyup', function(){
            var cols = $('#inputColumn').val().split(/\n/);
            var vals = $('#inputValue').val().split(/\n/);
            var len = cols.length;
            var arr = [];
            var num = 0;


            var ctx = document.getElementById("chartjs-1").getContext('2d');
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
                            'rgba(150, 85, 0, 1)',
                            'rgba(25, 25, 25, 1)',
                            'rgba(0, 66, 99, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 5
                    }]
                },
                options: {

                    animation: {
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
                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y + 70);
                          }),this)
                        }),this);
                      }
                    },

                    legend: {
                        display: false
                     },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                fontSize: 40
                            }
                        }],
                        xAxes: [{
                            barThickness : 120,
                            ticks: {
                                fontSize: 35
                            }
                        }]
                    }
                }
            });
        });


        $('#inputColumn2, #inputValue2').on('keyup', function(){
            var cols = $('#inputColumn2').val().split(/\n/);
            var vals = $('#inputValue2').val().split(/\n/);
            var num1 = vals[0];
            var num2 = vals[1];
            var num3 = vals[2];
            var num4 = vals[3];
            var num5 = vals[4];
            var num6 = vals[5];
            var num7 = vals[6];
            var num8 = vals[7];

            var ctx = document.getElementById("chartjs-1").getContext("2d");

            var data = {
              labels: cols,
              datasets: [{
                label: "Blue",
                backgroundColor: "#4e5155",
                data: [num1, num3, num5, num7]
              }, {
                label: "Red",
                backgroundColor: "#0091da",
                data: [num2, num4, num6, num8]
              }]
            };

            var myBarChart = new Chart(ctx, {
              type: 'bar',
              data: data,
              options: {


                animation: {
                      onComplete: function () {
                        var chartInstance = this.chart;
                        var ctx = chartInstance.ctx;
                        var height = chartInstance.controller.boxes[0].bottom;
                        ctx.textAlign = "center";
                        ctx.fontSize = 40;
                        ctx.fillStyle = "#000000";
                        Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                          var meta = chartInstance.controller.getDatasetMeta(i);
                          Chart.helpers.each(meta.data.forEach(function (bar, index) {
                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 15);
                          }),this)
                        }),this);
                      }
                    },

                legend: {
                        display: false
                     },



                scales: {
                  yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        min: 0,
                        max: 100,
                        stepSize: 25,
                        fontSize: 25
                    }
                  }],

                  xAxes: [{
                    display: false,
                    ticks: {
                        fontSize: 35
                    }
                  }]
                }
              }
            });

            
        });


        $('#inputDevValue1').on('keyup', function(){
            var vals = $('#inputDevValue1').val().split(/\n/);
            var cols = ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"];

            var ctx = document.getElementById("chartjs-1").getContext('2d');
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
                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 15);
                          }),this)
                        }),this);
                      }
                    },

                    legend: {
                        display: false
                     },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                min: 0,
                                max: 100,
                                stepSize: 25,
                                fontSize: 35
                            }
                        }],
                        xAxes: [{
                            display: false,
                            barThickness : 70,
                            ticks: {
                                fontSize: 20
                            }
                        }]
                    }
                }
            });
        });


        $('#inputDevValue2').on('keyup', function(){
            var vals = $('#inputDevValue2').val().split(/\n/);
            var cols = ["a", "a", "a", "a", "a", "a"];

            var ctx = document.getElementById("chartjs-1").getContext('2d');
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
                            ctx.fillText(dataset.data[index], bar._model.x, bar._model.y - 15);
                          }),this)
                        }),this);
                      }
                    },

                    legend: {
                        display: false
                     },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                min: 0,
                                max: 100,
                                stepSize: 25,
                                fontSize: 35
                            }
                        }],
                        xAxes: [{
                            display: false,
                            barThickness : 100,
                            ticks: {
                                fontSize: 20
                            }
                        }]
                    }
                }
            });
        });


        $('#inputHorColumn, #inputHorValue').on('keyup', function(){
            var cols = $('#inputHorColumn').val().split(/\n/);
            var vals = $('#inputHorValue').val().split(/\n/);
            var len = cols.length;
            var arr = [];
            var num = 0;

            for(num=0; num<len;num++){
                cols[num] = " " + cols[num] + " " + vals[num];
            }



            var ctx = document.getElementById("chartjs-1");
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
                        data: vals,
                        backgroundColor: [
                            'rgba(84, 84, 84, 1)',
                            'rgba(28, 164, 255, 1)'
                        ]
                    }]
                }
            });
            
        });


        $('#inputTot').on('keyup', function(){
            var dVal = $('#inputDou').val();
            var dTot = $('#inputTot').val();
            var dColor = $('#inputDouColor').val();


            if (dVal == "N/A" || dVal == "N.A."){
                var dispVal = "N/A";
                var value = 0;
            }
            else
            {
                var dispVal = dVal;
                var value = dVal;
            }

            var data = {
              labels: [
                "My val",
                ""
              ],
              datasets: [
                {
                  data: [value, dTot-value],
                  backgroundColor: [
                    dColor,
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

            var myChart = new Chart(document.getElementById('chartjs-1'), {
              type: 'doughnut',
              data: data,
              options: {
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

            textCenter(value);

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

        });


        $('#inputData1, #inputData2').on('keyup', function(){
            var data1s = $('#inputData1').val().split(/\n/);
            var data2s = $('#inputData2').val().split(/\n/);

            var d1min = Math.min.apply(Math,data1s);
            var d1max = Math.max.apply(Math,data1s);
            var d2min = Math.min.apply(Math,data2s);
            var d2max = Math.max.apply(Math,data2s);

            if(d1min < d2min){
                var minVal = d1min - 20;
            }
            else
            {
                var minVal = d2min - 20;
            }

            if(d1max > d2max){
                var maxVal = d1max + 20;
            }
            else
            {
                var maxVal = d2max + 20;
            }

            var config = {
                type: 'line',
                data: {
                    labels: ['Assurances', 'Compliance', 'Quality', 'Understanding', 'Intention', 'Reaction', 'Environment'],
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
                      
                      if(d1Len == 7){
                        var disp = [];
                        var cNum1 = 0;
                        var cNum2 = 0;
                        var cSum = 0;
                        initLine[0].data.forEach(function(value, index) {
                            cNum1 = parseInt(value);
                            cNum2 = parseInt(initLine[1].data[index]);
                            cSum = cNum1 - cNum2;
                            if(cSum < 0){
                                cSum = cSum * -1;
                            }

                            if(cSum < 11){
                                disp.push("adj");
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

                                if(setCount == 1){
                                    if(disp[index] == "adj"){
                                        fontColor = '#eb8501';
                                        yCoor = yCoor - 50;
                                    }
                                }
                                else if(setCount == 2){
                                    if(disp[index] == "adj"){
                                        fontColor = '#545454';
                                        yCoor = yCoor + 50;
                                    }
                                }

                                ctx.fillStyle = fontColor;
                                ctx.fillText(value, x, yCoor);
                                ctx.restore();
                             });
                          });

                      }
                      
                   }
                }]
            };

            var ctx = document.getElementById('chartjs-1').getContext('2d');
            window.myLine = new Chart(ctx, config);


        });

    });

  </script>

@endsection
