#### Resource URL
`POST /api/control-panel/bans`

#### Description
  Adds ban by `board_id` / `thread_id` / `chat_num`
  AND
  `ip` / `subnetwork` / `session` / `name` / `message` / `file` / `country`.

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`


#### Post parameters
| type     | required | name                  | description
|----------|----------|-----------------------|-------------
| `int`    | optional | board_id              | Board id, on which ban will work. If not set, ban will be considered as global.
| `int`    | optional | thread_id             | Thread id. If not set, ban will work for whole board.
| `int`    | optional | chat_page_num         | Chat page number. If not set, ban will work for whole thread.
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
POST /control-panel/bans
{
  "board_id": 11,
  "ip": "127.0.0.1",
  "banned_until": "12.12.2016",
  "reason_for_user": "Test",
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