<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Stock Menu</title>
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
    
    <!-- BEGIN BODY -->
    <body class="terapis">

        <div class="home-button">
            <form class="terapis-form" method="post" action="{{ url('cashier_stock_print') }}" > 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <br>    
                <p class="hidden-print" style='font-size: 50px; color: white'>Stok</p>
                <p class="hidden-print" style='font-size: 50px; color: white'>Berhasil di update</p>
                <ul><?='<span style="font-size: 16px; color: red">'.Session::get('successMsg').'</span>'?></ul>

                <div class="col-md-6 col-md-offset-4" id="tagihan">
                    <br>
                    <div>
                        <table class="table" style="width:400px; color: black; text-align: left; font-size: 25px;">
                            <tbody>
                                <tr>
                                    <td>
                                        ID Item
                                    </td>
                                    <td>
                                        : {{ $id }}
                                    </td>
                                </tr>
                                <tr>    
                                    <td>
                                        Nama Item 
                                    </td>
                                    <td>
                                        : {{ $nama }}
                                    </td>
                                </tr>   
                                <tr>    
                                    <td>
                                        Jumlah
                                    </td>
                                    <td>
                                        : {{ $jumlah }}
                                    </td>
                                </tr>   
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
                <div class="hidden-print col-md-6 col-md-offset-2">
                    <button style="padding: 10px;" type="submit" class="btn btn-success pull-right" onclick="window.print();">Print</button>
                </div>
            </form>
        </div>
    </body>
</html>