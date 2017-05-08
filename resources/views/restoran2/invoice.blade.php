<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Restoran 2 Invoice</title>
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
            <form class="terapis-form hidden-print"> 

                <br>    
                <p style='font-size: 50px; color: white'>Pembayaran</p>
                <p style='font-size: 50px; color: white'>Berhasil Dilakukan</p>
                <ul><?='<span style="font-size: 16px; color: red">'.Session::get('successMsg').'</span>'?></ul>

            </form>

            <div class="col-md-6 col-md-offset-3" id="tagihan">
                <br>
                <div>
                    <table class="table" style="width:250px; color: white; text-align: left">
                        <tbody>
                            <tr>
                                <td>
                                    No. Kartu 
                                </td>
                                <td>
                                    : {{ $noGelang }}
                                </td>
                            </tr>
                            <tr>    
                                <td>
                                    Tanggal 
                                </td>
                                <td>
                                    : {{ $date }}
                                </td>
                            </tr>   
                            @foreach($transaksiBar as $datanya)
                            <tr>    
                                <td>
                                    Nama
                                </td>
                                <td>
                                    : {{ $datanya['nama'] }} @ <b style="font-size: 40px;">{{ $datanya['qty'] }}</b>
                                </td>
                            </tr>   
                            @endforeach     
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>

    <script>
        window.onload = function() {
            setTimeout(function(){ window.print(); }, 2000);
            setTimeout(function(){ location.href = "{{ url('restoran2') }} "; }, 2000);
        };
    </script>

        <!-- END LOGIN -->
    </body>
<!-- END BODY -->
</html>