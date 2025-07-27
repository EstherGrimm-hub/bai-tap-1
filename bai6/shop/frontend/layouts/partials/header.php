<header data-bs-theme="dark">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">SHOP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/shop/frontend/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shop/frontend/pages/view_cart.php">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/shop/frontend/pages/about.php">About</a>
          </li>
          <?php if (isset($_SESSION['username'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="/shop/frontend/pages/logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="/shop/frontend/pages/login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/shop/frontend/pages/register.php">Register</a>
            </li>
          <?php endif; ?>



        </ul>

        <!-- Optional search form -->
        <!--
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        -->

      </div>
    </div>
  </nav>
</header>