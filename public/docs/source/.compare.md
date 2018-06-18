---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://pimtru.local/docs/collection.json)
<!-- END_INFO -->

#Product

Manage all the products data.
<!-- START_dd873464f7c6ace481b7520ef5394dc9 -->
## Show all products

> Example request:

```bash
curl -X GET "http://pimtru.local/products" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://pimtru.local/products",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
{
    "data": [
        {
            "name": "Damon",
            "descriptionn": "ME, and told me he was gone, and the Mock Turtle. 'Very much indeed,' said Alice. 'Call it.",
            "fechaModification": "2015-12-19 21:33:03",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/1"
                }
            ]
        },
        {
            "name": "Roselyn",
            "descriptionn": "At this moment Five, who had.",
            "fechaModification": "2009-12-01 22:05:32",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/2"
                }
            ]
        },
        {
            "name": "Marlene",
            "descriptionn": "Pat, what's that in about half.",
            "fechaModification": "2015-06-15 22:46:23",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/3"
                }
            ]
        },
        {
            "name": "Jamey",
            "descriptionn": "So they went up to the porpoise, \"Keep.",
            "fechaModification": "2013-05-08 08:32:15",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/4"
                }
            ]
        },
        {
            "name": "Chase",
            "descriptionn": "She generally gave herself very good height indeed!' said the King. On this the whole window!' 'Sure, it.",
            "fechaModification": "2016-03-13 00:12:33",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/5"
                }
            ]
        },
        {
            "name": "Allison",
            "descriptionn": "Alice asked in a rather offended tone, 'was, that the Gryphon replied very readily: 'but that's because it.",
            "fechaModification": "2013-09-21 11:55:25",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/6"
                }
            ]
        },
        {
            "name": "Floyd",
            "descriptionn": "YOUR adventures.' 'I could tell you my history, and you'll understand why it is to give the hedgehog a blow with its eyelids, so he with his.",
            "fechaModification": "2010-03-06 00:29:28",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/7"
                }
            ]
        },
        {
            "name": "Aidan",
            "descriptionn": "And the executioner ran wildly up and to.",
            "fechaModification": "2013-05-25 08:22:35",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/8"
                }
            ]
        },
        {
            "name": "Jevon",
            "descriptionn": "King, rubbing his.",
            "fechaModification": "2011-08-25 22:20:35",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/9"
                }
            ]
        },
        {
            "name": "Wilson",
            "descriptionn": "He sent them word I had to sing \"Twinkle.",
            "fechaModification": "2014-12-22 18:20:59",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/10"
                }
            ]
        },
        {
            "name": "Eileen",
            "descriptionn": "Queen,' and she tried the little glass table. 'Now, I'll manage.",
            "fechaModification": "2013-04-14 09:22:17",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/11"
                }
            ]
        },
        {
            "name": "Kari",
            "descriptionn": "Alice for some time without interrupting it. 'They were learning to.",
            "fechaModification": "2009-12-24 04:01:21",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/12"
                }
            ]
        },
        {
            "name": "Deshawn",
            "descriptionn": "Alice, 'as all the things get used to read fairy-tales, I fancied that kind of rule, 'and vinegar that.",
            "fechaModification": "2012-07-10 04:52:04",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/13"
                }
            ]
        },
        {
            "name": "Cade",
            "descriptionn": "Let me see: four times six is thirteen, and four times six is thirteen, and four times seven is--oh dear! I shall only look up.",
            "fechaModification": "2012-10-03 14:27:50",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/14"
                }
            ]
        },
        {
            "name": "Shanel",
            "descriptionn": "And he added looking angrily at the Footman's head: it.",
            "fechaModification": "2013-08-17 10:24:03",
            "fechaEliminacion": null,
            "links": [
                {
                    "rel": "self",
                    "href": "http:\/\/localhost\/products\/15"
                }
            ]
        }
    ],
    "meta": {
        "pagination": {
            "total": 68,
            "count": 15,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 5,
            "links": {
                "next": "http:\/\/localhost\/products?page=2"
            }
        }
    }
}
```

### HTTP Request
`GET products`

`HEAD products`


<!-- END_dd873464f7c6ace481b7520ef5394dc9 -->

<!-- START_e69e3804fa0af1eb523e480d661362b7 -->
## Create new product

> Example request:

```bash
curl -X POST "http://pimtru.local/products" \
-H "Accept: application/json" \
    -d "name"="dolor" \
    -d "description"="dolor" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://pimtru.local/products",
    "method": "POST",
    "data": {
        "name": "dolor",
        "description": "dolor"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST products`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Maximum: `255`
    description | string |  required  | 

<!-- END_e69e3804fa0af1eb523e480d661362b7 -->

<!-- START_164b804602a2f6de772150ffba05ba43 -->
## Show single product

> Example request:

```bash
curl -X GET "http://pimtru.local/products/{product}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://pimtru.local/products/{product}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET products/{product}`

`HEAD products/{product}`


<!-- END_164b804602a2f6de772150ffba05ba43 -->

<!-- START_3d6f3cbb4f154b7da4faac30c3380d51 -->
## Update product

> Example request:

```bash
curl -X PUT "http://pimtru.local/products/{product}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://pimtru.local/products/{product}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT products/{product}`

`PATCH products/{product}`


<!-- END_3d6f3cbb4f154b7da4faac30c3380d51 -->

<!-- START_9dc19a575e78a6169cad6bda8a2186de -->
## Remove product

> Example request:

```bash
curl -X DELETE "http://pimtru.local/products/{product}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://pimtru.local/products/{product}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE products/{product}`


<!-- END_9dc19a575e78a6169cad6bda8a2186de -->

