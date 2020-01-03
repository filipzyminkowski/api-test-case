# GlobeGroup Functional Unit Tests Library for Symfony 4.4
~~~~
composer require globegroup/api-test-case --dev
~~~~
Every Functional test that you make for your API should extend `GlobeGroup\ApiTest\ApiTestCase`
<br/><br/>
This library allows you to easily load fixtures per every test, and restarts the database on before each test.


### Installation
Create services.yml file under `config/packages/test/`
```bash
touch config/packages/test/services.yaml
```
Paste configuration to your newly created `services.yml`:
```yaml
services:
  # Here comes configuration for oAuth
  test.oauth.user:
    class: App\Entity\User\User #your user entity
    public: true
    autowire: true

  test.oauth.client:
    class: App\Entity\OAuth2\Client #your oauth client entity
    public: true
    autowire: true

  test.oauth.token:
    class: App\Entity\OAuth2\AccessToken #your oauth access token entity
    public: true
    autowire: true

```

### Using 

Create new test case that will test one endpoint (ws) that name will tell what is does like: <br/>
- `ListingModelTest` for testing lists,  
- `CreatingModelTest` for testing creation of entities or models, 
- `DeletingModelTest` for removing, marking as deleted or unassigning,
- `FetchingModelTest` for showing one model/entity,
<br/>
<br/>
Every test has to explain what it does in use-case, good practice is to write them as `snake_case`
 Here are some examples:

 ```php
 /** @test */
 function only_authorized_user_can_list_products() {
  ... your test goes here
 }
 
 ```
 
```php
  /** @test */
  function name_is_required() {
   ... your test goes here
  }
```

 ```php
 /** @test */
 function not_found_when_no_category_provided() {
  ... your test goes here
 }
 ```
 
<hr/>

### Changelog:<br/>
 - v0.1 - ApiTestCase, Traits, loading fixtures, asserting json, asserting status code
 - v1.0 - added oauth login, fixed array subset assertion, debug trait, changed to work in transaction
 - v1.1 - changed to webtestcase
 - v1.2 - added new fixtures way and fixed few problems
  