@component('mail::message')
# Booking Confirmation

Dear {{ $name }},

We are delighted to confirm your booking with us. Below are the details of your reservation:

**Guest Name:** {{ $reservation->guest_name }}<br/>
**Room Number:** {{ $reservation->rooms->pluck('room_number')->implode(', ') }}<br/>
**From Date:** {{ $reservation->from_date }}<br/>
**To Date:** {{ $reservation->to_date }}<br/>
**Total Guests:** {{ $reservation->total_person }}<br/>
**Total Price:** ${{ $reservation->total_price }}<br/>

Thank you for choosing to stay with us! If you have any special requests or need assistance during your stay, please don't hesitate to contact our front desk.

Safe travels, and we look forward to welcoming you soon.

Warm regards,<br>
The Hotel Team

@endcomponent
