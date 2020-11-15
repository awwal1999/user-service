# Reliance HMO User Service  
  
    
This is the base micro-service for the reliance engineering system. The service is built for reliance by Rhomans 😉 (Avengers)🎯  
  
    
  
*This readme hopes to provide a relatively brief and concise overview of the user service. This will try to go through the general project structure, the various dependencies and services the user service depends on, and try to justify the reasoning behind some of its design decisions where possible.*  
  
    
Base URL - Really? This depends on the DevOps guys!!  
  
    
    
  
## Context  
  
The user service responsibility will be to handle all user-specific data and business logic around creating a user well as accounts, roles, and also clients (ThirdParty and partnership clients). The user service will be built to be multi-tenant which means that a new reliance HMO project can build a user management solution around this service.  
  
    
  
New services can easily plug into the user service without having to worry about the business logic around user management as well as accounts.  
  
    
    
  
The service major aim is to provide the following core functionalities  
  
    
  
- **User and Third-party Signup** - New users as well as third-party/partnership systems will use the service to sign up.  
  
- **Account Sign Up** - On the fly, accounts can be created. Based on other service requirements.  
  
- **Authentication** - The user service provides a stateless authentication service. When users login. A JWT is generated for them. This JWT token can be used in other systems. Thanks to the power of our middleware(Lookout - coming soon though 🙅🏿‍♀️)  
  
    
    
  
## Structure  
  
The general file structure is really defined. we try to place things in the namespace that they are supposed to fall in.  
  
    
  
The codebase is built using the laravel framework, whilst eloquent is used as the Object Relationship Mapper. We tried to separate concerns as much as we can making the code base S.O.L.I.O.D, so this means that the coding style been used is the OO coding syle.  
  
    
  
Interestingly laravel does dependency injection for us out of the box 💃🏻💃🏻💃🏻💃🏻💃🏻💃🏻. So we inject via constructors only. We also wrote out some very simple tools in the project. In the nearest future, we really hope to publish this so other services can enjoy these benefits.  
  
    
  
#### Tools  
  
    
Notable packages include:  
  
    
  
- [Php Unit](https://phpunit.de/)  
  
- [Faker](https://github.com/marak/Faker.js/): A simple API for generating mock data  
  
    
  
> Note: Laravel comes packaged with Testing functionality, So it makes testing really easy for all.  
  
    
In the _`/unit`_ and _`/feature`_ folders, the test files are a one to one mapping with the production classes they test.  
  
    
  
### Integration Test  
  
Really we depend on the integration test for the project. That is like the heart of the project. We are currently maintaining a *>85%* coverage. Really we are hoping to get things better with testing. The integration test allows us to test the interaction of all independent services in the project.  
  
    
  
### File Structure  
  
Really, a look into the folder will allow a better understanding of how the file in structured. But we will kinda explain some on a very high level.  
  
Basically the project is broken down into three major layers  
  
    
  
- **Controller Layer** - The controller holds all the endpoints that the request hits upon getting to the system.  
  
- **Service Layer** - While this is the major stakeholder in the codebase. The service layer holds all the business logic. For no reason should the controller or other layers hold business logic? We broke the service layer into two segments.  
  
- [x] **ServiceContracts** - Just like the namespace name, the ServiceContracts namespace only houses interfaces. Like we said initially, the code base is S.O.L.I.D. So we allowed classes depend on interfaces and not concrete implementations. Like you may know, logic might change but classes that utilize these classes are not meant to know about this change. Here might be a very good reference to understand [S.O.L.I.D](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design)  
  
- [x] **Service** - The Service namespace holds the classes that implement their respective contracts.  
  
- **Repository Layer** - The repository layer maps the business layer to the database. We have abstracted the data layer as much as we can. Just like the service layer, we want to be able to swap the data provider without other layers knowing about it. Currently, the codebase uses Postgres. In the future, if we decide to change to a No-SQL DB, we keep it cool and other layers do not even have to know about the change (cool right ? 🙌🏿🙌🏿🙌🏿🙌🏿🙌🏿🙌🏿🙌🏿🙌🏿).  
  
    
  
- [x] **RepositoryContracts** - This will hold strictly interfaces of repositories.  
  
- [x] **Repository** - This will cold only the implementation of the contracts.  
  
    
  
**Registrars** - We are utilizing the power of Laravel’s decency injection. Unfortunately, Laravel does not do a project-wide scan to find the class that implements an interface like other frameworks like (spring boot). We will use what we have (dhooor!!!). Thus the repositories and services have to be registered in the RepositoryRegistrarProvider and ServiceRegistrarProvider respectively.  
  
    
  
** **Core** ** - We have carefully written our authentication layer our self because we want to be able to tweak things on the fly. We use [JWT](https://jwt.io/introduction/) and well as implementing the Laraval’sl AuthUserProvider. The core namespace provides auth implementation.  
  
    
  
** **Http\Requests** ** - We want to abstract every layer to the smallest possible layer. Yes we are looking at a very frictionless code base. Imagine removing something and others still stand one as they should. (Mind you we are policing with the test so if any business logic changes. We arrest and hard over the defaulter to SARS!!! ).  
  
    
  
The request class contains the abstraction of all validations. At any point should not have to write validation in the controller  
  
    
  
** **Rules** ** - We created some rules to serve our needs. Here might be a good read for [laraval rules](https://laravel.com/docs/7.x/validation#custom-validation-rules).  
  
    
    
    
  
## Important Notes.  
  
The core Auth provides a very powerful class and that's is the *RequestPrincipal* class. Upon Authentication, the RequestPrincipal holds all authenticated user information. The Request Principal can also act as a facade. This means that logged in user information can be gotten from anywhere in the code. (We abstracted this from the larval request object. That might really sound weird right? But the essence of this is we do not want the service layer to know about the framework controller properties(Request class is an important one). What this does for us is, it allows us to migrate business logic across the language-specific framework, you never can tell we might have a better framework better than Laraval, although our business Logic still remains the same.  
  
**Database** - This time we choose Postgres 🤪, and the reason is because of our existing legacy systems. We do not want to depend solely on generated IDs on the new system since we will be migrating data from the legacy system to the new system. Thus Postgres provides us with a sequence that can be tuned.  
  
## Todos  
  
    
- Email is not been sent on user activation and password reset. Thus  
  
there is a need to add the best means for notification.  
  
- API throttling is not implemented, this will be very nice to have using Redis as the driver. Caveat The username should be the key to the store.  
  
- Blacklisting and also web caching is also yet to be implemented.  
  
- We really need to put things in containers. We cannot be sure about running things in isolation. Docker will be nice to have, in short, a must-have.  
  
- Continuous Integration- Currently codebase has no continuous integration pipeline. Circle CI is a good fit since it is a small project.  
  
- We still need to document endpoints. We are not even thinking of using swagger. Swagger needs annotation processing for php and really its scappy.   
We most likely be using gitbooks or postman.   
  
    
    
  
## Use Case  
  
    
##### Resource Request Flow  
  
![enter image description here](https://s3.us-west-2.amazonaws.com/secure.notion-static.com/068dec27-022a-4dbd-8bd5-9f4233a3a6a5/Untitled.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAT73L2G45O3KS52Y5%2F20200602%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20200602T095259Z&X-Amz-Expires=86400&X-Amz-Signature=c7820a0893985fcd41aeb444a3fa058c397c3fe0829229fbc8bb232c49d32fe6&X-Amz-SignedHeaders=host&response-content-disposition=filename%20%3D%22Untitled.png%22)  
  
    
  
#### Proposed Resource Failed Login Flow  
  
![enter image description here](https://s3.us-west-2.amazonaws.com/secure.notion-static.com/70cf2f8b-214c-4434-a657-b0a0f919a182/Untitled.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAT73L2G45O3KS52Y5%2F20200602%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20200602T095417Z&X-Amz-Expires=86400&X-Amz-Signature=77322f7ac23b1ced9cdaaa855577fc1fd0fa3545cf15e120781211f00bb87530&X-Amz-SignedHeaders=host&response-content-disposition=filename%20%3D%22Untitled.png%22)  
  
    
  
#### Proposed Resource for Expired Token Request Flow  
  
![enter image description here](https://s3.us-west-2.amazonaws.com/secure.notion-static.com/e84814f2-dfa3-47e4-8420-5fc4066c0bbf/Untitled.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAT73L2G45O3KS52Y5%2F20200602%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20200602T095454Z&X-Amz-Expires=86400&X-Amz-Signature=18703817a5d283f133c9a78199abd4b9017bcc5ef94550066962d4a3fda8c8c0&X-Amz-SignedHeaders=host&response-content-disposition=filename%20%3D%22Untitled.png%22)  
  
    
  
## Security Vulnerabilities  


##	Setting Project Up Without Docker.
For now we do not have docker so you will have to set things up your self. Docker volunteers will be fine.

*Use the .**evn** file to run the project but you will need a redis instance for all this to work. We are using redis for caching API keys.



 
Not for now but really if you find let the Romans principals know.
