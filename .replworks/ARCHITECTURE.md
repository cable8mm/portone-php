# ARCHITECTURE.md

## Purpose

- This document defines the internal structure of the product: its components, ownership of responsibilities, information flow, and invariants.
- The product is an SDK that turns a method call into an authenticated request to the PortOne V2 REST API and turns the response into a typed result or a typed failure.
- The product also verifies PortOne webhooks.

## Core Concepts

- Operation: one callable action of the PortOne V2 REST API, exposed as one client method.
- Operation Definition: the static declaration of one Operation. It holds the operation name, the request method, the request path template, the parameter list, the success result type, the error set, and the authentication requirement.
- Client: a component that exposes the Operations of one resource group. A resource group is one of the clients named in PRODUCT_SPEC EL-002 to EL-015.
- Root Client: the component that exposes every top-level Client as an accessor.
- Credentials: the apiSecret value.
- Request Description: the complete description of one outgoing request: method, path, parameters, body, and authentication requirement. It carries no transport detail.
- Raw Response: status, headers, and body as received, or a transport failure.
- Future: a typed handle for one in-flight asynchronous Operation call; waiting resolves it to a result or raises one failure.
- Outcome: the classification of a Raw Response. The Outcome kinds are Success, Defined Error, Unknown Error, Unrecognized Success, and Transport Failure.
- Model: a typed request value, response value, or webhook value.
- Error Catalog: the set of failure types: PortOneException, the per-operation error types, UnknownException per operation, UnrecognizedResponseException, TransportException, WebhookVerificationException, and InvalidArgumentException.
- Webhook Verification: the check that a webhook body, msgId, msgSignature, and msgTimestamp are authentic under webhookSecret.
- Reference Set: the PortOne V2 OpenAPI document and the PortOne API documentation.

## System Flow

### Construction flow

- Caller gives apiSecret to the Root Client or to any Client.
- Credentials Validation rejects an empty apiSecret with InvalidArgumentException.
- The constructed component creates one Request Executor holding the Credentials.
- A parent Client passes its Request Executor to every child Client it exposes.
- Caller gives webhookSecret to the Webhook Verifier.
- The Webhook Verifier rejects an empty webhookSecret with InvalidArgumentException.

### Operation flow

- Caller calls an Operation on a Client with named parameters.
- The Client selects the Operation Definition of that Operation.
- The Client builds a Request Description from the Operation Definition and the parameters.
- The Client gives the Request Description to the Request Executor.
- The Request Executor attaches the authentication header per the Operation Definition, applies the fixed timeouts, and sends the request once.
- The Request Executor returns a Raw Response to the Client.
- The Client gives the Raw Response and the Operation Definition to the Response Interpreter.
- The Response Interpreter classifies the Raw Response into one Outcome.
- Success: the Response Interpreter asks the Model Catalog to decode the body into the success result type, and the Client returns it.
- Defined Error: the Response Interpreter raises the error type that the Operation Definition names for that error.
- Unknown Error: the Response Interpreter raises the UnknownException of that Operation.
- Unrecognized Success: the Response Interpreter raises UnrecognizedResponseException.
- Transport Failure: the Request Executor raises TransportException before the Raw Response stage.

### Asynchronous operation flow

- Caller calls an Async Operation on a Client with named parameters.
- The Client selects the same Operation Definition used by the synchronous Operation.
- The Client builds the same Request Description and gives it to the Request Executor.
- The Request Executor starts exactly one request using its asynchronous transport and returns a Future.
- The caller waits on the Future.
- The Request Executor completes the Raw Response, or the Future raises TransportException.
- The Response Interpreter classifies and decodes the Raw Response using the same rules as the synchronous flow.
- The Future resolves to the typed result or raises the same failure that the synchronous call would raise.

### Webhook flow

- Caller gives body, msgId, msgSignature, and msgTimestamp to the Webhook Verifier.
- The Webhook Verifier performs Webhook Verification.
- Verification fails: the Webhook Verifier raises WebhookVerificationException.
- Verification succeeds: the Webhook Verifier asks the Model Catalog to decode the body into a Webhook Model.
- The decoded type is known: the Webhook Verifier returns the typed Webhook Model.
- The decoded type is not known: the Webhook Verifier returns an UnrecognizedWebhook holding the decoded body.

## Components

### COMP-001 Root Client

- Responsibilities: expose the accessors payment, identityVerification, pgSpecific, auth, reconciliation, platform, b2b; create one Request Executor; share it with the Clients it exposes.
- Inputs: apiSecret.
- Outputs: Client instances.
- Ownership: the set of top-level accessors and the lifetime of the shared Request Executor.
- Does not own: Operation Definitions, request sending, response classification.

### COMP-002 Client

- Responsibilities: expose the Operations of one resource group; expose child Client accessors where PRODUCT_SPEC defines them; hold the Operation Definitions of its Operations; build a Request Description per call; hand it to the Request Executor and then to the Response Interpreter.
- Inputs: apiSecret or a shared Request Executor; Operation parameters.
- Outputs: a typed result or a raised error.
- Ownership: the Operation Definitions of its own Operations, including operation name, parameters, path, success result type, error set, and authentication requirement.
- Does not own: header construction, timeouts, status classification, model decoding, error type definitions.

### COMP-003 Request Executor

- Responsibilities: attach the authentication header; resolve the request origin; apply the connection timeout and the total timeout; send exactly one request per call; return the Raw Response; raise TransportException on network failure or timeout.
- Additional responsibility: start and progress asynchronous requests and complete their Futures without changing the synchronous path.
- Inputs: Request Description; Credentials.
- Outputs: Raw Response or TransportException.
- Ownership: the authentication header scheme, the origin, the timeouts, the no-retry rule, and all knowledge of the transport.
- Does not own: knowledge of any specific Operation, status classification, decoding.

### COMP-004 Response Interpreter

- Responsibilities: classify a Raw Response into an Outcome; select the error type from the Operation Definition; request decoding from the Model Catalog; raise errors from the Error Catalog.
- Inputs: Raw Response; Operation Definition.
- Outputs: a decoded result, or a raised error.
- Ownership: the rules that map status and body to Outcome kinds, including the rule for Unrecognized Success.
- Does not own: sending requests, the fields of any Model, the definition of any error type.

### COMP-005 Model Catalog

- Responsibilities: define the typed request, response, and webhook values; decode a body into a named type; report decode failure to the caller; provide the webhook type set and the UnrecognizedWebhook type.
- Inputs: a body and a target type name.
- Outputs: a typed value, or a decode failure.
- Ownership: the field definitions of every Model.
- Does not own: when decoding is requested, which error to raise on decode failure.

### COMP-006 Error Catalog

- Responsibilities: define every failure type, its place in the type hierarchy, and the data each carries.
- Inputs: none.
- Outputs: failure types.
- Ownership: PortOneException as the single root of all SDK failures; the per-operation error types; UnknownException per Operation; UnrecognizedResponseException; TransportException; WebhookVerificationException.
- Does not own: deciding when a failure is raised.

### COMP-007 Webhook Verifier

- Responsibilities: validate webhookSecret at construction; perform Webhook Verification; request decoding of a verified body; return a typed Webhook Model or UnrecognizedWebhook; raise WebhookVerificationException on failure.
- Inputs: webhookSecret; body; msgId; msgSignature; msgTimestamp.
- Outputs: Webhook Model, UnrecognizedWebhook, or WebhookVerificationException.
- Ownership: the whole Webhook Verification rule set and the webhook flow.
- Does not own: Credentials, the Request Executor, any Operation.

### COMP-008 Samples

- Responsibilities: demonstrate usage scenarios through the public interface.
- Inputs: secrets supplied by the environment of the sample runner.
- Outputs: none to other components.
- Ownership: sample scenarios only.
- Does not own: any logic that the library uses.

## Component Responsibilities

- Building the Request Description: COMP-002.
- Sending a request and applying timeouts: COMP-003.
- Attaching authentication: COMP-003.
- Choosing which error type applies to an error response: COMP-004, using the error set declared in COMP-002.
- Defining the fields of request and response values: COMP-005.
- Defining failure types: COMP-006.
- Verifying webhooks: COMP-007.
- Sharing one Request Executor between a parent Client and its children: COMP-001 and COMP-002 parents.

## Responsibility Boundaries

- COMP-002 MUST NOT build headers, set timeouts, or inspect status codes.
- COMP-003 MUST NOT read an Operation Definition beyond the authentication requirement carried by the Request Description.
- COMP-003 MUST NOT inspect response bodies.
- COMP-004 MUST NOT send requests.
- A synchronous Operation and its Async counterpart MUST use the same Operation Definition.
- An Async Operation MUST send exactly one request and MUST NOT retry.
- Waiting on a Future MUST apply the same response classification, decoding, and failure rules as the synchronous Operation.
- COMP-005 MUST NOT raise failures other than a decode failure report.
- COMP-006 MUST NOT contain logic.
- COMP-007 MUST NOT call COMP-003.
- COMP-008 MUST use only the public interface of COMP-001, COMP-002, and COMP-007.
- No component other than COMP-003 MUST hold or read the apiSecret after construction.
- No component other than COMP-007 MUST hold or read the webhookSecret.

## Data Flow

- apiSecret: Caller -> COMP-001 or COMP-002 -> COMP-003. It never flows elsewhere.
- webhookSecret: Caller -> COMP-007. It never flows elsewhere.
- Operation parameters: Caller -> COMP-002 -> Request Description -> COMP-003.
- Request Description: COMP-002 -> COMP-003.
- Raw Response: COMP-003 -> COMP-002 -> COMP-004.
- Decoded result: COMP-005 -> COMP-004 -> COMP-002 -> Caller.
- Failure: COMP-003, COMP-004, or COMP-007 -> Caller, using COMP-006 types.
- Webhook inputs: Caller -> COMP-007 -> COMP-005 -> COMP-007 -> Caller.

## Architectural Rules

- Each Operation MUST have exactly one Operation Definition, owned by exactly one Client.
- Operation Definitions MUST be static declarations. No component MUST discover Operations at runtime.
- The Operation set, operationIds, paths, methods, and parameter names MUST equal those of the OpenAPI Reference Set.
- Request paths, request bodies, response schemas, and error semantics MUST follow the PortOne API documentation.
- Where the OpenAPI document and the PortOne API documentation differ, the documentation MUST win for behavior and the conflict MUST be recorded for resolution.
- Authentication MUST be attached by COMP-003 on every request whose Operation Definition requires it, using the scheme "Authorization: PortOne {apiSecret}".
- Every Operation Definition MUST declare an authentication requirement. The default MUST be required.
- The SDK MUST NOT obtain, store, or refresh access tokens.
- AuthClient Operations MUST be treated as ordinary Operations.
- The SDK MUST NOT validate parameter values semantically. The PortOne REST API is the only validator of values.
- A parent Client and all its children MUST share one Request Executor.
- A Client constructed on its own MUST create its own Request Executor.
- COMP-003 MUST send exactly one request per Operation call.
- COMP-003 MUST NOT retry.
- Timeouts MUST be fixed constants owned by COMP-003 and MUST NOT be configurable.
- Response classification MUST be decided only by COMP-004.
- Every failure MUST be an instance of a type in COMP-006.
- Every type in COMP-006 MUST descend from PortOneException.
- Webhook decoding MUST happen only after Webhook Verification succeeds.
- The webhook body MUST be handled as the original unparsed text during Webhook Verification.
- An unknown webhook type MUST produce UnrecognizedWebhook and MUST NOT raise a failure.
- Model decoding MUST follow the OpenAPI schema and the documented forward-compatibility rules. Unknown response fields and future enum or union values MUST NOT crash decoding unless the operation cannot produce a valid typed result.

## Failure Boundaries

- Construction failure: Credentials Validation and webhookSecret validation raise InvalidArgumentException. No request is made.
- Transport failure: contained in COMP-003. It surfaces as TransportException. No Outcome classification occurs.
- Error response failure: contained in COMP-004. It surfaces as the per-operation error type or UnknownException.
- Decode failure of a success body: contained in COMP-004. It surfaces as UnrecognizedResponseException carrying the HTTP status and the raw body.
- Webhook failure: contained in COMP-007. It surfaces as WebhookVerificationException.
- An Operation call MUST return either a typed result or raise exactly one failure. It MUST NOT return a partial result.
- A failure in one Operation call MUST NOT affect any other call or any shared component state.

## Non-Goals

- This architecture provides no component for access token management.
- This architecture provides no retry or backoff component.
- This architecture provides no caching component.
- This architecture provides no request or response logging component.
- This architecture provides no client-side semantic validation of Operation parameters.
- This architecture provides no runtime generation or discovery of Operations.
- This architecture provides no user-configurable asynchronous scheduler or external event-loop integration.
- This architecture provides no shared mutable state between calls.
- This architecture provides no abstraction layer that makes the transport replaceable by the caller.

## Architectural Invariants

- Every Operation call sends at most one request.
- No credential appears in any failure message, failure data, result, or output of any component.
- Every request that requires authentication carries the authentication header.
- Every Raw Response is classified into exactly one Outcome kind.
- Every failure descends from PortOneException.
- A webhook is decoded only if Webhook Verification succeeded.
- No component holds state that changes after construction.
- Every Operation has exactly one Operation Definition.
- The Operation set equals the operation set in the OpenAPI Reference Set.
- Every Operation has a synchronous method and an Async counterpart backed by one Future.

## Resolved Decisions

- RD-01
  - Decided: the OpenAPI document is the source of the complete Operation catalog, names, paths, methods, parameters, and schemas.
  - Why: the product target is the complete PortOne V2 REST API.
- RD-02
  - Ambiguous: how apiSecret authenticates requests (FR-012).
  - Decided: the apiSecret is sent in the Authorization header with the scheme "PortOne {apiSecret}" on every authenticated request. No token lifecycle exists.
  - Why: the author gave the request form; token handling would add state the author did not ask for.
- RD-03
  - Ambiguous: Webhook Verification details beyond signature failure: timestamp tolerance, handling of several signatures, handling of a valid signature with a non-structured body.
  - Decided: identical to the PortOne V2 API documentation and OpenAPI contract where represented.
  - Why: the OpenAPI/API documentation is the final product boundary.
- RD-04
  - Ambiguous: the criteria for Unrecognized Success, Defined Error, and Unknown Error (ERR-003, ERR-004, ERR-005): treatment of extra fields, unknown union variants, missing required fields, non-structured bodies.
  - Decided: identical to the OpenAPI/API documentation and observed live behavior.
  - Why: the OpenAPI/API documentation is the final product boundary.
- RD-05
  - Ambiguous: whether child Clients create their own Request Executor or share the parent's.
  - Decided: a parent and its children share one Request Executor; a Client built alone creates its own.
  - Why: satisfies FR-003 to FR-007 with one credential holder and no duplicated state.
- RD-06
  - Ambiguous: whether the SDK validates parameter values before sending.
  - Decided: it does not. The PortOne REST API is the only validator.
  - Why: PRODUCT_SPEC defines no client-side parameter error; ERR-003 covers API-reported invalid requests.
- RD-07
  - Ambiguous: how Operation Definitions are produced and held.
  - Decided: static declarations owned by the Client of each resource group, authored from the PortOne API documentation, with no runtime discovery.
  - Why: stated data source is the PortOne API documentation; static ownership gives one definition per Operation.
- RD-08
  - Ambiguous: which component owns the choice between the per-operation error type and UnknownException.
  - Decided: COMP-004 chooses; COMP-002 declares the error set in the Operation Definition; COMP-006 defines the types.
  - Why: one owner per decision; the error set is operation data, the choice is classification logic.
- RD-09
  - Ambiguous: whether the unknown webhook type is a failure or a result.
  - Decided: it is a result (UnrecognizedWebhook).
  - Why: PRODUCT_SPEC FR-017 defines it as a return value.
- RD-10
  - Ambiguous: where the fixed timeouts and the no-retry rule live.
  - Decided: COMP-003 owns them as non-configurable constants.
  - Why: PRODUCT_SPEC FR-022 to FR-025 allow no configuration beyond the secrets.
- RD-11
  - Ambiguous: whether the Samples component is part of the runtime path.
  - Decided: it is not. It depends on the public interface only and nothing depends on it.
  - Why: keeps library responsibilities independent from sample content.
- RD-12
  - Decided: retain synchronous methods, add Async counterparts returning a typed Future, and keep the transport's asynchronous handle behind that Future.
  - Why: PHP has no standard asynchronous operation result type; a library-owned Future keeps the public API independent of the transport.
