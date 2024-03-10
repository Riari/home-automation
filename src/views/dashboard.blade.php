@include('partials.header', ['pageTitle' => "Greeting"])

<div class="flex items-center justify-center h-screen">
    <div class="bg-neutral-100 text-zinc-800 font-bold rounded-lg border shadow-lg p-10">
        <a href="https://api.meethue.com/v2/oauth2/authorize?client_id={{ $hueClientId }}&response_type=code&state={{ $hueState }}">
            Authorize Hue app
        </a>    
    </div>
</div>

@include('partials.footer')