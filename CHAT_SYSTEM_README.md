# WhatsApp-Like Chat System

## Overview
This is a complete WhatsApp-like chat system implemented for your Laravel application with both Admin and Agent interfaces.

## Features

### ✅ Core Features
- **Real-time messaging** with Pusher integration
- **Group chat** functionality
- **File and image sharing**
- **Message replies** and forwarding
- **Message search** functionality
- **Online/Offline status** indicators
- **Unread message counts**
- **Emoji picker**
- **Message deletion**
- **WhatsApp-like UI/UX**

### 🎨 UI Features
- **Dark theme** matching WhatsApp Web
- **Responsive design** for mobile and desktop
- **Message bubbles** with proper styling
- **Typing indicators**
- **Profile picture display**
- **Last seen status**

## Installation & Setup

### 1. Run Database Migrations
```bash
# Navigate to your project directory
cd c:\Users\Admin\Downloads\public_html1

# Run the setup script
setup_chat.bat

# OR run manually:
php artisan migrate --path=database/migrations/2024_01_20_000001_update_ch_messages_table.php
php artisan migrate --path=database/migrations/2024_01_20_000002_create_groups_chat_table.php
```

### 2. Configure Pusher (Real-time messaging)
Update your `.env` file with Pusher credentials:
```env
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

### 3. Access URLs
- **Admin Chat**: `http://127.0.0.1:8000/admin/chat_box`
- **Agent Chat**: `http://127.0.0.1:8000/agent/agent/chat_box`

## Database Structure

### Tables Created/Updated:

#### 1. `ch_messages` (Updated)
- `id` - UUID primary key
- `from_id` - Sender user ID
- `to_id` - Receiver user ID (nullable for group messages)
- `group_id` - Group ID (nullable for direct messages)
- `body` - Message content
- `attachment` - File/image path
- `seen` - JSON array of user IDs who have seen the message
- `reply_id` - ID of message being replied to
- `forward` - Boolean flag for forwarded messages
- `deleted` - Boolean flag for deleted messages
- `created_at` - Timestamp
- `updated_at` - Timestamp

#### 2. `groups_chats` (New)
- `id` - Primary key
- `name` - Group name
- `created_by` - Group creator user ID
- `user_ids` - JSON array of group member IDs
- `image` - Group profile picture path
- `description` - Group description
- `created_at` - Timestamp
- `updated_at` - Timestamp

## Controllers

### Admin Chat Controller
**File**: `app/Http/Controllers/Admin/chatboxcontroller.php`
- Handles admin chat interface
- Manages message sending/receiving
- Group creation and management

### Agent Chat Controller
**File**: `app/Http/Controllers/Agent/chatcontroller.php`
- Handles agent chat interface
- Same functionality as admin controller
- Agent-specific permissions

## Models

### ChMessage Model
**File**: `app/Models/ChMessage.php`
- Handles chat messages
- Relationships with User and Groups_chat
- JSON casting for seen array

### Groups_chat Model
**File**: `app/Models/Groups_chat.php`
- Handles group chat functionality
- JSON casting for user_ids array
- Relationships with messages and users

## Views

### Admin Chat View
**File**: `resources/views/admin/chat/view_chat.blade.php`
- WhatsApp-like interface for admins
- Complete chat functionality

### Agent Chat View
**File**: `resources/views/Agent/chat-box/view_chat.blade.php`
- WhatsApp-like interface for agents
- Same features as admin view

## Key Features Explained

### 1. Real-time Messaging
- Uses Pusher for real-time communication
- Messages appear instantly without page refresh
- Online/offline status updates

### 2. Group Chat
- Create groups with multiple users
- Group admin can manage members
- Group profile pictures and names

### 3. Message Features
- **Reply**: Click on any message to reply
- **Forward**: Forward messages to other users/groups
- **Delete**: Delete messages (marked as deleted)
- **Search**: Search through message history

### 4. File Sharing
- Upload and share images
- Download attachments
- Image preview in chat

### 5. UI/UX Features
- **WhatsApp-like design** with dark theme
- **Message bubbles** with proper alignment
- **Emoji picker** for expressions
- **Responsive design** for all devices

## Routes

### Admin Routes
```php
Route::get('/admin/chat_box', [chatboxcontroller::class, 'agent_chat'])->name('admin_chat');
Route::post('/admin/send-message', [chatboxcontroller::class, 'sendMessage'])->name('admin_sendmessage');
Route::post('/admin/create_group', [chatboxcontroller::class, 'create_group'])->name('admin_create_group');
// ... more routes
```

### Agent Routes
```php
Route::get('/agent/agent/chat_box', [chatcontroller::class, 'agent_chat'])->name('agent_chat');
Route::post('/agent/send-message', [chatcontroller::class, 'sendMessage'])->name('send.message');
Route::post('/agent/create_group', [chatcontroller::class, 'create_group'])->name('create_group');
// ... more routes
```

## Troubleshooting

### Common Issues:

1. **Messages not appearing in real-time**
   - Check Pusher configuration in `.env`
   - Verify Pusher credentials are correct

2. **File uploads not working**
   - Check file permissions in `public/uploads/image/chat_file/`
   - Verify max file size in PHP configuration

3. **Group chat not working**
   - Run the database migrations
   - Check if `groups_chats` table exists

4. **Styling issues**
   - Clear browser cache
   - Check if CSS files are loading properly

## Security Features

- **CSRF Protection** on all forms
- **File upload validation**
- **XSS Protection** with proper escaping
- **User authentication** required
- **Permission-based access** (admin/agent roles)

## Performance Optimizations

- **Efficient database queries** with proper indexing
- **Lazy loading** of chat messages
- **Image compression** for attachments
- **Caching** of user status

## Browser Support

- ✅ Chrome (recommended)
- ✅ Firefox
- ✅ Safari
- ✅ Edge
- ✅ Mobile browsers

## Future Enhancements

Potential features that can be added:
- Voice messages
- Video calls
- Message encryption
- Message scheduling
- Chat backup/export
- Advanced admin controls
- Message reactions
- Typing indicators
- Message status (sent/delivered/read)

## Support

For any issues or questions:
1. Check the troubleshooting section above
2. Verify all migrations have been run
3. Check browser console for JavaScript errors
4. Ensure Pusher is properly configured

---

**Note**: This chat system is designed to work with your existing Laravel application structure and user authentication system.