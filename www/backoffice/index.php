<html>

<head>
    
    <title>Back office - Get data</title>
    
    <link rel="stylesheet" href="css/reset.css">	
	<link rel="stylesheet" href="css/main.css">
    
    <script src="libs/jquery-2.1.3.js"></script>
    
    <script src="js/functions.js"></script>
    
</head>

<body>
    
    <div id="error"></div>
    
    <div id="outer">
        <div id="inner">
            <div id="content">
                <div id="title">Get data from servers</div>
                <div id="btn_start">Launch</div>
                <div id="config">
                    <select id="select_region">
                        <option value="br">BR</option>
                        <option value="eune">EUNE</option>
                        <option value="euw">EUW</option>
                        <option value="kr">KR</option>
                        <option value="lan">LAN</option>
                        <option value="las">LAS</option>
                        <option value="na">NA</option>
                        <option value="oce">OCE</option>
                        <option value="ru">RU</option>
                        <option value="tr">TR</option>
                    </select>
                    <input type="text" class="input_offset" id="input_start" value="0">
                    <input type="text" class="input_offset" id="input_end" value="9">
                </div>
                <div id="servers_list"></div> 
            </div>
        </div>
    </div>
    
</body>

</html>