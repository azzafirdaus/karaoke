<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Pendapatan Terapis</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <meta name="MobileOptimized" content="320">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrapCustom.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet">
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ asset('assets/plugins/select2/select2_conquer.css') }}" rel="stylesheet">
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="{{ asset('assets/css/style-conquer.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/styleCustom.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style-responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/themes/default.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/pages/loginWide.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>

    </head>
    
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
<!--            <img src="assets/img/logo.png" alt=""/>-->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content" style="height: 300px;">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ url('/') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3 class="form-title hidden-print" style='font-size: 38px;'>Pendapatan Terapis</h3>

                <br>
                <div class="col-md-6 col-md-offset-3" id="tagihan">
                    <div>
                        <span>No. Terapis : </span> <span style="font-size:30px"> {{ $noTerapis }}</span>
                    </div>
                    <br>
                    <div>
                        <table class="table table-hover" style="width:250px">
                            <thead>
                                <tr>
                                    <th>
                                         Bon
                                    </th>
                                    <th>
                                         Pendapatan
                                    </th>
                                    <th>
                                         Jumlah
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $isi)
                                <tr>
                                    <td style="font-size:30px">
                                         {{ $isi['qty'] }}
                                    </td>
                                    <td>
                                         {{ $isi['isi'] }}
                                    </td>
                                    <td>
                                         {{ $isi['jumlah'] }}
                                    </td>
                                </tr>
                                @endforeach 
                                        
                                <tr>
                                    <td>
                                        <strong class="customFontSize" style="font-size:30px">Total</strong>
                                    </td>
                                    <td>
                                         <strong class="customFontSize" style="font-size:30px">{{ $total }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
				    </div>
                </div>
            </form>
            
            <!-- <form class="login-form" action="{{ url('printPendapatan') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-actions hidden-print">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success" onclick="window.print();">
                            <span class="glyphicon glyphicon-check"></span> Print Invoice
                        </button>
                    </div>
                </div>
            </form> -->
            <!-- END LOGIN FORM -->
        </div>
        <!-- END LOGIN -->
    </body>

    <script>
        window.onload = function() {
            setTimeout(function(){ window.print(); }, 1000);
            setTimeout(function(){ location.href = "{{ url('printPendapatan') }} "; }, 3000);
        };
    </script>
<!-- END BODY -->
</html>