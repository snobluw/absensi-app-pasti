<!--Side Bar-->
<aside id="sidebar">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand d-flex align-items-center p-3">
        <!-- Sidebar Logo -->
        <img src="/img/logo-sekolah.png" alt="ABSENSI GURU" class="brand-image" style="width: 40px;">
        <!-- Sidebar Text Brand -->
        <div class="fw-medium ps-3">
            MTS CAHAYA HARAPAN
        </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-nav p-0">

        <!-- Dashboard -->
        <div class="sidebar-item-group">
            <li class="sidebar-item">
                <a href="/dashboard" class="sidebar-link">
                    <i class="bi bi-speedometer2 me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </div>

        <!-- Section: Lainnya -->
        <div class="sidebar-menu-group">
            <li class="sidebar-header">Lainnya</li>

            <div class="sidebar-item-group">
                <li class="sidebar-item">
                    <a href="/absensi/create" class="sidebar-link">
                        <i class="bi bi-clipboard-check me-2"></i>
                        <span>Absensi</span>
                    </a>
                </li>
            </div>

            <div class="sidebar-item-group">
                <li class="sidebar-item">
                    <a href="/slip-gaji/{{ auth()->user()->guru->id }}" class="sidebar-link">
                        <i class="bi bi-cash-stack me-2"></i>
                        <span>Slip Gaji</span>
                    </a>
                </li>
            </div>

            <div class="sidebar-item-group">
                <li class="sidebar-item">
                    <a href="/pinjaman" class="sidebar-link">
                        <i class="bi bi-credit-card-2-front me-2"></i>
                        <span>Pinjaman</span>
                    </a>
                </li>
            </div>
        </div>

        <!-- Section: Akun -->
        <div class="sidebar-menu-group">
            <li class="sidebar-header">Akun</li>

            <div class="sidebar-item-group">
                <li class="sidebar-item">
                    <a href="/profile" class="sidebar-link">
                        <i class="bi bi-person-circle me-2"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </div>
        </div>
    </ul>
</aside>
