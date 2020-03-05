---
title: API-参考文档

language_tabs:
- bash
- php
- javascript
- python

includes:

search: true

toc_footers:
- <a href='https://github.com/GabbyMrH'>Documentation Edit By GabbyMrH</a>

---
<!-- START_INFO -->
# 信息

欢迎使用本API文档
[点击获取Postman请求集合](http://pasn.api.com/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_500afaeb794e1d5b3191b39fb749c91b -->
## PASN WEB API文档

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/index" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/index',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/index"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/index'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> 返回示例 (200):

```json
null
```

### HTTP 请求
`GET /v1/index`


<!-- END_500afaeb794e1d5b3191b39fb749c91b -->

<!-- START_605cdc53e7c36bc756aa4518148c2dc0 -->
## user login check
登录验证

> 请求示例:

```bash
curl -X POST \
    "http://pasn.api.com/v1/user?username=qui" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://pasn.api.com/v1/user',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'username' => 'qui',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/user"
);

let params = {
    "username": "qui",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/user'
params = {
  'username': 'qui'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wYXNuLmFwaS5jb21cL3YxXC91c2VyIiwiaWF0IjoxNTgzMzc5MjAwLCJleHAiOjE1ODMzODY0MDAsIm5iZiI6MTU4MzM3OTIwMCwianRpIjoiYVRPdU00aW1ZejVxUWFteCIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.vZjnZLIYRwu_USyHCFUCCVe1J14yUTdx1t4H2SGgUiY",
    "token_type": "Bearer",
    "expires_in": "120",
    "code": 2001
}
```

### HTTP 请求
`POST /v1/user`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `username` |  required  | 账号

<!-- END_605cdc53e7c36bc756aa4518148c2dc0 -->

<!-- START_12d9d4f8056003d77e6712272689ceb2 -->
## refresh user token
刷新token

> 请求示例:

```bash
curl -X PUT \
    "http://pasn.api.com/v1/user/current" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://pasn.api.com/v1/user/current',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/user/current"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/user/current'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('PUT', url, headers=headers)
response.json()
```


> 返回示例 (200):

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wYXNuLmFwaS5jb21cL3YxXC91c2VyIiwiaWF0IjoxNTgzMzgwOTQ3LCJleHAiOjE1ODMzODgxNDcsIm5iZiI6MTU4MzM4MDk0NywianRpIjoiZVNCcWJ2SzNQZXFscHZuNyIsInN1YiI6MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.APLXxUp5wWk8mpWpWLUrUA78mkiz3HPcBTqow_3gQgo",
    "token_type": "Bearer",
    "expires_in": "120",
    "code": 2001
}
```

### HTTP 请求
`PUT /v1/user/current`


<!-- END_12d9d4f8056003d77e6712272689ceb2 -->

<!-- START_5bcaf108890a0fa554969d5086f45d01 -->
## delete user token
删除token

> 请求示例:

```bash
curl -X DELETE \
    "http://pasn.api.com/v1/user/current" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://pasn.api.com/v1/user/current',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/user/current"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/user/current'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('DELETE', url, headers=headers)
response.json()
```


> 返回示例 (200):

```json
null
```

### HTTP 请求
`DELETE /v1/user/current`


<!-- END_5bcaf108890a0fa554969d5086f45d01 -->

<!-- START_948a434031820e2c47e01fe9893bd270 -->
## dingTalk message
钉钉推送消息接口

> 请求示例:

```bash
curl -X POST \
    "http://pasn.api.com/v1/dingTest[/1]?message=animi" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://pasn.api.com/v1/dingTest[/1]',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'message' => 'animi',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/dingTest[/1]"
);

let params = {
    "message": "animi",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/dingTest[/1]'
params = {
  'message': 'animi'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "data": "编写api文档测试-V2",
    "code": 2001,
    "msg": "ok"
}
```

### HTTP 请求
`POST /v1/dingTest[/{message}]`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `message` |  required  | 信息内容

<!-- END_948a434031820e2c47e01fe9893bd270 -->

<!-- START_9d01787a501dbefea532af1a9a6b7a9b -->
## password encryption
密码加密接口

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/secret?secret=quis" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/secret',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'secret' => 'quis',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/secret"
);

let params = {
    "secret": "quis",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/secret'
params = {
  'secret': 'quis'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "data": "$2y$10$bjYB5CM75JOBmxPAi4KqxuSplXzkKF.m3gxIMugmWXOz7toB3K5fO",
    "code": 2001,
    "msg": "操作成功"
}
```

### HTTP 请求
`GET /v1/secret`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `secret` |  required  | 要加密的参数

<!-- END_9d01787a501dbefea532af1a9a6b7a9b -->

<!-- START_4191347324a0c063ce6ffd56dc118fb6 -->
## user info
用户信息

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/user',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/user'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> 返回示例 (200):

```json
{
    "data": {
        "id": 2,
        "name": "admin",
        "username": "123456",
        "created_at": "2019-12-19 15:08:23.910",
        "updated_at": "2019-12-19 15:08:23.910",
        "roles": "admin",
        "avatar": "http:\/\/pasn.api.com\/assets\/avatar\/avatar.jpg",
        "ed_customer_customer_id": "system"
    },
    "code": 2001,
    "msg": "操作成功"
}
```

### HTTP 请求
`GET /v1/user`


<!-- END_4191347324a0c063ce6ffd56dc118fb6 -->

<!-- START_adc96eee5cbaec937feedfacf1b4243f -->
## inventory total
inventory 总量

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/inventoryTotal" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/inventoryTotal',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/inventoryTotal"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/inventoryTotal'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> 返回示例 (200):

```json
{
    "Tips": "返回分页后的入库列表，从中提取总数"
}
```

### HTTP 请求
`GET /v1/inventoryTotal`


<!-- END_adc96eee5cbaec937feedfacf1b4243f -->

<!-- START_8a7d2f56235a93e9b3cbf2eaf1979377 -->
## warehouse list
仓库列表

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/warehouse" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/warehouse',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/warehouse"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/warehouse'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> 返回示例 (200):

```json
{
    "data": [
        {
            "warehouse_code": "PH"
        },
        {
            "warehouse_code": "1999"
        },
        {
            "warehouse_code": "KJJSZC"
        },
        {
            "warehouse_code": "222"
        }
    ],
    "code": 2001,
    "msg": "操作成功"
}
```

### HTTP 请求
`GET /v1/warehouse`


<!-- END_8a7d2f56235a93e9b3cbf2eaf1979377 -->

<!-- START_7e01c33c25ef45c343007f96d2a6c6d0 -->
## booking list
入库订单列表

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/inbound?ref_no=omnis&booking_no=qui&start_time%2Bend_time=sequi&page=autem&pge_limit=sint" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/inbound',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'ref_no' => 'omnis',
            'booking_no' => 'qui',
            'start_time+end_time' => 'sequi',
            'page' => 'autem',
            'pge_limit' => 'sint',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/inbound"
);

let params = {
    "ref_no": "omnis",
    "booking_no": "qui",
    "start_time+end_time": "sequi",
    "page": "autem",
    "pge_limit": "sint",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/inbound'
params = {
  'ref_no': 'omnis',
  'booking_no': 'qui',
  'start_time+end_time': 'sequi',
  'page': 'autem',
  'pge_limit': 'sint'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "data": {
        "current_page": 1,
        "data": [
            {
                "booking_id": "58f5ec3a-ac1c-407e-88d4-57bcb8b8de25",
                "order_id": "EC4249AA-D552-4231-9D1F-7D7C156D2000",
                "customer_id": "system",
                "booking_no": "1234",
                "warehouse_code": "KJJSZC",
                "booking_date": "2020-03-04 22:52:54.000",
                "ref_no": "1234",
                "truck_no": null,
                "bill_no": null,
                "order_qty": "12",
                "order_gw": "0.0",
                "order_cbm": "0.0",
                "receipt_qty": "0",
                "receipt_gw": "0.0",
                "receipt_cbm": "0.0",
                "create_by": " ",
                "booking_status": "NEW",
                "create_date": "2020-03-04 22:53:11.673",
                "update_by": " ",
                "update_date": "2020-03-04 22:53:12.290"
            }
        ],
        "first_page_url": "http:\/\/pasn.api.com\/v1\/inbound?page=1",
        "from": 1,
        "last_page": 1348,
        "last_page_url": "http:\/\/pasn.api.com\/v1\/inbound?page=1348",
        "next_page_url": "http:\/\/pasn.api.com\/v1\/inbound?page=2",
        "path": "http:\/\/pasn.api.com\/v1\/inbound",
        "per_page": "1",
        "prev_page_url": null,
        "to": 1,
        "total": 1348
    },
    "code": 2001,
    "msg": "操作成功"
}
```

### HTTP 请求
`GET /v1/inbound`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `ref_no` |  optional  | String 客户参考号
    `booking_no` |  optional  | String 入库预约号
    `start_time+end_time` |  optional  | Date 开始日期和结束日期
    `page` |  optional  | String 页码
    `pge_limit` |  optional  | String 每页显示条数

<!-- END_7e01c33c25ef45c343007f96d2a6c6d0 -->

<!-- START_9368541e59aa128d712184971949a9bf -->
## add booking order
新增预约入库单

> 请求示例:

```bash
curl -X POST \
    "http://pasn.api.com/v1/inbound/add?ref_no=esse&customer_id=doloribus&booking_date=perspiciatis&warehouse_code=quia&booking_detail=ex" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://pasn.api.com/v1/inbound/add',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'ref_no' => 'esse',
            'customer_id' => 'doloribus',
            'booking_date' => 'perspiciatis',
            'warehouse_code' => 'quia',
            'booking_detail' => 'ex',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/inbound/add"
);

let params = {
    "ref_no": "esse",
    "customer_id": "doloribus",
    "booking_date": "perspiciatis",
    "warehouse_code": "quia",
    "booking_detail": "ex",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/inbound/add'
params = {
  'ref_no': 'esse',
  'customer_id': 'doloribus',
  'booking_date': 'perspiciatis',
  'warehouse_code': 'quia',
  'booking_detail': 'ex'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "ref_no": "567",
    "booking_date": "2020-03-05 14:25:45",
    "warehouse_code": "PH",
    "customer_id": "system",
    "booking_detail": [
        {
            "ref_no": 567,
            "po_no": "111",
            "qty_case": "20",
            "country": "dsad",
            "case_length": 11,
            "case_width": "22",
            "case_height": 33,
            "case_weight": 44
        },
        {
            "ref_no": 567,
            "po_no": "222",
            "qty_case": "30",
            "country": "fsa",
            "case_length": 22,
            "case_width": "33",
            "case_height": 44,
            "case_weight": 55
        },
        {
            "ref_no": 567,
            "po_no": "333",
            "qty_case": "20",
            "country": "fdsf",
            "case_length": 33,
            "case_width": "44",
            "case_height": 55,
            "case_weight": 66
        }
    ],
    "code": "2001",
    "msg": "操作成功"
}
```

### HTTP 请求
`POST /v1/inbound/add`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `ref_no` |  required  | 客户参考号
    `customer_id` |  required  | 客户编码
    `booking_date` |  required  | 创建日期
    `warehouse_code` |  required  | 仓库编码
    `booking_detail` |  required  | 货物信息(array)

<!-- END_9368541e59aa128d712184971949a9bf -->

<!-- START_06e485123f0470d17c5f1cf2c4939786 -->
## /v1/inbound/edit
> 请求示例:

```bash
curl -X POST \
    "http://pasn.api.com/v1/inbound/edit" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://pasn.api.com/v1/inbound/edit',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/inbound/edit"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/inbound/edit'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('POST', url, headers=headers)
response.json()
```



### HTTP 请求
`POST /v1/inbound/edit`


<!-- END_06e485123f0470d17c5f1cf2c4939786 -->

<!-- START_68e7ff0c4d0c4bb7264e93e44230c0ef -->
## booking detail list
入库货物详情单列表

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/inbound/detail?ref_no=labore" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/inbound/detail',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'ref_no' => 'labore',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/inbound/detail"
);

let params = {
    "ref_no": "labore",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/inbound/detail'
params = {
  'ref_no': 'labore'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "data": {
        "current_page": 1,
        "data": [
            {
                "inboundid": "F6FAF1B5-5E11-4586-AF2C-92C19D43A848",
                "booking_id": "58f5ec3a-ac1c-407e-88d4-57bcb8b8de25",
                "line_num": null,
                "ref_no": "1234",
                "po_no": "312",
                "country": "123",
                "sku_code": null,
                "sku_cname": null,
                "sku_ename": null,
                "sku_hscode": null,
                "qty_case": "12",
                "qty_pices": "0",
                "sku_uom": null,
                "sku_pack": null,
                "case_length": "13.0",
                "case_width": "313.0",
                "case_height": "3132.0",
                "case_weight": "313.0",
                "case_upc": null,
                "case_upc1": null,
                "case_upc2": null,
                "pick_line": null,
                "qc_rate": "0.0",
                "qc_mark": null,
                "fba_warehouse": null,
                "lot_attrib1": null,
                "lot_attrib2": null,
                "lot_attrib3": null,
                "lot_attrib4": null,
                "lot_attrib5": null,
                "remarks": null,
                "create_by": " ",
                "create_date": "2020-03-04 22:53:11.793",
                "update_by": " ",
                "update_date": "2020-03-04 22:53:11.793",
                "booking_date": "2020-03-04 22:52:54.000",
                "order_qty": "12"
            }
        ],
        "first_page_url": "http:\/\/pasn.api.com\/v1\/inbound\/detail?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http:\/\/pasn.api.com\/v1\/inbound\/detail?page=1",
        "next_page_url": null,
        "path": "http:\/\/pasn.api.com\/v1\/inbound\/detail",
        "per_page": "1",
        "prev_page_url": null,
        "to": 1,
        "total": 1
    },
    "code": 2001,
    "msg": "操作成功"
}
```

### HTTP 请求
`GET /v1/inbound/detail`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `ref_no` |  required  | 客户参考号

<!-- END_68e7ff0c4d0c4bb7264e93e44230c0ef -->

<!-- START_6d3320488f28281a6822364ad63e4568 -->
## inventory list
库存余额列表

> 请求示例:

```bash
curl -X GET \
    -G "http://pasn.api.com/v1/inventory?page=esse&page_limit=quod" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -H "Api-Version: v1"
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://pasn.api.com/v1/inventory',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
            'Api-Version' => 'v1',
        ],
        'query' => [
            'page' => 'esse',
            'page_limit' => 'quod',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```javascript
const url = new URL(
    "http://pasn.api.com/v1/inventory"
);

let params = {
    "page": "esse",
    "page_limit": "quod",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
    "Api-Version": "v1",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```python
import requests
import json

url = 'http://pasn.api.com/v1/inventory'
params = {
  'page': 'esse',
  'page_limit': 'quod'
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer {token}',
  'Api-Version': 'v1'
}
response = requests.request('GET', url, headers=headers, params=params)
response.json()
```


> 返回示例 (200):

```json
{
    "data": {
        "current_page": 1,
        "data": [
            {
                "PKID": "937ED92C-1D0C-4B07-AE20-0EFDBA251662",
                "warehouse_code": "PH",
                "customer_id": "ZB",
                "sku_no": "FBA15K0DBJYCU000020",
                "lot_no": "2D618FF5-462B-225A-AC12-F031A83A1E7A",
                "po_no": "FBA15K0DBJYC",
                "ref_no": "ZBSZ19120320",
                "location_code": "STD",
                "drap_id": "",
                "qty": "1",
                "QtyAllocated": "0",
                "QtyPicked": "0",
                "QtyPickInProcess": "0",
                "QtyShipped": "0",
                "create_by": "system",
                "create_date": "2019-12-17 15:58:51.437",
                "update_by": "system",
                "update_date": "2019-12-17 15:58:51.437"
            }
        ],
        "first_page_url": "http:\/\/pasn.api.com\/v1\/inventory?page=1",
        "from": 1,
        "last_page": 71529,
        "last_page_url": "http:\/\/pasn.api.com\/v1\/inventory?page=71529",
        "next_page_url": "http:\/\/pasn.api.com\/v1\/inventory?page=2",
        "path": "http:\/\/pasn.api.com\/v1\/inventory",
        "per_page": "1",
        "prev_page_url": null,
        "to": 1,
        "total": 71529
    },
    "code": 2001,
    "msg": "操作成功"
}
```

### HTTP 请求
`GET /v1/inventory`

#### Query Parameters

参 数 | 状 态 | 描 述
--------- | ------- | ------- | -----------
    `page` |  optional  | 页码
    `page_limit` |  optional  | 每页显示条数

<!-- END_6d3320488f28281a6822364ad63e4568 -->


