<?php
/**
 * Middleware Class
 * 
 * This is the PHP equivalent of the middleware.ts file from the Next.js implementation.
 * It handles route protection and authentication checks.
 */
class Middleware {
    private $auth;
    
    public function __construct() {
        $this->auth = new Auth();
    }
    
    /**
     * Process the request
     */
    public function process($path) {
        // Define public paths that don't require authentication
        $publicPaths = ['/login', '/verify-2fa', '/forgot-password'];
        $isResetPasswordPath = strpos($path, '/reset-password') === 0;
        $isPublicPath = in_array($path, $publicPaths) || $isResetPasswordPath;
        
        // Check if the user is authenticated
        $isAuthenticated = $this->auth->isAuthenticated();
        $isLoggedIn = $this->auth->isLoggedIn();
        $is2FAVerified = $this->auth->is2FAVerified();
        
        // If the path is public and the user is authenticated, redirect to dashboard
        if ($isPublicPath && $isAuthenticated) {
            header('Location: /admin/dashboard');
            exit;
        }
        
        // If the path is not public and the user is not logged in, redirect to login
        if (!$isPublicPath && !$isLoggedIn) {
            header('Location: /login');
            exit;
        }
        
        // If the path requires 2FA verification
        if (strpos($path, '/admin') === 0 && $isLoggedIn && !$is2FAVerified) {
            header('Location: /verify-2fa');
            exit;
        }
        
        // If the path is the 2FA verification page and the user is not logged in, redirect to login
        if ($path === '/verify-2fa' && !$isLoggedIn) {
            header('Location: /login');
            exit;
        }
        
        // If the path is the 2FA verification page and the user has already verified 2FA, redirect to dashboard
        if ($path === '/verify-2fa' && $is2FAVerified) {
            header('Location: /admin/dashboard');
            exit;
        }
        
        return true;
    }
}

