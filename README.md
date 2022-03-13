#Soloine
Api for read Plinct and order data on RDFs schemas

###Parameters from path uri
> https://{apiHost}/soloine

type = Schema.org type (e.g. Organization, Place...)

### Paramater for query
> https://{apiHost}/soloine?{property}={value}

| property | value | example |
|:-----|:-----|:---|
| class | class of the rdfs schema  | http://plinct.com.br/soloine?class=organization |
| subClass | true | http://plinct.com.br/soloine?class=organization&subClass=true |
