<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Menu Bar Lantai 2</title>
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
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ url('barMenuAdd') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3 class="form-title" style='font-size: 38px;'>Menu Bar Lantai 2</h3>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li style='font-size: 16px; color: red'>{{ $error }}</li>
                    @endforeach
                </ul>

                <?='<span style="font-size: 16px; color: red">'.Session::get('loginError').'</span>'?>

                <br>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-beer fa-fw" style="font-size: 2em"></i>
                        </span>
                        <input class="form-control placeholder-no-fix" type="text" style='font-size: 24px;' autocomplete="off" placeholder="ID Makanan/Minuman" name="id"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-dashboard fa-fw" style="font-size: 2em"></i>
                        </span>
                       <input class="form-control placeholder-no-fix" type="number" style='font-size: 24px;' autocomplete="off" placeholder="Jumlah Item" name="jumlahItem"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <input class="hidden" name="noKartu" value="{{ $noKartu }}">
                        @foreach($transaksiBar1 as $value1)
                            <input type="hidden" name="result1[]" value="{{ $value1 }}">
                        @endforeach
                        @foreach($transaksiBar2 as $value2)
                            <input type="hidden" name="result2[]" value="{{ $value2 }}">
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success pull-right">
                        <span class="glyphicon glyphicon-plus"></span> Add
                    </button>
                </div>
                
            </form>
            <!-- END LOGIN FORM -->
            <div class="well" style="font-size:24px">
                <div class="table-responsive">
                    <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                             #
                        </th>
                        <th>
                             Makanan/Minuman
                        </th>
                        <th>
                             Jumlah
                        </th>
                        <th>
                             &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        
                                <p class="hidden">{{ $count = 1 }}</p>
                                @foreach($transaksiBar1 as $index => $isi)
                                <tr>
                                    <td>
                                         {{ $count++ }}
                                    </td>
                                    <td>
                                         {{ $isi }}
                                    </td>
                                    <td>
                                         {{ $transaksiBar2[$index] }}
                                    </td>
                                    <td>
                                        
                                        <form method="post">
                                            
                                        @foreach($transaksiBar1 as $value1)
                                            <input type="hidden" name="result1[]" value="{{ $value1 }}">
                                        @endforeach
                                        @foreach($transaksiBar2 as $value2)
                                            <input type="hidden" name="result2[]" value="{{ $value2 }}">
                                        @endforeach
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="hidden" name="noKartu" value="{{ $noKartu }}">
                                            <input class="hidden" type="" autocomplete="off" placeholder="" name="idArray" value="{{ $count }}"/>
                                            <button type="submit" formaction="{{ url('barItemDelete') }}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>    
                                @endforeach     
                    </tbody>
                    </table>
                </div>
            </div>
            
            <br>
            <form method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="hidden" name="noKartu" value="{{ $noKartu }}">
                                        @foreach($transaksiBar1 as $value1)
                                            <input type="hidden" name="result1[]" value="{{ $value1 }}">
                                        @endforeach
                                        @foreach($transaksiBar2 as $value2)
                                            <input type="hidden" name="result2[]" value="{{ $value2 }}">
                                        @endforeach
                <div class="form-actions hidden-print">
                        <div class="pull-left">
                            <button type="button" onclick="location.href = '{{ url('barPreMenu') }}';" class="btn btn-primary">
                                <span class="glyphicon glyphicon-chevron-left"></span> Back
                            </button>
                        </div>
                        <div class="pull-right">
                            <button type="submit" formaction="{{ url('barInvoice') }}" class="btn btn-success">
                                <span class="glyphicon glyphicon-check"></span> View Invoice
                            </button>
                        </div>
                    </div>
              </form>  
        </div>
        <!-- END LOGIN -->
    </body>
<!-- END BODY -->
</html>