---
description: Run TDD workflow — write failing tests, implement, verify. For bugs, use the Prove-It pattern.
---

Invoke the test-driven-development skill from .opencode/skills/test-driven-development/SKILL.md.

For new features:

1. Write tests that describe the expected behavior (they should FAIL)
2. Implement the code to make them pass

For bug fixes (Prove-It pattern):

1. Write a test that reproduces the bug (must FAIL)
2. Confirm the test fails
3. Implement the fix
4. Confirm the test passes
5. Run the full test suite for regressions

For browser-related issues, also invoke the browser-testing-with-devtools skill from .opencode/skills/browser-testing-with-devtools/SKILL.md to verify with Chrome DevTools MCP.

Request: $ARGUMENTS
