<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <span class="navbar-brand m-0 ms-1 font-weight-bold text-white">HIGH VIEW Dashboard</span>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <!-- Always Visible Items -->
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="/">
          <i class="material-icons opacity-10 me-2">home</i>
          <span class="nav-link-text">Dashboard</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="/articles">
          <i class="material-icons opacity-10 me-2">article</i>
          <span class="nav-link-text">Articles</span>
        </a>
      </li> -->

      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="/category">
          <i class="material-icons opacity-10 me-2">category</i>
          <span class="nav-link-text">Categories</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="../pages/virtual-reality.html">
          <i class="material-icons opacity-10 me-2">view_module</i>
          <span class="nav-link-text">Packages</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="/products">
          <i class="material-icons opacity-10 me-2">shopping_bag</i>
          <span class="nav-link-text">Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="/orders">
          <i class="material-icons opacity-10 me-2">shopping_cart</i>
          <span class="nav-link-text">Orders</span>
        </a>
      </li>

      <!-- Hidden Items -->
      <div id="more-items">
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="/customers">
            <i class="material-icons opacity-10 me-2">group</i>
            <span class="nav-link-text">Customers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="/coupons">
            <i class="material-icons opacity-10 me-2">local_offer</i>
            <span class="nav-link-text">Coupons</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="/reviews">
            <i class="material-icons opacity-10 me-2">star</i>
            <span class="nav-link-text">Reviews</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="/contacts">
            <i class="material-icons opacity-10 me-2">contacts</i>
            <span class="nav-link-text">Contacts</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="/discounts">
            <i class="material-icons opacity-10 me-2">price_change</i>
            <span class="nav-link-text">Discounts</span>
          </a>
        </li>
        <?php
        // Assume $userRole is fetched from the session or database and holds the user's role, e.g., "admin" or "super_admin".
        $userRole = $_SESSION['user_role'] ?? 'admin'; // Example: session variable for user role
        ?>

        <!-- Sidebar Navigation -->
        <ul class="nav">
          <!-- Other menu items -->

          <?php if ($userRole === 'super_admin'): ?>
            <li class="nav-item">
              <a class="nav-link text-white d-flex align-items-center" href="/superadmin">
                <i class="material-icons opacity-10 me-2">admin_panel_settings</i>
                <span class="nav-link-text">Manage Admin</span>
              </a>
            </li>
          <?php endif; ?>
        </ul>

      </div>
      <!-- <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      Logout Button
      <li class="nav-item mt-3">
        <a class="nav-link text-white d-flex align-items-center" href="/views/register/login.php">
          <i class="material-icons opacity-10 me-2">logout</i>
          <span class="nav-link-text">Logout</span>
        </a>
      </li> -->
    </ul>
  </div>
</aside>