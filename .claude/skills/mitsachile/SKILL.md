```markdown
# mitsachile Development Patterns

> Auto-generated skill from repository analysis

## Overview
This skill teaches the core development patterns and conventions found in the `mitsachile` TypeScript repository. You'll learn about file organization, code style, commit message standards, and how to write and run tests. This guide is ideal for contributors looking to maintain consistency and quality in the codebase.

## Coding Conventions

### File Naming
- Use **camelCase** for all file names.
  - Example: `userService.ts`, `dataParser.ts`

### Imports
- Use **relative import paths** for modules within the project.
  - Example:
    ```typescript
    import { fetchData } from './apiClient';
    ```

### Exports
- Use **named exports** for all modules.
  - Example:
    ```typescript
    // In utils.ts
    export function formatDate(date: Date): string { ... }
    ```

### Commit Messages
- Use **Conventional Commits** with the `feat` prefix for new features.
- Keep commit messages concise (average ~70 characters).
  - Example:
    ```
    feat: add user authentication middleware
    ```

## Workflows

### Feature Development
**Trigger:** When adding a new feature to the codebase  
**Command:** `/feature-development`

1. Create a new branch for your feature.
2. Write code using camelCase file names, relative imports, and named exports.
3. Add or update tests in files matching `*.test.*`.
4. Commit your changes using the `feat` prefix and a concise description.
5. Open a pull request for review.

### Testing
**Trigger:** When verifying code correctness  
**Command:** `/run-tests`

1. Identify test files with the `*.test.*` pattern.
2. Use the project's test runner (framework unknown; check project documentation or package.json for details).
3. Run all tests and ensure they pass before committing.

## Testing Patterns

- Test files are named with the `*.test.*` pattern (e.g., `userService.test.ts`).
- The testing framework is not specified; check the repository for more information.
- Place test files alongside the code they test or in a dedicated test directory.

## Commands
| Command              | Purpose                                      |
|----------------------|----------------------------------------------|
| /feature-development | Start the workflow for adding a new feature  |
| /run-tests           | Run all tests in the repository              |
```