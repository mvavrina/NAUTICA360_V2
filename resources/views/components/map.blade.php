@props(['latitude', 'longtitude', 'name', 'address' => null])
@if (!empty($latitude) && !empty($longtitude))
<div id="map" class="w-full h-96 mt-6 rounded-lg shadow-lg"></div>

<script>
    function initMap() {
            var baseLocation = { lat: {{ $latitude }}, lng: {{ $longtitude }} };

            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: baseLocation,
            });

            var marker = new google.maps.Marker({
                position: baseLocation,
                map: map,
                title: "{{ $name }}"
            });
        }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('app.mapKey')}}&callback=initMap">
</script>
@elseif (!empty($address))
<div id="map" class="w-full h-96 mt-6 rounded-lg shadow-lg"></div>
    <script>
        function initMap() {
            var baseLocation;

            // Use geocoding for the address
            var geocoder = new google.maps.Geocoder();
            var address = "{{ $address }}";
            geocoder.geocode({ 'address': address }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    baseLocation = results[0].geometry.location;

                    // Initialize the map
                    var map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: baseLocation,
                    });

                    // Add a marker at the address location
                    var marker = new google.maps.Marker({
                        position: baseLocation,
                        map: map,
                        title: "{{ $name }}"
                    });
                } else {
                    console.log("Geocode was not successful for the following reason: " + status);
                }
            });
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('app.mapKey') }}&callback=initMap"></script>

@endif