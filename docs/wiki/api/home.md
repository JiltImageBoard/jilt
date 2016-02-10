## Response errors
* [Errors](errors.md)

## Boards
* [POST /api/boards/](API_add_board)
* [GET /api/boards/](API_get_boards)
* [GET /api/boards/{name}/pages/{page_num}](API_get_board)
* [GET /api/boards/{name}](API_cp_get_board_settings)
* [PUT /api/boards/{name}](API_cp_put_board_settings)
* [DELETE /api/boards/{board_name}](API_delete_board)

## Threads
* [POST /api/boards/{name}/threads](API_add_thread)
* [GET /api/boards/{name}/threads/{thread_num}](API_get_thread)
* [PUT /api/boards/{name}/threads/{thread_num}](API_edit_thread)
* [DELETE /api/boards/{name}/threads/{thread_num}](API_delete_thread)

#### Chats
* [GET /api/boards/{name}/threads/{thread_num}/pages/{page_num}](API_get_chat_page)

## Posts
* [POST /api/boards/{name}/threads/{thread_num}/posts](API_add_post)
* [GET /api/boards/{name}/threads/{thread_num}/posts/{post_num}](API_get_post)
* [PUT /api/boards/{name}/threads/{thread_num}/posts/{post_num}](API_edit_post)
* [DELETE /api/boards/{name}/threads/{thread_num}/posts/{post_num}](API_delete_post)




## Control panel

#### Authentication
* [POST /api/control-panel/login](API_cp_login)
* [POST /api/control-panel/logout](API_cp_logout)
* [POST /api/control-panel/resetpassword](API_cp_resetpass)


#### Users
* [POST /api/control-panel/users](API_cp_post_user)
* [GET /api/control-panel/users](API_cp_get_users)
* [GET /api/control-panel/users/{id}](API_cp_get_user)
* [PUT /api/control-panel/users/{id}](API_cp_edit_user)
* [DELETE /api/control-panel/users/{id}](API_cp_delete_user)
* [GET /api/control-panel/users/{id}/cp-rights](API_cp_get_user_cp_rights)
* [PUT /api/control-panel/users/{id}/cp-rights](API_cp_edit_user_cp_rights)


#### Board and chat rights
* [GET /api/control-panel/users/{id}/rights](API_cp_get_user_rights)
* [PUT /api/control-panel/users/{id}/rights](API_cp_edit_user_rights)


#### Bans
* [POST /api/control-panel/bans](API_cp_post_bans)
* [GET /api/control-panel/bans](API_cp_get_bans)
* [GET /api/control-panel/bans/{id}](API_cp_get_bans_single)
* [PUT /api/control-panel/bans/{id}](API_cp_put_bans)
* [DELETE /api/control-panel/bans/{id}](API_cp_delete_bans)