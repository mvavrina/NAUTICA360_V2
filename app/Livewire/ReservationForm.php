<?php

namespace App\Livewire;

use App\Mail\ReservationConfirmation;
use App\Models\Api\Yacht;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ReservationForm extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $tel;
    public $note;
    public $yacht;
    public $yacht_id;
    public $price;
    public $discount;
    public $base_price;
    public $date_from;
    public $date_to;

    public function mount($yacht_id, $date_from, $date_to, $price)
    {
        // Initialize the component with values from the URL or any other context
        $this->yacht_id = $yacht_id;
        $this->yacht = Yacht::where('id',$yacht_id)->with('images')->first();
        $this->date_from = Carbon::parse($date_from);
        $this->date_to = Carbon::parse($date_to);
        $this->price = $price;
        $this->discount = config('yacht.percentage_sale');
        $this->base_price = $price / (1 - ($this->discount / 100)); // Calculate base price
    }

    public function submit()
{
    // Validate the form input
    $this->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'tel' => 'required|string|max:15',
        'note' => 'nullable|string|max:1000',
    ]);

    // Create the reservation
    $reservation = Reservation::create([
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'email' => $this->email,
        'tel' => $this->tel,
        'note' => $this->note,
        'yacht_id' => $this->yacht_id,
        'price' => $this->price,
        'discount' => $this->discount,
        'reserved' => Carbon::now(),
        'base_price' => $this->base_price,
        'date_from' => $this->date_from,
        'date_to' => $this->date_to,
        'status' => 'pending', // or any other status you want
    ]);

    Mail::to($this->email)->send(new ReservationConfirmation($this->first_name, $this->last_name));

    // Provide feedback to the user
    session()->flash('message', 'Reservation successfully created!');

    // Redirect back to the yacht detail page
    return redirect()->route('yacht.detail', ['id' => $this->yacht_id]);  // Make sure you have the correct route name
}

    public function render()
    {
        return view('livewire.reservation-form');
    }
}
