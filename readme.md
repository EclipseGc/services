# Services

Module port of Drupal Services module for Drupal 8


# What??? Services is in Core, why are you doing this?

- Services API allows others to expose custom API's or modify/hook into entities, and add actions/targetable actions or indexes in a standard way.
- Provide endpoint capabilities to put your API behind a centralized URL
- Accept header-based negotiation
- Provide abstraction from some of cores annoyances. Like hal_json POST only instead of just JSON acceptance.
- Version your API's
