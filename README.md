# Graphy Routes

This simple Drupal GraphQL V4 extension allows you to retrieve the URLs for all your nodes. You can filter by bundle. Very useful for projects that require static site generation!

## Installation

You can install using Composer.

```sh
composer require thaiphan/graphy-routes
```

## Usage

Use the following syntax to retrieve the URL for your nodes:

```graphql
query {
  routes(bundles: ["article", "page"]) {
    total
    items {
      url
    }
  }
}
```

You will get the following response:

```json
{
  "data": {
    "routes": {
      "total": 3,
      "items": [
        {
          "url": "/node/1"
        },
        {
          "url": "/contact-us"
        },
        {
          "url": "/the-best-dabs-of-2020"
        }
      ]
    }
  }
}
```

### Multilingual content

You will receive the URL paths for all of your translation content.

```json
{
  "data": {
    "routes": {
      "total": 3,
      "items": [
        {
          "url": "/hello"
        },
        {
          "url": "/it/hello"
        },
        {
          "url": "/fr/hello"
        }
      ]
    }
  }
}
```
