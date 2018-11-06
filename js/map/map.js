var map;
var osmLayer;
var origin = undefined;
var destination = undefined;
var routingControl = undefined;
var geojson = { type: "", coordinates: [] };
var parcelbuf = undefined;
var bufferattraction = [];
var markersBuffers = undefined;
var waypoints = [];

//Initialize location.
$(document).ready(function () {

  map.on('click', displayMarkerInfo);

  getUserLocation();

  getDestination();
});

//Builds the map.
function initMap() {
  osmTiles = new L.TileLayer
    (
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      minZoom: 3,
      maxZoom: 17,
      attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }
    );

  map = L.map('map', { preferCanvas: true }).setView([36.322205, 20.471628], 3);

  map.addLayer(osmTiles);
}

//Draws the route.
function drawRoute(src, dest, waypoints = undefined) {
  if (origin !== undefined && destination !== undefined && routingControl == undefined) {
    routingControl = L.Routing.control({
      draggableWaypoints: false,
      addWaypoints: false,
      lineOptions: {
        styles: [{color: '#33cc33', opacity: 0, weight: 9}]
      },
      waypoints: [L.latLng(src.lat, src.lng), L.latLng(dest.lat, dest.lng)], 
      //mapbox API code.
      router: L.Routing.mapbox('pk.eyJ1IjoibXlyb25saW96IiwiYSI6ImNqbDd0d2p2dDJhOXIzcHF5c2w2MTh3c2wifQ.iSVN6LZezFdRK5MTurzgIg'),
      //Sets the view to the route.
      fitSelectedRoutes: true
    }).addTo(map);

    buildBuffer();

    document.getElementById("route-btn2").disabled = false;
  }
}

//Set user location according to gps/ip.
function getUserLocation() {

  var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
  };

  function success(pos) {
    origin = { lat: pos.coords.latitude, lng: pos.coords.longitude };

    map.setView(new L.LatLng(origin.lat, origin.lng), 13);
    L.marker([origin.lat, origin.lng]).addTo(map);

    document.querySelector("#origin").setAttribute("placeholder", "IP location set");
    document.querySelector("#origin").setAttribute("disabled", "true");
  }

  function error() {

    search("origin", function (lat, lng) {

      origin = { lat: lat, lng: lng };

      map.setView(new L.LatLng(origin.lat, origin.lng), 13);
    });
  }

  navigator.geolocation.getCurrentPosition(success, error, options);
}

//Get the latitude and longtitude of the selected location in the search box.
function getDestination() {
  search("destination", function (lat, lng) {

    destination = { lat: lat, lng: lng };
  });
}

//Function that converts route to geojson points.
//This function is used for creation of the buffer.
function getRouteCoordinates(callback) {
  routingControl.on('routeselected', function (e) {

    var route = e.route;

    geojson.type = "LineString";
    for (i = 0; i < route.coordinates.length; i++) {
      geojson.coordinates[i] = [route.coordinates[i].lng, route.coordinates[i].lat];
    }

    callback && callback(geojson);
  });
}

//Function responsible for creation of the buffer.
function buildBuffer() {
  
  //Initial waypoint/point of origin.
  waypoints = [{coor: L.latLng(origin.lat, origin.lng), dist: 0}];

  getRouteCoordinates(function (geojson) {
    eraseBuffer();

    //turf API for buffer creation.
    var buffer = turf.buffer(geojson, 500, { units: 'meters' });
    parcelbuf = new L.GeoJSON(buffer);
    //Show buffer on map.
    parcelbuf.addTo(map);

    //Inserts all the attractions that are within buffer into new array called bufferattraction.
    for (i = 0; i < attractionList.length; i++) {
      var point = turf.point([attractionList[i].lng, attractionList[i].lat]);

      if (turf.booleanContains(buffer, point)) {
        bufferattraction.push(attractionList[i]);
      }
    }

    //Parameters for clustering function.
    buffersoptions = {
      disableClusteringAtZoom: 16,
      chunkedLoading: true,
      chunkInterval: 1000,
      spiderfyOnMaxZoom: false
    }

    //Removes the current shown layers in order to display only the attractions that are in the bufferattraction array.
    for (i=0 ; i<9 ; i++)
    {
      map.removeLayer(mCat[i]);
      //Defines each element in mCat as clustering object.
      mCat[i] = L.markerClusterGroup(buffersoptions);
    }

    //Sorts bufferattraction attractions into category array.
    for (i=0 ; i<bufferattraction.length ; i++)
    {
      mCat[bufferattraction[i].id_category-1].addLayer(bufferattraction[i].marker);
    }

    updateLayersCB();
  });
}

function eraseBuffer() {
  //Check if the buffer is defined.
  if (parcelbuf != undefined) {
    parcelbuf.remove(map);
    parcelbuf = undefined;
    geojson = { type: "", coordinates: [] };

    bufferattraction = [];

    removeCategoryLayer();

    //Restore all markers.
    rebuildLayers();

    markersBuffers = undefined;

    updateLayersCB();
  }
}

function removeCategoryLayer()
{
  for(i=0 ; i<9 ; i++)
    {
      map.removeLayer(mCat[i]);
    }
}

//Plan route button
$(function () {
  $('#route-btn').click(function () {
    drawRoute(origin, destination);
  });
});

//Clear route button
//Button is responsible to remove both initial planning route and final route.
$(function () {
  $('#clear-btn').click(function () {
    //Initial route.
    if (routingControl !== undefined) { //*
      map.removeControl(routingControl);
      routingControl = undefined;

      eraseBuffer();
    }

    //Final route.
    if (finalRouteObj !== undefined)
    {
      map.removeControl(finalRouteObj);
      finalRouteObj = undefined;

      rebuildLayers();
      updateLayersCB();
    }
    //Change status of "Add waypoint" buttons to disabled.
    document.getElementById("route-btn2").disabled = true;
    document.getElementById("addPoint").disabled = true;
    document.getElementById("removePointId").disabled = true;
  });
});
