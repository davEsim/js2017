  var cz = new google.maps.LatLng(49.93954519107312, 15.322085916210883);
  var mapOptions = {
    zoom:      7,
    center:    cz,
    disableDefaultUI: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: [
      {
          stylers: [ { "hue": "#4d4d4d" },{ "saturation": -100 } ]
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

          var infowindow = new google.maps.InfoWindow({
          content: 'neco'
          });
            infowindow.open(marker.get('map'), marker);

        var hidingMarker = currentPlace;
        var slideIn = function(marker) {
          info.fadeIn('fast');
          //$('h1', info).text(place.title);
          $.ajax({
              url:'./markerAjaxContent.php', 
              data:{id:place.id, mark:place.icon},
              type:'GET',
              dataType: 'html',
              success: function(html, textSuccess){
                  $('p', info).html(html).show(1000);
              },
              error: function(xhr, textStatus, errorThrown){	
                  alert("Nastala chyba"+errorThrown);
              }
          });
        }
        /*marker.setIcon(icons['mark-selected']);
        if (currentPlace) {
          currentPlace.setIcon(icons['marker']);
          info.animate(
            { display: 'none' },
            { complete: function() {
              if (hidingMarker != marker) {
                slideIn(marker);
              } else {
                currentPlace = null;
              }
            }}
          );
        } else {
          slideIn(marker);
        }
        currentPlace = marker;*/
      });

     });

