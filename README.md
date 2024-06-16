# Hexagonal Architecture with CQRS for Authentication Microservice
## Overview
This repository demonstrates an implementation of an authentication microservice using hexagonal architecture, domain-driven design (DDD), and command query responsibility segregation (CQRS) patterns with Symfony and PHP8. This is a proof of concept intended for learning purposes only, not for production use.

## Hexagonal Architecture Layers
### Domain Layer
The Domain Layer contains the core business logic and domain entities. This layer is completely independent of other layers and focuses solely on the business rules and logic. It includes:

- Entities: Core objects that represent the business model.
- Value Objects: Immutable objects that describe certain aspects of the business model.
- Domain Services: Operations that don’t naturally fit within entities or value objects.
- Repositories: Interfaces for data access, implemented in the Infrastructure Layer.

### Application Layer
The Application Layer orchestrates the use cases of the application. It coordinates the flow of data to and from the domain layer, without containing any business logic itself. This layer includes:

- Commands: Requests to change the state of the system.
- Queries: Requests to read the state of the system.
- Services: Facilitate use cases by interacting with the domain and infrastructure layers.
- Controllers: Handle HTTP requests and responses (could also be placed in a separate Presentation Layer). 

### Infrastructure Layer
The Infrastructure Layer contains the implementation details such as persistence, messaging, and external services. It includes:

- Repositories: Concrete implementations of the repository interfaces defined in the domain layer.
- Messaging: Interfaces for message brokers like RabbitMQ.
- Persistence: Data mappers, ORM configurations, and other persistence-related implementations.
- External Services: Integrations with third-party services.

### Presentation Layer (optional)
The Presentation Layer handles HTTP requests and responses, acting as the interface between the user and the application. Depending on project needs, controllers and other presentation logic can be placed here instead of the Application Layer.

## Layer Interactions
- Domain Layer: Independent and contains core business logic.
- Application Layer: Interacts with Domain Layer to execute use cases, and with Infrastructure Layer for implementation details.
- Infrastructure Layer: Provides concrete implementations for repositories, messaging, and other services.
- Presentation Layer: Handles user interactions and communicates with the Application Layer to process requests.

## Rules
- Domain Layer should not depend on any other layers.
- Application Layer should not have business logic; it should delegate to the domain layer.
- Infrastructure Layer should depend on the application and domain layers but should be replaceable.
- Presentation Layer should interact primarily with the Application Layer.

## Request Flow
- Controller in the Application Layer receives the request.
- Command/Query is dispatched to the Application Layer.
- Application Layer uses Services or Handlers to process the command/query.
- Domain Layer executes the business logic.
- Response is returned to the Application Layer and then to the Controller.

## Benefits for Microservices
- Scalability: Independent development and deployment of services.
- Flexibility: Easy to change and replace components.
- Maintainability: Clear separation of concerns and single responsibility.

## Benefits of Using CQRS
- Separation of Read and Write Models: Optimized performance and scalability.
- Clearer Code: Commands for mutations, queries for reads.
- Easier Maintenance: Reduced complexity in individual handlers.

## Summary
This repository showcases a hexagonal architecture with DDD and CQRS for an authentication microservice. It is designed to be modular, scalable, and maintainable, promoting clean code and separation of concerns. This architecture is particularly beneficial for microservices due to its flexibility and clear delineation between read and write operations.