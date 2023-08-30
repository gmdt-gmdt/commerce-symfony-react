# Install symfony app

symfony new symfony-6-react-crud --webapp

# Server (local)

0 composer update (to install all deps)
1 remove all migrations
2 create database : symfony console doctrine:database:create
3 make migration : symfony console make:migration
4 symfony console doctrine:migrations:migrate
5 populate database : symfony console doctrine:fixtures:load

symfony serve to run app

# TODO

- create fixture for products
- load fixture
- test api via postman or thunder (vscode extension)
- integrate alnadjah front app
- add admin dasboard
  - create product
  - create category
  - create user ()???

The error message "No route found for 'GET http://127.0.0.1:8000/category/laptops'" typically indicates that Symfony's routing system couldn't find a route that matches the provided URL. This could happen for a variety of reasons, but let's focus on the scenario of refreshing a specific category page in your ReactJS frontend.

When you're using ReactJS for frontend routing (using tools like React Router), direct page refreshes can cause issues because the frontend routing relies on JavaScript to handle navigation. When you refresh the page, the browser sends a direct request to the server for the URL, and Symfony's routing system might not recognize the URL as a valid route because it's being handled on the frontend.

To resolve this issue and enable proper handling of page refreshes for your ReactJS frontend in a Symfony application, follow these steps:

1. **Configure Symfony's Routing:**

   Ensure that Symfony's routing configuration can handle and redirect URLs to your ReactJS application's entry point. In your Symfony application, you need to define a route that captures any URL and directs it to your ReactJS app's entry point. For example:

   ```yaml
   # config/routes.yaml

   # Route to redirect all requests to your ReactJS app
   react_app:
     path: /{reactRoute}
     controller: App\Controller\ReactController::index
     requirements:
       reactRoute: ".*"
   ```

2. **Create ReactController:**

   Create a controller in Symfony that serves the ReactJS application's entry point (usually the `index.html` file) for all routes. This controller ensures that no matter what URL is requested, the ReactJS app is loaded, and your frontend routing can take over. Here's an example of the controller:

   ```php
   // src/Controller/ReactController.php

   namespace App\Controller;

   use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
   use Symfony\Component\HttpFoundation\Response;
   use Symfony\Component\Routing\Annotation\Route;

   class ReactController extends AbstractController
   {
       /**
        * @Route("/{reactRoute}", name="react_app", requirements={"reactRoute"=".+"})
        */
       public function index(): Response
       {
           // Load and return the ReactJS entry point (index.html)
           return $this->render('react/index.html.twig');
       }
   }
   ```

3. **Handle React Router:**

   Make sure your ReactJS application is set up to handle routing internally using tools like React Router. This will ensure that when the React app loads, it can correctly navigate to the appropriate views based on the URL.

   For instance, if you're using React Router, you'd set up routes within your React components to match the expected paths and render the appropriate components.

With these changes, when you refresh a category page URL (e.g., `http://127.0.0.1:8000/category/laptops`), Symfony's routing will capture the URL and redirect it to your ReactController, which then serves your ReactJS app's entry point. Your ReactJS app will handle the routing internally using React Router and display the correct category page.
