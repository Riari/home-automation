@if (isset($flashSuccess) && !empty($flashSuccess))
    @include('partials.message-success', ['message' => $flashSuccess])
@endif
@if (isset($flashError) && !empty($flashError))
    @include('partials.message-error', ['message' => $flashError])
@endif
@if (isset($flashWarning) && !empty($flashWarning))
    @include('partials.message-warning', ['message' => $flashWarning])
@endif