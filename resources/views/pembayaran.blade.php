<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Top Up Saldo</title>
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
        <!-- BEGIN EXTERNAL SCRIPTS -->
        <script src="{{ asset('assets/scripts/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- END EXTERNAL SCRIPTS -->

    </head>
    
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
<!--            <img src="assets/img/logo.png" alt=""/>-->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ url('pembayaran') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3 class="form-title hidden-print" style='font-size: 38px;'>Top Up Saldo</h3>
                <ul>
			         @foreach ($errors->all() as $error)
				    <li style='font-size: 16px; color: red'>{{ $error }}</li>
			         @endforeach
                </ul>
                <?='<span style="font-size: 16px; color: red">'.Session::get('loginError').'</span>'?>

                <div class="form-group hidden-print">
<!--
                        <label style='font-size: 24px'>Jumlah Top Up</label>
                        <select style='font-size: 24px' name="jmlTopUp" class="form-control">
                        
                            <option>50000</option>
                            <option>100000</option>
                            <option>150000</option>
                            <option>200000</option>
                            <option>250000</option>
                            <option>300000</option>
                            <option>350000</option>
                            <option>400000</option>
                            <option>450000</option>
                            <option>500000</option>
                        
                    </select>
-->

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-money fa-fw" style="font-size: 2em"></i>
                        </span>
                        <input class="form-control placeholder-no-fix" type="text" style='font-size: 24px;' autocomplete="off" placeholder="Jumlah Top Up" name="jmlTopUp" id="topup"/>
                    </div>
                </div>
            
                <div class="form-group hidden-print">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-barcode fa-fw" style="font-size: 2em"></i>
                        </span>
                        <input class="form-control placeholder-no-fix" type="text" style='font-size: 24px;' autocomplete="off" placeholder="No. Kartu" name="noGelang"/>
                    </div>
                </div>

                <div class="form-actions hidden-print">
                    <button type="submit" class="btn btn-info"> 
                        <span class="glyphicon glyphicon-credit-card"></span> Lihat Kartu
                    </button>
                </div>
                <br>

                <div class="form-actions hidden-print">
                    <button type="button" onclick="location.href = '{{ url('cashierMenu') }}';" class="btn btn-primary">
                        <span class="glyphicon glyphicon-chevron-left"></span> Back To Cashier
                    </button>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
        <!-- END LOGIN -->
    </body>
<!-- END BODY -->
</html>
<script type="text/javascript">
    var input = document.getElementById("topup");
    input.addEventListener('keyup', function(evt){
        var n = parseInt(this.value.replace(/\D/g,''),10);
        if (isNaN(n) == false){
            input.value = n.toLocaleString();
        } else {
            input.value = '';
        }
    }, false);
</script>