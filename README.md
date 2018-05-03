# ApiTools for Symfony

Usage:
```php
    /**
     * @Route("/example/{id}", name="example")
     * @Method("GET")
     */
    public function exampleAction(ApiResponse $apiResponse, MyEntity $entity)
    {
        // ...

        $em->persist($message);

        try {
            $em->flush();
            
            $someData = [];
            // ... Fill this array or object

            return $apiResponse->render(ApiResponse::SUCCESS, $someData);
        }
        catch(\Exception $e) {
            return $apiResponse->render(ApiResponse::ERROR, $e->getMessage());
        }
    }
```
