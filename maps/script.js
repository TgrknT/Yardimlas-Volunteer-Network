function initMap() {
    var mapOptions = {
        center: { lat: 39.9334, lng: 32.8597 }, // Türkiye'nin merkezi (Ankara)
        zoom: 6,
        zoomControl: true, // Sadece büyütme kontrolünü etkinleştir
        mapTypeControl: false, // Harita tipi kontrolünü devre dışı bırak
        scaleControl: false, // Ölçek kontrolünü devre dışı bırak
        streetViewControl: false, // Street View kontrolünü devre dışı bırak
        rotateControl: false, // Döndürme kontrolünü devre dışı bırak
        fullscreenControl: false // Tam ekran kontrolünü devre dışı bırak
    };

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var locations = [
        { title: "Yatak İhtiyacı", lat: 40.1828, lng: 29.0666, content: "İhtiyacı İncele" },
        { title: "Yatak İhtiyacı", lat: 40.1828, lng: 29.0666, content: "İhtiyacı İncele" },
        { title: "Yatak İhtiyacı", lat: 39.1828, lng: 29.0666, content: "İhtiyacı İncele" },
        { title: "Yatak İhtiyacı", lat: 80.1828, lng: 29.0666, content: "İhtiyacı İncele" }
    ];

    locations.forEach(location => {
        var marker = new google.maps.Marker({
            position: { lat: location.lat, lng: location.lng },
            map: map,
            title: location.title
        });

        var infowindow = new google.maps.InfoWindow({
            content: `<div style="width:150px; text-align:center;">
                        <h3>${location.title}</h3>
                        <p><a href="#">${location.content}</a></p>
                      </div>`
        });

        marker.addListener("click", function() {
            infowindow.open(map, marker);
        });
    });
}
