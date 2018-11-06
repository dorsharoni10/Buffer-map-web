//Array containing categories filtering elements.
var selectedCategories = [];

//Initialize selectedCategories elements.
$(document).ready(function () {
    selectedCategories[0] = (document.getElementById("shoppingID"));
    selectedCategories[1] = (document.getElementById("food_and_drinksID"));
    selectedCategories[2] = (document.getElementById("entertainmentID"));
    selectedCategories[3] = (document.getElementById("sportsID"));
    selectedCategories[4] = (document.getElementById("historic_and_religious_ID"));
    selectedCategories[5] = (document.getElementById("museumID"));
    selectedCategories[6] = (document.getElementById("eco_tourism_ID"));
    selectedCategories[7] = (document.getElementById("lodging_ID"));
    selectedCategories[8] = (document.getElementById("adult_entertainment_ID"));
});

//filtering checkboxes.
$(document).on('change', '#shoppingID', function() {
  shopping_CB();
});
$(document).on('change', '#food_and_drinksID', function() {
  food_and_drinks_CB();
});
$(document).on('change', '#entertainmentID', function () {
  entertainment_CB();
});
$(document).on('change', '#sportsID', function () {
  sports_CB();
});
$(document).on('change', '#historic_and_religious_ID', function () {
  historic_and_religious_CB();
});
$(document).on('change', '#museumID', function () {
  museum_CB();
});
$(document).on('change', '#eco_tourism_ID', function () {
  eco_tourism_CB();
});
$(document).on('change', '#lodging_ID', function () {
  lodging_CB();
});
$(document).on('change', '#adult_entertainment_ID', function () {
  adult_entertainment_CB();
});

//Add/remove layer given checkbox status.
function shopping_CB()
{
  if(selectedCategories[0].checked == true)
  {
    map.addLayer(mCat[0]);
  }
  else
  {
    map.removeLayer(mCat[0]);
  }
}

function food_and_drinks_CB()
{
  if(selectedCategories[1].checked == true)
  {
    map.addLayer(mCat[1]);
  }
  else
  {
    map.removeLayer(mCat[1]);
  }
}

function entertainment_CB()
{
  if(selectedCategories[2].checked == true)
  {
    map.addLayer(mCat[2]);
  }
  else
  {
    map.removeLayer(mCat[2]);
  }
}

function sports_CB()
{
  if(selectedCategories[3].checked == true)
  {
    map.addLayer(mCat[3]);
  }
  else
  {
    map.removeLayer(mCat[3]);
  }
}

function historic_and_religious_CB()
{
  if(selectedCategories[4].checked == true)
  {
    map.addLayer(mCat[4]);
  }
  else
  {
    map.removeLayer(mCat[4]);
  }
}

function museum_CB()
{
  if(selectedCategories[5].checked == true)
  {
    map.addLayer(mCat[5]);
  }
  else
  {
    map.removeLayer(mCat[5]);
  }
}

function eco_tourism_CB()
{
  if(selectedCategories[6].checked == true)
  {
    map.addLayer(mCat[6]);
  }
  else
  {
  map.removeLayer(mCat[6]);
  }
}

function lodging_CB()
{
  if(selectedCategories[7].checked == true)
  {
    map.addLayer(mCat[7]);
  }
  else
  {
    map.removeLayer(mCat[7]);
  }
}

function adult_entertainment_CB()
{
  if(selectedCategories[8].checked == true)
  {
    map.addLayer(mCat[8]);
  }
  else
  {
    map.removeLayer(mCat[8]);
  }
}
