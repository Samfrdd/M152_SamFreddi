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


    <!-- main right col -->
    <div class="column  " id="main">

        <!-- top nav -->
        <!-- top nav -->
        <div class="navbar navbar-blue navbar-fixed-top ">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="?page=home" class="navbar-brand logo">F</a>
            </div>
            <nav class="collapse navbar-collapse" role="navigation">
                <form class="navbar-form navbar-left">
                    <div class="input-group input-group-sm" style="max-width:360px;">
                        <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="?page=home"role="button" data-toggle="modal"><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="?page=post" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>
                            Post</a>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="">More</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- /top nav -->
        <div class="padding">
            <div class="full col-sm-12">
                <div class="well ">
                    <form class="form-horizontal" role="form" action="#" method="post" enctype="multipart/form-data">
                        <h4>Modifiez votre post ici !</h4>
                        <div class="form-group" style="padding:14px;">
                            <textarea name="message" class="form-control" ><?= $message->commentaire ?></textarea>
                        </div>

                        <input type="submit" class="btn btn-primary pull-right" name="modify" value="Sauvegarder">

                        <div class="form-group">
                            <label>Ajouter des photo !</label>
                            <!-- <label for="img"><i class="glyphicon glyphicon-upload"></i></label> -->
                            <input type="file" name="img[]" id="img" multiple accept="image/*,video/* ,audio/*">
                        </div>

                    </form>
                </div>
                <?= $erreurMessage ?>
                <?= $erreurImage ?>

                
            </div>


        <div>
            <h3>Modification des photos</h3>
            <?= $div  ?>
        </div>

        </div>

    </div>

</body>

</html>