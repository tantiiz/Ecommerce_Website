-- =====================================================
-- COMPREHENSIVE FIX for User Table AUTO_INCREMENT Issue
-- =====================================================
-- Run this in phpMyAdmin if you're experiencing 
-- "Duplicate entry '0' for key 'PRIMARY'" errors
-- 
-- This will:
-- 1. Remove problematic SQL mode
-- 2. Delete rows with user_id = 0
-- 3. Fix AUTO_INCREMENT
-- 4. Reset AUTO_INCREMENT to correct value
-- =====================================================

USE ecomfinal;

-- Step 1: Remove NO_AUTO_VALUE_ON_ZERO from SQL mode (if enabled)
SET SESSION sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '');
SET GLOBAL sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '');

-- Step 2: Delete any problematic rows with user_id = 0 (if they exist)
-- This is safe - these are invalid rows that shouldn't exist
DELETE FROM `user` WHERE `user_id` = 0;

-- Step 3: Ensure AUTO_INCREMENT is properly set on user_id
-- This makes sure the column has AUTO_INCREMENT enabled
ALTER TABLE `user` MODIFY `user_id` INT(10) NOT NULL AUTO_INCREMENT;

-- Step 4: Reset AUTO_INCREMENT to the next available number
-- This finds the highest user_id and sets AUTO_INCREMENT to the next value
SET @max_id = (SELECT IFNULL(MAX(`user_id`), 0) FROM `user`);
SET @next_id = @max_id + 1;
SET @sql = CONCAT('ALTER TABLE `user` AUTO_INCREMENT = ', @next_id);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 5: Verification - Check the current AUTO_INCREMENT value
SELECT 
    'Current AUTO_INCREMENT value:' as Info,
    AUTO_INCREMENT as Value
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'ecomfinal' 
AND TABLE_NAME = 'user';

-- Step 6: Show current users (for verification)
SELECT 
    'Current users in database:' as Info,
    COUNT(*) as Total_Users,
    MAX(user_id) as Max_User_ID
FROM `user`;

-- Step 7: Check for any remaining problematic rows
SELECT 
    'Rows with user_id = 0:' as Info,
    COUNT(*) as Count
FROM `user` 
WHERE `user_id` = 0;

