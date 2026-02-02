# User Authentication Setup Documentation

This document explains the user authentication system added to the website Vue application.

## Overview

The website now has a complete user authentication system with:
- User registration
- User login with "remember me"
- Protected profile page
- Profile editing
- Password change
- Logout functionality

## Architecture

### Backend (Laravel)

#### Middleware
- **CheckUserAuth** (`app/Http/Middleware/CheckUserAuth.php`)
  - Protects routes requiring user authentication
  - Redirects unauthenticated users to `/login`
  - Uses `auth('web')` guard

#### Controller
- **AuthController** (`app/Http/Controllers/Website/Auth/AuthController.php`)
  - Handles login, registration, and logout
  - Returns JSON responses for Vue components
  - Uses `auth('web')` guard for session-based authentication

#### Routes (`routes/web.php`)

**Public Routes:**
- `POST /user/login` - Login endpoint
- `POST /user/register` - Registration endpoint

**Protected Routes (require `checkUser` middleware):**
- `GET /user/profile` - Get user data
- `PUT /user/profile` - Update user profile
- `POST /user/change-password` - Change password
- `POST /user/logout` - Logout

### Frontend (Vue.js)

#### Components

**Authentication Pages:**
1. **Login.vue** (`resources/js/components/website/pages/Login.vue`)
   - Email and password fields
   - Remember me checkbox
   - Link to registration
   - Form validation and error handling

2. **Register.vue** (`resources/js/components/website/pages/Register.vue`)
   - Name, email, phone, password, and password confirmation fields
   - Link to login
   - Form validation and error handling

3. **Profile.vue** (`resources/js/components/website/pages/Profile.vue`)
   - Protected route (requires authentication)
   - Display user information
   - Edit profile form
   - Change password form
   - Logout button

#### State Management

**Pinia Store** (`resources/js/stores/authStore.ts`)
- Manages authentication state across the application
- Syncs with `window.authUser` from Laravel
- Provides `isAuthenticated` computed property
- Methods: `setUser()`, `clearUser()`

#### Router Configuration

Routes are configured with meta tags:
```typescript
{
    path: '/login',
    name: 'login',
    meta: { guest: true }  // Only for non-authenticated users
}

{
    path: '/profile',
    name: 'profile',
    meta: { requiresAuth: true }  // Requires authentication
}
```

#### Layout Updates

**Layout.vue** shows conditional navigation:
- **Authenticated users**: Profile link
- **Guest users**: Login and Register buttons
- Works on both desktop and mobile menus

## Authentication Flow

### Registration Flow

1. User fills registration form
2. Frontend validates inputs
3. POST request to `/user/register`
4. Backend creates user and logs them in
5. User is redirected to `/profile`

### Login Flow

1. User fills login form
2. Frontend validates inputs
3. POST request to `/user/login`
4. Backend validates credentials and creates session
5. User is redirected to `/profile`

### Protected Routes

1. User visits protected route (e.g., `/profile`)
2. Middleware checks if user is authenticated
3. If not authenticated, redirect to `/login`
4. If authenticated, render the page

### Logout Flow

1. User clicks logout button
2. POST request to `/user/logout`
3. Backend destroys session
4. User is redirected to homepage

## Configuration

### Auth Guards (`config/auth.php`)

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    // ... other guards
],
```

### Middleware Registration (`bootstrap/app.php`)

```php
'checkUser' => \App\Http\Middleware\CheckUserAuth::class,
```

## Usage Examples

### Checking Authentication in Vue Components

```vue
<script setup>
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore();

// Check if authenticated
if (authStore.isAuthenticated) {
    // User is logged in
    console.log(authStore.user);
}
</script>
```

### Making Authenticated API Requests

```typescript
// GET request (authenticated)
const response = await axios.get('/user/profile');

// PUT request (authenticated)
const response = await axios.put('/user/profile', {
    name: 'John Doe',
    email: 'john@example.com'
});
```

### Protecting Routes in Laravel

```php
// In routes/web.php
Route::middleware('checkUser')->group(function () {
    Route::get('/my-page', function () {
        $user = auth('web')->user();
        return view('my-page', compact('user'));
    });
});
```

## Security Features

✅ **CSRF Protection** - All forms include CSRF token
✅ **Password Hashing** - Passwords hashed with bcrypt
✅ **Session-based Auth** - Secure session management
✅ **Validation** - Server-side validation on all endpoints
✅ **Remember Me** - Optional persistent login
✅ **Middleware Protection** - Routes protected by middleware

## API Endpoints

### POST /user/login

**Request:**
```json
{
    "email": "user@example.com",
    "password": "password123",
    "remember": true
}
```

**Response (Success):**
```json
{
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com"
        },
        "redirect": "/profile"
    }
}
```

**Response (Error):**
```json
{
    "errors": {
        "email": "Invalid credentials"
    }
}
```

### POST /user/register

**Request:**
```json
{
    "name": "John Doe",
    "email": "user@example.com",
    "phone": "+1234567890",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (Success):**
```json
{
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com"
        },
        "redirect": "/profile"
    }
}
```

### GET /user/profile (Protected)

**Response:**
```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com",
        "phone": "+1234567890"
    }
}
```

### PUT /user/profile (Protected)

**Request:**
```json
{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "phone": "+0987654321"
}
```

**Response:**
```json
{
    "data": {
        "id": 1,
        "name": "Jane Doe",
        "email": "jane@example.com",
        "phone": "+0987654321"
    }
}
```

### POST /user/change-password (Protected)

**Request:**
```json
{
    "current_password": "oldpassword",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response:**
```json
{
    "message": "Password updated successfully"
}
```

### POST /user/logout (Protected)

**Response:**
```json
{
    "data": {
        "message": "Logged out successfully"
    }
}
```

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Website/
│   │       └── Auth/
│   │           └── AuthController.php
│   └── Middleware/
│       └── CheckUserAuth.php
resources/
├── js/
│   ├── components/
│   │   └── website/
│   │       ├── Layout.vue (updated with auth links)
│   │       └── pages/
│   │           ├── Login.vue
│   │           ├── Register.vue
│   │           └── Profile.vue
│   ├── stores/
│   │   └── authStore.ts
│   └── website/
│       └── router.ts (updated with auth routes)
└── views/
    └── website/
        └── index.blade.php (passes authUser to JS)
routes/
└── web.php (auth routes added)
bootstrap/
└── app.php (middleware registered)
```

## Testing

### Manual Testing Steps

1. **Test Registration:**
   - Visit `/register`
   - Fill form with valid data
   - Submit and verify redirect to `/profile`
   - Check user is created in database

2. **Test Login:**
   - Visit `/login`
   - Enter valid credentials
   - Test "remember me" functionality
   - Verify redirect to `/profile`

3. **Test Profile Access:**
   - While logged in, visit `/profile`
   - Verify user data displays correctly
   - Test without login, verify redirect to `/login`

4. **Test Profile Update:**
   - On `/profile`, update name/email/phone
   - Submit and verify success message
   - Verify database is updated

5. **Test Password Change:**
   - On `/profile`, use password change form
   - Try wrong current password (should fail)
   - Try correct password (should succeed)

6. **Test Logout:**
   - Click logout button
   - Verify redirect to homepage
   - Try accessing `/profile` (should redirect to login)

## Customization

### Add More Protected Routes

```typescript
// In resources/js/website/router.ts
{
    path: '/my-bookings',
    name: 'bookings',
    component: () => import('../components/website/pages/Bookings.vue'),
    meta: { requiresAuth: true }
}
```

### Add Email Verification

1. Enable email verification in User model
2. Send verification email on registration
3. Add verification route and controller
4. Protect routes with `verified` middleware

### Add Social Login

1. Install Laravel Socialite
2. Add social login buttons to Login.vue
3. Create social auth controller
4. Configure OAuth providers

## Troubleshooting

### Issue: User not authenticated after login

**Solution:** Check that:
- CSRF token is present
- Session driver is configured correctly
- `auth('web')` guard is used consistently

### Issue: Redirect loop on protected routes

**Solution:** Verify:
- Middleware is properly registered
- Route exclusions in middleware
- Guest routes are not protected

### Issue: Auth state not updating in Vue

**Solution:**
- Ensure `window.authUser` is set in blade
- Check Pinia store initialization
- Refresh page after login/logout

## Next Steps

- [ ] Add email verification
- [ ] Implement password reset
- [ ] Add two-factor authentication
- [ ] Create user dashboard
- [ ] Add user preferences
- [ ] Implement role-based permissions
- [ ] Add OAuth social login
- [ ] Create user activity log
