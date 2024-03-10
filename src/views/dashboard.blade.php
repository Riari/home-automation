@include('partials.header', ['pageTitle' => "Dashboard"])

<div class="flex items-center justify-center h-screen">
    <div class="bg-neutral-100 text-zinc-800 rounded-lg border shadow-lg p-10">
        @if ($flashSuccess)
            @include('partials.message-success', ['message' => $flashSuccess])
        @endif
        @if ($flashError)
            @include('partials.message-error', ['message' => $flashError])
        @endif

        <h1 class="font-bold">Quick actions</h1>
        <ul>
            <li>
                <a href="https://api.meethue.com/v2/oauth2/authorize?client_id={{ $hueClientId }}&response_type=code&state={{ $hueState }}">
                    Authorize Hue
                </a>
            </li>
        </ul>
    </div>
</div>

@include('partials.footer')