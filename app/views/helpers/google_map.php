<?php
/*
 * CakeMap -- a google maps integrated application built on CakePHP framework.
 * Based on initial versione from Garrett J. Woodworth : gwoo@rd11.com
 * Rewritten by  : http://www.small-software-utilities.com
 *
 * @author      info@small-software-utilities.com
 * @version     0.2
 * @license     OPPL
 *
 * Modified by     Mahmoud Lababidi <lababidi@bearsontherun.com>
 * Date        Dec 16, 2006
 * Rewritten by small software utilities <info@small-software-utilities.com>
 * Date        May, 2010
 */

class GoogleMapHelper extends Helper {

    var $errors = array();
    var $key = "your key here, not needed for v3";
    var $url ="http://maps.google.com/maps/api/js?sensor=false";

	function map($default, $style = 'width: 400px; height: 400px' )
    {
        
		
		//if (empty($default)){return "error: You have not specified an address to map"; exit();}
        $out = "<div id=\"map\"";
        $out .= isset($style) ? "style=\"".$style."\"" : null;
        $out .= " ></div>";
        $out .= "
        <script type=\"text/javascript\">
        //<![CDATA[
    var directionDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;
    var iconimage = \"http://labs.google.com/ridefinder/images/mm_20_red.png\";
         var iconshadow = \"http://labs.google.com/ridefinder/images/mm_20_shadow.png\";
         var myOptions = {
            zoom: ".$default['zoom'].",
            center: new google.maps.LatLng(".$default['lat'].", ".$default['long']."),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false
          };
      var map = new google.maps.Map(document.getElementById(\"map\"), myOptions);
      function cleardirs()
      {
          if(directionsDisplay)
              directionsDisplay.setMap(null);
          div = document.getElementById('".(isset($default['directions_div'])?$default['directions_div']:'directions_div')."');
          if(div)
              div.innerHTML = \"\";
      }
               ";
    if(isset($default['directions_div']))
            {
                $out .= "
				directionsDisplay = new google.maps.DirectionsRenderer();
              directionsDisplay.setMap(map);
              directionsDisplay.setPanel(document.getElementById('".$default['directions_div']."'));
              function calcRoute(fromid,tolat,tolon) {
              directionsDisplay.setMap(map);
                from = document.getElementById(fromid).value;
              var start = from;
              var end = new google.maps.LatLng(tolat,tolon);
              var request = {
                origin:start,
                destination:end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
              };
              directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(result);
                }
              });
}
                ";
            }
        $out .="
        //]]>
        </script>";
        return $out;
    }
    function addMarkers(&$data, $icon=null)
    {
        $out = "
            <script type=\"text/javascript\">
            //<![CDATA[
			var markerBounds = new google.maps.LatLngBounds();
            ";
            if(is_array($data))
            {
                $i = 0;
                foreach($data as $n=>$m){
                    $keys = array_keys($m);
                    $point = $m[$keys[0]];
                    if(!preg_match('/[^0-9\\.\\-]+/',$point['longitude']) &&
preg_match('/^[-]?(?:180|(?:1[0-7]\\d)|(?:\\d?\\d))[.]{1,1}[0-9]{0,15}/',$point['longitude'])
                        && !preg_match('/[^0-9\\.\\-]+/',$point['latitude']) &&
preg_match('/^[-]?(?:180|(?:1[0-7]\\d)|(?:\\d?\\d))[.]{1,1}[0-9]{0,15}/',$point['latitude']))
                    {
                        $out .= "
                            var point".$i." = new google.maps.LatLng(".$point['latitude'].",".$point['longitude'].");
                            var marker".$i." = new google.maps.Marker({
                                  position: point".$i.",
                      map: map,
                      title:\"".(isset($point['title'])?$point['title']:'')."\",
                      shadow: iconshadow,
                      icon: \"" . (isset($point['markerImage'])?$point['markerImage']:'iconimage') . "\",
                            });";
						//if(isset($point['title'])&&isset($point['html']))
                        if(isset($point['html']))
                        {
                           $out .= " var infowindow$i = new google.maps.InfoWindow({
                           content: \"$point[html]\"
                      		});
							google.maps.event.addListener(marker".$i.", 'click', function() {
															"; //, disableAutoPan:true
							for ($j = 0; $j< count($data); $j++){
								 $out .= "if (infowindow$j) infowindow" . $j .".close();
								 	";
							}
							$out .= "
								});
						    google.maps.event.addListener(marker".$i.", 'click', function() {
								infowindow$i.open(map,marker".$i.");
								});";
							}
							$data[$n][$keys[0]]['js']="marker$i.openInfoWindowHtml(marker$i.html);";
							$out .= "
								  markerBounds.extend(point". $i .");
							";
							$i++;
							
                    }
                }
				$out .= "map.setCenter(markerBounds.getCenter())
						map.fitBounds(markerBounds);";//, map.getBoundsZoomLevel(markerBounds));";
            }
        $out .=    "
                //]]>
            </script>";
        return $out;
    }
    function addClick($var, $script=null)
    {
        $out = "
            <script type=\"text/javascript\">
            //<![CDATA[
            $script
            google.maps.event.addListener(map, 'click', ".$var.", true);
            //]]>
            </script>";
        return $out;
    }
    function addMarkerOnClick($innerHtml = null)
    {
        $mapClick = '
            var mapClick = function (event) {
                var marker = new google.maps.Marker({
                position:event.latLng,
                icon: iconimage,
                map:map
                });
                var infowindow = new google.maps.InfoWindow({
            content: \"'.$innerHtml.'\"
        });
        google.maps.event.addListener(marker, \'click\', function() {
              infowindow.open(map,marker);
        });
            }
        ';
        return $this->addClick('mapClick', $mapClick);
    }
    function moveMarkerOnClick($lngctl, $latctl, $innerHtml = null)
    {
        $mapClick = '
            var mapClick = function (event) {
                marker0.setPosition(event.latLng);
                lngctl = document.getElementById(\''.$lngctl.'\');
                latctl = document.getElementById(\''.$latctl.'\');
                if(lngctl)
                 lngctl.value = event.latLng.lng();
                if(latctl)
                 latctl.value = event.latLng.lat();
            }
        ';
        return $this->addClick('mapClick', $mapClick);
    }

    function addClickInfo($var, $script=null)
    {
        $out = "
            <script type=\"text/javascript\">
            //<![CDATA[
            $script
            google.maps.event.addListener(infowindow0, 'mouseout', ".$var.", true);
            //]]>
            </script>";
        return $out;
    }
	 function closeMarkerOnClick()
	    {
	        $markerClick = '
	            var markerClick = function (event) {
	                infowindow0.close();
	            }
	        ';
	        return $this->addClickInfo('markerClick', $markerClick);
    }
}
?>