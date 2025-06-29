<!--Side Bar-->
<aside id="sidebar">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand d-flex">
        <!-- Sidebar Logo -->
        <img src="/img/logo-sekolah.png" alt="ABSENSI GURU" class="brand-image">
        <!-- Sidebar Text Brand -->
        <div class="fw-medium ps-3">
            MTS CAHAYA HARAPAN
        </div>
    </div>
    <!-- Sidebar Menu -->
    <ul class="sidebar-nav p-0">
        <!-- Sidebar Item Dashboard -->
        <div class="sidebar-item-group">
            <li class="sidebar-item">
                <a href="/dashboard" class="sidebar-link">
                    <i class="bi bi-ui-checks-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </div>
        <div class="sidebar-menu-group">
            <!-- Sidebar Header Master Data-->
            <li class="sidebar-header">
                Master Data
            </li>
            <div class="sidebar-item-group">
                
                @php
                $activeRoute = request()->path(); // e.g., 'guru', 'admin', etc.
                @endphp

                <!-- Sidebar Item Pengguna -->
                <li class="sidebar-item">
                    <a href="#"
                        class="sidebar-link has-dropdown {{ in_array($activeRoute, ['guru', 'admin']) ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" data-bs-target="#user"
                        aria-expanded="{{ in_array($activeRoute, ['guru', 'admin']) ? 'true' : 'false' }}"
                        aria-controls="user">
                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>
                    </a>
                    <ul id="user"
                        class="sidebar-dropdown list-unstyled collapse {{ in_array($activeRoute, ['guru', 'admin']) ? 'show' : '' }}">
                        <li class="sidebar-item">
                            <a href="/guru" class="sidebar-link {{ $activeRoute === 'guru' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i>
                                <span>Data Guru</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/admin" class="sidebar-link {{ $activeRoute === 'admin' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i>
                                <span>Data Admin</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Sidebar Item Absensi -->
                <li class="sidebar-item">
                    <a href="#"
                        class="sidebar-link has-dropdown {{ in_array($activeRoute, ['absensi-pilih-kategori', 'kategori-absensi']) ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" data-bs-target="#absensi"
                        aria-expanded="{{ in_array($activeRoute, ['absensi-pilih-kategori', 'kategori-absensi']) ? 'true' : 'false' }}"
                        aria-controls="absensi">
                        <i class="bi bi-card-checklist"></i>
                        <span>Absensi</span>
                    </a>
                    <ul id="absensi"
                        class="sidebar-dropdown list-unstyled collapse {{ in_array($activeRoute, ['absensi-pilih-kategori', 'kategori-absensi']) ? 'show' : '' }}">
                        <li class="sidebar-item">
                            <a href="/absensi-pilih-kategori"
                                class="sidebar-link {{ $activeRoute === 'absensi-pilih-kategori' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i>
                                <span>Kelola Absensi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/kategori-absensi"
                                class="sidebar-link {{ $activeRoute === 'kategori-absensi' ? 'active' : '' }}">
                                <i class="bi bi-circle"></i>
                                <span>Kelola Kategori</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </div>
        </div>
        <div class="sidebar-menu-group">
            <!-- Sidebar Header Lainnya -->
            <li class="sidebar-header">
                Lainnya
            </li>
            <div class="sidebar-item-group">
                <!-- Sidebar Item Pinjaman -->
                <li class="sidebar-item">
                    <a href="/admin/pinjaman" class="sidebar-link">
                        <i class="bi bi-ui-checks-grid"></i>
                        <span>Pinjaman</span>
                    </a>
                </li>
            </div>
        </div>
        <div class="sidebar-menu-group">
            <!-- Sidebar Header Saya -->
            <li class="sidebar-header">
                Akun
            </li>
            <div class="sidebar-item-group">
                <!-- Sidebar Item Profile -->
                <li class="sidebar-item">
                    <a href="/profile" class="sidebar-link">
                        <i class="bi bi-person-fill"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </div>
        </div>
    </ul>
</aside>
<!--Sidebar End-->