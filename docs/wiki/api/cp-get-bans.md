#### Resource URL
`GET /api/control-panel/bans`

#### Description
  Gets bans

#### Resource information:
  Requires authentication: yes    
  Response formats: `JSON`


#### Example Request
`GET /control-panel/bans`

#### Example Result
Status code: `200`
```JSON
{
  "bans":[
    {
      "id": 1,
      "board_id": 1,
      "ip": "127.0.0.1",
      "banned_until": "12.12.2016",
      "reason_for_user": "Test ban #1",
      "ban_user_on_violation": false
    },
    {
      "id": 2,
      "board_id": 2,
      "ip": "127.0.0.1",
      "banned_until": "12.12.2016",
      "reason_for_user": "Test ban #2",
      "ban_user_on_violation": false
    }
  ]
}
```