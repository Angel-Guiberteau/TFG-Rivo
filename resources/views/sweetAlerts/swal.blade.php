@if (session('success'))
    <div class="rivo-alert alert-success">
        <span class="rivo-alert-icon succes"><i class="fas fa-check-circle"></i></span>
        <span class="rivo-alert-text">{{ session('success') }}</span>
        <button type="button" class="rivo-alert-close" onclick="this.parentElement.remove();">&times;</button>
    </div>
@else
    @if (session('error'))
        <div class="rivo-alert alert-error">
            <span class="rivo-alert-icon error"><i class="fas fa-times-circle"></i></span>
            <span class="rivo-alert-text">{{ session('error') }}</span>
            <button type="button" class="rivo-alert-close" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @endif
@endif