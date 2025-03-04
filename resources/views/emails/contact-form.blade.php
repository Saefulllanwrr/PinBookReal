@component('mail::message')
    # Pesan Baru dari Form Kontak

    Anda menerima pesan baru dari form kontak PinBook. Berikut detailnya:

    @component('mail::panel')
        **Nama:** {{ $data['name'] }}
        **Email:** {{ $data['email'] }}
        **Pesan:**
        {{ $data['message'] }}
    @endcomponent

    Terima kasih,
    {{ config('app.name') }}
@endcomponent
