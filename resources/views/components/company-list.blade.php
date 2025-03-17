<div class="container mx-auto my-20">
    <h2 class="text-center mb-10">Seznam společností</h2>
    <table class="min-w-full bg-white border border-gray-300 mt-4 overflow-x-scroll">
        <thead>
            <tr class="text-left">
                <th class="border p-2">Name</th>
                <th class="border p-2">Address</th>
                <th class="border p-2">City</th>
                <th class="border p-2">Zip</th>
                <th class="border p-2">Country</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td class="border p-2"><a href="{{route('Detail společnosti', $company->id)}}">{{$company->name}}</a></td>
                    <td class="border p-2">{{ $company['address'] }}</td>
                    <td class="border p-2">{{ $company['city'] }}</td>
                    <td class="border p-2">{{ $company['zip'] }}</td>
                    <td class="border p-2">{{ $company['country'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $companies->links() }}
    </div>
</div>
