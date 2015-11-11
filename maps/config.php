<?php
    const DB_HOST = '10.36.0.82';
    const DB_USER = 'keno.teixeira';
    const DB_PASSWORD = '15975312';
    const DB_DATABASE = 'mapabbcode'; // if empty, db is not used (increase MAX_CACHED then)
    const DB_TABLE = 'bbcode'; // for other tables this is the prefix
    const NEED_INIT_DB = true; // set to false after calling /initdb
    const BING_KEY = ''; // put your bing imagery key here
    const MAX_CACHED = 500; // number of files in cache directory
    const HASH_LENGTH = 5; // code hash
    const EDIT_HASH_LENGTH = 5; // hash for editing
    const MAX_IMPORT_NODES = 200; // nodes in imported gps traces
    const MAX_TOTAL_NODES = 1000; // total nodes in all imported gps traces
    const IMPORT_SINGLE = false; // clear map on import

    //const MOD_REWRITE = true; // set to explicit value if autodetection is wrong
    const OZI_CHARSET = 'CP1251'; // charset for OziExplorer formats, UTF-8 by default

    // define the default map position
    const DEFAULT_LAT = -15.79969;
    const DEFAULT_LNG = -47.83584;
    const DEFAULT_ZOOM = 11;

    // tile layers are configured as a line of Javascript 
    $TILE_LAYERS = array(
        'L.tileLayer.wms( "http://10.233.34.6/geoserver/wms" , {name: "CATALOGO FOTO AÉREA 2009", layers: \'basemap:CATALOGO_FOTO_AEREA_20091\',format: \'image/png\',version: \'1.3.0\',zoom: 11,minZoom: 11,maxZoom:18,tiled:true})',
        'L.tileLayer("http://openmapsurfer.uni-hd.de/tiles/roads/x={x}&y={y}&z={z}", { name: "OpenMapSurfer", attribution: \'Map &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> | Tiles &copy; <a href=\"http://giscience.uni-hd.de/\">GIScience Heidelberg</a>\', minZoom: 0, maxZoom: 18 })',
        'L.tileLayer("http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png", { name: "CycleMap", attribution: \'Map &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> | Tiles &copy; <a href=\"http://www.opencyclemap.org\">OpenCycleMap</a>\', minZoom: 0, maxZoom: 18 })',
        'MapBBCode.prototype.createOpenStreetMapLayer(L)',
        //'L.tileLayer("http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", { name: "MapQuest Open", attribution: \'Map &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />\', subdomains: "1234" } )',
        //'L.tileLayer("http://otile{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png", { name: "MapQuest Aerial", attribution: \'Imagery &copy; NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency, Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />\', subdomains: "1234" } )',
    );

    if( defined('BING_KEY') && strlen(BING_KEY) > 0 )
        $TILE_LAYERS[] = 'new L.BingLayer("'.BING_KEY.'", { name: "Bing Satellite" })';

    // set this to your timezone or whatever (doesn't really matter)
    date_default_timezone_set('UTC');

    // this locale is used for transliterating file names and unknown chars for ozi waypoints
    setlocale(LC_CTYPE, 'pt-br');