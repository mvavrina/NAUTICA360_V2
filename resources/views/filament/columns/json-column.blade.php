@php
    // Assuming $column->getState($record) returns the JSON-encoded string.
    $roles = json_decode($column->getState($record), true); // Decode the JSON string into an array.
    $formattedRoles = is_array($roles) ? implode(', ', $roles) : 'No roles available';
@endphp

<span>{{ $formattedRoles }}</span>
