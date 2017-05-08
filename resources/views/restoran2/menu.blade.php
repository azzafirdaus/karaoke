<!DOCTYPE html>

<html lang="en">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Menu Restoran 2</title>
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
        <link href="{{ asset('assets/css/pages/terapis.css') }}" rel="stylesheet">

        <!-- END THEME STYLES -->
    
        <style type="text/css">
            .infototal{
                width:450px;
                height:70px;
                background:white;
                border-color: black;
                border-width: 2px;
                margin: 0px auto;
                padding: 3px;
            }
            .infototal table{
                margin: 10px;
            }
            .infototal table td{
                font-size: 25px;        
            }

            #dialogoverlay{
                display: none;
                opacity: .2;
                position: fixed;
                top: 0px;
                left: 0px;
                background: #FFF;
                width: 100%;
                z-index: 10;
            }
            #dialogbox{
                display: none;
                position: fixed;
                background: white;
                width: 750px;
                border-radius:4px;
                height: 300px;
                z-index: 10;
            }
            #dialogbox > div{ background:white; margin:8px; }
            /*#dialogbox > div > #dialogboxhead{ background: white; font-size:30px; padding:10px; color:black; }*/
            #dialogbox > div > #dialogboxbody{ background: white; font-size:40px; padding:40px 20px; text-align:center; color:black; }
            #dialogbox > div > #dialogboxfoot{ background: white; padding:10px; margin-top: 30px;text-align:center; }

            #alert_button {
                background-color: #008CBA;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                border-radius:2px;
                width: 150px;
                text-decoration: none;
                display: inline-block;
                font-size: 30px;
            }
            .btn-circle.btn-lg {
                width: 50px;
                height: 50px;
                padding: 5px 8px;
                font-size: 9px;
                line-height: 1.33;
                border-radius: 25px;
            }
            input
            {
                background: transparent;
                border: none;
            }

            .terapis .home-button .btn{
                width: 380px;
                padding: 10px 0px;
                margin: 20px;
                font-size: 60px;
                background: white;
            }
	
	    .table tr{
	    	border-top: 5px solid;
		border-bottom: 5px solid;
	    }

        </style>

    </head>
    
    <!-- BEGIN BODY -->
    <body class="login" style="margin-top: 0px">
        <!-- BEGIN LOGIN -->
        <form action="{{ url('restoran2/review') }}" method="post" id="formnya">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="noGelang" value="{{ $noGelang }}">
            <input type="hidden" name="saldo" value="{{ $saldo }}" id="saldo">
            
            @foreach ($errors->all() as $error)
                <li style='font-size: 16px; color: red'>{{ $error }}</li>
            @endforeach

            <div class="menu-atas back col-sm-3" style="margin: 5px; display: none;">           
                <div class="btn btn-primary submit-back" style="padding: 15px;">
                    <span class="glyphicon glyphicon-chevron-left"></span> Back To Menu
                </div>
            </div>

            <div class="infototal">
                <table>
                    <tr>
                        <td>Total: </td>
                        <td>Rp. </td>
                        <td><input style="width: 200px;" type="text" id="totaltampil" value="{{ isset($total)? number_format($total): 0 }}" disabled></td>
                        <td>
                            <button type="button" class="submission btn btn-success pull-right">
                                <i class="fa fa-credit-card"></i> Order 
                            </button>
                        </td>
                        <td><input style="width: 150px;" type="hidden" id="totaldinamis" name="totaldinamis" value="{{ isset($total)? $total: 0 }}" disabled></td>
                    </tr>
                </table>
            </div>
            
            <div class="terapis menu">
                <div class="home-button">                    
                    <div>
                        <div class="makanan-show btn">Makanan</div>
                    </div>

                    <div>
                        <div class="minuman-show btn">Minuman</div>
                    </div>

                    <div>
                        <div class="rokok-show btn">Rokok</div>
                    </div>
                </div>

                <button type="button" onclick="location.href = '{{ url('restoran2') }}';" class="btn btn-primary" style="margin-left: 30px; padding: 20px; font-size: 32px">
                    <span class="glyphicon glyphicon-chevron-left"></span> Keluar
                </button>
                <button type="submit" formaction="{{ url('restoran2/ob') }}" class="btn btn-primary" style="margin-right: 30px; padding: 10px 40px; font-size: 28px; float: right;">
                    OB
                </button>
            </div>

            <div class="makanan" style="display: none;">
                <div class="content" style="width: 450px; @if(isset($makananlist))float: left; margin: 5px 3px 3px 3px; @else margin: 5px auto 3px; @endif" >
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>
                            @foreach($makananlist->forPage(1, 10) as $index => $makanan)
                            <input type="hidden" name="id_item[]" value="{{ $makanan->id_item }}" />
                            <tr>
                                <td>
                                     {{ $makanan->nama }}<br>
                                     Rp. {{ number_format($makanan->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($makanan->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $makanan->id_item }}" type="number" value="{{ isset($jml[$makanan->id_item]) ? $jml[$makanan->id_item] : 0 }}" min="0" max="{{ $makanan->stock }}" name="jumlahbeli[]" harga="{{ $makanan->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($makanan->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
                <div class="content" style="float: left; width: 440px; margin: 5px 3px 3px 10px;">
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>
                            @foreach($makananlist->forPage(2, 10) as $index => $makanan)
                            <input type="hidden" name="id_item[]" value="{{ $makanan->id_item }}" />
                            <tr>
                                <td>
                                     {{ $makanan->nama }}<br>
                                     Rp. {{ number_format($makanan->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($makanan->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $makanan->id_item }}" type="number" value="{{ isset($jml[$makanan->id_item]) ? $jml[$makanan->id_item] : 0 }}" min="0" max="{{ $makanan->stock }}" name="jumlahbeli[]" harga="{{ $makanan->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($makanan->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                    <!-- END CRUD TABLE -->
                </div>
                <div class="content" style="float: left; width: 440px; margin: 5px 0px 3px 10px;">
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>                        
                            @foreach($makananlist->forPage(3, 10) as $index => $makanan)
                            <input type="hidden" name="id_item[]" value="{{ $makanan->id_item }}" />
                            <tr>
                                <td>
                                     {{ $makanan->nama }}<br>
                                     Rp. {{ number_format($makanan->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($makanan->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $makanan->id_item }}" type="number" value="{{ isset($jml[$makanan->id_item]) ? $jml[$makanan->id_item] : 0 }}" min="0" max="{{ $makanan->stock }}" name="jumlahbeli[]" harga="{{ $makanan->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($makanan->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach    
                        </tbody>
                    </table>
                    <!-- END CRUD TABLE -->
                </div>
            </div>

            <div class="minuman" style="display: none;">
                <div class="content" style="width: 450px; @if(isset($minumanlist[11]))float: left; margin: 5px 3px 3px 3px; @else margin: 5px auto 3px; @endif" >
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>
                            @foreach($minumanlist->forPage(1, 10) as $index => $minuman)
                            <input type="hidden" name="id_item[]" value="{{ $minuman->id_item }}" />
                            <tr>
                                <td>
                                     {{ $minuman->nama }}<br>
                                     Rp. {{ number_format($minuman->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($minuman->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $minuman->id_item }}" type="number" value="{{ isset($jml[$minuman->id_item]) ? $jml[$minuman->id_item] : 0 }}" min="0" max="{{ $minuman->stock }}" name="jumlahbeli[]" harga="{{ $minuman->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($minuman->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
		@if(isset($minumanlist[11]))
                <div class="content" style="float: left; width: 440px; margin: 5px 3px 3px 10px;">
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>
                            @foreach($minumanlist->forPage(2, 10) as $index => $minuman)
                            <input type="hidden" name="id_item[]" value="{{ $minuman->id_item }}" />
                            <tr>
                                <td>
                                     {{ $minuman->nama }}<br>
                                     Rp. {{ number_format($minuman->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($minuman->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $minuman->id_item }}" type="number" value="{{ isset($jml[$minuman->id_item]) ? $jml[$minuman->id_item] : 0 }}" min="0" max="{{ $minuman->stock }}" name="jumlahbeli[]" harga="{{ $minuman->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($minuman->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                    <!-- END CRUD TABLE -->
                </div>
		@endif
		@if(isset($minumanlist[21]))
                <div class="content" style="float: left; width: 440px; margin: 5px 0px 3px 10px;">
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>                        
                            @foreach($minumanlist->forPage(3, 10) as $index => $minuman)
                            <input type="hidden" name="id_item[]" value="{{ $minuman->id_item }}" />
                            <tr>
                                <td>
                                     {{ $minuman->nama }}<br>
                                     Rp. {{ number_format($minuman->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($minuman->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $minuman->id_item }}" type="number" value="{{ isset($jml[$minuman->id_item]) ? $jml[$minuman->id_item] : 0 }}" min="0" max="{{ $minuman->stock }}" name="jumlahbeli[]" harga="{{ $minuman->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($minuman->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach    
                        </tbody>
                    </table>
                    <!-- END CRUD TABLE -->
                </div>
		@endif
            </div>

            <div class="rokok" style="display: none;">
                <div class="content" style="width: 450px; @if(isset($rokoklist))float: left; margin: 5px 3px 3px 200px; @else margin: 5px auto 3px; @endif" >
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>
                            @foreach($rokoklist->forPage(1, 10) as $index => $rokok)
                            <input type="hidden" name="id_item[]" value="{{ $rokok->id_item }}" />
                            <tr>
                                <td>
                                     {{ $rokok->nama }}<br>
                                     Rp. {{ number_format($rokok->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($rokok->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $rokok->id_item }}" type="number" value="{{ isset($jml[$rokok->id_item]) ? $jml[$rokok->id_item] : 0 }}" min="0" max="{{ $rokok->stock }}" name="jumlahbeli[]" harga="{{ $rokok->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($rokok->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
                <div class="content" style="float: left; width: 440px; margin: 5px 3px 3px 3px;">
                    <!-- BEGIN CRUD TABLE -->
                    <table class="table table-hover" style="font-size:16px;">
                        <tbody>
                            @foreach($rokoklist->forPage(2, 10) as $index => $rokok)
                            <input type="hidden" name="id_item[]" value="{{ $rokok->id_item }}" />
                            <tr>
                                <td>
                                     {{ $rokok->nama }}<br>
                                     Rp. {{ number_format($rokok->price) }}
                                </td>
                                <td>
                                    <button type="button" id="sub" class="sub btn btn-default btn-circle btn-lg" @if($rokok->stock <= 0) disabled @endif><i class="glyphicon glyphicon-minus"></i></button>
                                    <input class="input-item" iditem="{{ $rokok->id_item }}" type="number" value="{{ isset($jml[$rokok->id_item]) ? $jml[$rokok->id_item] : 0 }}" min="0" max="{{ $rokok->stock }}" name="jumlahbeli[]" harga="{{ $rokok->price }}" style="width: 40px; text-align: center; font-size: 40px" />
                                    <button type="button" id="add" class="add btn btn-default btn-circle btn-lg" @if($rokok->stock <= 0) disabled @endif><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            @endforeach   
                        </tbody>
                    </table>
                    <!-- END CRUD TABLE -->
                </div>
            </div>
            
        </form>

        <div id="dialogoverlay"></div>
        <div id="dialogbox">
            <div>
                <!-- <div id="dialogboxhead"></div> -->
                <div id="dialogboxbody"></div>
                <div id="dialogboxfoot"></div>
            </div>
        </div>
        <!-- END LOGIN -->
    </body>
    <!-- END BODY -->
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery-migrate-1.2.1.min.js') }}"></script>
    <script>
        var counter;

        function startCount(){
            counter = setTimeout(function(){ location.href = "{{ url('restoran2') }} "; }, 8000);
        }

        function stopCount(){
            clearTimeout(counter);
        }

        window.onload = startCount();

        $('.makanan-show').click(function(){
            $('.menu').hide();
            $('.menu-atas').show();
            $('.makanan').show();
            stopCount();
        });

        $('.minuman-show').click(function(){
            $('.menu').hide();
            $('.menu-atas').show();
            $('.minuman').show();
            stopCount();
        });

        $('.rokok-show').click(function(){
            $('.menu').hide();
            $('.menu-atas').show();
            $('.rokok').show();
            stopCount();
        });

        $('.submit-back').click(function(){
            $('.menu').show();
            $('.menu-atas').hide();
            $('.makanan').hide();
            $('.minuman').hide();
            $('.rokok').hide();
            startCount();
        });

        var saldo = $('#saldo').val();
        var berisi = false;

        /*var storage = sessionStorage.getItem('cart');
        var dicti = {};

        if(storage != null){
            dicti = JSON.parse(storage);
            
            $( ".input-item" ).each(function(index) {
                if(dicti.hasOwnProperty($(this).attr('iditem'))){
                    var jml = parseInt(dicti[$(this).attr('iditem')]);
                    var hrg = parseInt($(this).attr('harga'));
                    $(this).val(jml);
                    
                    $('#totaldinamis').val(+$('#totaldinamis').val() + jml*hrg);
                    $('#totaltampil').val(numFormat(parseInt($('#totaldinamis').val(),10)));
                    berisi = true;
                }
            });
        }

        function storeToCart(){
            $( ".input-item" ).each(function(index) {
                if((dicti.hasOwnProperty($(this).attr('iditem'))) && ($(this).val() > 0)){
                    dicti[$(this).attr('iditem')] = $(this).val();                    
                }
                sessionStorage.setItem('cart', JSON.stringify(dicti));
            });
            alert(sessionStorage.getItem('cart')); 
        }*/

        function CustomAlert(){
            this.render = function(dialog){
                var winW = window.innerWidth;
                var winH = window.innerHeight;
                var dialogoverlay = document.getElementById('dialogoverlay');
                var dialogbox = document.getElementById('dialogbox');
                dialogoverlay.style.display = "block";
                dialogoverlay.style.height = winH+"px";
                dialogbox.style.left = (winW/2) - (750 * .5)+"px";
                dialogbox.style.top = "120px";
                dialogbox.style.display = "block";
                
                // document.getElementById('dialogboxhead').innerHTML = "Kembali ke menu awal";
                document.getElementById('dialogboxbody').innerHTML = dialog;
                document.getElementById('dialogboxfoot').innerHTML = '<button style="margin-right: 40px; float: right;" id="alert_button" onclick="Alert.ok()">OK</button>';
            }
            this.ok = function(){
                document.getElementById('dialogbox').style.display = "none";
                document.getElementById('dialogoverlay').style.display = "none";
                // document.getElementById("pelanggan-barcode").focus();
            }
        }
        var Alert = new CustomAlert();

        function numFormat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

        function cekIsi(){
            var isi = parseInt($('#totaldinamis').val(),10);
            if(isi > 0){
                berisi = true;
            }
            else{
                berisi = false;
            }
        }

        $('.add').click(function () {
            if ($(this).prev().val() < parseInt($(this).prev().attr("max"),10)){
                var jumlah = parseInt($(this).prev().attr("harga"),10);

                if((parseInt($('#totaldinamis').val(),10) + jumlah) <= saldo){
                    $(this).prev().val(+$(this).prev().val() + 1);
                    $('#totaldinamis').val(+$('#totaldinamis').val() + jumlah);
                    $('#totaltampil').val(numFormat(parseInt($('#totaldinamis').val(),10)));
                }
                else{
                    Alert.render('Saldo anda tidak mencukupi');
                    //alert("saldo anda sebesar "+numFormat(saldo)+" tidak mencukupi");
                }
                cekIsi();
            }
        });

        $('.sub').click(function () {
            if ($(this).next().val() > 0){
                var jumlah = parseInt($(this).next().attr("harga"),10);
                
                $(this).next().val(+$(this).next().val() - 1);
                $('#totaldinamis').val(+$('#totaldinamis').val() - jumlah);
                $('#totaltampil').val(numFormat(parseInt($('#totaldinamis').val(),10)));
                cekIsi();
            } 
        });

        $('.submission').click(function () {
            if (berisi == true){
                $("#formnya").submit();
            }
            else{
                Alert.render('Anda belum memilih item');
            }
        });

    </script>
</html>