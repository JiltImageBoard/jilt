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
`POST /control-panel/resetpassword`
```JSON

```

#### Example Result
Status code: `200`