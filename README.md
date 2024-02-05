# PSR Implementation Guidelines

## Naming Conventions

- Class names must be defined in **StudlyCaps**.
- Class constants must be defined in upper case with underscore separators.
- Method names must be defined in **camelCase**.

## File Structure

- All PHP files MUST end with a single blank line.
- The closing `?>` tag MUST be omitted from files containing only PHP.
- Blank lines MAY be added to improve readability and to indicate related blocks of code.

## Documentation

- All PHP files should include a **DocBlock** header.
- All classes should include a **DocBlock** for the class definition.
- All class constants, properties, and methods should include a **DocBlock** to explain their purpose.
- All functions should include a **DocBlock** to explain their purpose.

**Example of DocBlock:**
```php
<?php
/**
 * This is a DocBlock.
 */
function associatedFunction()
{
}

```

## Documentation avec phpDocumentor

### Référence pour comment commenter avec phpDocumentor:
Consultez la [documentation officielle de phpDocumentor](https://docs.phpdoc.org/3.0/guide/getting-started/what-is-a-docblock.html#what-is-a-docblock) pour apprendre à utiliser des DocBlocks.

### Extension VS Code pour commenter facilement avec phpDocumentor:
L'extension [phpDoc Comment](https://marketplace.visualstudio.com/items?itemName=rexshi.phpdoc-comment-vscode-plugin) pour Visual Studio Code simplifie le processus de commentaire en utilisant phpDocumentor. Installez cette extension pour améliorer l'expérience de documentation dans votre éditeur.
