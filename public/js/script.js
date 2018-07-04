/*$( document ).ready(function() {
    console.log("test")
    var btnContainer = document.getElementById("navbarmain");

// Get all buttons with class="btn" inside the container
    var btns = btnContainer.getElementsByClassName("nav-item");

// Loop through the buttons and add the active class to the current/clicked button
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
});
*/

$(document).ready(function() {
    //$('#datatablecategory').DataTable();

    var cityfromfield = $("#citydiv").text();

   // var url = "https://nominatim.openstreetmap.org/search.php?q="+city+"&polygon_geojson=1&viewbox=&format=json"
    var url = "https://nominatim.openstreetmap.org/search.php?q="+cityfromfield+"&viewbox=&format=json"

    $.ajax({
        url: url
    }).done(function(response) {
        var lat = response[0].lat;
        var lng = response[0].lon;

        var map = L.map('map').setView([lat, lng], 11);

        L.marker([lat, lng]).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    });

} );