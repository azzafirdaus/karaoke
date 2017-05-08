<html>
	<head>
		
	    <meta charset="utf-8" />
	    <title>Status Ruangan</title>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <!-- BEGIN GLOBAL MANDATORY STYLES -->          
	    <!-- <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/> -->
	    <!-- END GLOBAL MANDATORY STYLES -->
	    <link rel="shortcut icon" href="favicon.ico" />
		<style>
			.ruang {
			    background-color: #00FF00;
			    width: 120px;
			    height: 80px;
			    padding: 25px;
			    margin: 10px;
			    color: white;
			    font-size: 14px;
			    text-align: center;
				vertical-align: center;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<br>
			<p style='font-size: 60px; color: black; text-align: center;'>Status Ruangan Lantai 3</p>
			<div class="row col-xs-9" style="margin:40px 220px;">
			  @foreach($data as $ruang)
			  <button class="col-xs-1 ruang" onclick=" <?php if($ruang->available == 0){ ?> location.href = '{{ route('set.active', ['id' => $ruang->id]) }}'<?php }else{ ?>location.href = '{{ route('set.inactive', ['id' => $ruang->id]) }}'<?php } ?>" style="<?php if($ruang->available == 0): ?>background-color: red <?php endif; ?>">Ruang {{ $ruang->id }}</button>
			  @endforeach
			</div>

			<div class="tombol" style="float:right; margin-right: 300px">
				<button type="button" style="height: 60px; font-size: 20px; margin: 20px auto; padding: 20px;" onclick="location.href = '{{ url('statusRuang') }}'" class="btn btn-primary">
	            	Lantai 3
	        	</button>
	        	<button type="button" style="height: 60px; font-size: 20px; margin: 20px auto; padding: 20px;" onclick="location.href = '{{ url('statusRuang2') }}'" class="btn btn-primary">
	            	Lantai 4
	        	</button>
			</div>
		</div>		
	</body>

	<script>
        window.onload = function() {
            setTimeout(function(){ location.href = "{{ url('statusRuang') }} "; }, 10000);
        };
    </script>
</html>
