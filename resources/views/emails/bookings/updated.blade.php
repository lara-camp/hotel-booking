@component('mail::message')
# Booking Confirmation

Dear {{ $name }},

We are delighted to confirm your booking with us. Below are the details of your reservation:

**Guest Name:** {{ $reservation->guest_name }}  
**Room Number:** {{ $reservation->rooms->pluck('room_number')->implode(', ') }}  
**From Date:** {{ $reservation->from_date }}  
**To Date:** {{ $reservation->to_date }}  
**Total Guests:** {{ $reservation->total_person }}  
**Total Price:** ${{ $reservation->total_price }}  

Thank you for choosing to stay with us! If you have any special requests or need assistance during your stay, please don't hesitate to contact our front desk.

Safe travels, and we look forward to welcoming you soon.

Warm regards,  
The Hotel Team


@endcomponent