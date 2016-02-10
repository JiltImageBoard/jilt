#### Resource URL
`GET /api/control-panel/bans/{id}`

#### Description
  Gets ban record by id

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`

#### Url parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `int`    | yes      | id                                | Id


#### Example Request
```javascript
GET /control-panel/bans/2
```

#### Example Result
```javascript
{
  "id": 2,
  "board_id": 2
  "ip": "127.0.0.1",
  "banned_until": "12.12.2016",
  "reason_for_user": "Test ban #2",
  "ban_user_on_violation": false
}
```