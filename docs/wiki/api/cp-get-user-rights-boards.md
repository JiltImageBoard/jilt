#### Resource URL
`GET /api/control-panel/users/{id}/rights`

#### Description
  Gets user rights for board.

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id


#### Example Request
```javascript
GET /control-panel/users/5/rights
```

#### Example Result
```javascript
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
      "board": "test",
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