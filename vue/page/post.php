<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post </title>
    <link href="./vue/css/bootstrap.css" rel="stylesheet">
	<!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
	<link href="./vue/css/facebook.css" rel="stylesheet">
</head>

<body>
    <!-- sidebar -->
    <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">

        <ul class="nav">
            <li><a href="#" data-toggle="offcanvas" class="visible-xs text-center"><i
                        class="glyphicon glyphicon-chevron-right"></i></a></li>
        </ul>

        <ul class="nav hidden-xs" id="lg-menu">

            <li><a href="#"><i class="glyphicon glyphicon-refresh"></i> Refresh</a></li>
        </ul>


        <!-- tiny only nav-->
        <ul class="nav visible-xs" id="xs-menu">
            <li><a href="#featured" class="text-center"><i class="glyphicon glyphicon-list-alt"></i></a>
            </li>
            <li><a href="#stories" class="text-center"><i class="glyphicon glyphicon-list"></i></a></li>
            <li><a href="#" class="text-center"><i class="glyphicon glyphicon-paperclip"></i></a></li>
            <li><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
        </ul>

    </div>
    <!-- /sidebar -->

    <!-- main right col -->
    <div class="column col-sm-10 col-xs-11 " id="main">

        <!-- top nav -->
        <div class="navbar navbar-blue ">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand logo">F</a>
            </div>
            <nav class="collapse navbar-collapse" role="navigation">
                <form class="navbar-form navbar-left">
                    <div class="input-group input-group-sm" style="max-width:360px;">
                        <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="?page=home"><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="?page=post" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>
                            Post</a>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="glyphicon glyphicon-user"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="">More</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="padding">
            <div class="full col-sm-9">

                <div class="well ">

                    <form class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
                        <h4>Poster ici !</h4>
                        <div class="form-group" style="padding:14px;">
                            <textarea name="message" class="form-control" placeholder="Ecrivez votre post ici !"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary pull-right" name="post" value="post">

                        <div class="form-group">
                            <!-- <label for="img"><i class="glyphicon glyphicon-upload"></i></label> -->
                            <input type="file" name="img[]" id="img" multiple accept="image/*">
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>



</body>

</html>