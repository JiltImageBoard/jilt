#### Resource URL
`POST /api/control-panel/resetpassword`

#### Description
  Resets password.

#### Resource information:
  Requires authentication: yes
  Response formats: `JSON`

#### Post parameters
| type     | required | name                              | description
|----------|----------|-----------------------------------|-------------
| `string` | yes      | old_password                      | Old password
| `string` | yes      | new_password                      | New password


#### Example Request
```javascript
POST /control-panel/resetpassword
{
  "odl_password": "admin",
  "new_password": "admin22",
}
```

#### Example Result
```javascript
{
  "errorCode": 0,
  "errorMessage": ""
}
```