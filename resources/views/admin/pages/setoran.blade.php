@extends('admin.layout.sidebar')

@section('sidebar')
    @parent
@stop

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <div class="row hidden-print">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title hidden-print" style="font-size:28px;">
                        Setoran
                        </h3>
                        <button onClick ="$('#table').tableExport({type:'excel',escape:'false'});" class="btn btn-success pull-left hidden-print">
                            <span class="glyphicon glyphicon-download-alt"></span> Export
                        </button> 
                        <button onclick="window.print();" class="btn btn-success pull-left hidden-print" style="margin-left:5px;">
                            <span class="glyphicon glyphicon-check"></span> Print
                        </button> 
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                
                <!-- END PAGE HEADER-->

                <!-- BEGIN CRUD TABLE -->
                <h3 class="page-title visible-print" style="font-size:20px;">
                    Total Setoran
                </h3>
                <div class="portlet-body">
                    <div class="table">
                    <table id="table" class="table table-hover customFontSize">

                        <thead>
                        <tr>
                            <th class="customFontSize">
                                 Pendapatan
                            </th>
                            <th class="customFontSize">
                                 Total
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                 Kartu
                            </td>
                            <td>
                                 Rp. {{ number_format($totalKartu) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Penjualan Kartu
                            </td>
                            <td>
                                 Rp. {{ number_format($totalRegistrasi) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Refund 1
                            </td>
                            <td>
                                 Rp. {{ number_format($totalTerapis) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Refund 2
                            </td>
                            <td>
                                 Rp. {{ number_format($totalKosong) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Tanggal Transaksi : {{ $lastDate }}<br>
                                Total Setoran : Rp. {{ number_format($totalKartu + $totalRegistrasi - $totalTerapis - $totalKosong) }}
                            </td>
                        </tr>
                        </tbody>

                    </table>
                    <br>  
                    
                </div>
                <!-- END CRUD TABLE -->
            </div>
        </div>
</div>
    <!-- END CONTENT -->
@stop



