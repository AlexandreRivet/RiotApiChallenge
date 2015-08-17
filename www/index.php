<!DOCTYPE html>
<html class="full" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bilgewater Topkek</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.8/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">
    



</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Bilgewater Topkek</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Champions</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
     <div class="container">
        <!-- Portfolio Item Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Choose a region</h1>
            </div>
            <div class="col-lg-12">
                <div id="map_region"></div>
            </div>
        </div>
         
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" id="region_chosen">No region selected</h1>
            </div>
            <div class="col-lg-12" id="region_stats" style="display:none">
                <div id="bilgewater_stats">
                    <h3>Black Market stats</h3>
                </div>
                <div id="items_stats">
                    <h3>Items stats</h3>
                </div>
                <div id="champions_stats">
                    <h3>Champions stats</h3>
                    <div id="champions_table"></div>
                </div>
            </div>
        </div>
         
        <!-- /.row -->

    </div>    
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.8/js/dataTables.bootstrap.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom functions -->
    <script src="js/main.js"></script>
    
    <!-- For map -->
    <script src="http://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="http://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="http://www.amcharts.com/lib/3/themes/dark.js"></script>
    <script src="js/map.js"></script>
    
</body>

</html>