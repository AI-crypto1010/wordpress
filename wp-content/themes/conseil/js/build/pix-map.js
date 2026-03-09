// jQuery(document).ready(function($){
	//set your google maps parameters
	//google map custom marker icon - .png fallback for IE11
	var is_internetExplorer11= navigator.userAgent.toLowerCase().indexOf('trident') > -1;
	// var marker_url = ( is_internetExplorer11 ) ? 'img/cd-icon-location.png' : 'img/cd-icon-location.svg';

	//define the basic color of your map, plus a value for saturation and brightness
	// var	main_color = '#1274E7',
	// 	saturation_value= -40,
	// 	brightness_value= 5;
	//add custom buttons for the zoom-in/zoom-out on the map
	function CustomZoomControl(controlDiv, map, el) {
		// 1.grap the zoom elements from the DOM and insert them in the map
        // 2.Setup the click event listeners and zoom-in or out according to the clicked element
	  	var controlUIzoomIn,controlUIzoomOut;
		  
        if($(el).find('.pix-zoom-in').length){
            controlUIzoomIn= $(el).find('.pix-zoom-in')[0];
            controlDiv.appendChild(controlUIzoomIn);
            // google.maps.event.addEventListener(controlUIzoomIn, 'click', function() {
			$(controlUIzoomIn).on( 'click', function(e){
				map.setZoom(map.getZoom()+1);
			});
        }
        if($(el).find('.pix-zoom-out').length){
            controlUIzoomOut= $(el).find('.pix-zoom-out')[0];
            controlDiv.appendChild(controlUIzoomOut);
			$(controlUIzoomOut).on( 'click', function(e){
				map.setZoom(map.getZoom()-1);
			});
            // google.maps.event.addEventListener(controlUIzoomOut, 'click', function() {
            // google.maps.event.addListener(controlUIzoomOut, 'click', function() {
    		//     map.setZoom(map.getZoom()-1)
    		// });
        }

	}

    window.init_pix_maps = function(){
		if (typeof google === 'undefined') {
			console.log("undefinedundefined");
		    return false;
		}
        //inizialize the map
        $('.pix-google-map').each(function(i, el){


            var main_color = '#1274E7';
            if($(el).attr('data-color')){
                main_color = $(el).attr('data-color');
            }
            var saturation_value= -40,
    		      brightness_value= 5;

            var latitude = 45.739899,
          	     longitude = 4.818875,
          	     map_zoom = 14;

            if($(el).attr('data-latitude')){
                 latitude = $(el).attr('data-latitude');
             }
            if($(el).attr('data-longitude')){
                 longitude = $(el).attr('data-longitude');
             }
            if($(el).attr('data-map-zoom')){
                 map_zoom = $(el).attr('data-map-zoom');
             }
            if($(el).attr('data-saturation')){
                 saturation_value = $(el).attr('data-saturation');
             }
            if($(el).attr('data-brightness')){
                 brightness_value = $(el).attr('data-brightness');
             }

             var marker_url = '';
             if($(el).attr('data-marker')){
                  marker_url = $(el).attr('data-marker');
              }


             var style = 'custom';
             if($(el).attr('data-style')){
                  style = $(el).attr('data-style');
              }
             //we define here the style of the map
             var custom= [
         		{
         			//set saturation for the labels on the map
         			elementType: "labels",
         			stylers: [
         				{saturation: saturation_value}
         			]
         		},
         	    {	//poi stands for point of interest - don't show these lables on the map
         			featureType: "poi",
         			elementType: "labels",
         			stylers: [
         				{visibility: "off"}
         			]
         		},
         		{
         			//don't show highways lables on the map
         	        featureType: 'road.highway',
         	        elementType: 'labels',
         	        stylers: [
         	            {visibility: "off"}
         	        ]
         	    },
         		{
         			//don't show local road lables on the map
         			featureType: "road.local",
         			elementType: "labels.icon",
         			stylers: [
         				{visibility: "off"}
         			]
         		},
         		{
         			//don't show arterial road lables on the map
         			featureType: "road.arterial",
         			elementType: "labels.icon",
         			stylers: [
         				{visibility: "off"}
         			]
         		},
         		{
         			//don't show road lables on the map
         			featureType: "road",
         			elementType: "geometry.stroke",
         			stylers: [
         				{visibility: "off"}
         			]
         		},
         		//style different elements on the map
         		{
         			featureType: "transit",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "poi",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "poi.government",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		// {
         		// 	featureType: "poi.sport_complex",
         		// 	elementType: "geometry.fill",
         		// 	stylers: [
         		// 		{ hue: main_color },
         		// 		{ visibility: "on" },
         		// 		{ lightness: brightness_value },
         		// 		{ saturation: saturation_value }
         		// 	]
         		// },
         		{
         			featureType: "poi.attraction",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "poi.business",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "transit",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "transit.station",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "landscape",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]

         		},
         		{
         			featureType: "road",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "road.highway",
         			elementType: "geometry.fill",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		},
         		{
         			featureType: "water",
         			elementType: "geometry",
         			stylers: [
         				{ hue: main_color },
         				{ visibility: "on" },
         				{ lightness: brightness_value },
         				{ saturation: saturation_value }
         			]
         		}
         	];

            var styles = {
                standard: [],
                silver: [ { "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f5f5" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#ffffff" } ] }, { "featureType": "road.arterial", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#dadada" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#e5e5e5" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#eeeeee" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#c9c9c9" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] } ],
                retro: [ { "elementType": "geometry", "stylers": [ { "color": "#ebe3cd" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#523735" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f1e6" } ] }, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ { "color": "#c9b2a6" } ] }, { "featureType": "administrative.land_parcel", "elementType": "geometry.stroke", "stylers": [ { "color": "#dcd2be" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#ae9e90" } ] }, { "featureType": "landscape.natural", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#93817c" } ] }, { "featureType": "poi.park", "elementType": "geometry.fill", "stylers": [ { "color": "#a5b076" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#447530" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#f5f1e6" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#fdfcf8" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#f8c967" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#e9bc62" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry", "stylers": [ { "color": "#e98d58" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry.stroke", "stylers": [ { "color": "#db8555" } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#806b63" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "transit.line", "elementType": "labels.text.fill", "stylers": [ { "color": "#8f7d77" } ] }, { "featureType": "transit.line", "elementType": "labels.text.stroke", "stylers": [ { "color": "#ebe3cd" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [ { "color": "#b9d3c2" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#92998d" } ] } ],
                dark: [ { "elementType": "geometry", "stylers": [ { "color": "#212121" } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#212121" } ] }, { "featureType": "administrative", "elementType": "geometry", "stylers": [ { "color": "#757575" } ] }, { "featureType": "administrative.country", "elementType": "labels.text.fill", "stylers": [ { "color": "#9e9e9e" } ] }, { "featureType": "administrative.land_parcel", "stylers": [ { "visibility": "off" } ] }, { "featureType": "administrative.locality", "elementType": "labels.text.fill", "stylers": [ { "color": "#bdbdbd" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#181818" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "poi.park", "elementType": "labels.text.stroke", "stylers": [ { "color": "#1b1b1b" } ] }, { "featureType": "road", "elementType": "geometry.fill", "stylers": [ { "color": "#2c2c2c" } ] }, { "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "color": "#8a8a8a" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#373737" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#3c3c3c" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry", "stylers": [ { "color": "#4e4e4e" } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#616161" } ] }, { "featureType": "transit", "elementType": "labels.text.fill", "stylers": [ { "color": "#757575" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#000000" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#3d3d3d" } ] } ],
                night: [ { "elementType": "geometry", "stylers": [ { "color": "#242f3e" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#746855" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#242f3e" } ] }, { "featureType": "administrative.locality", "elementType": "labels.text.fill", "stylers": [ { "color": "#d59563" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#d59563" } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#263c3f" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#6b9a76" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#38414e" } ] }, { "featureType": "road", "elementType": "geometry.stroke", "stylers": [ { "color": "#212a37" } ] }, { "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "color": "#9ca5b3" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#746855" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#1f2835" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#f3d19c" } ] }, { "featureType": "transit", "elementType": "geometry", "stylers": [ { "color": "#2f3948" } ] }, { "featureType": "transit.station", "elementType": "labels.text.fill", "stylers": [ { "color": "#d59563" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#17263c" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#515c6d" } ] }, { "featureType": "water", "elementType": "labels.text.stroke", "stylers": [ { "color": "#17263c" } ] } ],
                aubergine: [ { "elementType": "geometry", "stylers": [ { "color": "#1d2c4d" } ] }, { "elementType": "labels.text.fill", "stylers": [ { "color": "#8ec3b9" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#1a3646" } ] }, { "featureType": "administrative.country", "elementType": "geometry.stroke", "stylers": [ { "color": "#4b6878" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#64779e" } ] }, { "featureType": "administrative.province", "elementType": "geometry.stroke", "stylers": [ { "color": "#4b6878" } ] }, { "featureType": "landscape.man_made", "elementType": "geometry.stroke", "stylers": [ { "color": "#334e87" } ] }, { "featureType": "landscape.natural", "elementType": "geometry", "stylers": [ { "color": "#023e58" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#283d6a" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#6f9ba5" } ] }, { "featureType": "poi", "elementType": "labels.text.stroke", "stylers": [ { "color": "#1d2c4d" } ] }, { "featureType": "poi.park", "elementType": "geometry.fill", "stylers": [ { "color": "#023e58" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#3C7680" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#304a7d" } ] }, { "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "color": "#98a5be" } ] }, { "featureType": "road", "elementType": "labels.text.stroke", "stylers": [ { "color": "#1d2c4d" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#2c6675" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#255763" } ] }, { "featureType": "road.highway", "elementType": "labels.text.fill", "stylers": [ { "color": "#b0d5ce" } ] }, { "featureType": "road.highway", "elementType": "labels.text.stroke", "stylers": [ { "color": "#023e58" } ] }, { "featureType": "transit", "elementType": "labels.text.fill", "stylers": [ { "color": "#98a5be" } ] }, { "featureType": "transit", "elementType": "labels.text.stroke", "stylers": [ { "color": "#1d2c4d" } ] }, { "featureType": "transit.line", "elementType": "geometry.fill", "stylers": [ { "color": "#283d6a" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#3a4762" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#0e1626" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#4e6d70" } ] } ],
                custom: custom
            };



            //set google map options
        	var map_options = {
              	center: new google.maps.LatLng(latitude, longitude),
              	zoom: Number(map_zoom),
              	panControl: false,
              	zoomControl: false,
              	mapTypeControl: false,
              	streetViewControl: false,
              	mapTypeId: google.maps.MapTypeId.ROADMAP,
              	scrollwheel: false,
              	styles: styles[style],
            }

            var map = new google.maps.Map($(el).find('.google-container')[0], map_options);

            //add a custom marker to the map
            if(marker!=''){
                if(marker!='none'){
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map,
                        visible: true,
                        icon: marker_url,
                    });
                }
            }else{
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitude, longitude),
                    map: map,
                    visible: true
                });
            }

            var zoomControlDiv = document.createElement('div');
            var zoomControl = new CustomZoomControl(zoomControlDiv, map, el);

            //insert the zoom div on the top left of the map
            map.controls[google.maps.ControlPosition.LEFT_TOP].push(zoomControlDiv);
        });
    }


// });
