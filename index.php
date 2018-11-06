<!DOCTYPE html>
<?php
session_start();
//session_destroy() ;
if (!isset($_SESSION['username']) || $_SESSION['username'] == '')
{
    
}
else{
   // echo "Hello ".$_SESSION['username']."!";
    //echo "<script> document.getElementById(\"login_l\").value='logOut'; </script>";

}

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>GIS Project</title>

        <!--Links-->

        <!--Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!--Bootstrap Javascript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!--Fonts-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <!--Leaflet API-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q==" crossorigin=""></script>
        <!--Leaflet Routing Machine-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
        <!--Clustering Markers-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.0/dist/MarkerCluster.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.0/dist/MarkerCluster.Default.css">
        <script src="https://unpkg.com/leaflet.markercluster@1.4.0/dist/leaflet.markercluster.js"></script>
        <!--Turf Geometry-->
        <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
        <!--Icons-->
        <link rel="stylesheet" href="icons/dist/css/leaflet.extra-markers.min.css">
        <script src="icons/dist/js/leaflet.extra-markers.min.js"></script>
        <!--Autocomplete - Algolia API-->
        <script src="https://cdn.jsdelivr.net/npm/places.js@1.9.0"></script>
        <!--JQuery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!--JS-->
        <script src="js/map/attractionDisplay.js"></script>
        <script src="js/map/categoriesFiltering.js"></script>
        <script src="formAjax.js"></script>
        <!--CSS-->
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <!--Navigation Bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <!--Nav bar title-->
            <a class="navbar-brand" href="#"> <i class="fas fa-map-pin"></i> Tour Guide App</a>

            <!--Mobile Toggler-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!--Nav Buttons-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <!--Login Button-->
                <li class="nav-item active">
                       <button id ="login_l" type="button" class="btn btn-light" data-toggle="modal" data-target="#LoginModal">Login</button>

            <!--Login Modal-->
            <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="LoginModalTitle">Login</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                        </div>

                        <!--Login Form-->
                        <form method="post">
                            <div class="modal-body">
                                <div class="container">    
                                    <div class="form-group">
                                        <!--User Name Field-->
                                        <label for="recipient-name" class="col-form-label">User Name</label>
                                        <input id="username" class="form-control" type="text" name="username" placeholder="abc">
                                        <!--Password Field-->
                                        <label for="recipient-name" class="col-form-label">Password</label>
                                        <input id="password" class="form-control" type="password" name="psw" placeholder="1234">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!--Submit Button-->
                                    <button type = "submit" button id="login" class="btn btn-outline-primary" data-dismiss="modal" >Login</button>
                                    <!--Close Button-->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
                </li>
                <!--Sign Up Button-->
                <li class="nav-item active">
                  
                       <button type="button" class="btn btn-light" data-toggle="modal" data-target="#SignUpModal">Sign Up</button>

            <!--SignUp Modal-->
            <div class="modal fade" id="SignUpModal" tabindex="-1" role="dialog" aria-labelledby="SignUpModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="LoginModalTitle">Sign Up</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                        </div>

                        <!--SignUp Form-->
                        <form method="post">
                            <div class="modal-body">
                                <div class="container">    
                                    <div class="form-group">                                    
									  <!--User Name Field-->
                                        <label for="recipient-name" class="col-form-label">User Name</label>
                                        <input id="username1" class="form-control" type="email" name="username1" placeholder="Maor">
										<!--Email Field-->
										    <label for="recipient-name" class="col-form-label">Email</label>
                                        <input id="email1" class="form-control" type="email" name="email1" placeholder="abc@gamil.com">
									   <!--Password Field-->
                                        <label for="recipient-name" class="col-form-label">Password</label>
                                        <input id="psw1" class="form-control" type="password" name="psw1" placeholder="1234">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!--Submit Button-->
                                    <button type = "submit" id="signup" class="btn btn-outline-primary" data-dismiss="modal" >Sign Up</button>
                                    <!--Close Button-->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </li>
                </ul>
            </div>
        </nav>

        <!--Center Window-->
        <div class="container-fluid">
            <div id="center-window"class="row">
                <!--Map Display-->
                <div id="map" class="col-sm-9">
                    <script src="js/map/map.js" onload="initMap()"></script>
                </div>
                
                <!--Side Bar (Map Utility Functions)-->
                <div class="col-sm-3 sidenav bg-light">
                    <!-- Begin page content -->
                    <form>
                        <div class="form-group">
                            <label for="Point of origin">Point of origin</label>
                            <input type="search" id="origin" class="form-control" placeholder="Where are you now?" />
                        </div>
                        <div class="form-group">
                            <label for="Destinaion">Destination</label>
                            <input type="search" id="destination" class="form-control" placeholder="Where are you going?"/>
                            <script src="js/map/search.js"></script>
                        </div>
                    </form>
                    <div class="container">
                        <div class="form">
                            <div class="form-group">
                                <button id="route-btn" class="btn btn-outline-primary btn-block">Plan</button>                       
                            </div>
                        </div>
                        <input type="checkbox" id="shoppingID" checked> shopping<br>
                        <input type="checkbox" id="food_and_drinksID" checked> Food and drinks<br>
                        <input type="checkbox" id="entertainmentID" checked> Entertainment<br>
                        <input type="checkbox" id="sportsID" checked> Sports<br>
                        <input type="checkbox" id="historic_and_religious_ID" checked> Historic and religious<br>
                        <input type="checkbox" id="museumID" checked> Museum<br>
                        <input type="checkbox" id="eco_tourism_ID" checked> eco tourism<br>
                        <input type="checkbox" id="lodging_ID" checked> lodging<br>
                        <input type="checkbox" id="adult_entertainment_ID" checked> adult<br>
                    </div>
                    <div class="form-inline justify-content-between">
                        <div class="form-group">
                            <button id="route-btn2" class="btn btn-primary" disabled>Route</button>                       
                        </div>
                        <div class="form-group">
                            <button id="clear-btn"class="btn">Clear Route</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer-->
        <footer class="container-fluid bg-light">
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#AboutModal">About</button>

            <div class="modal" id="AboutModal" tabindex="-1" role="dialog" aria-labelledby="AboutModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AboutModalTitle">About</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                        </div>
                        <div class="modal-body">
                            <p>About...</p>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Terms Of Use -->
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#TermsOfUseModal">Terms Of Use</button>

            <div class="modal" id="TermsOfUseModal" tabindex="-1" role="dialog" aria-labelledby="TermsOfUseModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="TermsOfUseModalTitle">Terms Of Use</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                        </div>
                        <div class="modal-body">
                            <p>Terms of use...</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <!--Button-->
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#ContactModal">Contact</button>

            <!--Modal-->
            <div class="modal fade" id="ContactModal" tabindex="-1" role="dialog" aria-labelledby="ContactModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ContactModalTitle">Contact</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                        </div>

                        <!--Contact Form-->
                        <form method="post">
                            <div class="modal-body">
                                <div class="container">    
                                    <div class="form-group">
                                        <!--Name Field-->
                                        <label for="recipient-name" class="col-form-label">Name</label>
                                        <input id="name" class="form-control" type="text" name="name" placeholder="e.g. Mark Israel">
                                        <!--Email Field-->
                                        <label for="recipient-name" class="col-form-label">Email</label>
                                        <input id="email" class="form-control" type="email" name="email" placeholder="name@example.com">
                                        <!--Message Box-->
                                        <label for="message-text" class="col-form-label">Message</label>
                                        <textarea id="message" type="text" class="form-control" name ="message"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!--Submit Button-->
                                    <button id="contact" class="btn btn-outline-primary" data-dismiss="modal" >Submit</button>
                                    <!--Close Button-->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#LegendModal">Legend</button>

            <!--Modal-->
            <div class="modal fade" id="LegendModal" tabindex="-1" role="dialog" aria-labelledby="LegendModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="LegendModalTitle">Legend</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>    
                        </div>

                        <!--Contact Form-->
                        <form method="post">
                            <div class="modal-body">
                                <div class="container">    
                                    <div class="form-group">
                                        <div>
                                            
                                            <!--<h6 style="float:left;">Shopping</h6>  
                                            <i class='fas fa-shopping-cart'></i> -->
                                            <h6><i class='fas fa-shopping-cart'></i>&nbsp;Shopping</h6>
                                            <h6><i class='fas fa-utensils'></i>&nbsp;Food & Drinks</h6>
                                            <h6><i class='fas fa-grin'></i>&nbsp;Entertainment</h6>
                                            <h6><i class='fas fa-futbol'></i>&nbsp;Sports</h6>
                                            <h6><i class='fas fa-archway'></i>&nbsp;Historic & Religious Sites</h6>
                                            <h6><i class='fas fa-university'></i>&nbsp;Museums</h6>
                                            <h6><i class='fas fa-umbrella-beach'></i>&nbsp;Eco-Tourism</h6>
                                            <h6><i class='fas fa-bed'></i>&nbsp;lodging</h6>
                                            <h6><i class='fas fa-cocktail'></i>&nbsp;Adult</h6>

                                                                                     
                                        </div>
                       
   
                                    </div>
                                </div>
                                <div class="modal-footer">
   
                                    <!--Close Button-->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </footer>
        <!--Marker Info Modal-->
        <div class="modal" id="MarkerInfo" tabindex="-1" role="dialog" aria-labelledby="Info" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MarkerInfoTitle">Site Information</h5>
                    </div>
                    <div class="modal-body">
                        <h3 id="siteName"></h3>
                        <p id="address"></p>
                        <img id="image" src="" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type = "addWayPoint" class="btn btn-success" id ="addPoint" style="position:relative; left: -160px" disabled><i class="fas fa-plus"></i> Add way point</button>
                        <button type = "removeWayPoint" class = "btn btn-success" id = "removePointId" style= "background-color: #f44336;position:relative; left: -160px" disabled>Remove</button>
                        <button type="button" id="markerInfoClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>