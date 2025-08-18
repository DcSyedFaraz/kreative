# Chat Read/Unread Message System

This document explains the implementation of the read/unread message system for the chat functionality.

## Features Implemented

### 1. Read/Unread Message Tracking
- Added `read_at` timestamp field to `chat_messages` table
- Messages are marked as unread by default (null `read_at`)
- Messages are marked as read when a user enters a chat room

### 2. Unread Message Counts
- Real-time unread message counts for each chat room
- Total unread messages across all conversations
- Visual indicators (red badges) for unread messages

### 3. Last Message Display
- Shows the last message preview in chat list
- Displays "You: " prefix for own messages
- Shows message timestamps in relative format (e.g., "2m ago", "1h ago")

### 4. Duplicate Chat Room Prevention
- Fixed issue where multiple chat rooms could be created between the same users
- Added `findOrCreateBetweenUsers()` method to ChatRoom model
- Prevents creation of duplicate rooms with reversed `client_id` and `service_provider_id`
- Automatically determines correct client/service provider roles based on user roles

## Database Changes

### Migration: `add_read_at_to_chat_messages_table`
```php
Schema::table('chat_messages', function (Blueprint $table) {
    $table->timestamp('read_at')->nullable()->after('message');
});
```

## Model Updates

### ChatMessage Model
- Added `read_at` to fillable fields
- Added datetime casting for `read_at`
- Added methods:
  - `isRead()` - Check if message is read
  - `isUnread()` - Check if message is unread
  - `markAsRead()` - Mark message as read
  - `scopeUnread()` - Query scope for unread messages
  - `scopeRead()` - Query scope for read messages

### ChatRoom Model
- Added methods:
  - `findOrCreateBetweenUsers()` - Find or create room between two users, preventing duplicates
  - `getUnreadCountAttribute()` - Get unread count for a user
  - `getLastMessageAttribute()` - Get the last message in the room
  - `markMessagesAsRead()` - Mark all unread messages as read
  - `scopeWithUnreadCount()` - Query scope with unread count

## Controller Updates

### ChatRoomController
- Updated `index()` method to include unread counts and last messages
- Updated `show()` method to use `findOrCreateBetweenUsers()` for duplicate prevention
- Updated `show()` method to mark messages as read when entering room
- Improved query efficiency with proper eager loading

### ChatMessageController
- Added `markAsRead()` method to handle marking messages as read via API

## Maintenance Commands

### Fix Duplicate Chat Rooms
If duplicate chat rooms exist in the database, use the following command to fix them:

```bash
# Check for duplicates (dry run)
php artisan chat:fix-duplicates --dry-run

# Fix duplicates
php artisan chat:fix-duplicates
```

This command will:
- Find duplicate chat rooms with reversed `client_id` and `service_provider_id`
- Merge messages from duplicate rooms into the primary room
- Delete the duplicate rooms

## Frontend Updates

### Chat Index Page (`Index.vue`)
- Added unread message count badges
- Added last message preview
- Added total unread count display
- Improved visual indicators for unread messages

### Chat Room Page (`Room.vue`)
- Added real-time message sending
- Added automatic scroll to bottom for new messages
- Added "scroll to bottom" button for long conversations
- Added message timestamps
- Added read/unread status indicators
- Added Laravel Echo integration for real-time updates

## API Endpoints

### Chat Messages
- `POST /chat/messages` - Send a new message
- `POST /chat/{room}/mark-read` - Mark messages as read

### Chat Rooms
- `GET /chat` - List all chat rooms for current user
- `GET /chat/{user}` - Open or create chat room with specific user

## Broadcasting

### Events
- `MessageSent` - Broadcasted when a new message is sent

### Channels
- `chat.room.{roomId}` - Private channel for each chat room

## Security Features

- Users can only access chat rooms they are participants in
- Messages are validated to ensure sender is a room participant
- Self-chat prevention (users cannot chat with themselves)
- Role-based access control for service providers and clients
