// Initialize and add the map
function initMap() {
    // The location of Hospital
    const hospitalLocation = { lat: 11.028512768446078, lng: 77.13410448300769 };
    // The map, centered at Hospital
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: hospitalLocation,
    });
    // The marker, positioned at Hospital
    const marker = new google.maps.Marker({
        position: hospitalLocation,
        map: map,
    });
}