<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · Login</title>
  <?=_bootstrap_css()?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <?=assets_css('login')?>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center p-3">

  <div class="login-card p-4 p-md-5">
    
    <!-- back to home -->
    <a href="/" class="back-home text-dark d-inline-flex align-items-center mb-4">
      <i class="fas fa-arrow-left"></i> Back to home
    </a>

    <!-- brand / logo -->
    <div class="text-center">
      <div class="brand-icon rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
        <i class="fas fa-code"></i>
      </div>
      <h2 class="fw-bold mb-1 text-dark">CodeYro</h2>
      <p class="text-secondary small mb-4">sign in to your dashboard</p>
    </div>

    <!-- login form -->
    <form id="loginForm">
      
      <!-- email -->
      <div class="mb-3">
        <label for="emailInput" class="form-label fw-semibold text-secondary">Email address</label>
        <div class="input-group">
          <span class="input-group-text input-group-text-custom">
            <i class="fas fa-envelope"></i>
          </span>
          <input type="email" name="email" class="form-control form-control-custom" id="email" 
                 placeholder="you@example.com" autofocus>
        </div>
        <?=error_text("email")?>
      </div>

      <!-- password -->
      <div class="mb-3">
        <label for="passwordInput" class="form-label fw-semibold text-secondary">Password</label>
        <div class="input-group">
          <span class="input-group-text input-group-text-custom">
            <i class="fas fa-lock"></i>
          </span>
          <input type="password" name="password" class="form-control form-control-custom" id="password" 
                 placeholder="••••••••">
          <button class="btn password-toggle" type="button" id="togglePass">
            <i class="fas fa-eye" id="toggleIcon"></i>
          </button>
        </div>
        <?=error_text("password")?>
      </div>

      <!-- remember & forgot -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="rememberMe">
          <label class="form-check-label small text-secondary" for="rememberMe">
            Remember me
          </label>
        </div>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>

      <!-- submit -->
      <button type="submit" class="btn btn-primary btn-login w-100">
        <i class="fas fa-sign-in-alt me-2"></i> Sign in
      </button>

      <div class="alert alert-danger alert-custom mt-3 py-2 text-center d-none" id="generalError" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> Invalid email or password
      </div>
    </form>

    <!-- divider -->
    <div class="d-flex align-items-center my-4">
      <hr class="flex-grow-1">
      <span class="mx-3 divider-text">or continue with</span>
      <hr class="flex-grow-1">
    </div>

    <!-- social login -->
    <div class="d-flex gap-2">
      <button class="btn btn-outline-secondary social-btn rounded-pill py-2" onclick="socialLogin('google')">
        <i class="fab fa-google text-danger me-2"></i> Google
      </button>
      <button class="btn btn-outline-secondary social-btn rounded-pill py-2" onclick="socialLogin('github')">
        <i class="fab fa-github me-2"></i> GitHub
      </button>
    </div>

    <!-- sign up -->
    <p class="text-center mt-4 mb-0 small text-secondary">
      Don't have an account? <a href="#" class="signup-link">Sign up free</a>
    </p>
  </div>

  <?=_bootstrap_js()?>
  <?=js()?>
</body>
</html>