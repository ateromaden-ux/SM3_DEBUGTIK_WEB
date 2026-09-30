{{--
    Tab: Dasbor Utama
    Variabel: sudah disediakan oleh DashboardController (via @include dari dashboard-guru.blade.php)
--}}
<div id="view-dashboard" class="view-section">
    @include('components.dashboard.profile-banner')
    @include('components.dashboard.stats-grid')

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
        @include('components.dashboard.progress-students')
        @include('components.dashboard.manage-materials')
    </div>
</div>
