var prev_infowindow =false;
var cz = new google.maps.LatLng(49.93954519107312, 15.322085916210883);
  var mapOptions = {
    zoom:      7,
    center:    cz,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: [
      {
          stylers: [ { "hue": "#00aaff" },{ "saturation": -100 } ]
      }
    ]
  }
  var map = new google.maps.Map($("#map_canvas")[0], mapOptions);
  var currentPlace = null;
  var info = $('#placeDetails');
  var icons = {
    'marker42':        '/rscs/marks/42.png',
    'marker44':        '/rscs/marks/44.png',
    'marker48':        '/rscs/marks/48.png',
    'marker49':        '/rscs/marks/49.png',
    'marker50':        '/rscs/marks/50.png',
    'marker52':        '/rscs/marks/52.png',
    'marker57':        '/rscs/marks/57.png'
  }
    $(places).each(function() {
      var place = this;
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(place.position[0], place.position[1]),
        map:      map,
        title:    place.title,
        icon:     icons[place.icon]
      });

      google.maps.event.addListener(marker, 'click', function() {
      if( prev_infowindow ) {
      prev_infowindow.close();
      }
      var infowindow = new google.maps.InfoWindow({
      content: "Zapojená škola:<br><strong>"+place.title+"<br>"+place.address
          });
          prev_infowindow = infowindow;
          infowindow.open(marker.get('map'), marker);



      });

     });

