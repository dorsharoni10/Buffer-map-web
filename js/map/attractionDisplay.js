//List containing all attraction objects - {id, lat, lng, id_category}.
var attractionList = [];
//List containing attractions divided into categories.
var categories = [];
var finalRouteObj = undefined;

for (var i = 0 ; i<9 ; i++)
{
  categories[i] = [];
}

//Function to retrieve information of attractions from php file.
$.get("php/import_att_map.php", function(data)
{
    var attractionStr="";
    var attractions = [];

    attractionStr = data;
    attractions = attractionStr.split(',');
    attractionStr = undefined;

    j = 0;
    //Assign information into each object in attractionlist array.
    for (i = 0; i < attractions.length / 4 - 1; i++)
    {
        attractionList[i] = {id: attractions[j], lat: attractions[j+1], lng: attractions[j+2], id_category: attractions[j+3]};
        categories[attractions[j+3]-1].push(attractionList[i]);
        j += 4;

    }

    attractions = undefined;

    markerClustering();
});

//Adds/removes layer given checkbox status.
function updateLayersCB()
{
  shopping_CB();
  food_and_drinks_CB();
  entertainment_CB();
  sports_CB();
  historic_and_religious_CB();
  museum_CB();
  eco_tourism_CB();
  lodging_CB();
  adult_entertainment_CB();
}

//Parameters for clustering function.
options = {
    disableClusteringAtZoom: 16,
    chunkedLoading: true,
    chunkInterval: 1000,
    spiderfyOnMaxZoom: false
}

var mCat = [];
for (i=0 ; i<9 ; i++)
{
  mCat[i] = L.markerClusterGroup(options);
}

//Function of the clustering API.
function markerClustering()
{
    //Go over all the attractions, create marker for each and add it to the relevant layer.
    for (j = 0; j < 9 ; j++)
    {
      for (i = 0; i < categories[j].length; i++)
      {
        categories[j][i].marker = L.marker(new L.LatLng(categories[j][i].lat, categories[j][i].lng), { icon: categoryMarker[categories[j][i].id_category - 1] });
        categories[j][i].marker.on('click', displayMarkerInfo, {id: categories[j][i].id, lat: categories[j][i].lat, lng: categories[j][i].lng});
        mCat[j].addLayer(categories[j][i].marker);
      }
    }

    updateLayersCB();
}

//Restore layers containing all the markers.
function rebuildLayers()
{
  for (i=0 ; i<9 ; i++)
  {
    mCat[i] = L.markerClusterGroup(options);
  }
  for (j = 0; j < 9 ; j++)
  {
    for (i = 0; i < categories[j].length; i++)
    {
      mCat[j].addLayer(categories[j][i].marker);
    }
  }
}

//Icon variables
{
    var categoryMarker = [];

    categoryMarker[0] = L.ExtraMarkers.icon({
    icon: 'fa-shopping-cart',
    markerColor: 'cyan',
    shape: 'square',
    prefix: 'fas'
    });

    categoryMarker[1] = L.ExtraMarkers.icon({
    icon: 'fa-utensils',
    markerColor: 'red',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[2] = L.ExtraMarkers.icon({
    icon: 'fa-grin',
    markerColor: 'orange',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[3] = L.ExtraMarkers.icon({
    icon: 'fa-futbol',
    markerColor: 'green-light',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[4] = L.ExtraMarkers.icon({
    icon: 'fa-archway',
    markerColor: 'violet',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[5] = L.ExtraMarkers.icon({
    icon: 'fa-university',
    markerColor: 'yellow',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[6] = L.ExtraMarkers.icon({
    icon: 'fa-umbrella-beach',
    markerColor: 'green',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[7] = L.ExtraMarkers.icon({
    icon: 'fa-bed',
    markerColor: 'blue',
    shape: 'square',
    prefix: 'fas'
    });
    categoryMarker[8] = L.ExtraMarkers.icon({
    icon: 'fa-cocktail',
    markerColor: 'pink',
    shape: 'square',
    prefix: 'fas'
    });
}

//Contains functionality related to a click on a specific attraction.
function displayMarkerInfo(event)
{
  //Check if the click was on a marker.
  if (this.id != undefined)
  {
    //Get html modal element.
    var modal = document.getElementById('MarkerInfo');
    //Get close button element.
    var close = document.getElementById('markerInfoClose');

    //Once marker was clicked, display modal.
    modal.style.display = 'block';

    //Retrieve information of the clicked attraction.
    $.post(escapeHtml("php/attraction_info.php"),
      {
        //Send the id of the attraction to php file.
        id: this.id
      },

      function(data) {

        var infoString;
        var infoArr;

        infoString = data;

        //Parse recieved information.
        infoArr = infoString.split(',');

        infoString = undefined;

        //Display the information on the modal.
        $("#siteName").text(infoArr[0]);

        $("#address").text(infoArr[1] + ' ' + infoArr[2]);

        if (infoArr[3].length > 0)
        {
          $("#image").attr({
            src: 'pic\\' + infoArr[3]
          });
        }
        else
        {
          $("#image").text('Picture not available');
        }

        //Add/remove buttons functionality.
        //Check if planning route exists.
        if (routingControl != undefined) {

          var btnAddPoint = document.getElementById("addPoint");
          var btnRemovePoint = document.getElementById("removePointId");
          //Indicates wether attraction is already added or not.
          //False if attraction is not added/True if attraction is added.
          var flag = false;

          //Check if the attraction was already added.
          for (var i = 0; i < waypoints.length; i++) {
            if (event.latlng.lat == waypoints[i].coor.lat && event.latlng.lng == waypoints[i].coor.lng)
            {
              //Set add button to inactive.
              btnAddPoint.disabled = true;
              //Set remove button to active.
              btnRemovePoint.disabled = false;
              flag = true;
              break;
            }
          }

          if (flag == false)
          {
            btnAddPoint.disabled = false;
            btnRemovePoint.disabled = true;
          }

          //Add button click event function.
          btnAddPoint.onclick = function () {

            var options = { units: 'meters' };

            //Push attraction into waypoints array.
            waypoints.push({ coor: L.latLng(event.latlng.lat, event.latlng.lng), dist: turf.distance([origin.lat, origin.lng], [event.latlng.lat, event.latlng.lng], options) });

            //Sorts the array according to distance from origin point.
            waypoints.sort(function (a, b) { return a.dist - b.dist });
            btnRemovePoint.disabled = false;
            btnAddPoint.disabled = true;

          }

          //Remove button click event function.
          btnRemovePoint.onclick = function () {

            //Searches if the attraction exists in waypoints array, and if it does, removes it.
            for (var i = 0; i < waypoints.length; i++) {
              if (event.latlng.lat == waypoints[i].coor.lat && event.latlng.lng == waypoints[i].coor.lng)
                waypoints.splice(i, 1);
            }

            btnAddPoint.disabled = false;
            btnRemovePoint.disabled = true;
          }
        }
    });

    //Close button click functionality.
    close.onclick = function()
    {
      modal.style.display = 'none';

      infoArr = [];

      //Erase text from modal.
      $("#siteName").text('');

      $("#address").text('');

      $("#image").attr({ src: ''});
    }
  }
}

//Function to display final route.
function finalRoute()
{
  //Check if final route exists.
  if (finalRouteObj === undefined)
  {
    eraseBuffer();

    //Remove initial route.
    map.removeControl(routingControl);

    //Push destination to waypoints array.
    waypoints.push({coor: L.latLng(destination.lat, destination.lng), dist: 0});

    var wp = [];

    for (var i = 0; i < waypoints.length; i++)
    {
      wp[i] = waypoints[i].coor;
    }
    finalRouteObj = L.Routing.control({
      draggableWaypoints: false,
      addWaypoints: false,
      lineOptions: {
        styles: [{color: '#33cc33', opacity: 1, weight: 9}, {color: 'white', opacity: 1, weight: 2}]
      },
      waypoints: wp,
      router: L.Routing.mapbox('pk.eyJ1IjoibXlyb25saW96IiwiYSI6ImNqbDd0d2p2dDJhOXIzcHF5c2w2MTh3c2wifQ.iSVN6LZezFdRK5MTurzgIg'),
      fitSelectedRoutes: true
    }).addTo(map);
  }

  removeCategoryLayer();
}

//Final route button.
$(function()
{
  $('#route-btn2').click(function()
  {
    finalRoute();
  });
});
