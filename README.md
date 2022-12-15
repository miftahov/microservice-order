#Микросервис Orders

##Примеры graphql запросов:

Получить все заказы:

```
query {
    orders {
        uuid
    }
}
```

Получить один заказ по uuid:
```
query{
    order(uuid:892407a2-d154-4adc-9cdb-16dc9ba62f1b){
        uuid
    }
}
```

Мутация:
```
mutation{
  createOrder(userUuid: "938cf154-6e54-4a41-9f16-08e6788ad203")
  {
    uuid
  }
}
```

Получить один заказ с корзиной:
```
query{
    order(uuid:892407a2-d154-4adc-9cdb-16dc9ba62f1b){
        uuid
        cart {
            uuid
        }
    }
}
```
