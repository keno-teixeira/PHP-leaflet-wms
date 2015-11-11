<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';
// leaflet
require_once '../includes/libleaflet.php';
?>

<div id="main" style="overflow:hidden"> 
	<div id="Gmap"></div> 
</div> 

<script>
/////////////////////////////////////////////////////////////////////////
/////////////////  variaveis   /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////

var server = "http://10.233.34.6/geoserver/wms";
var server1 = "http://10.233.34.5:8080/geoserver/gwc/service/wms";
var propiedade = "";

/////////////////////////////////////////////////////////////////////////
/////////////////  definição de escala principal   /////////////////////
///////////////////////////////////////////////////////////////////////

//var map = L.map('Gmap').setView([-15.79969,-47.83584], 11);
var map = new L.Map('Gmap', {
			center: new L.LatLng(-15.79969,-47.83584),
			zoom: 11,
			fullscreenControl: true,
			fullscreenControlOptions: { // optional
				title:"fullscreen"
			}
		});

/////////////////////////////////////////////////////////////////////////
/////////////////  chamada de base maps   //////////////////////////////
///////////////////////////////////////////////////////////////////////

basemap = L.tileLayer.wms( server, {
	layers: 'basemap:CATALOGO_FOTO_AEREA_20091',
	format: 'image/jpeg',
	version: '1.3.0',
	zoom: 11,
	minZoom: 11,
	maxZoom:18,
	tiled:true
}).addTo(map);

basemap2 = L.tileLayer.wms(server, {
	layers: 'basemap:FOTO_area_2013',
	format: 'image/jpeg',
	version: '1.3.0',
	zoom: 11,
	minZoom: 11,
	maxZoom:18,
	tiled:true
});

/////////////////////////////////////////////////////////////////////////
/////////////////  chamadas de layers   ////////////////////////////////
///////////////////////////////////////////////////////////////////////

<?php
$usuarios = new Usuarios();
$layers = $usuarios->buscaLayersNomes($_SESSION['id']);

$chamada = "";

foreach($layers as $layer){
	$chamada .= str_replace(" ", "_", $layer["nome"]) . ' = L.tileLayer.wms(server,'; 
		$chamada .= '{';
		$chamada .=	'layers: \''. $layer["workspace"] . ':' . $layer["nome"] .'\',';
		$chamada .= 'format: \'image/png\',';
		$chamada .= 'transparent: true,';
		$chamada .= 'tiled: true,';
		$chamada .= 'minZoom: 11,';
		$chamada .= 'maxZoom: 18';
		$chamada .= '});';
}

echo $chamada;

?>

/////////////////////////////////////////////////////////////////////////
/////////////////  bloco controle de layers   //////////////////////////
///////////////////////////////////////////////////////////////////////

var baseLayers = {
	"FOTO AEREA 2009": basemap,
	"FOTO AEREA 2013": basemap2       
};

var overlays = {
	<?php
	$lista = array();

	foreach($layers as $layer):
		$lista[] = "\"layer " . $layer["nome"] . "\":" . str_replace(" ", "_", $layer["nome"]);
	endforeach;

	echo implode(',', $lista);
	?>
};

L.control.layers(baseLayers, overlays).addTo(map);
L.control.scale().addTo(map);

/////////////////////////////////////////////////////////////////////////
///////////////// bloco draw (ferramentas de desenho)   ////////////////
///////////////////////////////////////////////////////////////////////

var src = new Proj4js.Proj('EPSG:4326');
var dst = new Proj4js.Proj('EPSG:31983');

var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Set the title to show on the polygon button
    L.drawLocal.draw.toolbar.buttons.polygon = 'Desenhe um polígono';

    var drawControl = new L.Control.Draw({
        position: 'topleft',
        draw: {
            polyline: {
                shapeOptions: {
                    color: 'blue'                    
                }
            },
            rectangle: {
                shapeOptions: {
                    color: '#5C5DBF'                    
                }
            },
            polygon: {
                allowIntersection: false,
                showArea: true,
                drawError: {
                    color: 'red',
                    timeout: 1000
                },
                shapeOptions: {
                    color: 'red'
                }
            },
            circle: true
        },
        edit: {
				featureGroup: drawnItems,
				remove: true
			}
    });
    map.addControl(drawControl);
    
    map.on('draw:created', function (e) {updatePopup(e)});
    
    map.on('draw:edited', function (e) {
        var layers = e.layers;
        var countOfEditedLayers = 0;
        layers.eachLayer(function(layer) {
            countOfEditedLayers++;
        });
        //console.log("Edited " + countOfEditedLayers + " layers");
    });

//  #############################################
//  @@@@@@@@@@@@   barra lag long  @@@@@@@@@@@
//  #############################################
	//add standard controls
		L.control.coordinates().addTo(map);

//  #############################################
//  @@@@@@@@@@@@   botao FULLscreem  @@@@@@@@@@@
//  #############################################
		// detect fullscreen toggling
		map.on('enterFullscreen', function(){
			if(window.console) window.console.log('enterFullscreen');
		});
		map.on('exitFullscreen', function(){
			if(window.console) window.console.log('exitFullscreen');
		});


//  #############################################
//  @@@@@@@@@@@@   query com o click  @@@@@@@@@@@
//  #############################################
	var rootURL = 'http://10.233.34.2:8080';
    
     var lOverlays = {};

    //Set up trigger functions for adding layers to interactivity.
    map.on('overlayadd', function(e) {
        updateInteractiveLayers(e.layer.options.layers);
    }); 
    map.on('overlayremove', function(e) {
        updateInteractiveLayers(e.layer.options.layers);
    }); 

    var intLayers = [];
    var intLayersString = "";
    function updateInteractiveLayers(layer) {
        if(layer !== "layers:conjunto") { //exclude this layer...
            var index = $.inArray(layer, intLayers);
            if(index > -1) {
                intLayers.splice(index,1);
            } else {
                intLayers.push(layer);
            }
            intLayersString = intLayers.join();
        }
    };

    function handleJson(data) {
        selectedFeature = L.geoJson(data, {
            style: function (feature) {
                return {color: 'yellow'};
            },
            onEachFeature: function (feature, layer) {
                var content = "";
                content = content + "<b><u>" + feature.id.split('.')[0] + "</b></u><br>";
                delete feature.properties.bbox;
                for (var name in feature.properties) {content = content + "<b>" + name + ":</b> " + feature.properties[name] + "<br>"};
                var popup = L.popup()
                    .setLatLng(queryCoordinates)
                    .setContent(content)
                    .openOn(map);
                layer.bindPopup(content);
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight
                });
            },                
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, {
                    radius: 5,
                    fillColor: "yellow",
                    color: "#000",
                    weight: 5,
                    opacity: 0.6,
                    fillOpacity: 0.2
                });
            }
        });
        selectedFeature.addTo(map);
    }

    //Query layer functionality.
    var selectedFeature;
    var queryCoordinates;
    var src = new Proj4js.Proj('EPSG:4326');
    var dst = new Proj4js.Proj('EPSG:31983'); 

    map.on('click', function(e) {
        if (selectedFeature) {
            map.removeLayer(selectedFeature);
        };
        var owsrootUrl = rootURL + '/geoserver/ows';
        
        var p = new Proj4js.Point(e.latlng.lng,e.latlng.lat);
        Proj4js.transform(src, dst, p);
        queryCoordinates = e.latlng;
        
        var defaultParameters = {
            service : 'WFS',
            version : '1.1.1',
            request : 'GetFeature',
            typeName : 'layers:conjunto,layers:lote',
            outputFormat : 'text/javascript',
            format_options : 'callback:getJson',
            SrsName : 'EPSG:4326'
        };

       
        var customParams = {
           //bbox : map.getBounds().toBBoxString(),
            //cql_filter:'DWithin(geom, POINT(' + p.x + ' ' + p.y + '), 10, meters)'
            cql_filter:'DWithin(shape, POINT(' + p.x + ' ' + p.y + '), 10, meters)'
        };

        //console.log(customParams);

        var parameters = L.Util.extend(defaultParameters, customParams);
        //var parameters = L.Util.extend(defaultParameters, BBOX);
         //console.log(parameters);

        var url = owsrootUrl + L.Util.getParamString(parameters)
        //console.log(url);

        $.ajax({
            url : owsrootUrl + L.Util.getParamString(parameters),
            dataType : 'jsonp',
            jsonpCallback : 'getJson',
            success : handleJson
        });
    });

    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({
            fillColor: "yellow",
            color: "yellow",
            weight: 5,
            opacity: 1
        });

        if (!L.Browser.ie && !L.Browser.opera) {
            layer.bringToFront();
        }
    }

    function resetHighlight(e) {
        var layer = e.target;
        layer.setStyle({
            radius: 5,
            fillColor: "yellow",
            color: "yellow",
            weight: 5,
            opacity: 0.6,
            fillOpacity: 0.2
        });
    }
</script>

<!--
///////////////////////////////////////////////////////////////////////// 
//////////     JAVASCRIPT/CORE      ////////////////////////////////////
///////////////////////////////////////////////////////////////////////
-->
<?php require_once '../includes/core.php'; ?>
<!--
/////////////////////////////////////////////////////////////////////////
////////////////// drag control painel /////////////////////////////////
///////////////////////////////////////////////////////////////////////
-->
<script type="text/javascript">
	$(document).ready(function(){
		$(function() {
			$( ".leaflet-control-layers-overlays" ).sortable({
				opacity: 0.6, cursor: 'pointer',
				start: function(event, ui) {
					ui.item.startPos = ui.item.index();
				},
				opacity: 0.6, cursor: 'pointer',
				stop: function(event, ui) {
					var start = ui.item.startPos;
					var finish = ui.item.index();

					start = start+3;
					finish = finish+3;

					$(".leaflet-tile-pane .leaflet-layer").each(function( index ) {
						if(start<finish){
							if( $( this ).css('z-index') == start){
								$( this ).css('z-index',finish);
							}
							else if( $( this ).css('z-index') <= finish && $( this ).css('z-index') != 1 ){
								if( $( this ).css('z-index') != 3 ){
									var nova = $( this ).css('z-index') - 1;
									$( this ).css('z-index',nova);
								}
							}
						}
						if(start>finish){
							if( $( this ).css('z-index') == start){
								$( this ).css('z-index',finish);
							}
							else if( $( this ).css('z-index') >= finish && $( this ).css('z-index') != 1 ){
								var nova1 = $( this ).css('z-index');
								nova1 = parseInt( nova1);
								nova1 = nova1+1;
								$( this ).css('z-index',nova1);
							}
						}
					});
					start = 0;
					finish =0;
				}
			});
		});
	});
</script>
<?php require_once '../includes/footer.php'; ?>