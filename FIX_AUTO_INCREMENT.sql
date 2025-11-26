-- =====================================================
-- CRITICAL FIX: Enable AUTO_INCREMENT on user_id
-- =====================================================
-- Run this ONCE in phpMyAdmin to fix the AUTO_INCREMENT issue
-- This will ensure user_id auto-increments properly
-- =====================================================

USE ecomfinal;

-- Step 1: Remove NO_AUTO_VALUE_ON_ZERO from SQL mode
SET SESSION sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '');
SET GLOBAL sql_mode = REPLACE(@@sql_mode, 'NO_AUTO_VALUE_ON_ZERO', '');

-- Step 2: Delete any rows with user_id = 0 (these are invalid)
DELETE FROM `user` WHERE `user_id` = 0;

-- Step 3: CRITICAL - Force enable AUTO_INCREMENT on user_id column
-- This ensures the column will auto-increment
ALTER TABLE `user` MODIFY `user_id` INT(10) NOT NULL AUTO_INCREMENT;

-- Step 4: Get the maximum user_id and set AUTO_INCREMENT to the next value
SET @max_id = (SELECT IFNULL(MAX(`user_id`), 0) FROM `user` WHERE `user_id` > 0);
SET @next_id = GREATEST(@max_id + 1, 1);
SET @sql = CONCAT('ALTER TABLE `user` AUTO_INCREMENT = ', @next_id);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Step 5: Verify AUTO_INCREMENT is working
SELECT 
    'Verification:' as Info,
    AUTO_INCREMENT as Current_AUTO_INCREMENT_Value,
    (SELECT COUNT(*) FROM `user`) as Total_Users,
    (SELECT MAX(user_id) FROM `user`) as Max_User_ID
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'ecomfinal' 
AND TABLE_NAME = 'user';

-- If AUTO_INCREMENT shows NULL or 0, the fix didn't work
-- If it shows a number > 0, AUTO_INCREMENT is working correctly!

