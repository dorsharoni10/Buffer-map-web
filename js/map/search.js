//Built-in function for autocomplete.

function search(id, callback)
{
  var searchResult = {lat: undefined, lng: undefined};

  var placesAutocomplete = places({
    language: 'en',
    container: document.querySelector('#' + id)
  });

  placesAutocomplete.on('change', function(e)
  {
    searchResult = e.suggestion.latlng;

    callback && callback(searchResult.lat, searchResult.lng);
  });

  placesAutocomplete.on('clear', function()
  {
    searchResult.lat = undefined;
    searchResult.lng = undefined;
  });
};
