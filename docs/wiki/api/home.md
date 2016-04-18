## Boards
* [POST /api/boards/](create-board.md)
* [GET /api/boards/](get-boards.md)
* [GET /api/boards/{name}/pages/{page_num}](get-board-single.md)
* [GET /api/boards/{name}](get-board-settings.md)
* [PUT /api/boards/{name}](edit-board-settings.md)
* [DELETE /api/boards/{board_name}](delete-board.md)

## Threads
* [POST /api/boards/{name}/threads](create-thread.md)
* [GET /api/boards/{name}/threads/{thread_num}](get-thread.md)
* [PUT /api/boards/{name}/threads/{thread_num}](edit-thread.md)
* [DELETE /api/boards/{name}/threads/{thread_num}](delete-thread.md)

#### Chats
* [GET /api/boards/{name}/threads/{thread_num}/pages/{page_num}](get-thread-page.md)

## Posts
* [POST /api/boards/{name}/threads/{thread_num}/posts](create-post.md)
* [GET /api/boards/{name}/threads/{thread_num}/posts/{post_num}](get-post-single.md)
* [PUT /api/boards/{name}/threads/{thread_num}/posts/{post_num}](edit-post.md)
* [DELETE /api/boards/{name}/threads/{thread_num}/posts/{post_num}](delete-post.md)




## Control panel

#### Authentication
* [POST /api/control-panel/login](cp-login.md)
* [POST /api/control-panel/logout](cp-logout.md)
* [POST /api/control-panel/resetpassword](cp-reset-password.md)
* [GET /api/control-panel/csrf-token/](get-csrf-token.md)


#### Users
* [POST /api/control-panel/users](cp-create-user.md)
* [GET /api/control-panel/users](cp-get-users.md)
* [GET /api/control-panel/users/{id}](cp-get-user-single.md)
* [PUT /api/control-panel/users/{id}](cp-edit-user.md)
* [DELETE /api/control-panel/users/{id}](cp-delete-user.md)
* [GET /api/control-panel/users/{id}/cp-rights](cp-get-user-cp-rights.md)
* [PUT /api/control-panel/users/{id}/cp-rights](cp-edit-user-cp-rights.md)


#### Board and chat rights
* [GET /api/control-panel/users/{id}/rights](cp-get-user-rights.md)
* [PUT /api/control-panel/users/{id}/rights](cp-edit-user-rights.md)


#### Bans
* [POST /api/control-panel/bans](cp-create-ban.md)
* [GET /api/control-panel/bans](cp-get-bans.md)
* [GET /api/control-panel/bans/{id}](cp-get-ban-single.md)
* [PUT /api/control-panel/bans/{id}](cp-edit-ban.md)
* [DELETE /api/control-panel/bans/{id}](cp-delete-ban.md)