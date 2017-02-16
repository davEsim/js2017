
	var customIcons = {
      cinema: {
        icon: 'https://www.jedensvet.cz/dev/imgs/icons/marker.png',
        shadow: 'https://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      bar: {
        icon: 'https://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'https://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(49.881048, 15.760234),
        zoom: 7,
        mapTypeId: 'terrain'
      });
	  var styles = [
		{
		  stylers: [
			{ hue: "#0099ff" },
			{ saturation: -100 }
		  ]
		}
	  ];

	  map.setOptions({styles: styles});
      var infoWindow = new google.maps.InfoWindow;
	 	
      // Change this depending on the name of your PHP file
      downloadUrl("https://www.jedensvet.cz/dev/php/ext/googleMapsXML.php", function(data) {

        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address;
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            shadow: icon.shadow
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
	  
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}