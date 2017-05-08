<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Register Customer</title>
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
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/pages/terapis.css') }}" rel="stylesheet">
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    
    <style type="text/css">
        .terapis .home-button button{
            width: 150px;
            padding: 15px 0px;
            margin: 10px;
            font-size: 30px;
        }
    </style>
    <!-- BEGIN BODY -->
    <body class="terapis">

        <div class="home-button">
            <form class="terapis-form" method="post" action="{{ url('cashierMenu') }}" > 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <br>    
                <p class="hidden-print" style='font-size: 50px; color: white'>No Kartu</p>
                <p class="hidden-print" style='font-size: 50px; color: white'>Berhasil di Register</p>
                <ul><?='<span style="font-size: 16px; color: red">'.Session::get('successMsg').'</span>'?></ul>

                <div class="col-md-6 col-md-offset-4" id="tagihan">
                    <br>
                    <div>
                        <table class="table" style="width:250px; color: black; text-align: left">
                            <tbody>
                                <tr>
                                    <td>
                                        No. Kartu
                                    </td>
                                    <td>
                                        : {{ $noKartu }}
                                    </td>
                                </tr>
                                <tr>    
                                    <td>
                                        Isi Saldo 
                                    </td>
                                    <td>
                                        : Rp. {{ number_format($saldo) }}
                                    </td>
                                </tr>   
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
                <div class="hidden-print col-md-4 col-md-offset-4">
                    <button type="button" class="btn btn-primary" onclick="location.href = '{{ url('auth/register') }}';">
                        <i class="glyphicon glyphicon-chevron-left"></i> Back
                    </button>
                    <button style="padding: 5px;" type="submit" formaction="{{ url('registerPrint') }}" class="btn btn-success pull-right" onclick="window.print();">Print</button>
                </div>
            </form>
        </div>
    </body>
</html>