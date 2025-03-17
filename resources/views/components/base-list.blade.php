<div class="container mx-auto my-20">
    <h2 class="text-center mb-10">Seznam marín</h2>
    <table class="min-w-full bg-white border border-gray-300 mt-4 overflow-x-scroll">
        <thead>
            <tr class="text-left">
                <th class="border p-2">Name</th>
                <th class="border p-2">City</th>
                <th class="border p-2">Country</th>
                <th class="border p-2">Address</th>
                <th class="border p-2">Latitude</th>
                <th class="border p-2">Longitude</th>
                <th class="border p-2">Sailing Areas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bases as $base)
                <tr>
                    <td class="border p-2"><a href="{{route('Detail maríny', $base->id)}}">{{$base->name}}</a></td>
                    <td class="border p-2">{{ $base->city }}</td>
                    <td class="border p-2">{{ $base->country }}</td>
                    <td class="border p-2">{{ $base->address }}</td>
                    <td class="border p-2">{{ $base->latitude }}</td>
                    <td class="border p-2">{{ $base->longitude }}</td>
                    <td class="border p-2">
                        @php
                            $sailingAreaIds = json_decode($base->sailingAreas, true);
                        @endphp
                        @if (is_array($sailingAreaIds))
                            {{ implode(', ', array_map(fn($id) => $sailingAreas[$id] ?? $id, $sailingAreaIds)) }}
                        @else
                            {{ $base->sailingAreas }}
                        @endif
                    </td>    
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $bases->links() }}
    </div>
    
    <!-- Map Display -->
    <div id="map" class="w-full h-96 mt-6"></div>


    <script>
        const locations = [
    { lat: -31.56391, lng: 147.154312 },
    { lat: -33.718234, lng: 150.363181 },
    { lat: -33.727111, lng: 150.371124 },
    { lat: -33.848588, lng: 151.209834 },
    { lat: -33.851702, lng: 151.216968 },
    { lat: -34.671264, lng: 150.863657 },
    { lat: -35.304724, lng: 148.662905 },
    { lat: -36.817685, lng: 175.699196 },
    { lat: -36.828611, lng: 175.790222 },
    { lat: -37.75, lng: 145.116667 },
    { lat: -37.759859, lng: 145.128708 },
    { lat: -37.765015, lng: 145.133858 },
    { lat: -37.770104, lng: 145.143299 },
    { lat: -37.7737, lng: 145.145187 },
    { lat: -37.774785, lng: 145.137978 },
    { lat: -37.819616, lng: 144.968119 },
    { lat: -38.330766, lng: 144.695692 },
    { lat: -39.927193, lng: 175.053218 },
    { lat: -41.330162, lng: 174.865694 },
    { lat: -42.734358, lng: 147.439506 },
    { lat: -42.734358, lng: 147.501315 },
    { lat: -42.735258, lng: 147.438 },
    { lat: -43.999792, lng: 170.463352 },
  ];


    </script>
</div>