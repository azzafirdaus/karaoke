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
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title" style="font-size:28px;">
                        Laporan Kasir
                        </h3>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                        <button onClick ="$('#table').tableExport({type:'excel',escape:'false'});" class="btn btn-success pull-left">
                            <span class="glyphicon glyphicon-download-alt"></span> Export
                        </button>
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <br> 
                <!-- BEGIN CRUD TABLE -->
                <div class="portlet-body">

                    <div class="table-responsive">
                    <table id="table" class="table table-hover customFontSize">

                    <thead>
                    <tr>
                        <th style="font-size:16px;">
                             No.
                        </th>
                        <th style="font-size:16px;">
                             Nama Kasir
                        </th>
			 <th style="font-size:16px;">
                             Jumlah Registrasi
                        </th>

                        <th style="font-size:16px;">
                             Jumlah
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <p class="hidden">{{ $count = 1 }}</p>
                    <p class="hidden">{{ $jumlah = 0 }}</p>
                    @foreach($data as $datanya)
                    <tr>
                        <td>
                            {{ $count++ }}
                        </td>
                        <td>
                            {{ $datanya->nama_kasir }}
                        </td>
			<td>
                            {{ $datanya->total_berapa }}
                        </td>
                        <td>
                            Rp. {{ number_format($datanya->total_kasir) }}
                        </td>
                    <p class="hidden">{{ $jumlah += $datanya->total_kasir }}</p>
                    </tr> 
                    @endforeach
       
                    </tbody>
                    </table>
                    </div>
                    
                </div>
                <!-- END CRUD TABLE -->
            </div>
        </div>
</div>
    <!-- END CONTENT -->
@stop



