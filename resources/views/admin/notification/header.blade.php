<ul class="nav nav-tabs nav-fill border-primary" role="tablist">
    <li class="nav-item">
        <a class="nav-link @if (Route::current()->getName() == 'admin.settings.mail.index') active @endif" id="system-tab"
            href="{{ route('admin.settings.mail.index') }}" aria-controls="system" aria-controls="system">General
            Template</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::current()->getName() == 'admin.settings.mail.templates') active @endif" id="templates-tab"
            href="{{ route('admin.settings.mail.templates') }}" aria-controls="templates"
            aria-controls="templates">Templates</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::current()->getName() == 'admin.settings.mail.email') active @endif" id="dashboard-tab"
            href="{{ route('admin.settings.mail.email') }}" aria-controls="dashboard" aria-controls="system">Email
            Settings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::current()->getName() == 'admin.settings.mail.sms') active @endif" id="trading-tab"
            href="{{ route('admin.settings.mail.sms') }}" aria-controls="trading" aria-controls="system">SMS
            Settings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::current()->getName() == 'admin.settings.mail.push') active @endif" id="wallet-tab"
            href="{{ route('admin.settings.mail.push') }}" aria-controls="wallet" aria-controls="system">Push
            Notification Settings</a>
    </li>
</ul>
