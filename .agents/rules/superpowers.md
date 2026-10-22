# Automatic Superpowers & Skills Workflow Rule

This rule ensures the agent always invokes and follows the appropriate skills automatically without requiring explicit manual reminders.

## The Automatic Workflow

1. **New Features, Components, UI, or System Additions:**
   - **Step 1:** Automatically invoke `brainstorming` to clarify objectives, scope, and approach.
   - **Step 2:** Formulate a structured step-by-step implementation plan using `writing-plans`.
   - **Step 3:** Execute the plan systematically using `executing-plans` (or `subagent-driven-development`).
   - Combine with project skills: `ci4-fullstack-mastery` for backend/database and `sneat-ui-ux-crafting` for UI/UX.

2. **Bugs, Test Failures, or Unexpected Behavior:**
   - Automatically invoke `systematic-debugging`.
   - Never guess or apply speculative fixes without first finding concrete evidence of the root cause.

3. **Code Quality and Completion:**
   - Always run `verification-before-completion` before declaring any task finished.
   - Ensure all manual modifications made by the user are preserved.
