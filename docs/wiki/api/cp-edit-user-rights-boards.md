#### Resource URL
`PUT /api/control-panel/users/{id}/rights`

#### Description
  Edits user rights for board

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id

#### Put parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `string` | yes      | type                              | Type of right
| `int`    | yes      | id                                | Id
| `array`  | yes      | rights                            | Array which contains rights
| `bool`   | yes      | (rights)can_ban                   | User can ban in specific board/chat
| `bool`   | yes      | (rights)can_delete_posts          | User can delete posts at specific board/chat
| `bool`   | yes      | (rights)can_delete_threads        | User can delete posts at specific board
| `bool`   | yes      | (rights)can_edit_boards_settings  | User can edit settings of specific board
| `bool`   | yes      | (rights)can_edit_posts            | User can edit posts at specific board/chat
| `bool`   | yes      | (rights)can_edit_threads          | User can edit threads at specific board
| `bool`   | yes      | (rights)can_edit_pages            | User can edit pages in specific chat
| `bool`   | yes      | (rights)can_lock_threads          | User can lock threads at specific board
| `bool`   | yes      | (rights)can_stick_threads         | User can stick threads at specific board


#### Example Request
```javascript
PUT /control-panel/users/5/rights
{
  "rights_list": [
    {
      "type": "board",
      "id": "1",
      "rights": {
        "can_ban": true,
        "can_delete_posts": false,
        "can_delete_threads": true,
        "can_edit_boards_settings": true,
        "can_edit_posts": false,
        "can_edit_threads": true,
        "can_lock_threads": true,
        "can_stick_threads": true
      }
    },
    {
      "type": "chat",
      "id": "123",
      "rights": {
        "can_edit_pages": true,
        "can_delete_posts": true,
        "can_edit_posts": true,
        "can_ban": true
      }
    }
  ]
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```