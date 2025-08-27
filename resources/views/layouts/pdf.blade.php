<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PDF</title>
	
	@googlefonts

	<style type="text/css">
		@font-face {
    		font-family: "Nunito Sans";
		    src: url('/google-fonts/Nunito_Sans/NunitoSans-VariableFont_YTLC,opsz,wdth,wght.ttf') format('truetype');
		    font-weight: normal;
		    font-style: normal;
		}

		body{
			font-family: 'Nunito Sans', sans-serif !important;
			font-size: 14px;
		}
		.w-50{
			width:48%;
			display: block;
			float: left;
			padding: 1%;
		}
		.w-100{
			width: 96%;
			display: block;
			clear: both;
			padding: 2%;
		}
		td, th{
			border:1px solid #000;
			text-align: left;
			padding: 5px;
		}
		table{
  			border-collapse: collapse;
  			width: 100%;
		}
		thead tr{
			background-color: {{$company->companyBranding->header_background??null}};
			color: {{$company->companyBranding->header_color??null}};
		}
		.header{
			margin-bottom: 20px;
			display: block;
			clear: both;
			width: 100%;
		}
		.footer{
			margin-top: 20px;
			display: block;
			clear: both;
			width: 100%;
			position: absolute;
			bottom: 0px;
			left: 0px;
		}
		.content{
			display: block;
			width: 100%;
			margin-bottom: 20px;
		}
		.document-number{
    		text-align:right;
		}

		.name-wrapper, .signature-wrapper, .date-wrapper {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
		}
		.name, .signature, .date {
			border-bottom: 1px dotted black;
			width: 100%;
			text-align: left;
		}
	</style>
</head>
<body>
@if($company->companyBranding && $company->companyBranding->letterhead!=null)<div class="header"><img src="{{$company->companyBranding->letterhead}}" width="100%"/></div>@endif

@if($company->companyBranding && $company->companyBranding->letterhead==null && $company->companyBranding->logo!=null)
<div class="header"><img src="{{$company->companyBranding->logo}}" width="200px"/></div>
@endif

<div class="content" >
@yield('content')
</div>

@if($company->companyBranding && $company->companyBranding->footer!=null)<div class="footer"><img src="{{$company->companyBranding->footer}}" width="100%"/></div>@endif

</body>
</html>