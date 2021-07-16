//  EDIT POINT MAP
function edit_point_map(lat,lng,id) {

    // Creating map options
    var mapOptions = {
        center: [lat, lng],
        zoom: 16
    };

    // Creating a map object
    var map = new L.map(id, mapOptions);
    // Creating a Layer object
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    // Adding layer to the map
    map.addLayer(layer);

    // show old point
    var  marker='';
    marker=L.marker([lat, lng]).addTo(map);
    document.getElementById('deleteposition').classList.remove('d-none');
    document.getElementById('deleteposition').classList.add('d-block');

    map.on('click', function(ev) {
        var lat=ev.latlng.lat;
        var lang=ev.latlng.lng;
        if (marker!=='')
        {
            marker.setLatLng(ev.latlng);
        }
        else
        {
            marker=L.marker([lat, lang]).addTo(map);
            document.getElementById('deleteposition').classList.remove('d-none');
            document.getElementById('deleteposition').classList.add('d-block');
        }

        document.getElementById('lat').value=lat;
        document.getElementById('lng').value=lang;

        document.getElementById('deleteposition').onclick=function () {
            document.getElementById('deleteposition').classList.remove('d-block');
            document.getElementById('deleteposition').classList.add('d-none');
            map.removeLayer(marker);
            marker='';
        }
    });
}

// ADD POINT MAP
function add_point_map(lat,lng,id,zoom) {

    // Creating map options
    var mapOptions = {
        center: [lat, lng],
        zoom: zoom
    };

    // Creating a map object
    var map = new L.map('map', mapOptions);
    // Creating a Layer object
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    // Adding layer to the map
    map.addLayer(layer);


    var  marker='';

    map.on('click', function(ev) {
        var lat=ev.latlng.lat;
        var lang=ev.latlng.lng;
        if (marker!=='')
        {
            marker.setLatLng(ev.latlng);
        }
        else
        {
            marker=L.marker([lat, lang]).addTo(map);
            document.getElementById('deleteposition').classList.remove('d-none');
            document.getElementById('deleteposition').classList.add('d-block');
        }

        document.getElementById('lat').value=lat;
        document.getElementById('lng').value=lang;

        document.getElementById('deleteposition').onclick=function () {
            document.getElementById('deleteposition').classList.remove('d-block');
            document.getElementById('deleteposition').classList.add('d-none');
            map.removeLayer(marker);
            marker='';
        }
    });

}

//  SHOW POINT MAP
function show_map(lat,lng,id) {

    var mapOptions = {
        center: [lat, lng],
        zoom: 16
    };

    // Creating map for xl-lg
    var map = new L.map(id, mapOptions);
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);
    var marker=L.marker([lat, lng]).addTo(map);
}

//  CHANGE VIEW MAP
function set_view(parent,type,zoom,id) {

    $.ajax({
        url:'/Api/getLocation',
        method:'post',
        data:{id:parent.value,type:type},
        dataType:'json',
        success:function (data) {

            document.getElementById(id).innerHTML = '<div id="map" class="col-12" style="height: 300px"></div>';
            add_point_map(data['lat'],data['lng'],'map',zoom);
        }
    });
}


