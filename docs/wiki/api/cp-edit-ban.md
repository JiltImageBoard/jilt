#### Resource URL
`PUT /api/control-panel/bans/{id}`

#### Description
  Edits ban record by id

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`


#### Put parameters
| type     | required | name                  | description
|----------|----------|-----------------------|-------------
| `int`    | optional | board_id              | Board id, on which ban will work. If not set, ban will be considered as global.
| `int`    | optional | thread_id             | Thread id. If not set, ban will work for whole board.
| `int`    | optional | chat_num              | Chat number. If not set, ban will work for whole thread.
| `string` | no       | ip                    | Ip adress
| `string` | no       | subnetwork            | Subnetwork. Can be set only if ip is not empty.
| `string` | no       | session               | Session
| `string` | no       | name                  | Name
| `string` | no       | message               | Message
| `string` | no       | file                  | Banned file id
| `string` | no       | country               | Country
| `string` | yes      | banned_until          | Banned until
| `string` | yes      | reason_for_user       | Reason for user
| `string` | no       | reason_for_mod        | Reason for mods
| `bool`   | yes      | ban_user_on_violation | If true, user will be banned on attempting to post something using banned values specified here. User will be banned by his ip and session.


#### Example Request
```javascript
PUT /control-panel/bans/1
{
  "board_id": 11,
  "thread_id": null,
  "chat_num": null,
  "ip": "127.0.0.1",
  "subnetwork": null,
  "session": null,
  "name": null,
  "message": null,
  "file": null,
  "country": null
  "banned_until": "12.12.2016",
  "reason_for_user": "Test",
  "reason_for_mod": null,
  "ban_user_on_violation": false
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```