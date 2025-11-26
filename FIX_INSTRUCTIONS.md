# Database Fix Instructions

## Problem
- "Duplicate entry '0' for key 'PRIMARY'" error
- "Registration failed: Could not verify user creation" error
- Cannot register multiple accounts

## Solution - Follow These Steps:

### Step 1: Run the Database Fix Script (REQUIRED - Do this first!)

1. Open your browser
2. Go to: `http://localhost/EcomFinalProject/fix_database.php`
3. The script will automatically:
   - Remove problematic SQL mode settings
   - Delete invalid rows (user_id = 0)
   - Fix AUTO_INCREMENT
   - Verify everything is working
4. You should see "✅ All fixes applied successfully!"

### Step 2: Test Registration

1. Go to: `http://localhost/EcomFinalProject/signup.html`
2. Try creating a new account
3. It should work now!

### Alternative: Manual SQL Fix (if fix_database.php doesn't work)

1. Open phpMyAdmin
2. Select the `ecomfinal` database
3. Go to the SQL tab
4. Copy and paste the contents of `fix_user_table.sql`
5. Click "Go"

## What Was Fixed:

1. **Removed NO_AUTO_VALUE_ON_ZERO SQL mode** - This was causing AUTO_INCREMENT to use 0
2. **Deleted rows with user_id = 0** - These invalid rows were causing conflicts
3. **Fixed AUTO_INCREMENT** - Ensured it's properly configured and set to the correct value
4. **Improved verification** - The signup process now verifies users are actually created
5. **Better error handling** - More specific error messages to help diagnose issues

## After Fixing:

- Multiple users can now create accounts
- Each user gets a unique AUTO_INCREMENT user_id
- Existing users are not affected
- The system will automatically prevent duplicate emails/usernames

## Troubleshooting:

If you still get errors after running the fix:

1. Check if MySQL/XAMPP is running
2. Verify the database `ecomfinal` exists
3. Check that the `user` table exists
4. Run `test_db_connection.php` to diagnose issues
5. Check MySQL error logs in XAMPP

## Files Created:

- `fix_database.php` - Automatic fix script (run this first!)
- `fix_user_table.sql` - Manual SQL fix script
- `test_db_connection.php` - Database diagnostic tool


