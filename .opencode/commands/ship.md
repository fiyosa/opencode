---
description: Run the pre-launch checklist via parallel fan-out to specialist personas, then synthesize a go/no-go decision
---

Invoke the shipping-and-launch skill from .opencode/skills/shipping-and-launch/SKILL.md.

`/ship` is a **fan-out orchestrator**. It runs three specialist personas against the current change, then merges their reports into a single go/no-go decision with a rollback plan. The personas operate independently — no shared state, no ordering.

## Phase A — Fan-out

OpenCode does not expose custom agent files as separate callable subagent tools the way Claude Code does. Invoke each persona's instructions sequentially in the main context instead, treating their outputs as if returned independently — the merge phase still works the same way.

Read and apply each persona definition in order:

1. **`.opencode/agents/reviewer-code.md`** — Run a five-axis review (correctness, readability, architecture, security, performance) on the staged changes or recent commits. Output the standard review template.
2. **`.opencode/agents/security-auditor.md`** — Run a vulnerability and threat-model pass. Check OWASP Top 10, secrets handling, auth/authz, dependency CVEs. Output the standard audit report.
3. **`.opencode/agents/test-engineer.md`** — Analyze test coverage for the change. Identify gaps in happy path, edge cases, error paths, and concurrency scenarios. Output the standard coverage analysis.

Constraints:

- Do not let one persona delegate to another — keep the fan-out flat.
- For richer multi-agent collaboration patterns, see `.opencode/references/orchestration-patterns.md`.

## Phase B — Merge in main context

Once all three reports are done, synthesize them:

1. **Code Quality** — Aggregate Critical/Important findings from the code-reviewer pass and any failing tests, lint, or build output. Resolve duplicates between reviewers.
2. **Security** — Promote any Critical/High security-auditor findings to launch blockers. Cross-reference with the code-reviewer's security axis.
3. **Performance** — Pull from the code-reviewer's performance axis; cross-check Core Web Vitals if applicable.
4. **Accessibility** — Verify keyboard nav, screen reader support, contrast (handle directly here, or check `.opencode/references/accessibility-checklist.md`).
5. **Infrastructure** — Env vars, migrations, monitoring, feature flags. Verify directly.
6. **Documentation** — README, ADRs, changelog. Verify directly.

## Phase C — Decision and rollback

Produce a single output:

```markdown
## Ship Decision: GO | NO-GO

### Blockers (must fix before ship)

- [Source persona: Critical finding + file:line]

### Recommended fixes (should fix before ship)

- [Source persona: Important finding + file:line]

### Acknowledged risks (shipping anyway)

- [Risk + mitigation]

### Rollback plan

- Trigger conditions: [what signals would prompt rollback]
- Rollback procedure: [exact steps]
- Recovery time objective: [target]

### Specialist reports (full)

- [code-reviewer report]
- [security-auditor report]
- [test-engineer report]
```

## Rules

1. Run all three Phase A passes before merging — do not skip any.
2. Personas do not call each other. The main agent merges in Phase B.
3. The rollback plan is mandatory before any GO decision.
4. If any persona returns a Critical finding, the default verdict is NO-GO unless the user explicitly accepts the risk.
5. **Skip the fan-out only if all of the following are true:** the change touches 2 files or fewer, the diff is under 50 lines, and it does not touch auth, payments, data access, or config/env. Otherwise, default to fan-out. `/ship` is designed for production-bound changes — when the blast radius is non-trivial, run the full review even if the diff looks small.

Request: $ARGUMENTS
