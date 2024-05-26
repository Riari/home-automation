@include('partials.header', ['pageTitle' => "Dashboard"])

<div class="flex items-center justify-center h-screen">
    <div class="bg-neutral-100 text-zinc-800 rounded-lg border shadow-lg p-7 w-96">
        @include('partials.messages')

        <h1 class="font-bold">Quick actions</h1>
        <form method="post" action="/admin/events/sleep/enable"><button type="submit">Enable sleep events</button></form>
        <form method="post" action="/admin/events/sleep/disable"><button type="submit">Disable sleep events</button></form>
        <ul>
            <li>
                <a href="https://api.meethue.com/v2/oauth2/authorize?client_id={{ $hueClientId }}&response_type=code&state={{ $hueState }}">
                    Authorize Hue
                </a>
            </li>
            <li>
                <a href="/admin/hue/devices">
                    List Hue devices
                </a>
            </li>
            <li>
                <a href="/admin/logout">
                    Log out
                </a>
            </li>
        </ul>
    </div>
</div>

@include('partials.footer')