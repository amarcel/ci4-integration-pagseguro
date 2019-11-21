#### Formato de retorno da API:

```json
    "date":"2019-11-21T15:08:21.000-03:00",
    "code":"XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXX",
    "reference":"XXXXXXXXXXXXXXXXXXXXXXXXXXX",
    "type":"1",
    "status":"1",
    "lastEventDate":"2019-11-21T15:08:22.000-03:00",
    "paymentMethod":{ 
       "type":"2",
       "code":"202"
    },
    "paymentLink":"link",
    "grossAmount":"171.57",
    "discountAmount":"0.00",
    "feeAmount":"8.96",
    "netAmount":"162.61",
    "extraAmount":"0.00",
    "installmentCount":"1",
    "itemCount":"1",
    "items":{ 
       "item":{ 
          "id":"1",
          "description":"Teste",
          "quantity":"1",
          "amount":"170.57"
       }
    },
    "sender":{ 
       "name":"name",
       "email":"testing@sandbox.pagseguro.com.br",
       "phone":{ 
          "areaCode":"21",
          "number":"111111111"
       },
       "documents":{ 
          "document":{ 
             "type":"CPF",
             "value":"11111111111"
          }
       }
    },
    "shipping":{ 
       "address":{ 
          "street":"Av. Brig. Faria Lima",
          "number":"1384",
          "complement":"5o andar",
          "district":"Jardim Paulistano",
          "city":"Sao Paulo",
          "state":"SP",
          "country":"BRA",
          "postalCode":"01452002"
       },
       "type":"1",
       "cost":"1.00"
    }
```