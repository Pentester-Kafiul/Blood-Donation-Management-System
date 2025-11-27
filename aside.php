<aside class="w-64 bg-gray-800 text-white fixed h-full left-0 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Menu</h2>
<ul class="space-y-3">
    <?php
    $current = basename($_SERVER['PHP_SELF']);
    $links = [
        'dashboard.php'   => 'Dashboard',
        'profile.php'     => 'Profile',
        'request.php'     => 'Request Donate',
        'signdonor.php'   => 'Sign As Donor',
        'update.php'      => 'Received',
        'pass-change.php' => 'Change Password',
        'logout.php'      => 'Logout'
    ];

    foreach ($links as $file => $label) {
        $activeClass = ($current === $file) ? 'bg-gray-700' : 'hover:bg-gray-700 transition duration-150';
        echo '<li>
                <a href="' . $file . '" class="block px-4 py-2 rounded-lg ' . $activeClass . '">' . $label . '</a>
              </li>';
    }
    ?>
</ul>

            </div>
        </aside>