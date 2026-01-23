@echo off
echo Running Chat System Database Migrations...
echo.

cd /d "c:\Users\Admin\Downloads\public_html1"

echo Running migration to update ch_messages table...
php artisan migrate --path=database/migrations/2024_01_20_000001_update_ch_messages_table.php --force

echo.
echo Running migration to create groups_chats table...
php artisan migrate --path=database/migrations/2024_01_20_000002_create_groups_chat_table.php --force

echo.
echo Migrations completed!
echo.
echo Your WhatsApp-like chat system is now ready!
echo.
echo Access URLs:
echo Admin Chat: http://127.0.0.1:8000/admin/chat_box
echo Agent Chat: http://127.0.0.1:8000/agent/agent/chat_box
echo.
pause