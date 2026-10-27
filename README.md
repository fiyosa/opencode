# Agent Tooling Setup — OpenCode

Engineering workflows, design-system generation, and code intelligence for this repository, wired into [OpenCode](https://opencode.ai).

## Progress Tracking (Todos)

The user wants to follow the work as it happens:

- Before starting, post a short `todowrite` list for any task with 3+ distinct steps, multiple files, or a debugging loop.
- Keep exactly one item `in_progress`; update it immediately when a step starts or finishes.
- Narrate each phase in one line: what you are doing now and what the result was. The user should not have to guess from tool output alone.
- Mark `completed` only after verification (tests, lint, command output). If blocked, state the cause and the next attempt instead of silently retrying.
- Add newly discovered follow-ups to the list; cancel stale items.
- For quick questions or a single trivial edit, answer directly without a todo list, but still say what you are checking.

## Active systems

| System            | Purpose                                                           | Location                          |
| ----------------- | ----------------------------------------------------------------- | --------------------------------- |
| **CodeGraph**     | Code intelligence: symbols, call paths, blast radius              | `.codegraph/`                     |
| **Agent Skills**  | Engineering workflow skills, references, slash commands, personas | `.opencode/`                      |
| **UI/UX Pro Max** | Design-system generation (layout, color, typography)              | `.opencode/skills/ui-ux-pro-max/` |

`AGENTS.md` is the instruction file the agent loads; `opencode.json` holds permissions and MCP server config.

## Repository layout

```
.codegraph/            # CodeGraph index (generated locally, not committed)
.opencode/
├── agent-skills/      # 4 persona definitions
├── commands/          # 8 slash commands
├── references/        # 7 supplementary checklists
└── skills/            # 31 skills (24 engineering + 7 design/UI)
AGENTS.md              # Agent instructions
opencode.json          # OpenCode config: permissions + CodeGraph MCP
```

## CodeGraph

CodeGraph indexes the repository into a local graph so agents can locate and understand code without a grep/read loop. The index lives in `.codegraph/`; `opencode.json` registers it as a local MCP server:

```json
"mcp": {
  "codegraph": {
    "type": "local",
    "command": ["codegraph", "serve", "--mcp"],
    "enabled": true
  }
}
```

Usage:

- **MCP tool** (when available): `codegraph_explore` returns the relevant symbols' verbatim source plus call paths, in one call.
- **Shell** (always works): `codegraph explore "<symbol names or question>"`.

If `.codegraph/` does not exist, CodeGraph is skipped entirely — indexing is the user's decision (`codegraph init`).

## Agent Skills

Configuration of engineering skills from [addyosmani/agent-skills](https://github.com/addyosmani/agent-skills), adapted to run on OpenCode.

### Why it was adapted

The original repo targets Claude Code, using native slash commands and subagents. OpenCode differs in both areas, so this setup makes the following adjustments:

- Skills and references live under `.opencode/` to keep one consistent namespace.
- The 8 commands use `.md` files with YAML frontmatter, matching OpenCode's custom command convention.
- `/ship` and `/webperf` invoke their personas sequentially in the same context instead of as parallel subagents, since OpenCode has no subagent tool system.
- Persona definitions live in `.opencode/agent-skills/` and are read by the commands that need them.
- `AGENTS.md` was rewritten so every referenced path matches the `.opencode/` structure.

### Usage

Via slash command:

```
/spec add a CSV export feature
/plan add a CSV export feature
/build
/test
/review
/webperf
/code-simplify
/ship
```

Via natural language — no command required. `AGENTS.md` instructs the agent to detect intent and invoke the matching skill automatically.

```
I want to build a feature to export report data to CSV
```

```
There's a 500 error on the login endpoint, can you check it
```

### Command reference

| Command          | Skill invoked                                       | Purpose                                      |
| ---------------- | --------------------------------------------------- | -------------------------------------------- |
| `/spec`          | spec-driven-development                             | Write a spec before writing code             |
| `/plan`          | planning-and-task-breakdown                         | Break work into small tasks                  |
| `/build`         | incremental-implementation, test-driven-development | Implement incrementally, one slice at a time |
| `/test`          | test-driven-development                             | Red-green-refactor cycle                     |
| `/review`        | code-review-and-quality                             | Five-axis review before merge                |
| `/code-simplify` | code-simplification                                 | Simplify code without changing behavior      |
| `/webperf`       | performance-optimization                            | Web performance audit                        |
| `/ship`          | shipping-and-launch                                 | Pre-launch checklist, go/no-go decision      |

### Skill catalog

31 skills live under `.opencode/skills/`: 24 engineering skills across six lifecycle phases, plus 7 design/UI skills.

**Define** — using-agent-skills, interview-me, idea-refine, spec-driven-development

**Plan** — planning-and-task-breakdown

**Build** — incremental-implementation, test-driven-development, context-engineering, source-driven-development, doubt-driven-development, frontend-ui-engineering, api-and-interface-design

**Verify** — browser-testing-with-devtools, debugging-and-error-recovery

**Review** — code-review-and-quality, code-simplification, security-and-hardening, performance-optimization

**Ship** — git-workflow-and-versioning, ci-cd-and-automation, deprecation-and-migration, documentation-and-adrs, observability-and-instrumentation, shipping-and-launch

**Design / UI** — ui-ux-pro-max, design, design-system, ui-styling, brand, banner-design, slides

Skills also activate automatically based on context, without a slash command. See the Intent → Skill Mapping section in `AGENTS.md` for the full mapping.

## UI/UX Pro Max

[ui-ux-pro-max](https://github.com/nextlevelbuilder/ui-ux-pro-max-skill) provides design-system generation (layout patterns, color palettes, typography, anti-patterns) for UI/UX requests. It auto-activates independently from the engineering skills, no command needed.

```
Build a landing page for my SaaS product
Create a dashboard for healthcare analytics
```

Requires Python 3.x locally (used only by the skill's local search script, no network calls). Check with `python3 --version`.

It runs alongside, not instead of, the engineering skills — see `AGENTS.md` for how it fits into the spec → build → test lifecycle.

## Source

- CodeGraph: [colbymchenry/codegraph](https://github.com/colbymchenry/codegraph)
- Agent Skills: [addyosmani/agent-skills](https://github.com/addyosmani/agent-skills)
- UI/UX Pro Max: [nextlevelbuilder/ui-ux-pro-max-skill](https://github.com/nextlevelbuilder/ui-ux-pro-max-skill)
- Docs: [OpenCode](https://opencode.ai/docs/)
